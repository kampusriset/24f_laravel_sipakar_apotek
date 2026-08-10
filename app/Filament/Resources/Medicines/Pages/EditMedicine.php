<?php

namespace App\Filament\Resources\Medicines\MedicineResource\Pages;

use App\Filament\Resources\Medicines\MedicineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedicine extends EditRecord
{
    protected static string $resource = MedicineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}