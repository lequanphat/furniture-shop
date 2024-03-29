<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;

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
        $order_data = [                                             //mảng order_data
            'total_price' => $request->input('totalPrice'),         //lấy dữ liệu từ ô có id và name là totalPrice được đính qua request
            'is_paid' => $request->input('paid'),
            'status' => $request->input('status'),
            'receiver_name' => $request->input('receiver_name'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'customer_id' => $request->input('customer_id'),
            'created_by' => $request->input('employee_id'),
        ];
        $order = Order::create($order_data);        //hàm tạo order
        return ['message' => 'Created order successfully!', 'order' => $order]; //gửi message về order_api.js để thông báo thành công
    }


    //sửa thông tin order
    public function order_update(Request $request)
    { //request chứa dữ liệu về request http đang tới
        //lấy thông tin về order trong database
        //lấy order ở order_id trên database, dựa trên order_id trong dữ liệu của request request
        $order = order::where('order_id', $request->input('order_id'))->first();    //first là lấy phần tử đầu tiên
        if ($order) {     //nếu biến order trả lại 1 (là tìm ra)
            $order->update([                                            //update order trong database qua biến này
                'total_price' => $request->input('totalPrice'),         //lấy dữ liệu từ ô có id và name là totalPrice được đính qua request
                'is_paid' => $request->input('paid'),
                'status' => $request->input('status'),
                'receiver_name' => $request->input('receiver_name'),
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
                'customer_id' => $request->input('customer_id'),
                'created_by' => $request->input('employee_id'),
            ]);
            return ['message' => 'Update order successfully', 'order' => $order];
        } else {         //nếu không có order nào được tìm thấy
            abort(404); //ném ra 404 Not Found HTTP exception
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
        $detailedOrders = $order->order_details()->with('detailed_product')->paginate(6); // 5 items per page
        $data = [
            'page' => 'Order Details',
            'order' => $order,
            'detailed_orders' => $detailedOrders,
        ];
        return view('admin.orders.order_details', $data);
    }
}
