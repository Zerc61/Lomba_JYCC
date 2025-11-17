<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\WisataController;
use App\Models\Wisata;

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::patch('/users/{user}', [UserController::class, 'patch']); // partial update
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::post('/login', [UserController::class, 'login']);

Route::get('/test', function () {
    return response()->json(['message' => 'API berjalan']);
});

//ALTER TABLE users AUTO_INCREMENT = 1

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [UserController::class, 'logout']);
});

//api TOPUP

Route::get('/topups', [TopupController::class, 'index']);
Route::get('/topups/{topup}', [TopupController::class, 'show']);
Route::post('/topups', [TopupController::class, 'store']);
Route::put('/topups/{topup}', [TopupController::class, 'update']); // full update
Route::patch('/topups/{topup}', [TopupController::class, 'patch']); // partial update
Route::delete('/topups/{topup}', [TopupController::class, 'destroy']);

//api WISATA

Route::get('/wisatas', [WisataController::class, 'index']);

