<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetailedProduct;
use App\Http\Requests\CreateProduct;
use App\Http\Requests\UpdateDetailedProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $data = [
            'page' => 'Products',
            'products' => Product::with('category', 'brand', 'detailed_products.images')->paginate(4) // 6 elements per page
        ];
        return view('admin.products.index', $data);
    }
    public function create_ui()
    {
        $data = [
            'page' => 'Create Product',
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'tags' => Tag::all(),
        ];
        return view('admin.products.create', $data);
    }
    public function create(CreateProduct $request)
    {
        // create products
        $product = Product::create([
            'name' => $request->input('title'),
            'category_id' => $request->input('category'),
            'brand_id' => $request->input('brand'),
            'description' => $request->input('description'),
            'quantities' => 0,
        ]);
        // create tags
        $tags = json_decode($request->input('tags'));

        foreach ($tags as $tag) {
            ProductTag::create([
                'product_id' => $product->product_id,
                'tag_id' => $tag
            ]);
        }
        return  ['product' => $product];
    }
    public function update_ui(Request $request)
    {
        $product_id = $request->route('product_id');
        $data = [
            'page' => 'Product Details',
            'product' => Product::with('category', 'brand', 'product_tags')->find($product_id),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'tags' => Tag::all(),
        ];
        return  view('admin.products.update', $data);;
    }
    public function update(CreateProduct $request)
    {
        $product_id = $request->route('product_id');
        $product = Product::find($product_id);
        // update product
        if ($product) {
            $product->update([
                'name' => $request->input('title'),
                'category_id' => $request->input('category'),
                'brand_id' => $request->input('brand'),
                'description' => $request->input('description'),
            ]);
        }
        // update tags
        $tags = json_decode($request->input('tags'));
        // delete all tags
        ProductTag::where('product_id', $product_id)->delete();
        // create new tags
        foreach ($tags as $tag) {
            ProductTag::create([
                'product_id' => $product->product_id,
                'tag_id' => $tag
            ]);
        }
        return ['product' => $product, 'message' => 'Product updated successfully!'];
    }
    public function details(Request $request)
    {
        $product_id = $request->route('product_id');
        $data = [
            'page' => 'Product Details',
            'product' => Product::with('category', 'brand', 'product_tags.tag')->find($product_id),
            'detaild_products' => ProductDetail::where('product_id', $product_id)->with('images')->with('color')->paginate(6) // 6 elements per page
        ];
        return  view('admin.products.product_details', $data);
    }
    public function create_detailed_product_ui(Request $request)
    {
        $product_id = $request->route('product_id');
        $data = [
            'page' => 'Create Product Details',
            'product' => Product::with('category', 'brand')->find($product_id),
            'colors' => Color::all(),
        ];
        return view('admin.products.create_product_details', $data);
    }
    public function create_detailed_product(CreateDetailedProduct $request)
    {
        $product_id = $request->route('product_id');
        $detailed_product = ProductDetail::create([
            'product_id' => $product_id,
            'sku' => $request->input('sku'),
            'name' => $request->input('name'),
            'color_id' => $request->input('color_id'),
            'size' => $request->input('size'),
            'original_price' => $request->input('original_price'),
            'warranty_month' => $request->input('warranty_month'),
            'description' => $request->input('description') ?? '',
            'quantities' => 0
        ]);
        $count = 0;
        while ($request->hasFile('image' . $count)) {
            $file = $request->file('image' . $count);
            $path = config('app.url') . 'storage/' . $file->store('uploads/images', 'public');
            ProductImage::create([
                'sku' => $request->input('sku'),
                'url' => $path
            ]);
            $count++;
        }

        return ['detailed_product' => $detailed_product];
    }
    public function detailed_product_details(Request $request)
    {
        $sku = $request->route('sku');
        $data = [
            'page' => 'Product Details',
            'detailed_product' => ProductDetail::with('images', 'color')->find($sku),
        ];
        return  view('admin.products.detailed_product_details', $data);
    }
    public function  update_detailed_product_ui(Request $request)
    {
        $sku = $request->route('sku');
        $data = [
            'page' => 'Update Detailed Product',
            'detailed_product' => ProductDetail::with('images')->find($sku),
            'colors' => Color::all(),
        ];
        return  view('admin.products.update_product_details', $data);
    }
    public function  update_detailed_product(UpdateDetailedProduct $request)
    {
        $sku = $request->route('sku');
        $detailed_product = ProductDetail::find($sku);
        $detailed_product->update([
            'name' => $request->input('name'),
            'color_id' => $request->input('color_id'),
            'size' => $request->input('size'),
            'original_price' => $request->input('original_price'),
            'warranty_month' => $request->input('warranty_month'),
            'description' => $request->input('description') ?? '',
        ]);
        // handle images update here
        $old_images =  explode(',', $request->input('old_images'));
        ProductImage::where('sku', $sku)
            ->whereNotIn('product_image_id', $old_images)
            ->delete();
        $count = 0;
        while ($request->hasFile('image' . $count)) {
            $file = $request->file('image' . $count);
            $path = config('app.url') . 'storage/' . $file->store('uploads/images', 'public');
            ProductImage::create([
                'sku' => $request->input('sku'),
                'url' => $path
            ]);
            $count++;
        }
        return ['message' => 'Product details updated successfully!'];
    }

    public function get_products()
    {
        $categories = request()->query('categories');
        $color = request()->query('color');
        $search = request()->query('search');
        $sorted_by = request()->query('sorted_by');
        // query
        $query = Product::with(
            'category',
            'brand',
            'detailed_products.images',
            'detailed_products.product_discounts.discount',
        )->where('is_deleted', false);

        // If categories is not 'all', filter by category_id
        if ($categories !== 'all' && $categories !== null) {
            $categoryIds = explode(',', $categories);
            $query->whereIn('category_id', $categoryIds);
        }
        // If color is not 'all', filter by color_id
        if ($color !== 'all' && $color !== null) {
            $colorIds = explode(',', $color);
            $query->whereHas('detailed_products', function ($query) use ($colorIds) {
                $query->whereIn('color_id', $colorIds);
            });
        }

        // If search is not null, filter by name
        if ($search !== null) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
        // sorted 
        if ($sorted_by === 'latest') {
            $query->orderBy('created_at', 'desc');
        }
        if ($sorted_by === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        $products = $query->paginate(9); // 9 elements per page
        if ($sorted_by === 'price_asc') {
            
        }
        $data = [
            'products' => $products
        ];

        return response()->json($data);
    }

    
}
