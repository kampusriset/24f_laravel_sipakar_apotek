<?php

namespace App\Filament\Resources\Medicines;

use App\Filament\Resources\Medicines\MedicineResource\Pages;
use App\Models\Medicine;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;

    protected static ?string $recordTitleAttribute = 'nama_obat';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationLabel = 'Daftar Obat';
    protected static ?string $modelLabel = 'Obat';
    protected static ?string $pluralModelLabel = 'Daftar Obat';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_obat')
                    ->label('Nama Obat')
                    ->required()
                    ->maxLength(100),

                TextInput::make('harga_beli')
                    ->label('Harga Beli')
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('harga_jual')
                    ->label('Harga Jual')
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->default(0),

                DatePicker::make('tanggal_expired')
                    ->label('Tanggal Expired'),

                TextInput::make('id_kategori')
                    ->label('ID Kategori')
                    ->numeric(),

                TextInput::make('id_supplier')
                    ->label('ID Supplier')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_obat')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_obat')
                    ->label('Nama Obat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->sortable()
                    ->color(fn (int $state): string => $state < 10 ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('tanggal_expired')
                    ->label('Expired')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }
}