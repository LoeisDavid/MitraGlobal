<?php

namespace App\Http\Controllers;

use App\Models\Nota_model;
use Illuminate\Support\Facades\DB;

abstract class Controller
{
   function generateKodeMerk(string $nama): string
{
    $nama = trim($nama);

    // Jika ada angka → ambil semua
    if (preg_match('/\d/', $nama)) {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $nama));
    }

    // Hapus selain huruf
    $nama = preg_replace('/[^A-Za-z]/', '', $nama);

    return strtoupper(substr($nama, 0, 4));
}

function generateKodeKategori(string $nama): string
{
    // Bersihkan spasi berlebih
    $nama = trim(preg_replace('/\s+/', ' ', $nama));
    $kata = explode(' ', $nama);

    // Hitung total huruf (tanpa spasi)
    $totalHuruf = strlen(str_replace(' ', '', $nama));

    // Jika total huruf <= 5, ambil semua
    if ($totalHuruf <= 5) {
        return strtoupper(str_replace(' ', '', $nama));
    }

    // Jika hanya 1 kata
    if (count($kata) === 1) {
        return strtoupper(substr($kata[0], 0, 5));
    }

    $maxSlot = 5;
    $hasilPerKata = [];
    $slotTerpakai = 0;

    // Step 1: ambil huruf pertama tiap kata (disimpan per kata)
    foreach ($kata as $k) {
        if ($slotTerpakai < $maxSlot) {
            $hasilPerKata[] = strtoupper($k[0]);
            $slotTerpakai++;
        } else {
            $hasilPerKata[] = '';
        }
    }

    $slotSisa = $maxSlot - $slotTerpakai;

    // Step 2: isi slot sisa (huruf kedua lalu terakhir, per kata)
    for ($i = 0; $i < count($kata) && $slotSisa > 0; $i++) {
        $panjang = strlen($kata[$i]);

        // huruf kedua
        if ($panjang >= 2 && $slotSisa > 0) {
            $hasilPerKata[$i] .= strtoupper($kata[$i][1]);
            $slotSisa--;
        }

        // huruf terakhir
        if ($panjang >= 1 && $slotSisa > 0) {
            $hasilPerKata[$i] .= strtoupper($kata[$i][$panjang - 1]);
            $slotSisa--;
        }
    }

    // Gabungkan sesuai urutan kata
    return implode('', $hasilPerKata);
}


    function generateKodeBarang(string $nama): string
{
    
    // Rapikan spasi
    $nama = trim(preg_replace('/\s+/', ' ', $nama));
    $kataSemua = explode(' ', $nama);

    $kataNonTipe = [];
    $kataTipe = [];

    // Pisahkan kata tipe dan non-tipe
    foreach ($kataSemua as $k) {
        if (preg_match('/\d/', $k)) {
            $kataTipe[] = strtoupper($k);
        } else {
            $kataNonTipe[] = strtoupper($k);
        }
    }

    $jumlahNonTipe = count($kataNonTipe);
    $kode = '';

    // ===== ATURAN B =====
    if ($jumlahNonTipe >= 5) {
        foreach ($kataNonTipe as $k) {
            $kode .= $k[0];
        }
    }
    // ===== ATURAN A =====
    else {
        $maxSlot = 5;
        $hasilPerKata = [];
        $slotTerpakai = 0;

        // Ambil huruf pertama tiap kata (disimpan)
        foreach ($kataNonTipe as $k) {
            if ($slotTerpakai < $maxSlot) {
                $hasilPerKata[] = $k[0];
                $slotTerpakai++;
            } else {
                $hasilPerKata[] = '';
            }
        }

        $slotSisa = $maxSlot - $slotTerpakai;

        // Isi slot sisa: huruf kedua lalu terakhir
        for ($i = 0; $i < count($kataNonTipe) && $slotSisa > 0; $i++) {
            $panjang = strlen($kataNonTipe[$i]);

            if ($panjang >= 2 && $slotSisa > 0) {
                $hasilPerKata[$i] .= $kataNonTipe[$i][1];
                $slotSisa--;
            }

            if ($panjang >= 1 && $slotSisa > 0) {
                $hasilPerKata[$i] .= $kataNonTipe[$i][$panjang - 1];
                $slotSisa--;
            }
        }

        $kode = implode('', $hasilPerKata);
    }

    // Gabungkan kata tipe (angka)
    return $kode . implode('', $kataTipe);
}


    function generateNoNota(string $tanggal): string
    {
        $dateKey = date('Ymd', strtotime($tanggal));
        $prefix  = "MGA-$dateKey-";

        return DB::transaction(function () use ($prefix) {

            $lastNota = Nota_model::where('no_nota', 'like', $prefix . '%')
                ->orderBy('no_nota', 'desc')
                ->lockForUpdate()
                ->value('no_nota');

            if ($lastNota) {
                $lastNumber = (int) substr($lastNota, -2);
                $nextNumber = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '01';
            }

            return $prefix . $nextNumber;
        });
    
}









}
