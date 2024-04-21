<?php

namespace App\Http\Controllers;

use App\Models\ReceivingReport;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReceiptsController extends Controller
{
    public function index()
    {
        $data_receipts = ReceivingReport::all();
        $supplier_id = Supplier::all();

        echo "$supplier_id";
        $data =
            [
                'receipts' => $data_receipts,
                'supplier' => $supplier_id
            ];

        return view('admin.receipts.index', $data);
    }


    public function create_receiving(Request $request)
    {
    }
}
