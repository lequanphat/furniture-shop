<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            [
                'category',
                'brand',
                'detailed_products' => function ($query) {
                    $query->where('is_deleted', 0)->with('images', 'product_discounts.discount');
                },
            ]
        )->where('is_deleted', false)->has('detailed_products');

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

            if (isset($detailed_product->images)) {
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
        $product = Product::with(['category', 'brand', 'product_tags.tag', 'detailed_products' => function ($query) {
            $query->where('is_deleted', 0);
        }])
            ->where('is_deleted', false)->find($product_id);
        if ($product) {
            $data = [
                'page' => 'Product Details',
                'product' => $product,
            ];
            return view('pages.product_details.index', $data);
        }
        abort(404);
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

    public function change_password()
    {
        return view('auth.change-password');
    }

    public function handle_checkout_order(Request $request)
    {
        $order_id = $request->route('order_id');
        $order = Order::where('order_id', $order_id)->where('customer_id', Auth::id())->with('order_details')->first();
        $data = [
            'page' => 'Checkout Success',
        ];
        if (isset($request->vnp_ResponseCode)) {
            if ($request->vnp_ResponseCode == '00') {
                if ($order) {
                    $order->update([
                        'is_paid' => true,
                    ]);
                    $order->get_status = $order->get_status();
                    $data['order'] = $order;
                }
                return view('pages.checkout.success', $data);
            } else {
                // Increase the quantities of the product details
                foreach ($order->order_details as $order_detail) {
                    $product_detail = ProductDetail::where('sku', $order_detail->detailed_product->sku)->first();
                    $product_detail->update([
                        'quantities' => $product_detail->quantities + $order_detail->quantities,
                    ]);
                }

                // Delete the order details and the order
                $order->order_details()->delete();
                $order->delete();
                $data['page'] = 'Checkout Fail';
                return view('pages.checkout.fail', $data);
            }
        } else {
            if ($order) {
                $order->get_status = $order->get_status();
                $data['order'] = $order;
            }
            return view('pages.checkout.success', $data);
        }
    }
    public function my_orders()
    {
        $orders = Order::where('customer_id', Auth::id())->with('order_details')->orderBy('created_at', 'desc')->get();
        $data = [
            'page' => 'My orders',
            'orders' => $orders,
        ];
        return view('pages.myorders.index', $data);
    }
    public function my_detailed_order()
    {
        $order_id = request()->route('order_id');
        $order = Order::where('order_id', $order_id)->where('customer_id', Auth::id())->with('order_details')->first();

        if ($order) {
            $order->get_status = $order->get_status();
            $data = [
                'page' => 'My order details',
                'order' => $order,
            ];
        } else {
            $data = [
                'page' => 'My order details',
                'order' => null,
            ];
        }

        return view('pages.myorders.detailed-order', $data);
    }
}
