<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;


// auth api
Route::get('login', [PagesController::class, 'login'])->name('login');
Route::get('register', [PagesController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('logout', [AuthController::class, 'logout']);

// public api
Route::get('/', [PagesController::class, 'index']);
Route::get('/shop', [PagesController::class, 'shop']);
Route::get('/about', [PagesController::class, 'about']);
Route::get('/services', [PagesController::class, 'services']);
Route::get('/blog', [PagesController::class, 'blog']);
Route::get('/contact', [PagesController::class, 'contact']);


Route::middleware([AuthMiddleware::class])->group(function () {
    // private api
});

Route::middleware([AdminMiddleware::class])->group(function () {
    // admin api
    Route::get('/admin', [PagesController::class, 'admin']);
    Route::get('/admin/users', [PagesController::class, 'admin_users']);
    Route::get('/admin/user1', [PagesController::class, 'admin_user1']);
    Route::get('/admin/user2', [PagesController::class, 'admin_user2']);
});
