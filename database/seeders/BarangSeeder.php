<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barang')->insert([
            [
                'barcode' => '1234567890123',
                'nama' => 'Mouse',
                'harga_jual' => 150000,
                'stok' => 50,
                'merk_kode_merk' => 2,
                'kategori_kode_kategori' => 'EL'
            ]
        ]);
    }
}
