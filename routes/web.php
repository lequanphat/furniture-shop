<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestsController;
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

    // user
    Route::get('/', [PagesController::class, 'index']);

    // admin
    Route::get('/admin', [PagesController::class, 'admin']);

    // users
    Route::get('admin/users', [UserController::class, 'index']);
    Route::post('admin/users/create-user', [UserController::class, 'createUser']);
    Route::get('admin/users/delete/{id}', [UserController::class, 'deleteUser']);
});
