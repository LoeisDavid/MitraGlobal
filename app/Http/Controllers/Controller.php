<?php

namespace App\Http\Controllers;

abstract class Controller
{
   function generateCode(string $nama): string
{
    $vokal = ['A','I','U','E','O'];

    $nama = strtoupper(trim($nama));
    $nama = str_replace('-', ' ', $nama);
    $kata = array_values(array_filter(explode(' ', $nama)));

    $jumlahKata = count($kata);
    $hasil = '';

    // helper cek angka
    $hasNumber = fn($w) => preg_match('/\d/', $w);

    // ======================
    // 1 KATA
    // ======================
    if ($jumlahKata === 1) {
        $w = $kata[0];

        // jika ada angka → ambil utuh
        if ($hasNumber($w)) {
            return $w;
        }

        $len = strlen($w);

        if ($len <= 4) {
            return $w;
        }

        $awal = $w[0];
        $end  = $len - 1;

        // awal vokal
        if (in_array($awal, $vokal)) {
            $hasil = substr($w, 0, 3);

            while ($end >= 0 && !in_array($w[$end], $vokal)) {
                $end--;
            }

            if ($end >= 0 && strlen($hasil) < 4) {
                $hasil .= $w[$end];
            }

            return $hasil;
        }

        // awal non-vokal
        $depan = substr($w, 0, 2);

        if (!in_array($w[$end], $vokal)) {
            $end--;
        }

        $belakang = substr($w, max(0, $end - 1), 2);

        return $depan . $belakang;
    }

    // ======================
    // 2 KATA
    // ======================
    if ($jumlahKata === 2) {
        foreach ($kata as $w) {
            if ($hasNumber($w)) {
                $hasil .= $w;
            } else {
                $hasil .= substr($w, 0, 2);
            }
        }
        return $hasil;
    }

    // ======================
    // 3 KATA ATAU LEBIH
    // ======================
    foreach ($kata as $i => $w) {
        if ($i > 2) break;

        if ($hasNumber($w)) {
            $hasil .= $w;
        } else {
            $hasil .= ($i === 0)
                ? substr($w, 0, 2)
                : substr($w, 0, 1);
        }
    }

    return $hasil;
}






}
