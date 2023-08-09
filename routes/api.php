<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthController;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::patch('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout/{user}', 'logout');
    Route::post('register', 'register');
});
