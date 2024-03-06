<?php

namespace App\Http\Controllers;

use App\Models\User;

class PagesController extends Controller
{
    //
    public function index()
    {
        $data = [
            'title' => 'Modern Interior',
            'subtitle' => 'Design Studio',
            'content' => 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
            vulputate velit imperdiet dolor tempor tristique.'
        ];
        return view('pages.dashboard.index', $data);
    }


    public function shop()
    {
        $data = [
            'title' => 'Shop',
            'content' => 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
            vulputate velit imperdiet dolor tempor tristique.'
        ];
        return view('pages.shop.index', $data);
    }
    public function about()

    {
        $data = [
            'title' => 'About us',
            'subtitle' => '',
            'content' => 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
            vulputate velit imperdiet dolor tempor tristique.'
        ];
        return view('pages.about.index', $data);
    }
    public function services()
    {
        $data = [
            'title' => 'Services',
            'content' => 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
            vulputate velit imperdiet dolor tempor tristique.'
        ];
        return view('pages.services.index', $data);
    }
    public function blog()
    {
        $data = [
            'title' => 'Blog',
            'content' => 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
            vulputate velit imperdiet dolor tempor tristique.'
        ];
        return view('pages.blog.index', $data);
    }
    public function contact()
    {
        $data = [
            'title' => 'Contact',
            'content' => 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam
            vulputate velit imperdiet dolor tempor tristique.'
        ];
        return view('pages.contact.index', $data);
    }
    public function admin()
    {
        $data = [
            'page' => 'Home',
        ];
        return view('admin.dashboard.index', $data);
    }
    public function admin_employee()
    {
        $data = [
            'page' => 'Employee',
            'user' => $users = User::all()
        ];

        return view('admin.users.employee', $data);
    }
    public function admin_customers()
    {
        $data = [
            'page' => 'Customers',
        ];
        return view('admin.users.customers', $data);
    }
    public function admin_products()
    {
        $data = [
            'page' => 'Products',
        ];
        return view('admin.products.index', $data);
    }
    public function admin_categories()
    {
        $data = [
            'page' => 'Categories',
        ];
        return view('admin.categories.index', $data);
    }
    public function admin_brands()
    {
        $data = [
            'page' => 'Brands',
        ];
        return view('admin.brands.index', $data);
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
    public function admin_suppliers()
    {
        $data = [
            'page' => 'Suppliers',
        ];
        return view('admin.suppliers.index', $data);
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
}
