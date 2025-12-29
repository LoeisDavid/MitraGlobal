<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id('kode_barang');
            $table->string('barcode', 13);
            $table->string('nama', 45);
            $table->decimal('harga_jual', 15, 2);
            $table->integer('stok');

            $table->foreignId('merk_kode_merk')->constrained('merk', 'kode_merk');
            $table->char('kategori_kode_kategori', 2);
            $table->foreign('kategori_kode_kategori')->references('kode_kategori')->on('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
