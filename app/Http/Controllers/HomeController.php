<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    //

    public function index()
    {
        $data = [
            'page' => 'Admin Dashboard',
        ];
        return view('admin.dashboard.index', $data);
    }
}
