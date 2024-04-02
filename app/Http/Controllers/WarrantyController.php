<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\Warranty;
use App\Http\Requests\CreateWarranty;

use Carbon\Carbon;
use Illuminate\Http\Request;

class WarrantyController extends Controller{
    public function index(){
        $data = [
            'page' => 'Warranties ',
            'warranties' => Warranty::with('product_detail','order')->paginate(5),
            'orders' => Order::all(),
            'order_detail' => OrderDetail::all(),
            'all_product_detail' => ProductDetail::all(),
        ];

    return view('admin.warranties.index', $data);
    }

    //thêm warranty
    public function warranty_create(CreateWarranty $request){
        //nhận ngày bắt đầu, kiếm số tháng bảo hành từ product detail rồi tính ra ngày kết thúc
        $start_date = Carbon::parse($request->input('start_date'));
        $warranty_month = ProductDetail::query()->where('sku', $request->input('product_detail_ID'))->first();
        $end_date = $start_date->addMonths($warranty_month->warranty_month);

        $warranty_data = [
            'order_id' => $request->input('orderID'),
            'sku' => $request->input('product_detail_ID'),
            'start_date' => $request->input('start_date'),
            'end_date'=> $end_date,
            'description' => $request->input('description'),
        ];
        $warranty = Warranty::create($warranty_data);
        return ['message' =>'Create Warranty succesfully!','warranty'=> $warranty];
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
                'end_date'=> $end_date,
                'description' => $request->input('description'),
            ]);
            return ['message' => 'Update warranty successfully', 'warranty' => $warranty];
        } else {
            response()->json(['errors' => ['message' => ['Cannot find this order.']]], 400);
        }
    }

    //tìm kiếm warranty
    public function warranty_search_ui(Request $request)
    {
        $search = $request->input('search');
        $search_date = $request->input('start_date');

        $warranty = Warranty::where('order_id', 'LIKE', '%' . $search . '%')->paginate(5);
        if (isset($search) && isset($search_date)){
            $warranty = Warranty::where('order_id', 'LIKE', '%' . $search . '%')->whereDate('start_date',$search_date)->paginate(5);
        } else {
            if(isset($search_date)){
                $warranty = Warranty::whereDate('start_date',$search_date)->paginate(5);
            }
        }

        $data = [
            'page' => 'Warranties',
            'warranties' => $warranty,
            'orders' => Order::all(),
            'order_detail' => OrderDetail::all(),
            'all_product_detail' => ProductDetail::all(),
            'search' => $search,
            'search_date' => $search_date,
        ];
        return view('admin.warranties.index', $data);
    }

}
