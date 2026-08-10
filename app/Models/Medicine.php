<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'obat';
    protected $primaryKey = 'id_obat';

    protected $fillable = [
        'nama_obat',
        'category',
        'chemical_group',
        'side_effects',
        'harga_beli',
        'harga_jual',
        'stok',
        'tanggal_expired',
        'id_kategori',
        'id_supplier',
    ];

    protected $casts = [
        'tanggal_expired' => 'date',
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'stok' => 'integer',
        'side_effects' => 'array',
    ];

    public function getNameAttribute()
    {
        return $this->nama_obat;
    }

    public function getPriceAttribute()
    {
        return $this->harga_jual;
    }
}