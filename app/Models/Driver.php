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
        'no_hp',
        'alamat',
        'foto_driver',
        'email'
    ];

}
