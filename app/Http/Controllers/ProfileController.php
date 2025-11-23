<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Mendapatkan data identitas user yang sedang login.
     * Endpoint: GET /api/users/me
     */
    public function getUser(Request $request)
    {
        // $request->user() akan otomatis mengambil user yang sedang login
        $user = $request->user(); 
        
        return response()->json([
            "status" => 1,
            "data" => $user
        ]);
    }

    /**
     * Mendapatkan data saldo user yang sedang login.
     * Endpoint: GET /api/topups/me
     */
     public function getTopup(Request $request)
    {
        $user = $request->user();
        
        // PERUBAHAN LOGIKA:
        // Kita tidak lagi mengambil satu data (->first()),
        // tetapi MENJUMLAHKAN (->sum()) semua data topup yang statusnya 'sudah'.
        
        $totalRupiah = $user->topup()->where('status_bayar', 'sudah')->sum('saldo_rupiah');
        $totalEmas = $user->topup()->where('status_bayar', 'sudah')->sum('saldo_emas');
        $totalDcoin = $user->topup()->where('status_bayar', 'sudah')->sum('saldo_dcoin');

        // Kembalikan data yang sudah dijumlahkan
        return response()->json([
            "status" => 1,
            "data" => [
                'id_user' => $user->id_user,
                'saldo_rupiah' => $totalRupiah,
                'saldo_emas' => $totalEmas,
                'saldo_dcoin' => $totalDcoin,
            ]
        ]);
    }

    public function getTopupHistory(Request $request)
    {
        $user = $request->user();
        
        // Ambil SEMUA data topup yang statusnya 'sudah'
        // dan urutkan dari yang terbaru
        $topupHistory = $user->topup()
            ->where('status_bayar', 'sudah')
            ->latest('updated_at') // Urutkan berdasarkan update terakhir
            ->get(); // Gunakan get() untuk mendapatkan koleksi/banyak data

        return response()->json([
            "status" => 1,
            "data" => $topupHistory
        ]);
    }
}