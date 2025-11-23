<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\PenginapanController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransportasiController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TiketWisataController;
use App\Models\Topup;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route untuk login dan register (tidak perlu login)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Route yang memerlukan autentikasi (harus login)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profil User
    Route::get('/users/me', [ProfileController::class, 'getUser']);
    Route::get('/topups/me', [ProfileController::class, 'getTopup']);
    Route::get('/topups/me/history', [ProfileController::class, 'getTopupHistory']); 

    // PERBAIKAN: Pindahkan route tiket wisata ke dalam middleware auth
    // dan ubah method dari 'confirmPayment' menjadi 'konfirmasi'
    Route::post('tiket-wisatas/{id}/confirm', [TiketWisataController::class, 'konfirmasi']);
    Route::get('tiket-wisatas', [TiketWisataController::class, 'index']);
    Route::post('tiket-wisatas', [TiketWisataController::class, 'store']);
    Route::get('tiket-wisatas/{id}', [TiketWisataController::class, 'show']);
    
    // Route untuk mendapatkan saldo user
    Route::get('/saldo', function (Request $request) {
        $user = $request->user();
        // PERBAIKAN: Gunakan primary key yang benar ('id_user')
        $topup = Topup::where('id_user', $user->id_user)->first();
        
        return response()->json([
            'status' => 1,
            'data' => [
                'saldo_rupiah' => $topup ? $topup->saldo_rupiah : 0,
                'saldo_dcoin' => $topup ? $topup->saldo_dcoin : 0,
            ],
            'message' => 'Data saldo berhasil dimuat.'
        ]);
    });

    Route::get('/my-tickets', [TiketWisataController::class, 'myTickets']);
});

// Route untuk umum (bisa diakses tanpa login, biasanya untuk admin)
// USER
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::patch('/users/{user}', [UserController::class, 'patch']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

// TOPUP
Route::get('/topups', [TopupController::class, 'index']);
Route::post('/topups', [TopupController::class, 'store']);
Route::get('/topups/{topup}', [TopupController::class, 'show']);
Route::put('/topups/{topup}', [TopupController::class, 'update']);
Route::delete('/topups/{topup}', [TopupController::class, 'destroy']);

// PENGINAPAN
Route::get('/penginapans', [PenginapanController::class, 'index']);
Route::post('/penginapans', [PenginapanController::class, 'store']);
Route::get('/penginapans/{id}', [PenginapanController::class, 'show']);
Route::put('/penginapans/{id}', [PenginapanController::class, 'update']);
Route::delete('/penginapans/{id}', [PenginapanController::class, 'destroy']);

// WISATA
Route::get('/wisatas', [WisataController::class, 'index']);
Route::post('/wisatas', [WisataController::class, 'store']);
Route::get('/wisatas/{wisata}', [WisataController::class, 'show']);
Route::put('/wisatas/{wisata}', [WisataController::class, 'update']);
Route::patch('/wisatas/{wisata}', [WisataController::class, 'patch']);
Route::delete('/wisatas/{wisata}', [WisataController::class, 'destroy']);

// UMKM
Route::get('/umkms', [UmkmController::class, 'index']);
Route::post('/umkms', [UmkmController::class, 'store']);
Route::get('/umkms/{umkm}', [UmkmController::class, 'show']);
Route::put('/umkms/{umkm}', [UmkmController::class, 'update']);
Route::patch('/umkms/{umkm}', [UmkmController::class, 'patch']);
Route::delete('/umkms/{umkm}', [UmkmController::class, 'destroy']);

// PAKET
Route::get('/pakets', [PaketController::class, 'index']);
Route::post('/pakets', [PaketController::class, 'store']);
Route::get('/pakets/{paket}', [PaketController::class, 'show']);
Route::put('/pakets/{paket}', [PaketController::class, 'update']);
Route::patch('/pakets/{paket}', [PaketController::class, 'patch']);
Route::delete('/pakets/{paket}', [PaketController::class, 'destroy']);

// TRANSPORTASI
Route::get('/transportasis', [TransportasiController::class, 'index']);
Route::post('/transportasis', [TransportasiController::class, 'store']);
Route::get('/transportasis/{transportasi}', [TransportasiController::class, 'show']);
Route::put('/transportasis/{transportasi}', [TransportasiController::class, 'update']);
Route::patch('/transportasis/{transportasi}', [TransportasiController::class, 'patch']);
Route::delete('/transportasis/{transportasi}', [TransportasiController::class, 'destroy']);

// RUTE
Route::get('/rutes', [RuteController::class, 'index']);
Route::post('/rutes', [RuteController::class, 'store']);
Route::get('/rutes/{rute}', [RuteController::class, 'show']);
Route::put('/rutes/{rute}', [RuteController::class, 'update']);
Route::patch('/rutes/{rute}', [RuteController::class, 'patch']);
Route::delete('/rutes/{rute}', [RuteController::class, 'destroy']);

// OTP
Route::get('/otps', [OtpController::class, 'index']);
Route::post('/otps', [OtpController::class, 'store']);
Route::get('/otps/{otp}', [OtpController::class, 'show']);
Route::put('/otps/{otp}', [OtpController::class, 'update']);
Route::patch('/otps/{otp}', [OtpController::class, 'patch']);
Route::delete('/otps/{otp}', [OtpController::class, 'destroy']);

// ROLE
Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles', [RoleController::class, 'store']);
Route::get('/roles/{role}', [RoleController::class, 'show']);
Route::put('/roles/{role}', [RoleController::class, 'update']);
Route::patch('/roles/{role}', [RoleController::class, 'patch']);
Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

// DRIVER
Route::get('/drivers', [DriverController::class, 'index']);
Route::post('/drivers', [DriverController::class, 'store']);
Route::get('/drivers/{id}', [DriverController::class, 'show']);
Route::put('/drivers/{id}', [DriverController::class, 'update']);
Route::delete('/drivers/{id}', [DriverController::class, 'destroy']);