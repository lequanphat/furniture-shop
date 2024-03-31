<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetailedOrder;
use App\Http\Requests\CreateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //mỗi hàm đều sẽ được nạp qua route để kết nối mvc
    //ở đây ta sẽ gọi hàm truy vấn, add dữ liệu trong file này luôn

    //hàm index, theo route sẽ xử lý cái view index
    public function index()
    {
        $data = [               //nhãn gồm có tên trang là orders, dòng 2 là dữ liệu nạp từ model
            'page' => 'Orders ', //đặt tên cho pages
            'orders' =>  Order::query()->paginate(5),     //hàm query cho phân trang

            'customer_and_employee' => User::all() //dùng để nạp dữ liệu chọn vào các ô trong trang tạo
            //Đây là dòng query, lấy toàn bộ dữ liệu database trong order
            //lưu ý chữ orders bên trái này sẽ là biến để sử dụng ở view
        ];
        return view('admin.orders.index', $data); //return về view với mớ data để nạp vô bảng
    }



    //tạo order mới
    //dữ liệu từ order_api.js sẽ được route dẫn qua đây nạp vào rồi gửi tạo ở database
    public function order_create(CreateOrder $request)
    {
        $isPaid = $request->input('paid') === 'on' ? true : false;
        $order_data = [
            'total_price' => 0,
            'is_paid' => $isPaid,
            'status' => $request->input('status'),
            'receiver_name' => $request->input('receiver_name'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'customer_id' => $request->input('customer_id'),
            'created_by' => Auth::user()->user_id,
        ];
        $order = Order::create($order_data);
        return ['message' => 'Created order successfully!', 'order' => $order];
    }


    //sửa thông tin order
    public function order_update(Request $request)
    {
        //request chứa dữ liệu về request http đang tới
        //lấy thông tin về order trong database
        //lấy order ở order_id trên database, dựa trên order_id trong dữ liệu của request request
        $order_id = $request->route('order_id');
        $order = order::where('order_id', $order_id)->first();    //first là lấy phần tử đầu tiên
        if ($order) {     //nếu biến order trả lại 1 (là tìm ra)
            $isPaid = $request->input('paid') === 'on' ? true : false;
            $order->update([                                            //update order trong database qua biến này
                'is_paid' => $isPaid,
                'status' => $request->input('status'),
                'receiver_name' => $request->input('receiver_name'),
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
                'customer_id' => $request->input('customer_id'),
            ]);
            return ['message' => 'Update order successfully', 'order' => $order];
        } else {
            response()->json(['errors' => ['message' => ['Cannot find this order.']]], 400);
        }
    }

    public function order_search_ui(Request $request)
    {

        $search = $request->input('search');
        $data = [
            'page' => 'Orders',
            'orders' =>  Order::where('receiver_name', 'LIKE', '%' . $search . '%')->paginate(5),
            'customer_and_employee' => User::all(),
            'search' => $search,
        ];
        return view('admin.orders.index', $data);
    }

    /*public function change_status_table(Request $request){
        $status = $request->input('select_status_for_table');
        $data = [
            'page' => 'Orders',
            'orders' => Order::where('status', 'LIKE', '%'.$status.'%')->paginate(5),
            'customer_and_employee' => User::all(),
        ];
        return view('admin.orders.index', $data);
    }*/

    //Phần của order detail
    public function details(Request $request)
    {
        $order_id = $request->route('order_id');
        $order = Order::where('order_id', $order_id)->with('employee.default_address')->first();
        $detailedOrders = $order->order_details()->with('detailed_product')->paginate(5); // 5 items per page
        $data = [
            'page' => 'Order Details',
            'order' => $order,
            'detailed_orders' => $detailedOrders,
            'all_product_detail' => ProductDetail::all(),
        ];
        return view('admin.orders.order_details', $data);
    }


    //tạo detail mới
    public function order_detail_create(CreateDetailedOrder $request)
    {
        $order_detail_data = [
            'order_id' => $request->input('orderID'),
            'sku' => $request->input('productDetailId'),
            'quantities' => $request->input('quantity'),
            'unit_price' => $request->input('unitPrice'),
        ];
        $order_detail = OrderDetail::create($order_detail_data);        //hàm tạo order
        return ['message' => 'Created order detail successfully!', 'order_detail' => $order_detail]; //gửi message về order_api.js để thông báo thành công
    }

    //update detail
    public function order_detail_update(Request $request)
    {
        $orderdetail = OrderDetail::where('order_id', '=', $request->input('orderId'))->where('sku', '=', $request->input('productDetailId'))->first();    //first là lấy phần tử đầu tiên
        if ($orderdetail) {     //nếu biến order trả lại 1 (là tìm ra)
            $orderdetail->update([
                'order_id' => $request->input('orderID'),
                'sku' => $request->input('productDetailId'),
                'quantities' => $request->input('quantity'),
                'unit_price' => $request->input('unitPrice'),
            ]);
            return ['message' => 'Update order detail successfully', 'order_detail' => $orderdetail];
        } else {         //nếu không có order detail nào được tìm thấy
            abort(404); //ném ra 404 Not Found HTTP exception
        }
    }
}
