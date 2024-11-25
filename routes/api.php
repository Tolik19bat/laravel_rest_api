<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class, 'register']);
Route::post('login',[AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('logout',[AuthController::class, 'logout']);

Route::post('/tokens/create', [TokenController::class, 'create']);


Route::middleware('auth:sanctum')->apiResource('cars', CarController::class); 
