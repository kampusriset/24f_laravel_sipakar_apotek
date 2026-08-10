<?php

namespace App\Filament\Exports;

use App\Models\Sale;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Str;

class SaleExportExporter extends Exporter
{
    protected static ?string $model = Sale::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('invoice_number')->label('No. Invoice'),
            ExportColumn::make('created_at')->label('Tanggal Transaksi'),
            ExportColumn::make('patient.name')->label('Nama Pasien')->formatStateUsing(fn ($state) => $state ?? 'Umum'),
            ExportColumn::make('total_price')->label('Total Harga (Rp)'),
        ];
    }

    public function getJobQueue(): ?string
    {
        return null;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor laporan penjualan berhasil dan ' . Str::of('baris')->counted($export->successful_rows) . ' data telah diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Str::of('baris')->counted($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }
}