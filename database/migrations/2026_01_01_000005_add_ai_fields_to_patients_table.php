<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
