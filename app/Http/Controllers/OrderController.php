<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrder;
use App\Models\Order;


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
            'orders_table' => Order::all()
              //Đây là dòng query, lấy toàn bộ dữ liệu database trong order
            //lưu ý chữ orders bên trái này sẽ là biến để sử dụng ở view
        ];
        return view('admin.orders.index', $data);//return về view với mớ data để nạp vô bảng
    }
}



