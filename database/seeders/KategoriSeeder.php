<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['kode_kategori' => 'EL', 'nama' => 'Elektronik'],
            ['kode_kategori' => 'AT', 'nama' => 'Alat Tulis']
        ]);
    }
}
