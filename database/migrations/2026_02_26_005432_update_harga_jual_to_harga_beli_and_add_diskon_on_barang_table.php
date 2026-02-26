<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Rename kolom
            $table->renameColumn('harga_jual', 'harga_beli');

            // Tambah kolom diskon
            $table->decimal('diskon', 5, 2)->default(0)->after('harga_beli');
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            // Balikkan perubahan
            $table->renameColumn('harga_beli', 'harga_jual');
            $table->dropColumn('diskon');
        });
    }
};