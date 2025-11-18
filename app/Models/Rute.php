<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    protected $table = 'rutes';
    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'id_online',
        'id_umkm',
        'latitude',
        'longitude',
        'alamat',
    ];
}

