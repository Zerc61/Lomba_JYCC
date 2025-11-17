<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    protected $table = 'wisatas';
    protected $primaryKey = 'id_wisata';

    protected $fillable = [
        'nama_wisata',
        'alamat_wisata',
        'informasi_wisata',
        'biaya_wisata',
        'kategori',
        'foto_wisata',
        'lokasi',
    ];
}
