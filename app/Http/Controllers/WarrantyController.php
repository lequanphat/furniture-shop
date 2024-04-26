<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\Warranty;
use App\Http\Requests\CreateWarranty;

use Carbon\Carbon;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    //index đã được sửa lại để lưu search khi reload trang, copy lại từ hàm search_warranties_ajax ở dưới
    public function index()
    {
        $search = request()->query('search');
        $day_first = request()->query('searchdayfirst');
        $day_last = request()->query('searchdaylast');
        $type = request()->query('statustype');
        $sort = request()->query('sortby');

        // filter orders by start_date, end_date
        if (!isset($day_first)) {
            $day_first = Carbon::create(1900, 1, 1);
        }
        if (isset($day_last)) {
            $day_last = Carbon::parse($day_last)->addDay();
        } else {
            $day_last = Carbon::tomorrow();
        }

        $query = Warranty::with('product_detail', 'order')->whereBetween('created_at', [$day_first, $day_last])
            ->where(function ($query) use ($search) {
                $query->where('warranty_id', 'LIKE', '%' . $search . '%')
                    ->orwhere('order_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('sku', 'LIKE', '%' . $search . '%');
            });

        $today = date('Y-m-d');
        if ($type == '0') {
            $query = $query->whereDate('start_date', '>', $today)->orWhereDate('end_date', '<', $today);
        } elseif ($type == '1') {
            $query = $query->where('start_date', '<=', $today)->Where('end_date', '>=', $today);
        }

        if ($sort == 'oldest_warrant') {
            $query = $query->orderBy('created_at', 'asc');
        } elseif ($sort == 'latest_warrant') {
            $query = $query->orderBy('created_at', 'desc');
        } elseif ($sort == 'longest_warrant') { //bug

        } elseif ($sort == 'shortest_warrant') { //bug

        } elseif ($sort == 'sort_by_order') {
            $query = $query->orderBy('order_id', 'asc');
        } elseif ($sort == 'sort_by_product') {
            $query = $query->orderBy('sku', 'asc');
        }

        $warranties = $query->paginate(5);


        $data = [
            'page' => 'Warranties ',
            'warranties' => $warranties,
            'orders' => Order::all(),
            'all_product_detail' => ProductDetail::all(),
            //trả về để lại trên các thanh search trong view khi reload
            'search' => $search,
            'searchdayfirst' => $day_first,
            'searchdaylast' => $day_last,
            'statustype' => $type,
            'sort' => $sort,
        ];

        return view('admin.warranties.index', $data);
    }


    //thêm warranty
    public function warranty_create(CreateWarranty $request)
    {
        //nhận ngày bắt đầu, kiếm số tháng bảo hành từ product detail rồi tính ra ngày kết thúc
        $start_date = Carbon::parse($request->input('start_date'));
        $warranty_month = ProductDetail::query()->where('sku', $request->input('product_detail_ID'))->first();
        $end_date = $start_date->addMonths($warranty_month->warranty_month);

        $warranty_data = [
            'order_id' => $request->input('orderID'),
            'sku' => $request->input('product_detail_ID'),
            'start_date' => $request->input('start_date'),
            'end_date' => $end_date,
            'description' => $request->input('description'),
        ];
        $warranty = Warranty::create($warranty_data);
        return ['message' => 'Create Warranty succesfully!', 'warranty' => $warranty];
    }




    //sửa thông tin warranty
    public function warranty_update(Request $request)
    {
        //request chứa dữ liệu về request http đang tới
        //lấy thông tin về order trong database
        //lấy order ở order_id trên database, dựa trên order_id trong dữ liệu của request request
        $warranty_id = $request->route('warranty_id');
        $warranty = Warranty::where('warranty_id', $warranty_id)->first();    //first là lấy phần tử đầu tiên

        //tương tự như trên kia
        $start_date = Carbon::parse($request->input('start_date'));
        $warranty_month = ProductDetail::query()->where('sku', $request->input('product_detail_ID'))->first();
        $end_date = $start_date->addMonths($warranty_month->warranty_month);


        if ($warranty) {     //nếu biến order trả lại 1 (là tìm ra)
            $warranty->update([                                            //update warranty trong database qua biến này
                'order_id' => $request->input('orderID'),
                'sku' => $request->input('product_detail_ID'),
                'start_date' => $request->input('start_date'),
                'end_date' => $end_date,
                'description' => $request->input('description'),
            ]);
            return ['message' => 'Update warranty successfully', 'warranty' => $warranty];
        } else {
            response()->json(['errors' => ['message' => ['Cannot find this order.']]], 400);
        }
    }

    //tìm kiếm warranty
    // public function warranty_search_ui(Request $request)
    // {
    //     $search = $request->input('search');
    //     $search_date = $request->input('start_date');

    //     $warranty = Warranty::where('order_id', 'LIKE', '%' . $search . '%')->paginate(5);
    //     if (isset($search) && isset($search_date)){
    //         $warranty = Warranty::where('order_id', 'LIKE', '%' . $search . '%')->whereDate('start_date',$search_date)->paginate(5);
    //     } else {
    //         if(isset($search_date)){
    //             $warranty = Warranty::whereDate('start_date',$search_date)->paginate(5);
    //         }
    //     }

    //     $data = [
    //         'page' => 'Warranties',
    //         'warranties' => $warranty,
    //         'orders' => Order::all(),
    //         'order_detail' => OrderDetail::all(),
    //         'all_product_detail' => ProductDetail::all(),
    //         'search' => $search,
    //         'search_date' => $search_date,
    //     ];
    //     return view('admin.warranties.index', $data);
    // }

    //hàm trả json về cho bên warranty_api lấy làm việc trong filterWarranties
    public function search_warranties_ajax()
    {
        $search = request()->query('search');
        $day_first = request()->query('searchdayfirst');
        $day_last = request()->query('searchdaylast');
        $type = request()->query('statustype');
        $sort = request()->query('sortby');

        //khoảng thời gian tạo
        if (!isset($day_first)) {
            $day_first = Carbon::create(1900, 1, 1);
        }
        if (isset($day_last)) {
            $day_last = Carbon::parse($day_last)->addDay();
        } else {
            $day_last = Carbon::tomorrow();
        }

        //search theo khoảng thời gian tạo và thanh tìm kiếm
        $query = Warranty::with('product_detail', 'order')->whereBetween('created_at', [$day_first, $day_last])
            ->where(function ($query) use ($search) {
                $query->where('warranty_id', 'LIKE', '%' . $search . '%')
                    ->orwhere('order_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('sku', 'LIKE', '%' . $search . '%');
            });

        //search theo còn trong bảo hành ko
        $today = date('Y-m-d');
        if ($type == '0') {
            $query = $query->whereDate('start_date', '>', $today)->orWhereDate('end_date', '<', $today);
        } elseif ($type == '1') {
            $query = $query->where('start_date', '<=', $today)->Where('end_date', '>=', $today);
        }

        //search theo các loại sort
        if ($sort == 'oldest_warrant') {
            $query = $query->orderBy('created_at', 'asc');
        } elseif ($sort == 'latest_warrant') {
            $query = $query->orderBy('created_at', 'desc');
        } elseif ($sort == 'longest_warrant') { //bug
            $query = $query->orderByRaw('DATEDIFF(end_date, start_date) DESC');
        } elseif ($sort == 'shortest_warrant') { //bug
            $query = $query->orderByRaw('DATEDIFF(end_date, start_date) ASC');
        } elseif ($sort == 'sort_by_order') {
            $query = $query->orderBy('order_id', 'asc');
        } elseif ($sort == 'sort_by_product') {
            $query = $query->orderBy('sku', 'asc');
        }

        $warranties = $query->paginate(5);

        foreach ($warranties as $warranty) {
            $warranty->is_active = $warranty->is_active();
        }
        return response()->json(['warranties' => $warranties]);
    }


    //hàm trả dữ liệu cho trang warranty detail
    public function warranty_details(Request $request)
    {
        $warranty_id = $request->route('warranty_id');
        $warranty = Warranty::with('product_detail', 'order')->where('warranty_id', $warranty_id)->first();
        $detailedOrders = $warranty->order->order_details; //$order->order_details()->with('detailed_product');
        $data = [
            'page' => 'Warranty Details',
            'warranty' => $warranty,
            'detailed_orders' => $detailedOrders,
        ];
        return view('admin.warranties.warranty_details', $data);
    }
}
