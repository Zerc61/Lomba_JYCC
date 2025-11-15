<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topup extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

     protected $table = 'topups';

      protected $primaryKey = 'id_topup';

    protected $fillable = [
        'name',
        'email',
        'password',
        'no_telpon',
        'role',
        'saldo_rupiah',
        'saldo_emas',
        'saldo_dcoin'
    ];

    protected $hidden = [
        'password',
    ];
}
