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
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReceiptsController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarrantyController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PrivateMiddleware;
use App\Http\Middleware\PublicMiddleware;
use App\Models\Discount;
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

    // google login
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    // facebook login
    Route::get('auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);
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
    Route::get('/lastproducts', [HotDealController::class, 'get_LastestProduct']);
    Route::get('/bestseller', [HotDealController::class, 'get_BestSeller']);


    Route::get('/cart/async', [PagesController::class, 'asyncCart']);
});

Route::middleware([PrivateMiddleware::class])->group(function () {
    // private api
    Route::get('/change-password', [PagesController::class, 'change_password'])->name('change_password_ui');
    Route::post('/change-password', [AuthController::class, 'change_password'])->name('change_password');
    //account
    Route::get('/account', [PagesController::class, 'profile'])->name('my_account');
    Route::post('/account/profile/update', [PagesController::class, 'update_profile']);
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

    Route::get('/admin/dashboard/orders-statistic', [HomeController::class, 'getOrdersStatistic']);
    

    // users routes
    Route::middleware(['can:read users'])->group(function () {
        // employee routes
        Route::get('/admin/employee', [UserController::class, 'employee_ui']);
        Route::get('/admin/employee/pagination', [UserController::class, 'employee_pagination']);
        Route::get('/admin/employee/{user_id}', [UserController::class, 'employee_details']);
        Route::get('/admin/employee/{user_id}/details', [UserController::class, 'employee_details_ui']);

        // customer routes
        Route::get('/admin/customers', [UserController::class, 'customers_ui']);
        Route::get('/admin/customers/{user_id}/details', [UserController::class, 'customer_details_ui']);
        Route::get('/admin/customers/pagination', [UserController::class, 'customers_pagination']);
    });
    Route::middleware(['can:create user'])->group(function () {
        Route::post('/admin/employee/create', [UserController::class, 'create_employee']);
    });
    Route::middleware(['can:update user'])->group(function () {
        Route::post('/admin/employee/update', [UserController::class, 'update_employee']);
    });

    Route::middleware(['can:delete user'])->group(function () {
        Route::get('/admin/users/{user_id}/ban', [UserController::class, 'ban_user'])->middleware('can:delete user');
        Route::get('/admin/users/{user_id}/unban', [UserController::class, 'unban_user'])->middleware('can:delete user');
    });

    // brands routes
    Route::middleware(['can:read brands'])->group(function () {
        Route::get('/admin/brands', [BrandController::class, 'brand_ui'])->name('brands.index');
        Route::get('/admin/brands', [BrandController::class, 'brand_search_ui'])->name('brands.search');
        Route::get('/admin/brands/pagination', [BrandController::class, 'brands_pagination'])->name('brands.search');
    });
    Route::middleware(['can:create brand'])->group(function () {
        Route::post('/admin/brands/create', [BrandController::class, 'brand_create'])->name('brands.create');
    });
    Route::middleware(['can:update brand'])->group(function () {
        Route::put('/admin/brands/update', [BrandController::class, 'brand_update'])->name('brands.edit');
    });
    Route::middleware(['can:delete brand'])->group(function () {
        Route::delete('/admin/brands/{brand_id}/delete', [BrandController::class, 'brand_delete'])->name('brands.delete');
    });


    // categories routes
    Route::middleware(['can:read categories'])->group(function () {
        Route::get('/admin/categories', [CategoryController::class, 'category_ui']);
        Route::get('/admin/categories/getall', [CategoryController::class, 'getAll']);
        Route::get('/admin/categories/{category_id}', [CategoryController::class, 'getCategory']);
    });
    Route::post('/admin/categories', [CategoryController::class, 'create'])->name('categories.create');

    Route::middleware(['can:update category'])->group(function () {
        Route::patch('/admin/categories/{category_id}', [CategoryController::class, 'update'])->name('categories.update');
    });
    Route::middleware(['can:delete category'])->group(function () {
        Route::delete('/admin/categories/{category_id}', [CategoryController::class, 'delete'])->name('categories.delete');
    });


    // suppliers
    Route::middleware(['can:read suppliers'])->group(function () {
        Route::get('/admin/suppliers', [SupplierController::class, 'supplier_ui'])->name('suppliers.index');
        Route::get('/admin/suppliers/pagination', [SupplierController::class, 'supplier_pagination'])->name('suppliers.search');
    });
    Route::middleware(['can:create supplier'])->group(function () {
        Route::post('/admin/suppliers/create', [SupplierController::class, 'supplier_create']);
    });
    Route::middleware(['can:update supplier'])->group(function () {
        Route::put('/admin/suppliers/update', [SupplierController::class, 'supplier_update'])->name('suppliers.edit');
    });
    Route::middleware(['can:delete supplier'])->group(function () {
        Route::delete('/admin/suppliers/{supplier_id}/delete', [SupplierController::class, 'supplier_delete'])->name('suppliers.delete');
    });


    // orders and warranty routes
    Route::middleware(['can:read orders'])->group(function () {
        Route::get('/admin/orders', [OrderController::class, 'index']);
        Route::get('/admin/orders/search', [OrderController::class, 'search_orders_ajax']);
        // order detail
        Route::get('/admin/orders/{order_id}', [OrderController::class, 'details'])->name('orders.details');

        // warranty
        Route::get('/admin/warranties', [WarrantyController::class, 'index']);
        Route::get('/admin/warranties/search', [WarrantyController::class, 'search_warranties_ajax'])->name('warranty.search');
        Route::get('/admin/warranties/{warranty_id}', [WarrantyController::class, 'warranty_details'])->name('warranties.details');
    });
    Route::middleware(['can:create order'])->group(function () {
        Route::post('/admin/orders', [OrderController::class, 'create']);
        Route::post('/admin/orders/{order_id}', [OrderController::class, 'create_detailed_order']);
        Route::post('/admin/warranties/create', [WarrantyController::class, 'warranty_create']);
    });
    Route::middleware(['can:update order'])->group(function () {
        Route::put('/admin/orders/{order_id}', [OrderController::class, 'update']);
        Route::put('/admin/warranties/{warranty_id}', [WarrantyController::class, 'warranty_update']);
    });

    Route::middleware(['can:delete order'])->group(function () {
        Route::delete('/admin/orders/{order_id}/delete/{sku}', [OrderController::class, 'remove_detailed_order']);
    });

    // colors and tags
    Route::middleware(['can:read colors'])->group(function () {
        Route::get('/admin/colors', [ColorController::class, 'index'])->name('colors.index');
        Route::get('/admin/tags', [TagController::class, 'index'])->name('tags.index');
    });
    Route::middleware(['can:create color'])->group(function () {
        Route::post('/admin/colors', [ColorController::class, 'create'])->name('colors.create');
        Route::post('/admin/tags', [TagController::class, 'create'])->name('tags.create');
    });
    Route::middleware(['can:update color'])->group(function () {
        Route::patch('/admin/colors/{color_id}', [ColorController::class, 'update'])->name('colors.update');
        Route::patch('/admin/tags/{tag_id}', [TagController::class, 'update'])->name('tags.update');
    });
    Route::middleware(['can:delete color'])->group(function () {
        Route::delete('/admin/colors/{color_id}', [ColorController::class, 'delete'])->name('colors.delete');
        Route::delete('/admin/tags/{tag_id}', [TagController::class, 'delete'])->name('tags.delete');
    });

    // product routes
    Route::get('/admin/products/detailed_products', [ProductController::class, 'search_detailed_product'])->name('products.detailed_products.search'); // => json
    Route::middleware(['can:create product'])->group(function () {
        Route::get('/admin/products/create', [ProductController::class, 'create_ui'])->name('products.create_ui');
        Route::post('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/admin/products/{product_id}/create', [ProductController::class, 'create_detailed_product_ui'])->name('products.create_detailed_product_ui');
        Route::post('/admin/products/{product_id}/create', [ProductController::class, 'create_detailed_product'])->name('products.create_detailed_product');
    });
    Route::middleware(['can:update product'])->group(function () {
        Route::get('/admin/products/{product_id}/update', [ProductController::class, 'update_ui'])->name('products.update_ui');
        Route::patch('/admin/products/{product_id}/update', [ProductController::class, 'update'])->name('products.update');
        Route::get('/admin/products/{product_id}/{sku}/update', [ProductController::class, 'update_detailed_product_ui'])->name('products.update_detailed_product_ui');
        Route::patch('/admin/products/{product_id}/{sku}/update', [ProductController::class, 'update_detailed_product'])->name('products.update_detailed_product');
    });
    Route::middleware(['can:delete product'])->group(function () {
        Route::delete('/admin/products/{product_id}', [ProductController::class, 'delete'])->name('products.delete');
        Route::delete('/admin/products/delete/{sku}', [ProductController::class, 'delete_detailed_product'])->name('products.delete_detailed_product');
    });
    Route::middleware(['can:read products'])->group(function () {
        Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/admin/products/pagination', [ProductController::class, 'products_pagination'])->name('products.pagination'); //-> json
        Route::get('/admin/products/{product_id}', [ProductController::class, 'details'])->name('products.details');
        Route::get('/admin/products/{product_id}/{sku}', [ProductController::class, 'detailed_product_details'])->name('products.detailed_product_details');
    });





    // receipts routes
    Route::middleware(['can:read receipts'])->group(function () {
        Route::get('/admin/receipts', [ReceiptsController::class, 'index']);
        Route::get('/admin/receipts/pagination', [ReceiptsController::class, 'receipt_pagination']); // => json
        Route::get('/admin/receipts/{receipt_id}', [ReceiptsController::class, 'details'])->name('receipts.details');
    });
    Route::middleware(['can:create receipt'])->group(function () {
        Route::post('/admin/receipts/create', [ReceiptsController::class, 'create']);
        Route::post('/admin/receipts/{receipt_id}', [ReceiptsController::class, 'create_detailed_receipt']);
    });

    Route::middleware(['can:delete receipt'])->group(function () {
        Route::delete('/admin/receipts/{receipt_id}/delete/{sku}', [ReceiptsController::class, 'delete_detailed_receipt']);
    });



    // discounts routes
    Route::middleware(['can:read discounts'])->group(function () {
        Route::get('/admin/discounts', [DiscountController::class, 'index']);
        Route::get('/admin/discounts/{discount_id}', [DiscountController::class, 'discount_detail'])->name('discount.detail');
        Route::get('/admin/discount/{discount_id}/get_products_not_in_discount', [DiscountController::class, 'get_products_not_in_discount']);
    });

    Route::post('/admin/discounts', [DiscountController::class, 'create'])->middleware('can:create discount');
    Route::put('/admin/discounts/{discount_id}', [DiscountController::class, 'update'])->name('discounts.update')->middleware('can:update discount');
    Route::middleware(['can:delete discount'])->group(function () {
        Route::delete('admin/discounts/{discount_id}', [DiscountController::class, 'destroy'])->name('discount.delete');
        Route::patch('admin/discounts/{discount_id}', [DiscountController::class, 'restore'])->name('discount.restore');
    });

    Route::post('/admin/discount/{discount_id}/{sku}', [DiscountController::class, 'add_product_to_discount'])->middleware('can:update discount');
    Route::delete('/admin/discount/{discount_id}/{sku}', [DiscountController::class, 'remove_product_from_discount'])->middleware('can:delete discount');


    // statistic routes
    Route::get('/admin/statistics', [StatisticController::class, 'statistic_ui']);
    Route::get('/admin/statistics/overviewLast7day', [StatisticController::class, 'overviewLast7day']);
    Route::post('/admin/statistics/getstatistic', [StatisticController::class, 'RevenueDateByDate']);
    Route::get('/admin/statistics/sellingproductpie', [StatisticController::class, 'SellingProductPie']);

    Route::get('/admin/statistics/getBestSellerProducts', [StatisticController::class, 'getBestSellerProducts']);



    // authorization
    Route::middleware(['can:read roles'])->group(function () {
        Route::get('/admin/roles', [PermissionController::class, 'index']);
        Route::get('/admin/roles/pagination', [PermissionController::class, 'roles_pagination']);
        Route::get('/admin/roles/{role_id}', [PermissionController::class, 'get_role']);
    });
    Route::middleware(['can:create role'])->group(function () {
        Route::post('/admin/roles', [PermissionController::class, 'create']);
    });
    Route::middleware(['can:update role'])->group(function () {
        Route::patch('/admin/roles/{role_id}', [PermissionController::class, 'update']);
    });
    Route::middleware(['can:delete role'])->group(function () {
        Route::delete('/admin/roles/{role_id}', [PermissionController::class, 'delete']);
    });


    Route::middleware(['can:read roles,create roles,update roles,delete roles'])->group(function () {
        Route::get('/admin/authorization', [PermissionController::class, 'authorization_ui']);
        Route::get('/admin/authorization/pagination', [PermissionController::class, 'authorization_pagination']);
        Route::post('/admin/authorization', [PermissionController::class, 'assign_role']);
    });


    Route::get('/admin/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings/profile', [SettingController::class, 'update_profile']);
    Route::get('/admin/settings/change-password', [SettingController::class, 'changePasswordUI'])->name('settings.change_password');
    Route::post('/admin/settings/change-password', [SettingController::class, 'changePassword']);
});
