<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pegawai_model extends Authenticatable
{
    protected $table = 'pegawai';

    protected $primaryKey = 'kode_pegawai';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_pegawai',
        'nama',
        'username',
        'password'
    ];

    protected $hidden = [
        'password',
    ];

    public function nota()
    {
        return $this->hasMany(
            Nota_model::class,
            'pegawai_kode_pegawai',
            'kode_pegawai'
        );
    }
}
