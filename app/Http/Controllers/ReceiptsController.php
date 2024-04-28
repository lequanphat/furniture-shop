<?php

namespace App\Http\Controllers;

use App\Models\ReceivingReport;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

use App\Models\ProductDetail;


class ReceiptsController extends Controller
{
    public function index()
    {
        $data_receipts = ReceivingReport::all();
        $supplier_id = Supplier::all();


        $data =
            [
                'receipts' => $data_receipts,
                'supplier' => $supplier_id
            ];

        return view('admin.receipts.index', $data);
    }


    public function create_receiving(Request $request)
    {


        $receipts_data = [
            'total_price' => 0,

            'supplier_id' => $request->input('supplier_id'),

            'created_by' => Auth::user()->user_id,
        ];


        $receipts = ReceivingReport::create($receipts_data);

        return ['message' => 'Created order successfully!', 'receipts' => $receipts];
    }

    public function details(Request $request)
    {
        $receipt_id = $request->route('receipt_id');
        $receipt = ReceivingReport::where('receiving_report_id', $receipt_id)->with('employee.default_address')->first();
        $detailed_Receipts = $receipt->receiving_details()->with('detailed_product')->paginate(5); // 5 items per page
        $data = [
            'page' => 'Order Details',
            'receipt' => $receipt,
            'detailed_receipts' => $detailed_Receipts,
            'detailed_products' => ProductDetail::paginate(5),
        ];
        return view('admin.receipts.receipts_details', $data);
    }
}
