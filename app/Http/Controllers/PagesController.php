<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
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
            'page' => 'Dashboard',
        ];
        return view('admin.dashboard.index', $data);
    }
    public function admin_users()
    {
        $data = [
            'page' => 'Users',
            'user' => $users = User::all()
        ];

        return view('admin.users.index', $data);
    }
    public function admin_user1()
    {
        $data = [
            'page' => 'Users1',
        ];
        return view('admin.users.user1', $data);
    }
    public function admin_user2()
    {
        $data = [
            'page' => 'Users1',
        ];
        return view('admin.users.user2', $data);
    }
}
