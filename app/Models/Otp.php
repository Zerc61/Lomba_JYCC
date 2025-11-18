<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $table = 'otps';
    protected $primaryKey = 'otp_id';

    protected $fillable = [
        'user_id',
        'otp_kode',
    ];
}

