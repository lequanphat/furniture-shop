<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrder;
use App\Models\Order;
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
            'orders_table' => Order::all(),
            'customer_and_employee' => User::all()//dùng để nạp dữ liệu chọn vào các ô trong trang tạo
            //Đây là dòng query, lấy toàn bộ dữ liệu database trong order
            //lưu ý chữ orders bên trái này sẽ là biến để sử dụng ở view
        ];
        return view('admin.orders.index', $data);//return về view với mớ data để nạp vô bảng
    }

    //dùng để nạp dữ liệu chọn vào các ô trong trang tạo
    /*public function create_ui()
    {
        $data = [
            'page' => 'Create Product',
            'customer_and_employee' => User::all()
        ];
        return view('admin.orders.create_order', $data);
    }*/

    //tạo order mới
    public function order_create(CreateOrder $request)
    {
        $order_data = [
            'total_price' => $request->input('totalPrice'),
            'is_paid' => $request->input('paid'),
            'status'=> $request->input('status'),
            'receiver_name'=> $request->input('receiver_name'),
            'address'=> $request->input('address'),
            'phone_number'=> $request->input('phone_number'),
            'customer_id'=> $request->input('customer_id'),
            'created_by'=> $request->input('employee_id'),
        ];
        $order = Order::create($order_data);
        return ['message' => 'Created order successfully!', 'order' => $order];
    }

}



