<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    protected $table = 'wisatas';
    protected $primaryKey = 'id_wisata'; // primary key jadi id_wisata
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'kategori',
        'alamat_wisata',
        'deskripsi',
        'foto_wisata',
        'biaya_wisata',
        'lokasi',
    ];

}
