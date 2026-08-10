<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SaleExportController extends Controller
{
    public function export(): StreamedResponse
    {
        $fileName = 'laporan-penjualan-' . date('Y-m-d') . '.csv';
        $sales = Sale::with('patient')->get();

        $callback = function() use ($sales) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['No. Invoice', 'Tanggal Transaksi', 'Nama Pasien', 'Total Harga']);

            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->invoice_number,
                    $sale->created_at,
                    $sale->patient->name ?? 'Umum',
                    $sale->total_price,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$fileName\"",
        ]);
    }
}