<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['patient_id', 'invoice_number', 'total_price'];

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}