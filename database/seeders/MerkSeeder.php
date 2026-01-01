<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('merk')->insert([
            [
                'kode_merk' => 'MRK001',
                'nama' => 'Samsung'
            ],
            [
                'kode_merk' => 'MRK002',
                'nama' => 'Logitech'
            ]
        ]);
    }
}
