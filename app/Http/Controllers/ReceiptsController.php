<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetailedReceipt;
use App\Models\OrderDetail;
use App\Models\ReceivingReport;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\ProductDetail;
use App\Models\ReceivingReportDetails;
use Illuminate\Support\Facades\DB;

class ReceiptsController extends Controller
{
    public function index()
    {
        $search = request()->query('search');
        $type = request()->query('type');
        $sort = request()->query('sort');
        $query = ReceivingReport::with('supplier', 'employee.default_address')
            ->where(function ($query) use ($search) {
                $query->where('receiving_report_id', $search)
                    ->orWhereHas('supplier', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                            ->orWhere('address', 'LIKE', '%' . $search . '%');
                    });
            });

        if ($type !== null && $type !== 'all') {
            $query = $query->where('supplier_id', $type);
        }
        // sort receipts
        if ($sort == 'oldest') {
            $query = $query->orderBy('created_at', 'asc');
        } else if ($sort == 'latest'  || $sort == null) {
            $query = $query->orderBy('created_at', 'desc');
        } else if ($sort == 'price_asc') {
            $query = $query->orderBy('total_price', 'asc');
        } else if ($sort == 'price_desc') {
            $query = $query->orderBy('total_price', 'desc');
        }
        $receipts = $query->paginate(7);
        $suppliers = Supplier::all();
        $data = [
            'receipts' => $receipts,
            'suppliers' => $suppliers,
            'search' => $search,
            'type' => $type,
            'sort' => $sort,
        ];

        return view('admin.receipts.index', $data);
    }

    public function receipt_pagination()
    {
        $search = request()->query('search');
        $type = request()->query('type');
        $sort = request()->query('sort');
        $query = ReceivingReport::with('supplier', 'employee.default_address')
            ->where(function ($query) use ($search) {
                $query->where('receiving_report_id', $search)
                    ->orWhereHas('supplier', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                            ->orWhere('address', 'LIKE', '%' . $search . '%');
                    });
            });

        if ($type !== null && $type !== 'all') {
            $query = $query->where('supplier_id', $type);
        }
        // sort receipts
        if ($sort == 'oldest') {
            $query = $query->orderBy('created_at', 'asc');
        } else if ($sort == 'latest'  || $sort == null) {
            $query = $query->orderBy('created_at', 'desc');
        } else if ($sort == 'price_asc') {
            $query = $query->orderBy('total_price', 'asc');
        } else if ($sort == 'price_desc') {
            $query = $query->orderBy('total_price', 'desc');
        }

        $receipts = $query->paginate(7);
        foreach ($receipts as $receipt) {
            $receipt->date_time = $receipt->format_created_at();
            $receipt->total_price = $receipt->format_total_price();
        }
        return response()->json(['receipts' => $receipts]);
    }
    public function create(Request $request)
    {
        $receipt = ReceivingReport::create([
            'total_price' => 0,
            'supplier_id' => $request->input('supplier_id'),
            'created_by' => Auth::user()->user_id,
        ]);

        return ['message' => 'Created order successfully!', 'receipt' => $receipt];
    }

    public function details(Request $request)
    {
        $receipt_id = $request->route('receipt_id');
        $receipt = ReceivingReport::where('receiving_report_id', $receipt_id)->with('employee.default_address', 'supplier')->first();
        if (!$receipt) abort(404, 'Receipt not found!');
        $detailed_receipts = ReceivingReportDetails::where('receiving_report_id', $receipt_id)->with('detailed_product.images')->paginate(5);
        $detailed_products = ProductDetail::where('is_deleted', 0)->paginate(5);
        $data = [
            'page' => 'Order Details',
            'receipt' => $receipt,
            'detailed_receipts' => $detailed_receipts,
            'detailed_products' => $detailed_products,
        ];
        return view('admin.receipts.receipts_details', $data);
    }


    public function create_detailed_receipt(CreateDetailedReceipt $request)
    {
        $receipt_id = $request->route('receipt_id');
        $sku = $request->input('sku');
        $quantities = $request->input('quantities');
        $unit_price = $request->input('unit_price');

        $receipt = ReceivingReport::where('receiving_report_id', $receipt_id)->first();
        if (!$receipt) return response()->json(['errors' => ['message' => ['Cannot find this receipt.']]], 400);

        $detailed_receipt_exist = ReceivingReportDetails::where('receiving_report_id', $receipt_id)->where('sku', $sku)->first();
        if ($detailed_receipt_exist) {
            ReceivingReportDetails::where('receiving_report_id', $receipt_id)->where('sku', $sku)->update([
                'quantities' => $detailed_receipt_exist->quantities + $quantities,
                'unit_price' => $unit_price,
            ]);
            ProductDetail::where('sku', $sku)->increment('quantities', $request->input('quantities'));
            $receipt->update([
                'total_price' => $receipt->total_price + $quantities * $unit_price,
            ]);
            return ['message' => 'Created detailed receipt successfully!', 'detailed_receipt' => $detailed_receipt_exist];
        } else {
            $detailed_receipt = ReceivingReportDetails::create([
                'receiving_report_id' => $receipt_id,
                'sku' => $sku,
                'quantities' => $quantities,
                'unit_price' => $unit_price,
            ]);
            ProductDetail::where('sku', $sku)->increment('quantities', $request->input('quantities'));
            $receipt->update([
                'total_price' => $receipt->total_price + $quantities * $unit_price,
            ]);
            return ['message' => 'Created detailed receipt successfully!', 'detailed_receipt' => $detailed_receipt];
        }
    }

    public function delete_detailed_receipt(Request $request)
    {
        $receipt_id = $request->route('receipt_id');
        $sku = $request->route('sku');
        $detailed_receipt = ReceivingReportDetails::where('receiving_report_id', $receipt_id)->where('sku', $sku)->first();
        if ($detailed_receipt) {
            ReceivingReport::where('receiving_report_id', $receipt_id)->decrement('total_price', $detailed_receipt->quantities * $detailed_receipt->unit_price);


            $detailed_product = ProductDetail::where('sku', $sku)->first();
            $total_quantities = $detailed_product->quantities - $detailed_receipt->quantities;
            if ($total_quantities < 0) {
                return response()->json(['errors' => ['message' => ['Quantities of this product is not enough.']]], 400);
            }
            $detailed_product->decrement('quantities', $detailed_receipt->quantities);
            DB::statement("DELETE FROM receiving_report_details WHERE receiving_report_id = :receipt_id AND sku = :sku", ['receipt_id' => $receipt_id, 'sku' => $sku]);
            return ['message' => 'Remove detailed receipt successfully'];
        }
        return ['message' => 'Can not find this detailed receipt'];
    }
}
