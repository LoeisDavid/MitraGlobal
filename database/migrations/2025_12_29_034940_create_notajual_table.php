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
        Schema::create('notajual', function (Blueprint $table) {
            $table->id('no_nota');
            $table->date('tanggal');

            $table->foreignId('pelanggan_kode_pelanggan')
                ->constrained('pelanggan', 'kode_pelanggan');

            $table->foreignId('pegawai_kode_pegawai')
                ->constrained('pegawai', 'kode_pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notajual');
    }
};
