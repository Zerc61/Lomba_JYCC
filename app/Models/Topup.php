<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Ini sudah cukup
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini untuk relasi balik

class Topup extends Model
{
    use HasFactory; // Hanya ini yang diperlukan

    /**
     * Nama tabel yang digunakan
     */
    protected $table = 'topups';

    /**
     * Primary key dari tabel
     */
    protected $primaryKey = 'id_topup';

    /**
     * Kolom yang bisa diisi secara massal
     */
    protected $fillable = [
        'id_user',
        'name',
        'email',
        'no_telpon',
        'role',
        'saldo_rupiah',
        'saldo_emas',
        'saldo_dcoin',
        'pajak',
        'admin',
        'metode_pembayaran',
        'status_bayar'
    ];

    /**
     * Relasi ke model User (ini adalah relasi balik)
     * Satu data Topup dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
}