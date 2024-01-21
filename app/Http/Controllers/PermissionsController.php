<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionsController extends Controller
{
    //
    public function index(): View
    {
        return view('admin.permissions.index');
    }
}
