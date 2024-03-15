<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\supplierController;
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
    //brand
    Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/admin/brands/search', [BrandController::class, 'search'])->name('brands.search');
    Route::get('/admin/brands/create', [BrandController::class,'create'])->name('brands.create');
    Route::post('/admin/brands', [BrandController::class,'store'])->name('brands.store');
    Route::get('/admin/brands/{id}/show', [BrandController::class,'show'])->name('brands.show');
    Route::get('/admin/brands/{id}/edit', [BrandController::class,'edit'])->name('brands.edit');
    Route::get('/admin/brands/{id}', [BrandController::class,'update'])->name('brands.update');
//supplier
Route::get('/admin/suppliers', [supplierController::class, 'index'])->name('suppliers.index');
Route::get('/admin/suppliers/search', [supplierController::class, 'search'])->name('suppliers.search');
Route::get('/admin/suppliers/create', [supplierController::class,'create'])->name('suppliers.create');
Route::post('/admin/suppliers', [supplierController::class,'store'])->name('suppliers.store');
Route::get('/admin/suppliers/{id}/show', [supplierController::class,'show'])->name('suppliers.show');
Route::get('/admin/suppliers/{id}/edit', [supplierController::class,'edit'])->name('suppliers.edit');
Route::get('/admin/suppliers/{id}', [supplierController::class,'update'])->name('suppliers.update');
//
    Route::get('/admin', [PagesController::class, 'admin'])->name('admin');
    Route::get('/admin/employee', [PagesController::class, 'admin_employee']);
    Route::get('/admin/customers', [PagesController::class, 'admin_customers']);
    Route::get('/admin/products', [PagesController::class, 'admin_products']);
    Route::get('/admin/categories', [PagesController::class, 'admin_categories']);
   
    Route::get('/admin/discounts', [PagesController::class, 'admin_discounts']);
    Route::get('/admin/orders', [PagesController::class, 'admin_orders']);
    Route::get('/admin/warranties', [PagesController::class, 'admin_warranties']);
    Route::get('/admin/receipts', [PagesController::class, 'admin_receipts']);
    Route::get('/admin/permissions', [PagesController::class, 'admin_permissions']);
    Route::get('/admin/authorization', [PagesController::class, 'admin_authorization']);
    Route::get('/admin/profile', [PagesController::class, 'admin_profiles']);
    Route::get('/admin/settings', [PagesController::class, 'admin_settings']);
});
