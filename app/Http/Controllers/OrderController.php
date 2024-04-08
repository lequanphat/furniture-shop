<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDetailedOrder;
use App\Http\Requests\CreateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $data = [
            'page' => 'Orders',
            'orders' =>  Order::query()->paginate(5),
            'customers' => User::where('is_staff', false)->get(),
        ];
        return view('admin.orders.index', $data);
    }

    public function create(CreateOrder $request)
    {
        $isPaid = $request->input('paid') === 'on' ? true : false;
        $order_data = [
            'total_price' => 0,
            'is_paid' => $isPaid,
            'status' => $request->input('status'),
            'receiver_name' => $request->input('receiver_name'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'customer_id' => $request->input('customer_id') == -1 ? null : $request->input('customer_id'),
            'created_by' => Auth::user()->user_id,
        ];
        $order = Order::create($order_data);
        return ['message' => 'Created order successfully!', 'order' => $order];
    }

    public function update(Request $request)
    {

        $order_id = $request->route('order_id');
        $order = order::where('order_id', $order_id)->first();
        if ($order) {
            $isPaid = $request->input('paid') === 'on' ? true : false;
            $order->update([
                'is_paid' => $isPaid,
                'status' => $request->input('status'),
                'receiver_name' => $request->input('receiver_name'),
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
                'customer_id' => $request->input('customer_id') == -1 ? null : $request->input('customer_id'),
            ]);
            return ['message' => 'Update order successfully', 'order' => $order];
        } else {
            response()->json(['errors' => ['message' => ['Cannot find this order.']]], 400);
        }
    }

    //search, hàm trả json về cho bên order_api lấy làm việc trong filterOrders
    public function search_orders_ajax()
    {
        $search = request()->query('search');
        $orders = Order::with('product_detail','order')->where('order_id', 'LIKE', '%' . $search . '%')->paginate(5);
        // foreach( $warranties as $warranty ) {
        //     $warranty->is_active = $warranty->is_active();
        // }
        return response()->json(['warranties' => $orders]);
    }


    public function details(Request $request)
    {
        $order_id = $request->route('order_id');
        $order = Order::where('order_id', $order_id)->with('employee.default_address')->first();
        $detailedOrders = $order->order_details()->with('detailed_product')->paginate(5); // 5 items per page
        $data = [
            'page' => 'Order Details',
            'order' => $order,
            'detailed_orders' => $detailedOrders,
            'detailed_products' => ProductDetail::paginate(4),
        ];
        return view('admin.orders.order_details', $data);
    }



    public function create_detailed_order(CreateDetailedOrder $request)
    {
        $order_id = $request->route('order_id');
        $sku = $request->input('sku');
        $quantities = $request->input('quantities');
        $unit_price = $request->input('unit_price');
        $detailed_order_exist = OrderDetail::where('order_id', $order_id)->where('sku', $sku)->first();
        if ($detailed_order_exist) {
            OrderDetail::where('order_id', $order_id)->where('sku', $sku)->update([
                'quantities' => $detailed_order_exist->quantities + $quantities,
                'unit_price' => $unit_price,
            ]);
            ProductDetail::where('sku', $sku)->decrement('quantities', $request->input('quantities'));
            return ['message' => 'Created order detail successfully!', 'detailed_order' => $detailed_order_exist];
        } else {
            $order_detail = OrderDetail::create([
                'order_id' => $order_id,
                'sku' => $sku,
                'quantities' => $quantities,
                'unit_price' => $unit_price,
            ]);
        }
        ProductDetail::where('sku', $sku)->decrement('quantities', $request->input('quantities'));
        return ['message' => 'Created order detail successfully!', 'detailed_order' => $order_detail];
    }

    public function checkout_order(Request $request)
    {

        $order = Order::create([
            'total_price' => 0,
            'is_paid' => false,
            'status' => 0,
            'receiver_name' => $request->input('receiver_name'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'customer_id' => Auth::user()->user_id,
            'created_by' => null,
        ]);
        $checkout = json_decode($request->input('checkout'), true);
        foreach ($checkout as $item) {
            $order_detail = OrderDetail::create([
                'order_id' => $order->order_id,
                'sku' => $item['sku'],
                'quantities' => $item['quantities'],
                'unit_price' => $item['unit_price'],
            ]);
            ProductDetail::where('sku', $item['sku'])->decrement('quantities', $item['quantities']);
        }
        return ['message' => 'Checkout order successfully!', 'order' => $order];
    }

    public function checkout_order_success(Request $request)
    {
        $data = [
            'page' => 'Checkout Success',
        ];
        return view('pages.checkout.success', $data);
    }
}
