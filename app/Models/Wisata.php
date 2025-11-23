<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;
    
    protected $table = 'wisatas';
    protected $primaryKey = 'id_wisata';
    
    protected $fillable = [
        'nama_user',
        'nama',
        'kategori',
        'alamat_wisata',
        'deskripsi',
        'foto_wisata',
        'biaya_wisata',
        'lokasi',
    ];
    
    // Tambahkan atribut virtual untuk harga_dcoin
    protected $appends = ['harga_dcoin'];
    
    public function getHargaDcoinAttribute()
    {
        // Konversi 1000 rupiah = 1 dcoin
        return round($this->biaya_wisata / 1000);
    }
    
    public function tikets()
    {
        return $this->hasMany(TiketWisata::class, 'id_wisata');
    }
}