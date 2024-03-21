<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetailedProduct;
use App\Http\Requests\CreateProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $data = [
            'page' => 'Products',
            'products' => Product::with('category', 'brand', 'detailed_products.images')->paginate(6) // 6 elements per page
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
    public function update_ui(Request $request)
    {
        $product_id = $request->route('product_id');
        $data = [
            'page' => 'Product Details',
            'product' => Product::with('category', 'brand')->find($product_id),
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ];
        return  view('admin.products.update', $data);;
    }
    public function update(CreateProduct $request)
    {
        $product_id = $request->route('product_id');
        $product = Product::find($product_id);
        if ($product) {
            $product->update([
                'name' => $request->input('title'),
                'category_id' => $request->input('category'),
                'brand_id' => $request->input('brand'),
                'description' => $request->input('description'),
            ]);
        }
        return back()->with('message', 'Product updated successfully!');
    }
    public function details(Request $request)
    {
        $product_id = $request->route('product_id');
        $data = [
            'page' => 'Product Details',
            'product' => Product::with('category', 'brand')->find($product_id),
            'detaild_products' => ProductDetail::where('product_id', $product_id)->with('images')->paginate(6) // 6 elements per page
        ];
        return  view('admin.products.product_details', $data);
    }
    public function create_detailed_product_ui(Request $request)
    {
        $product_id = $request->route('product_id');
        $data = [
            'page' => 'Create Product Details',
            'product' => Product::with('category', 'brand')->find($product_id),
        ];
        return view('admin.products.create_product_details', $data);
    }
    // CreateDetailedProduct
    public function create_detailed_product(Request $request)
    {
        $product_id = $request->route('product_id');
        $detailed_product = ProductDetail::create([
            'product_id' => $product_id,
            'sku' => $request->input('sku'),
            'name' => $request->input('name'),
            'color' => $request->input('color'),
            'size' => $request->input('size'),
            'original_price' => $request->input('original_price'),
            'warranty_month' => $request->input('warranty_month'),
            'description' => $request->input('description') ?? '',
            'quantities' => 0
        ]);
        $count = 0;
        while ($request->hasFile('image' . $count)) {
            $file = $request->file('image' . $count);
            $path = $file->store('uploads/images', 'public');
            ProductImage::create([
                'sku' => $request->input('sku'),
                'url' => $path
            ]);
            $count++;
        }

        return back()->with('message', 'Product details created successfully!');
    }
}
