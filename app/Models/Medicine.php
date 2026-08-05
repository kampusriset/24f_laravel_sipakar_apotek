<?php

// Lokasi: app/Models/Medicine.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = ['name', 'category', 'chemical_group', 'side_effects', 'stock', 'price'];

    protected $casts = [
        'side_effects' => 'array',
    ];
}