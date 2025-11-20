<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkms';
    protected $primaryKey = 'id_umkm';

    protected $fillable = [
        'nama_umkm',
        'pemilik',
        'informasi_umkm',
        'kategori',
        'jam_buka',
        'jam_tutup',
        'foto_umkm'
    ];

    protected $casts = [
        'jam_buka' => 'datetime:H:i',
        'jam_tutup' => 'datetime:H:i',
    ];

    public $timestamps = true;
}
