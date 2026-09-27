<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpressController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/password/reset', [UserController::class, 'resetPassword']);
Route::post('/password/update', [UserController::class, 'updatePassword'])->middleware('auth:sanctum');

// FLASK
Route::post('/example', [AccountController::class, 'example']);

// NodeJS Express
Route::post('/express_example', [ExpressController::class, 'express_example']);
