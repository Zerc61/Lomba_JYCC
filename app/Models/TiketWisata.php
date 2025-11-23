<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketWisata extends Model
{
    use HasFactory;

    protected $table = 'tiket_wisatas';
    protected $primaryKey = 'id_tiket';
    
    protected $fillable = [
        'id_wisata',
        'id_user',
        'jumlah_tiket',
        'metode_pembayaran',
        'total_harga_dcoin',
        'total_harga_rupiah',
        'status_pembayaran',
        'tanggal_pembelian',
        'tanggal_konfirmasi',
    ];

    protected $casts = [
        'total_harga_dcoin' => 'integer',
        'total_harga_rupiah' => 'decimal:2',
        'tanggal_pembelian' => 'datetime',
        'tanggal_konfirmasi' => 'datetime',
    ];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}