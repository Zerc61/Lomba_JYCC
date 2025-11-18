<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'pakets';
    protected $primaryKey = 'id_paket';

    protected $fillable = [
        'id_umkm',
        'jenis_paket',
        'deskripsi_paket'
    ];
}

