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
        Schema::create('notajual_detil', function (Blueprint $table) {
            $table->id();
            $table->decimal('harga', 15, 2);
            $table->integer('jumlah');
            $table->integer('diskon');

            $table->foreignId('notajual_no_nota')
                ->constrained('notajual', 'no_nota');

            $table->foreignId('barang_kode_barang')
                ->constrained('barang', 'kode_barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notajual_detil');
    }
};
