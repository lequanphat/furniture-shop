<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{

    public function index()
    {
        $data = [
            'page' => 'Products',
            'products' => []
        ];
        return view('admin.products.index', $data);
    }
    public function create_ui()
    {
        $data = [
            'page' => 'Create Product',
            'categories' => Category::all(),
            'brands' => Brand::all()
        ];
        return view('admin.products.create', $data);
    }
}
