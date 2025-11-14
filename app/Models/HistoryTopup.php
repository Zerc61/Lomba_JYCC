<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoryTopup extends Model
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'history_topups';

    protected $fillable = [
        'jumlah_rupiah',
        'jumlah_emas',
        'jumlah_dcoin',
        'riwayat_saldo'
    ];
}
