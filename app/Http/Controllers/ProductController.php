<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $data = [
            'page' => 'Products',
            'products' => Product::with('category', 'brand')->get()
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
    public function create(CreateProduct $request)
    {
        $product = Product::create([
            'name' => $request->input('title'),
            'category_id' => $request->input('category'),
            'brand_id' => $request->input('brand'),
            'description' => $request->input('description'),
            'quantities' => 0,
        ]);
        return  $product;
    }
    public function details()
    {
        $data = [
            'page' => 'Product Details',
        ];
        return  view('admin.products.product_details', $data);;
    }
}
