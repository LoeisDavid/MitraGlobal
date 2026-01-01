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
            $table->string('kode_barang')->primary();
            $table->string('barcode', 13)->nullable()->unique();
            $table->string('nama', 45);
            $table->decimal('harga_jual', 15, 2);
            $table->integer('stok');

            // foreign key ke merk (string/char)
            $table->string('merk_kode_merk');
            $table->foreign('merk_kode_merk')
                ->references('kode_merk')
                ->on('merk');

            // foreign key ke kategori (char(2))
            $table->char('kategori_kode_kategori');
            $table->foreign('kategori_kode_kategori')
                ->references('kode_kategori')
                ->on('kategori');

                $table->timestamps();
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
