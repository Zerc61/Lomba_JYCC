<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transportasi';
    protected $fillable = [
        'informasi_transportasi',
        'jenis_kendaraan',
        'plat_nomor',
        'harga',
        'diskon',
        'informasi_online',
        'deskripsi_transportasi',
    ];

}
