<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota_model extends Model
{
    protected $table = 'notajual';

    protected $primaryKey = 'no_nota';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_nota',
        'tanggal',
        'pelanggan_kode_pelanggan',
        'pegawai_kode_pegawai',
        'draft',
    ];

    protected $casts = [
        'draft' => 'boolean',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan_model::class, 'pelanggan_kode_pelanggan', 'kode_pelanggan');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai_model::class, 'pegawai_kode_pegawai', 'kode_pegawai');
    }

    public function detil()
    {
        return $this->hasMany(NotaJualDetil_model::class, 'notajual_no_nota', 'no_nota');
    }
}
