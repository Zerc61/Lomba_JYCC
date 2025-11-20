<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_driver'; // sesuaikan dengan migration
    protected $fillable = [
        'nama',
        'umur',
        'jenis_kelamin',
        'rating',
        'no_telepon',
        'alamat',
        'foto_driver',
    ];

    // Relasi ke transportasi (1 driver bisa punya banyak transportasi)
    public function transportasis()
    {
        return $this->hasMany(Transportasi::class, 'driver_id', 'id_driver');
    }
}
