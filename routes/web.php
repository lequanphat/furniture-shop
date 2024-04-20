<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HotDealController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReceiptsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarrantyController;
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
    Route::get('/shop', [PagesController::class, 'shop'])->name('shop');
    Route::get('/about', [PagesController::class, 'about']);
    Route::get('/contact', [PagesController::class, 'contact']);
    // products api
    Route::get('/products/{product_id}', [PagesController::class, 'product_details']);
    Route::get('/products', [ProductController::class, 'get_products']); // => json

    Route::get('/cart', [PagesController::class, 'cart'])->name('cart');
    Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout');;

    Route::get('/products', [ProductController::class, 'get_products']);
    Route::get('/top5deal', [HotDealController::class, 'get_Deal_of_Date_product']);
    Route::get('/lastproducts', [HotDealController::class, 'get_LastestProduct']);
    Route::get('/bestseller', [HotDealController::class, 'get_BestSeller']);

});

Route::middleware([PrivateMiddleware::class])->group(function () {
    // private api
    //account
    Route::get('/account', [ProfileController::class, 'customer_ui'])->name('my_account');
    Route::post('/account/profile/update', [ProfileController::class, 'update_customer']);
    //address_card
    Route::post('/account/profile/addresscard/update', [AddressController::class, 'update_address']);
    Route::post('/account/profile/addresscard/create', [AddressController::class, 'create_address']);
    Route::post('/account/profile/addresscard/remove', [AddressController::class, 'remove_address']);
    // checkout
    Route::post('/checkout', [OrderController::class, 'checkout_order'])->name('checkout');
    Route::get('/checkout/{order_id}', [PagesController::class, 'handle_checkout_order'])->name('checkout.handle');

    // my orders
    Route::get('/myorders', [PagesController::class, 'my_orders'])->name('my_orders');
    Route::get('/myorders/{order_id}', [PagesController::class, 'my_detailed_order'])->name('my_detailed_order');
    Route::patch('/myorders/{order_id}', [OrderController::class, 'cancel_order']);
});


