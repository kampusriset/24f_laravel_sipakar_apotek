<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PharmacyAiService;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Controller
{
    protected $aiService;

    public function __construct(PharmacyAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        $medicines = Medicine::orderBy('nama_obat', 'asc')->get();
        $patients = Patient::orderBy('name', 'asc')->get();

        return view('kasir-pintar', compact('medicines', 'patients'));
    }

    public function checkItemSafety(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
            'medicine_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Input tidak valid. Pastikan pasien dan obat sudah terpilih.'
            ], 422);
        }

        $patient = Patient::find($request->patient_id);
        $medicine = Medicine::find($request->medicine_id);

        if (!$patient || !$medicine) {
            return response()->json([
                'status' => 'error',
                'message' => 'Eror: Data Pasien atau Data Obat tidak ditemukan di database Anda!'
            ], 404);
        }

        $analysis = $this->aiService->screenPrescription(
            $request->patient_id, 
            $request->medicine_id
        );

        return response()->json($analysis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:obat,id_obat',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalPrice = 0;
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(uniqid());

            $sale = Sale::create([
                'patient_id' => $request->patient_id,
                'invoice_number' => $invoiceNumber,
                'total_price' => 0
            ]);

            foreach ($request->items as $item) {
                $medicine = Medicine::lockForUpdate()->findOrFail($item['medicine_id']);

                if ($medicine->stok < $item['quantity']) {
                    throw new \Exception("Stok obat {$medicine->nama_obat} tidak mencukupi! Sisa stok: {$medicine->stok}");
                }

                $price = $medicine->harga_jual ?? 0;
                $subtotal = $price * $item['quantity'];
                $totalPrice += $subtotal;

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $medicine->id_obat,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal
                ]);

                $medicine->decrement('stok', $item['quantity']);
            }

            $sale->update(['total_price' => $totalPrice]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disimpan, stok obat telah diperbarui!',
                'invoice' => $invoiceNumber,
                'total_bayar' => $totalPrice
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function downloadPdf($invoice)
    {
        $sale = Sale::with(['details.medicine', 'patient'])
                    ->where('invoice_number', $invoice)
                    ->firstOrFail();

        $pdf = Pdf::loadView('pdf.struk', compact('sale'));
        
        return $pdf->stream('Struk-' . $sale->invoice_number . '.pdf');
    }
}