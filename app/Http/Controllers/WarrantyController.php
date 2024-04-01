<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\ProductDetail;
use App\Models\Warranty;

class WarrantyController extends Controller{
    public function index(){
        $data = [
            'page' => 'Warranties ',
            'warranties' => Warranty::query()->paginate(5),
        ];
        return view('admin.warranties.index', $data);
    }

}
