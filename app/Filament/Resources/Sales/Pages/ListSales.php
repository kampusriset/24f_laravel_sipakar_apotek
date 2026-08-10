<?php

namespace App\Filament\Resources\Sales\Pages;

use App\Filament\Resources\Sales\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_excel')
                ->label('Export Data')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(route('sales.export'))
                ->openUrlInNewTab(false),
        ];
    }
}