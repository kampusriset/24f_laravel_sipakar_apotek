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

    /**
     * Variabel Input #3 (Faktor Demografi dan Usia) pada Sistem Pakar:
     * anak (<=12 th), dewasa (13-65 th), lansia (>65 th).
     * Jika usia tidak diisi, default dianggap dewasa.
     */
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