Route::middleware([AdminMiddleware::class])->group(function () {
    // admin api
    Route::get('/admin', [HomeController::class, 'index'])->name('admin');
    Route::get('/change-password', [PagesController::class, 'change_password'])->name('change_password_ui');
    Route::post('/change-password', [AuthController::class, 'change_password'])->name('change_password');

    // users routes
    Route::get('/admin/employee/{user_id}/ban', [UserController::class, 'ban_user']);
    Route::get('/admin/employee/{user_id}/unban', [UserController::class, 'unban_user']);
    // employee routes
    Route::get('/admin/employee', [UserController::class, 'employee_ui']);
    Route::get('/admin/employee/pagination', [UserController::class, 'employee_pagination']);
    Route::post('/admin/employee/create', [UserController::class, 'create_employee']);
    Route::get('/admin/employee/{user_id}', [UserController::class, 'employee_details']);
    Route::get('/admin/employee/{user_id}/details', [UserController::class, 'employee_details_ui']);
    Route::post('/admin/employee/update', [UserController::class, 'update_employee']);
    // customer routes
    Route::get('/admin/customers', [UserController::class, 'customers_ui']);
    Route::get('/admin/customers/{user_id}/details', [UserController::class, 'customer_details_ui']);

    //brand
    Route::get('/admin/brands', [BrandController::class, 'brand_ui'])->name('brands.index');
    Route::get('/admin/brands', [BrandController::class, 'brand_search_ui'])->name('brands.search');
    Route::get('/admin/brands/pagination', [BrandController::class, 'brands_pagination'])->name('brands.search');
    Route::post('/admin/brands/create', [BrandController::class, 'brand_create'])->name('brands.create');
    Route::put('/admin/brands/update', [BrandController::class, 'brand_update'])->name('brands.edit');
    
    //supplier
    Route::get('/admin/suppliers', [SupplierController::class, 'supplier_ui'])->name('suppliers.index');
    Route::get('/admin/suppliers/pagination', [SupplierController::class, 'supplier_pagination'])->name('suppliers.search');
    Route::post('/admin/suppliers/create', [SupplierController::class, 'supplier_create']);
    Route::put('/admin/suppliers/update', [SupplierController::class, 'supplier_update'])->name('suppliers.edit');


    //order
    Route::get('/admin/orders', [OrderController::class, 'index']);
    Route::post('/admin/orders', [OrderController::class, 'create']);
    Route::put('/admin/orders/{order_id}', [OrderController::class, 'update']);

    //order detail
    Route::get('/admin/orders/{order_id}', [OrderController::class, 'details'])->name('orders.details');
    Route::post('/admin/orders/{order_id}', [OrderController::class, 'create_detailed_order']);

    //warranty
    Route::get('/admin/warranties', [WarrantyController::class, 'index']);
    Route::post('/admin/warranties/create', [WarrantyController::class, 'warranty_create']);
    Route::put('/admin/warranties/{warranty_id}', [WarrantyController::class, 'warranty_update']);
    //Route::get('/admin/warranties', [WarrantyController::class,'warranty_search_ui'])->name('warranty.search');
    Route::get('/admin/warranties/search', [WarrantyController::class, 'search_warranties_ajax'])->name('warranty.search');

    // category
    Route::get('/admin/categories', [CategoryController::class, 'category_ui']);
    Route::post('/admin/categories', [CategoryController::class, 'create'])->name('categories.create');
    Route::delete('/admin/categories/{category_id}', [CategoryController::class, 'delete'])->name('categories.delete');
    Route::patch('/admin/categories/{category_id}', [CategoryController::class, 'update'])->name('categories.update');


    // tag
    Route::get('/admin/tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('/admin/tags', [TagController::class, 'create'])->name('tags.create');
    Route::patch('/admin/tags/{tag_id}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/admin/tags/{tag_id}', [TagController::class, 'delete'])->name('tags.delete');

    // color
    Route::get('/admin/colors', [ColorController::class, 'index'])->name('colors.index');
    Route::post('/admin/colors', [ColorController::class, 'create'])->name('colors.create');
    Route::patch('/admin/colors/{color_id}', [ColorController::class, 'update'])->name('colors.update');
    Route::delete('/admin/colors/{color_id}', [ColorController::class, 'delete'])->name('colors.delete');

    // product
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/products/pagination', [ProductController::class, 'products_pagination'])->name('products.pagination'); //-> json
    Route::get('/admin/products/create', [ProductController::class, 'create_ui'])->name('products.create_ui');
    Route::post('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/admin/products/detailed_products', [ProductController::class, 'search_detailed_product'])->name('products.detailed_products.search'); // => json
    Route::get('/admin/products/{product_id}', [ProductController::class, 'details'])->name('products.details');
    Route::get('/admin/products/{product_id}/update', [ProductController::class, 'update_ui'])->name('products.update_ui');
    Route::patch('/admin/products/{product_id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/admin/products/{product_id}/create', [ProductController::class, 'create_detailed_product_ui'])->name('products.create_detailed_product_ui');
    Route::post('/admin/products/{product_id}/create', [ProductController::class, 'create_detailed_product'])->name('products.create_detailed_product');
    Route::get('/admin/products/{product_id}/{sku}', [ProductController::class, 'detailed_product_details'])->name('products.detailed_product_details');
    Route::get('/admin/products/{product_id}/{sku}/update', [ProductController::class, 'update_detailed_product_ui'])->name('products.update_detailed_product_ui');
    Route::patch('/admin/products/{product_id}/{sku}/update', [ProductController::class, 'update_detailed_product'])->name('products.update_detailed_product');


    // receipts
    Route::get('/admin/receipts', [ReceiptsController::class, 'index']);

    // discounts
    Route::get('/admin/discounts', [DiscountController::class, 'index']);
    Route::post('/admin/discounts/create', [DiscountController::class, 'create']);
    Route::patch('/admin/discounts/update', [DiscountController::class, 'update'])->name('discounts.update');
    Route::delete('admin/discounts/delete/{id}', [DiscountController::class, 'destroy'])->name('discount.delete');
    Route::get('/admin/discounts/viewDetail/{discount_id}', [DiscountController::class, 'discount_detail'])->name('discount.detail');

    Route::post('/admin/discounts/update-product-discount', [DiscountController::class, 'updateProductDiscount'])->name("product.Discount.checkbox");
    Route::post('/admin/discounts/deleteProductDiscount', [DiscountController::class, 'deleteProductDiscountCheck'])->name('delete.ProductDiscount.checkbox');
    //profile
    Route::get('/admin/profile/{user_id}', [ProfileController::class, 'user_ui'])->name('profiles.profile_details');
    Route::post('/admin/profile', [ProfileController::class, 'update_employee']);




    Route::get('/admin/roles', [PermissionController::class, 'index']);
    Route::post('/admin/roles', [PermissionController::class, 'create']);
    Route::patch('/admin/roles/{role_id}', [PermissionController::class, 'update']);
    Route::get('/admin/roles/{role_id}', [PermissionController::class, 'get_role']);


    Route::get('/admin/authorization', [PermissionController::class, 'authorization_ui']);
    Route::post('/admin/authorization', [PermissionController::class, 'assign_role']);


    // *This is only temporary, use the appropriate controller





    Route::get('/admin/settings', [PagesController::class, 'admin_settings']);

    Route::get('/admin/catetest', [CategoryController::class, 'category_ui_1']);
});
