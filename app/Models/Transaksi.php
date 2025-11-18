<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_transportasi',
        'id_user',
        'id_paket',
        'harga',
        'jam_berangkat',
        'jam_tiba',
        'tanggal_berangkat',
        'tanggal_tiba',
        'tujuan',
        'status',
    ];
}

