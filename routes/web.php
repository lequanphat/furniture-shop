<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PrivateMiddleware;
use App\Http\Middleware\PublicMiddleware;
use Illuminate\Support\Facades\Route;


// auth api
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('login', [AuthController::class, 'login_ui'])->name('login');
    Route::get('register', [AuthController::class, 'register_ui'])->name('register');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('email-verify/{user_id}', [AuthController::class, 'accountVerification_ui'])->where('id', '[0-9]+');
    Route::post('email-verify/{user_id}', [AuthController::class, 'accountVerification'])->where('id', '[0-9]+');
    Route::get('resend-otp/{user_id}', [AuthController::class, 'resendOTP'])->where('id', '[0-9]+');
});

Route::get('logout', [AuthController::class, 'logout']);

Route::middleware([PublicMiddleware::class])->group(function () {
    // public api
    Route::get('/', [PagesController::class, 'index'])->name('user');
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

    // users routes
    Route::get('/admin/employee', [UserController::class, 'employee_ui']);
    Route::get('/admin/customers', [UserController::class, 'customers_ui']);

    //
    Route::get('/admin/products', [PagesController::class, 'admin_products']);
    Route::get('/admin/categories', [PagesController::class, 'admin_categories']);
    Route::get('/admin/brands', [PagesController::class, 'admin_brands']);
    Route::get('/admin/discounts', [PagesController::class, 'admin_discounts']);
    Route::get('/admin/orders', [PagesController::class, 'admin_orders']);
    Route::get('/admin/warranties', [PagesController::class, 'admin_warranties']);
    Route::get('/admin/receipts', [PagesController::class, 'admin_receipts']);
    Route::get('/admin/suppliers', [PagesController::class, 'admin_suppliers']);
    Route::get('/admin/permissions', [PagesController::class, 'admin_permissions']);
    Route::get('/admin/authorization', [PagesController::class, 'admin_authorization']);
    Route::get('/admin/profile', [PagesController::class, 'admin_profiles']);
    Route::get('/admin/settings', [PagesController::class, 'admin_settings']);
});
