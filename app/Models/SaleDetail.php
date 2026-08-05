<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = ['sale_id', 'medicine_id', 'quantity', 'price', 'subtotal'];

    // Relasi ke obat
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
