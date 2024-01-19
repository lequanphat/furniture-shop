<?php

use App\Http\Controllers\ProductController;
use App\Http\Middleware\Authorizate;
use Illuminate\Support\Facades\Route;


Route::middleware([Authorizate::class])->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products/create-product', [ProductController::class, 'createProduct']);
    Route::get('products/{id}', [ProductController::class, 'details']);
    Route::get('products/delete/{id}', [ProductController::class, 'deleteProduct']);
});








// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/products', function () {
//     return view('products');
// });
// Route::get('/orders', function () {
//     return view('orders');
// });
// Route::get('/404', function () {
//     return view('404');
// });

// Route::fallback(function () {
//     return redirect("/404");
// });