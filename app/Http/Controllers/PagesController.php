<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Tag;

class PagesController extends Controller
{
    //
    public function index()
    {
        $data = [
            'page' => 'Home',
        ];
        return view('pages.dashboard.index', $data);
    }


    public function shop()
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

        $data = [
            'page' => 'Shop',
            'categories' => Category::all(),
            'colors' => Color::all(),
            'selected_categories' => $categoryIds ?? [],
            'selected_colors' => $colorIds ?? [],
            'tags' => Tag::all(),
            'products' => $query->paginate(9), // 9 elements per page
            'search' => $search ?? '',
            'sorted_by' => $sorted_by ?? 'default',
        ];

        return view('pages.shop.index', $data);
    }
    public function product_details()
    {
        $product_id = request()->route('product_id');

        $data = [
            'page' => 'Product Details',
            'product' => Product::with('category', 'brand', 'detailed_products', 'product_tags.tag')
                ->where('is_deleted', false)->find($product_id),
        ];
        return view('pages.product_details.index', $data);
    }
    public function cart()
    {
        $data = ['page' => 'Cart'];
        return view('pages.cart.index', $data);
    }
    public function checkout()
    {
        $data = ['page' => 'Checkout'];
        return view('pages.checkout.index', $data);
    }
    public function about()

    {
        $data = [
            'page' => 'About us'
        ];
        return view('pages.about.index', $data);
    }

    public function contact()
    {
        $data = [
            'page' => 'Contact us'
        ];
        return view('pages.contact.index', $data);
    }
    public function account()
    {
        $data = [
            'page' => 'My account'
        ];
        return view('pages.account.index', $data);
    }
    public function admin()
    {
        $data = [
            'page' => 'Home',
        ];
        return view('admin.dashboard.index', $data);
    }



    public function admin_discounts()
    {
        $data = [
            'page' => 'Discounts',
        ];
        return view('admin.discounts.index', $data);
    }
    public function admin_orders()
    {
        $data = [
            'page' => 'Orders',
        ];
        return view('admin.orders.index', $data);
    }
    public function admin_warranties()
    {
        $data = [
            'page' => 'Warranties',
        ];
        return view('admin.warranties.index', $data);
    }
    public function admin_receipts()
    {
        $data = [
            'page' => 'Receipts',
        ];
        return view('admin.receipts.index', $data);
    }

    public function admin_permissions()
    {
        $data = [
            'page' => 'Permissions',
        ];
        return view('admin.permissions.index', $data);
    }
    public function admin_authorization()
    {
        $data = [
            'page' => 'Authorization',
        ];
        return view('admin.permissions.authorization', $data);
    }
    public function admin_profiles()
    {
        $data = [
            'page' => 'Profiles',
        ];
        return view('admin.profiles.index', $data);
    }
    public function admin_settings()
    {
        $data = [
            'page' => 'Settings',
        ];
        return view('admin.settings.index', $data);
    }

    public function change_password()
    {
        return view('auth.change-password');
    }
}
