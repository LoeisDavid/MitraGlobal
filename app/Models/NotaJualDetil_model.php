<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nota_model as Notajual;
use App\Models\Barang_model as Barang;

class NotajualDetil_model extends Model
{
    /**
     * Nama tabel eksplisit
     */
    protected $table = 'notajual_detil';

    /**
     * Kolom yang boleh diisi
     */
    protected $fillable = [
        'notajual_no_nota',
        'barang_kode_barang',
        'harga',
        'jumlah',
        'diskon',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'harga'  => 'decimal:2',
        'jumlah' => 'integer',
        'diskon' => 'integer',
    ];

    /**
     * Relasi ke nota jual
     * notajual_detil.notajual_no_nota -> notajual.no_nota
     */
    public function notajual()
    {
        return $this->belongsTo(
            Notajual::class,
            'notajual_no_nota',
            'no_nota'
        );
    }

    /**
     * Relasi ke barang
     * notajual_detil.barang_kode_barang -> barang.kode_barang
     */
    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'barang_kode_barang',
            'kode_barang'
        );
    }
}
