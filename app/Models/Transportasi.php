<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    protected $table = 'transportasis';
    protected $primaryKey = 'id_transportasi';

    protected $fillable = [
        'informasi_transportasi',
        'jenis_kendaraan',
        'nama_driver',
        'plat_nomor',
        'harga',
        'diskon',
        'informasi_online',
        'deskripsi_transportasi',
    ];
}

