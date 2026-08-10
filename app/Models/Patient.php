<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'age',
        'allergies',
        'medical_conditions',
        'is_pregnant',
        'is_breastfeeding',
    ];

    protected $casts = [
        'allergies' => 'array',
        'medical_conditions' => 'array',
        'is_pregnant' => 'boolean',
        'is_breastfeeding' => 'boolean',
    ];

    public function getAgeCategoryAttribute(): string
    {
        if (is_null($this->age)) {
            return 'dewasa';
        }
        if ($this->age <= 12) {
            return 'anak';
        }
        if ($this->age > 65) {
            return 'lansia';
        }
        return 'dewasa';
    }
}
