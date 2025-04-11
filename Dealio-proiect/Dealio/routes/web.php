<?php
// routes/web.php
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('products', ProductController::class);
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show']);
