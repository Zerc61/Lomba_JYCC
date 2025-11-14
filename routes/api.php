<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::post('/login', [UserController::class, 'login']);

Route::get('/test', function () {
    return response()->json(['message' => 'API berjalan']);
});

//ALTER TABLE users AUTO_INCREMENT = 1

Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [UserController::class, 'logout']);
});