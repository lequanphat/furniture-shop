<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;



Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'details']);






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