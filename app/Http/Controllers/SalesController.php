<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PharmacyAiService;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Medicine; // <-- PASTIKAN BARIS INI ADA
use App\Models\Patient;  // <-- PASTIKAN BARIS INI ADA
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    protected $aiService;

    public function __construct(PharmacyAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    // Fungsi screening keamanan obat (sudah dibuat sebelumnya)
 // Lokasi: app/Http/Controllers/SalesController.php

public function checkItemSafety(Request $request)
{
    // Menggunakan Validator manual agar tidak terjadi auto-redirect jika error
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'patient_id' => 'required',
        'medicine_id' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Input tidak valid. Pastikan pasien dan obat sudah terpilih.'
        ], 422);
    }

    // Cek apakah data pasien & obat benar-benar ada di database
    $patient = \App\Models\Patient::find($request->patient_id);
    $medicine = \App\Models\Medicine::find($request->medicine_id);

    // JIKA DATA TIDAK DITEMUKAN (Ini penyebab utama redirect 404 kemarin)
    if (!$patient || !$medicine) {
        return response()->json([
            'status' => 'error',
            'message' => 'Eror: Data Pasien atau Data Obat tidak ditemukan di database Anda! Pastikan sudah jalankan php artisan db:seed.'
        ], 404);
    }

    // Jika data ada, jalankan logic AI Service seperti biasa
    $analysis = $this->aiService->screenPrescription(
        $request->patient_id, 
        $request->medicine_id
    );

    return response()->json($analysis);
}

    // Lanjutan: Fungsi menyimpan transaksi final saat tombol "Bayar" diklik
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Menggunakan Database Transaction agar jika ada salah satu stok habis/gagal, semua data dibatalkan otomatis
        DB::beginTransaction();

        try {
            $totalPrice = 0;
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(uniqid());

            // 1. Buat struk penjualan induk dulu
            $sale = Sale::create([
                'patient_id' => $request->patient_id,
                'invoice_number' => $invoiceNumber,
                'total_price' => 0 // Sementara diganti setelah kalkulasi item selesai
            ]);

            // 2. Loop semua item obat yang dibeli
            foreach ($request->items as $item) {
                $medicine = Medicine::lockForUpdate()->findOrFail($item['medicine_id']);

                // Cek apakah stok di gudang cukup
                if ($medicine->stock < $item['quantity']) {
                    throw new \Exception("Stok obat {$medicine->name} tidak mencukupi! Sisa stok: {$medicine->stock}");
                }

                $subtotal = $medicine->price * $item['quantity'];
                $totalPrice += $subtotal;

                // Simpan ke detail transaksi
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $medicine->id,
                    'quantity' => $item['quantity'],
                    'price' => $medicine->price,
                    'subtotal' => $subtotal
                ]);

                // POTONG STOK OBAT DI GUDANG
                $medicine->decrement('stock', $item['quantity']);
            }

            // 3. Update total_price di struk induk
            $sale->update(['total_price' => $totalPrice]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan, stok obat telah diperbarui!',
                'invoice' => $invoiceNumber,
                'total_bayar' => $totalPrice
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada error
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}