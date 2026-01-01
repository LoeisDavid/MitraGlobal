<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pegawai')->insert([
            [
                'kode_pegawai' => 'PGW001',
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('admin123')
            ]
        ]);

    }
}
