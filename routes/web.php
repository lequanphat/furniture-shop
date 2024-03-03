<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PrivateMiddleware;
use App\Http\Middleware\PublicMiddleware;
use Illuminate\Support\Facades\Route;


// auth api
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('login', [PagesController::class, 'login'])->name('login');
    Route::get('register', [PagesController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('email-verify/{user_id}', [PagesController::class, 'emailVerify'])->where('id', '[0-9]+');
    Route::post('email-verify/{user_id}', [AuthController::class, 'verifyAccount'])->where('id', '[0-9]+');
});
Route::get('logout', [AuthController::class, 'logout']);



Route::middleware([PublicMiddleware::class])->group(function () {
    // public api
    Route::get('/', [PagesController::class, 'index']);
    Route::get('/shop', [PagesController::class, 'shop']);
    Route::get('/about', [PagesController::class, 'about']);
    Route::get('/services', [PagesController::class, 'services']);
    Route::get('/blog', [PagesController::class, 'blog']);
    Route::get('/contact', [PagesController::class, 'contact']);
});

Route::middleware([PrivateMiddleware::class])->group(function () {
    // private api

});

Route::middleware([AdminMiddleware::class])->group(function () {
    // admin api
    Route::get('/admin', [PagesController::class, 'admin'])->name('admin');
    Route::get('/admin/users', [PagesController::class, 'admin_users']);
    Route::get('/admin/user1', [PagesController::class, 'admin_user1']);
    Route::get('/admin/user2', [PagesController::class, 'admin_user2']);
});
