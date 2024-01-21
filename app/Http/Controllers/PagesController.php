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
    public function classroom()
    {
        return view('pages.classrooms.index');
    }
    public function tests()
    {
        return view('pages.tests.index');
    }
    public function result()
    {
        return view('pages.results.index');
    }
}
