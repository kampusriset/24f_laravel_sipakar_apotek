<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan variabel input Sistem Pakar yang belum tersedia
     * di tabel patients:
     * - age                -> Variabel #3: Faktor Demografi dan Usia
     * - is_pregnant         -> Variabel #4: Kondisi Kesehatan Khusus (kehamilan)
     * - is_breastfeeding    -> Variabel #4: Kondisi Kesehatan Khusus (menyusui)
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->unsignedTinyInteger('age')->nullable()->after('name');
            $table->boolean('is_pregnant')->default(false)->after('medical_conditions');
            $table->boolean('is_breastfeeding')->default(false)->after('is_pregnant');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['age', 'is_pregnant', 'is_breastfeeding']);
        });
    }
};
