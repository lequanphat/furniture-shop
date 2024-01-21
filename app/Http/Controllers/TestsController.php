<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TestsController extends Controller
{
    //
    public function index(): View
    {
        return view('admin.tests.index');
    }
}
