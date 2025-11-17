<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkms';
    protected $primaryKey = "id_umkms";

    protected $fillable = [
        'pemilik',
        'nama',
        'informasi_umkm',
        'pasokan_umkm',
        'harga',
        'kategori',
        'foto_umkm',
        'jam_buka',
        'jam_tutup'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'pasokan_umkm' => 'integer',
        'jam_buka' => 'datetime',
        'jam_tutup' => 'datetime',
    ];
}
