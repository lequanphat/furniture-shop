<?php

namespace App\Http\Controllers;

use App\Models\Product;

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
        $data = [
            'page' => 'Shop',
            'products' => Product::with(
                'category',
                'brand',
                'detailed_products.images'
            )->where('is_deleted', false)->paginate(9) // 9 elements per page
        ];
        return view('pages.shop.index', $data);
    }
    public function product_details()
    {
        $product_id = request()->route('product_id');
        $data = [
            'page' => 'Product Details',
            'product' => Product::with('category', 'brand', 'detailed_products.images')->where('is_deleted', false)->find($product_id),
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
