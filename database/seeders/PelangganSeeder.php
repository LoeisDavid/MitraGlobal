<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            [
                'nama' => 'Budi',
                'alamat' => 'Jakarta',
                'telepon' => '08123456789'
            ],
            [
                'nama' => 'Siti',
                'alamat' => 'Bandung',
                'telepon' => '08234567890'
            ]
        ]);

    }
}
