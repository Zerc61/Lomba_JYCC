<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkms';
    protected $primaryKey = "id_umkm";

    protected $fillable = [
    'nama_umkm',
    'pemilik',
    'informasi_umkm',
    'pasokan_umkm',
    'harga',
    'kategori',
    'jam_buka',
    'jam_tutup',
    'foto_umkm'
];


    protected $casts = [
        'harga' => 'decimal:2',
        'pasokan_umkm' => 'integer',
        'jam_buka' => 'datetime',
        'jam_tutup' => 'datetime',
    ];
}
