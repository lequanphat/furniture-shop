<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function index()
    {
        return view('pages.dashboard.index');
    }
    public function admin()
    {
        return view('admin.dashboard.index');
    }
}
