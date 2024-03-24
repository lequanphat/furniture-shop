<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptsController extends Controller
{
    public function index()
    {
        return view('admin.receipts.index');
    }
}
