<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/signup', [AuthController::class,'signup']);
Route::post('login', [AuthController::class,'login']);
Route::get('/products', [ProductController::class,'index']);

Route::get('/profile', [AuthController::class,'profile'])
    ->middleware(['auth:sanctum']);