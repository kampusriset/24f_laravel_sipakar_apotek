<?php

namespace App\Filament\Resources\Sales;

use App\Filament\Resources\Sales\Pages\ListSales;
use App\Models\Sale;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Laporan Penjualan';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')->label('No. Invoice')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Transaksi')->dateTime(),
                Tables\Columns\TextColumn::make('patient.name')->label('Pasien')->default('Umum'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total (Rp)')
                    ->money('IDR', locale: 'id'),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('Dari Tanggal'),
                        DatePicker::make('to')->label('Sampai Tanggal'),
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when($data['from'], fn ($query, $date) => $query->whereDate('created_at', '>=', $date))
                        ->when($data['to'], fn ($query, $date) => $query->whereDate('created_at', '<=', $date))
                    ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSales::route('/'),
        ];
    }
}