<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan_model extends Model
{
    protected $table = 'pelanggan';

    protected $fillable = [
        'kode_pelanggan',
        'nama',
        'alamat',
        'telepon',
    ];
}
