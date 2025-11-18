<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Penginapan extends Model
{
    protected $primaryKey = 'id_penginapan';

    protected $fillable = [
        'nama_penginapan',
        'alamat_penginapan',
        'informasi_penginapan',
        'biaya_penginapan',
        'kategori',
        'foto_penginapan',
        'lokasi',
    ];
}
