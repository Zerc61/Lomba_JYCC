<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model.
     * @var string
     */
    protected $table = 'wisatas';

    /**
     * Kolom kunci utama di tabel.
     * @var string
     */
    protected $primaryKey = 'id_wisata';

    /**
     * Tipe data kunci utama (optional, tapi baik untuk kejelasan).
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Menentukan bahwa kolom kunci utama adalah auto-incrementing.
     * @var bool
     */
    public $incrementing = true;

    /**
     * Kolom yang dapat diisi secara massal (mass assignable).
     * Tambahkan 'id_user' dan 'nama_user' (walaupun 'nama_user' mungkin sebaiknya diambil dari relasi User,
     * tapi disesuaikan dengan kebutuhan form Anda).
     * @var array
     */
    protected $fillable = [
        'id_user',
        'nama_user', // Disimpan untuk kemudahan akses di admin panel (asumsi sementara)
        'nama',
        'kategori',
        'alamat_wisata',
        'deskripsi',
        'foto_wisata',
        'biaya_wisata',
        'lokasi',
    ];

    /**
     * Kolom yang harus di-casting ke tipe data tertentu.
     * @var array
     */
    protected $casts = [
        'biaya_wisata' => 'integer',
    ];

    // Opsional: Relasi ke model User (jika ada)
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id_user', 'id');
    // }
}