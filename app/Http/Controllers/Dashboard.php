<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nota_model;
use App\Models\Pelanggan_model;
use App\Models\Barang_model;
use App\Models\Pegawai_model;

class Dashboard extends Controller
{
    public function index()
    {
        $notas = Nota_model::count();
        $notaToday = Nota_model::whereDate('tanggal', now()->toDateString())->count();
        $pelanggans = Pelanggan_model::count();
        $barangs = Barang_model::count();
        $pegawai = Pegawai_model::count();

        return view('dashboard.index', compact('notas', 'notaToday', 'pelanggans', 'barangs', 'pegawai'));
    }
}
