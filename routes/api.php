<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::get('/test', function () {
    return response()->json(['message' => 'API berjalan']);
});

//ALTER TABLE users AUTO_INCREMENT = 1
