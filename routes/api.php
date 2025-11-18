<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\PenginapanController;

// USER
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::patch('/users/{user}', [UserController::class, 'patch']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::post('/login', [UserController::class, 'login']);

Route::get('/test', function () {
    return response()->json(['message' => 'API berjalan']);
});

// Sanctum Protected
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
});

// TOPUP
Route::get('/topups', [TopupController::class, 'index']);
Route::post('/topups', [TopupController::class, 'store']);
Route::get('/topups/{topup}', [TopupController::class, 'show']);
Route::put('/topups/{topup}', [TopupController::class, 'update']);
Route::patch('/topups/{topup}', [TopupController::class, 'patch']);
Route::delete('/topups/{topup}', [TopupController::class, 'destroy']);

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
