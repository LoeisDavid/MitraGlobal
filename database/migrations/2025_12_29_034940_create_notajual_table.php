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
            $table->string('no_nota')->primary();
            $table->date('tanggal');
            $table->boolean('draft')->default(true);
            $table->char('pelanggan_kode_pelanggan', 10);
            $table->char('pegawai_kode_pegawai', 10);
            $table->foreign('pelanggan_kode_pelanggan')
                ->references('kode_pelanggan')
                ->on('pelanggan');

            $table->foreign('pegawai_kode_pegawai')
                ->references('kode_pegawai')
                ->on('pegawai');

            $table->timestamps();
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
