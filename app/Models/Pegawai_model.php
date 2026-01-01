<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai_model extends Model
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

     public function nota()
    {
        return $this->hasMany(
            Nota_model::class,
            'pegawai_kode_pegawai',
            'kode_pegawai'
        );
    }
}
