<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    //
    public function index(): View {
        $title = 'index';
        return view('products.index', compact('title'));
    }
    public function details(string $id): View {
        $array = [
            'product_id' => $id,
            'email' => 'lequanphat3579@gmail.com',
            'password' => '123123'

        ];
        return view('products.details', compact('array'));
    }
}
