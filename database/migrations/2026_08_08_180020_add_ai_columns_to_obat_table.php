<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->string('chemical_group')->nullable();
            $table->json('side_effects')->nullable();
            $table->decimal('price', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropColumn(['category', 'chemical_group', 'side_effects', 'price']);
        });
    }
};