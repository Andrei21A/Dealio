<?php
// routes/web.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserREgistrationController;
use Illuminate\Support\Facades\Route;

Route::resource('products', ProductController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('products', ProductController::class)
    ->only(['index', 'show']);

Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show'])
    ->middleware('auth');

Route::get('login', [AuthController::class, 'create'])
    ->name('login');
Route::post('login', [AuthController::class, 'store'])
    ->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])
    ->name('logout');

Route::resource('user-account', UserAccountController::class)
    ->only(['create', 'store']);

