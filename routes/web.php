<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authorizate;
use Illuminate\Support\Facades\Route;


Route::middleware([Authorizate::class])->group(function () {
    // products
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products/create-product', [ProductController::class, 'createProduct']);
    Route::get('products/{id}', [ProductController::class, 'details']);
    Route::get('products/delete/{id}', [ProductController::class, 'deleteProduct']);


    // users
    Route::get('users', [UserController::class, 'index']);
    Route::post('users/create-user', [UserController::class, 'createUser']);
    Route::get('users/delete/{id}', [UserController::class, 'deleteUser']);
});
