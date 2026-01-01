<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Merk_model;
use App\Models\Kategori_model;

class Barang_model extends Model
{
    protected $table = 'barang';

    // primary key string
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_barang',
        'barcode',
        'nama',
        'harga_jual',
        'stok',
        'merk_kode_merk',
        'kategori_kode_kategori',
    ];

    /* ================= RELATIONSHIPS ================= */

    public function merk()
    {
        return $this->belongsTo(Merk_model::class, 'merk_kode_merk', 'kode_merk');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori_model::class, 'kategori_kode_kategori', 'kode_kategori');
    }
}
