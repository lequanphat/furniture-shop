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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        $search = request()->query('search');
        $brand = request()->query('brand');
        $category = request()->query('category');
        $query = Product::with('category', 'brand', 'detailed_products.images');
        if ($category !== null && $category !== 'all') {
            $query = $query->where('category_id', $category);
        }
        if ($brand !== null && $brand !== 'all') {
            $query = $query->where('brand_id', $brand);
        }
        $query = $query
            ->where('is_deleted', 0)
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('product_id', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('brand', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
        $products = $query->paginate(4); // 4 elements per page
        $brands = Brand::orderBy('index', 'asc')->get();
        $categories = Category::orderBy('index', 'asc')->get();
        $data = [
            'page' => 'Products',
            'search' => $search,
            'products' => $products,
            'selected_category' => $category,
            'selected_brand' => $brand,
            'categories' => $categories,
            'brands' => $brands,
        ];
        return view('admin.products.index', $data);
    }

    public function products_pagination()
    {
        $search = request()->query('search');
        $brand = request()->query('brand');
        $category = request()->query('category');
        $query = Product::with('category', 'brand', 'detailed_products.images');
        if ($category !== null && $category !== 'all') {
            $query = $query->where('category_id', $category);
        }
        if ($brand !== null && $brand !== 'all') {
            $query = $query->where('brand_id', $brand);
        }
        $query = $query
            ->where('is_deleted', 0)
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('product_id', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    })
                    ->orWhereHas('brand', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
        $products = $query->paginate(4); // 4 elements per page

        foreach ($products as $product) {
            $average_price = 0;
            foreach ($product->detailed_products as $detailed_product) {
                $average_price += $detailed_product->original_price;
            }
            if (count($product->detailed_products) > 0) {
                $average_price = $average_price / count($product->detailed_products);
            } else {
                $average_price = 0;
            }
            $product->detailed_product = $product->detailed_products->first();
            $product->average_price = $average_price;
            $product->number_of_detailed_products = count($product->detailed_products);
            $product->sum_quantities = $product->detailed_products->sum('quantities');

            if ($product->created_at->diffInDays() < 7) {
                $product->new = true;
            }
            $product->setRelation('detailed_products', null);
        }
        // get permissions for the admin
        $user = User::where('user_id', Auth::id())->first();
        $data = [
            'page' => 'Products',
            'products' => $products,
            'can_update' => $user->can('update product'),
            'can_delete' => $user->can('delete product'),
        ];
        return response()->json($data);
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
    public function delete(Request $request)
    {
        $product_id = $request->route('product_id');
        $product = Product::find($product_id);
        if ($product) {
            $product->update([
                'is_deleted' => true
            ]);
            return ['message' => 'Product deleted successfully!'];
        }
        return ['message' => 'Product not found!'];
    }
    public function details(Request $request)
    {
        $product_id = $request->route('product_id');
        $product = Product::where('is_deleted', 0)->with('category', 'brand', 'product_tags.tag')->find($product_id);
        if ($product) {
            $detailed_products = ProductDetail::where('product_id', $product_id)->where('is_deleted', 0)->with('images')->with('color')->paginate(6); // 6 elements per page
            $data = [
                'page' => 'Product Details',
                'product' => $product,
                'detaild_products' => $detailed_products
            ];
            return  view('admin.products.product_details', $data);
        }
        return abort(404);
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
        $product_id = $request->route('product_id');
        $product = Product::where('product_id', $product_id)->where('is_deleted', 0)->first();
        if ($product) {
            $detailed_product = ProductDetail::where('is_deleted', 0)->with('images', 'color')->find($sku);
            if ($detailed_product) {
                $data = [
                    'page' => 'Product Details',
                    'detailed_product' => $detailed_product,
                ];
                return  view('admin.products.detailed_product_details', $data);
            }
        }
        return abort(404);
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
    public function delete_detailed_product(Request $request)
    {
        $sku = $request->route('sku');
        $detailed_product = ProductDetail::where('sku', $sku)->first();
        if ($detailed_product) {
            $detailed_product->update([
                'is_deleted' => true
            ]);
            return ['message' => 'Product details deleted successfully!'];
        }
        return ['message' => 'Product details not found!'];
    }

    public function get_products()
    {
        $category = request()->query('category');
        $color = request()->query('color');
        $tag = request()->query('tag');
        $search = request()->query('search');
        $sorted_by = request()->query('sorted_by');
        $price_from = request()->query('price_from');
        $price_to = request()->query('price_to');
        // query
        $query = Product::with(
            [
                'category',
                'brand',
                'detailed_products' => function ($query) {
                    $query->where('is_deleted', 0)->with('images', 'product_discounts.discount');
                },
            ]
        )->where('is_deleted', false)->has('detailed_products');


        if ($price_from !== null && $price_to !== null) {
            $query->whereHas('detailed_products', function ($query) use ($price_from, $price_to) {
                $query->where('is_deleted', 0)
                    ->whereBetween('original_price', [$price_from, $price_to]);
            });
        }
        // If category is not 'all', filter by category_id
        if ($category !== 'all' && $category !== null) {
            $query->where('category_id', $category);
        }
        // If color is not 'all', filter by color_id
        if ($color !== 'all' && $color !== null) {
            $colorIds = explode(',', $color);
            $query->whereHas('detailed_products', function ($query) use ($colorIds) {
                $query->whereIn('color_id', $colorIds);
            });
        }

        // If tag is not 'all', filter by tag
        if ($tag !== 'all' && $tag !== null) {
            $tagIds = explode(',', $tag);
            $query->whereHas('product_tags', function ($query) use ($tagIds) {
                $query->whereIn('tag_id', $tagIds);
            });
        }


        // If search is not null, filter by name
        if ($search !== null) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }
        // sorted 
        if ($sorted_by === 'latest') {
            $query->orderBy('created_at', 'desc');
        } else if ($sorted_by === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        $products = $query->paginate(9); // 9 elements per page

        foreach ($products as $product) {
            $total_discount_percentage = 0;
            foreach ($product->detailed_products as $detailed_product) {
                foreach ($detailed_product->product_discounts as $product_discount) {
                    if ($product_discount->discount->is_currently_active()) {
                        $total_discount_percentage += $product_discount->discount->percentage;
                    }
                }
                $detailed_product->total_discount_percentage = $total_discount_percentage;
            }
        }
        $today = now();
        foreach ($products as $product) {
            $detailed_product =
                $product->detailed_products
                ->sortByDesc(function ($detailed_product) use ($today) {
                    return $detailed_product->product_discounts
                        ->where('discount.start_date', '<=', $today)
                        ->where('discount.end_date', '>=', $today)
                        ->sum('discount.percentage');
                })
                ->first() ?? $product->detailed_products->first();

            if (isset($detailed_product->images->first()->url)) {
                $detailed_product->image = $detailed_product->images->first()->url;
                $detailed_product->setRelation('images', null);
            }
            $product->detailed_product = $detailed_product;
            $product->price = $detailed_product->original_price;
            $total_quantities = $product->detailed_products->sum('quantities');
            $product->setRelation('detailed_products', null);
            $product->total_quantities = $total_quantities;
        }

        if ($sorted_by === 'price_asc' || $sorted_by === 'price_desc') {
            if ($sorted_by === 'price_asc') {
                $sortedItems = collect($products->items())->sortBy(function ($product) {
                    return $product->price;
                })->values();
            } else if ($sorted_by === 'price_desc') {
                $sortedItems = collect($products->items())->sortByDesc(function ($product) {
                    return $product->price;
                })->values();
            }
            $products = new LengthAwarePaginator(
                $sortedItems,
                $products->total(),
                $products->perPage(),
                $products->currentPage(),
                ['path' => Paginator::resolveCurrentPath()]
            );
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    public function search_detailed_product()
    {
        $search = request()->query('search');
        $detailed_products = ProductDetail::with('product_discounts.discount', 'images', 'color')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('sku', 'LIKE', '%' . $search . '%')
            ->paginate(4); // 4 elements per page
        return response()->json(['detailed_products' => $detailed_products]);
    }
}
