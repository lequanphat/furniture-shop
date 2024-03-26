<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ReceiptsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PrivateMiddleware;
use App\Http\Middleware\PublicMiddleware;
use Illuminate\Support\Facades\Route;

// auth api
Route::middleware([AuthMiddleware::class])->group(function () {
    // login
    Route::get('login', [AuthController::class, 'login_ui'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    // register
    Route::get('register', [AuthController::class, 'register_ui'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    // account verification
    Route::get('account-verification/{user_id}', [AuthController::class, 'account_verification_ui'])->where('id', '[0-9]+');
    Route::post('account-verification/{user_id}', [AuthController::class, 'account_verification'])->where('id', '[0-9]+');
    Route::get('resend-otp/{user_id}', [AuthController::class, 'resend_otp'])->where('id', '[0-9]+');
    // forgot password
    Route::get('forgot-password', [AuthController::class, 'forgot_password_ui']);
    Route::post('forgot-password', [AuthController::class, 'forgot_password']);
    Route::get('forgot-password-verification', [AuthController::class, 'forgot_password_verification_ui'])->where('id', '[0-9]+');;
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

    Route::get('/profile', [PagesController::class, 'profile']);
});


Route::middleware([AdminMiddleware::class])->group(function () {
    // admin api
    Route::get('/admin', [PagesController::class, 'admin'])->name('admin');

    // users routes
    Route::get('/admin/employee/{user_id}/ban', [UserController::class, 'ban_user']);
    Route::get('/admin/employee/{user_id}/unban', [UserController::class, 'unban_user']);
    // employee routes
    Route::get('/admin/employee', [UserController::class, 'employee_ui']);
    Route::post('/admin/employee/create', [UserController::class, 'create_employee']);
    Route::get('/admin/employee/{user_id}/details', [UserController::class, 'employee_details_ui']);
    Route::post('/admin/employee/update', [UserController::class, 'update_employee']);
    // customer routes
    Route::get('/admin/customers', [UserController::class, 'customers_ui']);
    Route::get('/admin/customers/{user_id}/details', [UserController::class, 'customer_details_ui']);

    //brand
    Route::get('/admin/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/admin/brands/search', [BrandController::class, 'search'])->name('brands.search');
    Route::get('/admin/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/admin/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/admin/brands/{id}/show', [BrandController::class, 'show'])->name('brands.show');
    Route::get('/admin/brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/admin/brands/edit/{id}', [BrandController::class, 'update'])->name('brands.update');
    //supplier
    Route::get('/admin/suppliers', [supplierController::class, 'index'])->name('suppliers.index');
    Route::get('/admin/suppliers/search', [supplierController::class, 'search'])->name('suppliers.search');
    Route::get('/admin/suppliers/create', [supplierController::class, 'create'])->name('suppliers.create');
    Route::post('/admin/suppliers', [supplierController::class, 'store'])->name('suppliers.store');
    Route::get('/admin/suppliers/{id}/show', [supplierController::class, 'show'])->name('suppliers.show');
    Route::get('/admin/suppliers/{id}/edit', [supplierController::class, 'edit'])->name('suppliers.edit');
    Route::get('/admin/suppliers/{id}', [supplierController::class, 'update'])->name('suppliers.update');

    // category
    Route::get('/admin/categories', [CategoryController::class, 'category_ui']);
    Route::post('/admin/categories/create', [CategoryController::class, 'category_insert']);
    // Route::post('/admin/categories', [CategoryController::class, 'category_insert']); for create
    Route::get('/admin/categories/delete/{id}', [CategoryController::class, 'category_delete']);
    // Route::delete('/admin/categories/{id}', [CategoryController::class, 'category_delete']); for delete
    Route::post('/admin/categories/update', [CategoryController::class, 'category_update']);
    // Route::patch('/admin/categories/{id}', [CategoryController::class, 'category_delete']); for update

    // product
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create_ui'])->name('products.create_ui');
    Route::post('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/admin/products/{product_id}', [ProductController::class, 'details'])->name('products.details');
    Route::get('/admin/products/{product_id}/update', [ProductController::class, 'update_ui'])->name('products.update_ui');
    Route::patch('/admin/products/{product_id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/admin/products/{product_id}/create', [ProductController::class, 'create_detailed_product_ui'])->name('products.create_detailed_product_ui');
    Route::post('/admin/products/{product_id}/create', [ProductController::class, 'create_detailed_product'])->name('products.create_detailed_product');

    // receipts
    Route::get('/admin/receipts', [ReceiptsController::class, 'index']);

    // *This is only temporary, use the appropriate controller
    Route::get('/admin/discounts', [DiscountController::class, 'index']);
Route::post('/admin/discounts/create',[DiscountController::class,'create'] );




    Route::get('/admin/orders', [PagesController::class, 'admin_orders']);
    Route::get('/admin/warranties', [PagesController::class, 'admin_warranties']);
    Route::get('/admin/receipts', [PagesController::class, 'admin_receipts']);
    Route::get('/admin/permissions', [PagesController::class, 'admin_permissions']);
    Route::get('/admin/authorization', [PagesController::class, 'admin_authorization']);
    Route::get('/admin/profile', [PagesController::class, 'admin_profiles']);
    Route::get('/admin/settings', [PagesController::class, 'admin_settings']);

    Route::get('/admin/catetest', [CategoryController::class, 'category_ui_1']);

});
