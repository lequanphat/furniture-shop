<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authorizate;
use Illuminate\Support\Facades\Route;


Route::middleware([Authorizate::class])->group(function () {
    // auth
    Route::get('login', [AuthController::class, 'loginView']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'registerView']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('logout', [AuthController::class, 'logout']);

    // dashboard
    Route::get('/', function () {
        return view('dashboard.index');
    });

    // products
    Route::get('admin/products', [ProductController::class, 'index']);
    Route::post('admin/products/create-product', [ProductController::class, 'createProduct']);
    Route::get('admin/products/{id}', [ProductController::class, 'details']);
    Route::get('admin/products/delete/{id}', [ProductController::class, 'deleteProduct']);


    // users
    Route::get('admin/users', [UserController::class, 'index']);
    Route::post('admin/users/create-user', [UserController::class, 'createUser']);
    Route::get('admin/users/delete/{id}', [UserController::class, 'deleteUser']);
});
