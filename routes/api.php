<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\CarController;
use Illuminate\Http\Request;

// Группа маршрутов для аутентификации
Route::middleware('guest')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});

// Группа защищенных маршрутов
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('auth.user');

    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::post('/tokens/create', [TokenController::class, 'create'])->name('tokens.create');

    // API-ресурс для управления машинами
    Route::apiResource('cars', CarController::class)->names([
        'index'   => 'cars.index',
        'store'   => 'cars.store',
        'show'    => 'cars.show',
        'update'  => 'cars.update',
        'destroy' => 'cars.destroy',
    ]);
});