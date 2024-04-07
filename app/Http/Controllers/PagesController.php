<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $total_quantities = $product->detailed_products->sum('quantities');
            $product->setRelation('detailed_products', null);
            $product->total_quantities = $total_quantities;
        }

        $data = [
            'page' => 'Shop',
            'categories' => Category::all(),
            'colors' => Color::all(),
            'selected_categories' => $categoryIds ?? [],
            'selected_colors' => $colorIds ?? [],
            'tags' => Tag::all(),
            'products' => $products,
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
        if (Auth::check()) {
            $data = ['page' => 'Checkout'];
            return view('pages.checkout.index', $data);
        } else {
            session()->put('url.intended', '/checkout');
            return redirect()->route('login');
        }
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

    public function admin_warranties()
    {
        $data = [
            'page' => 'Warranties',
        ];
        return view('admin.warranties.index', $data);
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

    public function checkout_order_success(Request $request)
    {
        $order_id = $request->route('order_id');
        $order = Order::where('order_id', $order_id)->with('order_details')->first();
        if ($order && $order->customer_id == Auth::id()) {
            $order->get_status = $order->get_status();
            $data = [
                'page' => 'Checkout Success',
                'order' => $order,
            ];
        } else {
            $data = [
                'page' => 'Checkout Success',
                'order' => null,
            ];
        }
        return view('pages.checkout.success', $data);
    }
    public function my_orders()
    {
        $data = [
            'page' => 'My orders',
        ];
        return view('pages.myorders.index', $data);
    }
}
