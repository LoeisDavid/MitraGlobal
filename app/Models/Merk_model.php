<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merk_model extends Model
{
    protected $table = 'merk';
    protected $primaryKey = 'kode_merk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_merk',
        'nama'
    ];
}
