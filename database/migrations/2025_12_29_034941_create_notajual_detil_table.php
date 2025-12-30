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

            $table->string('notajual_no_nota');
            $table->string('barang_kode_barang');
            $table->foreign('notajual_no_nota')
                ->references('no_nota')
                ->on('notajual');

            $table->foreign('barang_kode_barang')
                ->references('kode_barang')
                ->on('barang');

            $table->timestamps();
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
