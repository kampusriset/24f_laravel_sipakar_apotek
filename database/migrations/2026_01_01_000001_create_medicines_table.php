<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obat', function (Blueprint $table) {
            $table->id('id_obat');
            $table->string('nama_obat', 100);
            $table->decimal('harga_beli', 10, 2)->nullable();
            $table->decimal('harga_jual', 10, 2)->nullable();
            $table->integer('stok')->nullable();
            $table->date('tanggal_expired')->nullable();
            $table->foreignId('id_kategori')->nullable();
            $table->foreignId('id_supplier')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};