<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\PenginapanController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransportasiController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RoleController;

// USER
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::patch('/users/{user}', [UserController::class, 'patch']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

// TOPUP
Route::get('/topups', [TopupController::class, 'index']);
Route::post('/topups', [TopupController::class, 'store']);
Route::get('/topups/{topup}', [TopupController::class, 'show']);
Route::put('/topups/{topup}', [TopupController::class, 'update']);
Route::patch('/topups/{topup}', [TopupController::class, 'patch']);
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

// UMKM
Route::get('/umkms', [UmkmController::class, 'index']);
Route::post('/umkms', [UmkmController::class, 'store']);
Route::get('/umkms/{umkm}', [UmkmController::class, 'show']);


// PAKET
Route::get('/pakets', [PaketController::class, 'index']);
Route::post('/pakets', [PaketController::class, 'store']);
Route::get('/pakets/{paket}', [PaketController::class, 'show']);
Route::put('/pakets/{paket}', [PaketController::class, 'update']);
Route::patch('/pakets/{paket}', [PaketController::class, 'patch']);
Route::delete('/pakets/{paket}', [PaketController::class, 'destroy']);


// TRANSAKSI
Route::get('/transaksis', [TransaksiController::class, 'index']);
Route::post('/transaksis', [TransaksiController::class, 'store']);
Route::get('/transaksis/{transaksi}', [TransaksiController::class, 'show']);
Route::put('/transaksis/{transaksi}', [TransaksiController::class, 'update']);
Route::patch('/transaksis/{transaksi}', [TransaksiController::class, 'patch']);
Route::delete('/transaksis/{transaksi}', [TransaksiController::class, 'destroy']);



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