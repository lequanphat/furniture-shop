<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelOrder;
use App\Http\Requests\CheckoutOrder;
use App\Http\Requests\CreateDetailedOrder;
use App\Http\Requests\CreateOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        // query parameters
        $search = request()->query('search');
        $sort = request()->query('sort');
        $type = request()->query('type');
        $day_first = request()->query('dayfirst');
        $day_last = request()->query('daylast');

        // filter orders by start_date, end_date
        if (!isset($day_first)) {
            $day_first = Carbon::create(1900, 1, 1);
        }

        if (isset($day_last)) {
            $day_last = Carbon::parse($day_last)->addDay();
        } else {
            $day_last = Carbon::tomorrow();
        }

        $query = Order::whereBetween('created_at', [$day_first, $day_last])
            ->where(function ($query) use ($search) {
                $query->where('order_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('receiver_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('address', 'LIKE', '%' . $search . '%');
            });

        if ($type != 'all' && $type != null) {
            $query = $query->where('status', $type);
        }
        // sort orders
        if ($sort == 'oldest') {
            $query = $query->orderBy('created_at', 'asc');
        } else if ($sort == 'latest' || $sort == null) {
            $query = $query->orderBy('created_at', 'desc');
        } else if ($sort == 'price_asc') {
            $query = $query->orderBy('total_price', 'asc');
        } else if ($sort == 'price_desc') {
            $query = $query->orderBy('total_price', 'desc');
        }
        $orders = $query->paginate(5); // 5 orders per page

        $data = [
            'page' => 'Orders',
            'orders' =>  $orders,
            'customers' => User::where('is_staff', false)->get(),
            'search' => $search,
            'type' => $type,
            'sort' => $sort,
            'dayfirst' => $day_first,
            'daylast' => $day_last,
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

            //sau khi update xong mà tình trạng của order đã paid và delivered thì tự tạo cái phiếu bảo hành cho sản phẩm trong order
            if($request->input('status') == '3' && $request->input('paid') == 'on'){
                $order_details = OrderDetail::where('order_id', $order_id);
                foreach($order_details as $order_detail){
                    $start_date = now();
                    $product_info = ProductDetail::query()->where('sku', $order_detail->sku)->first();
                    $end_date = $start_date->addMonths($product_info->warranty_month);

                    $warranty_data = [
                        'order_id' => $order_detail->order_id,
                        'sku' => $order_detail->sku,
                        'start_date ' => $start_date,
                        'end_date' => $end_date,
                        'description' => 'finish',//'Order #' + $order_detail->order_id + ', ' + $product_info->name,
                    ];
                    $warranty = Warranty::create($warranty_data);
                }
            }

            return ['message' => 'Update order successfully', 'order' => $order];
        } else {
            response()->json(['errors' => ['message' => ['Cannot find this order.']]], 400);
        }
    }

    public function search_orders_ajax()
    {
        // query parameters
        $search = request()->query('search');
        $sort = request()->query('sort');
        $type = request()->query('type');
        $day_first = request()->query('dayfirst');
        $day_last = request()->query('daylast');

        // filter orders by start_date, end_date
        if (!isset($day_first)) {
            $day_first = Carbon::create(1900, 1, 1);
        }

        if (isset($day_last)) {
            $day_last = Carbon::parse($day_last)->addDay();
        } else {
            $day_last = Carbon::tomorrow();
        }

        $query = Order::whereBetween('created_at', [$day_first, $day_last])
            ->where(function ($query) use ($search) {
                $query->where('order_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('receiver_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('address', 'LIKE', '%' . $search . '%');
            });

        if ($type != 'all' && $type != null) {
            $query = $query->where('status', $type);
        }
        // sort orders
        if ($sort == 'oldest') {
            $query = $query->orderBy('created_at', 'asc');
        } else if ($sort == 'latest'  || $sort == null) {
            $query = $query->orderBy('created_at', 'desc');
        } else if ($sort == 'price_asc') {
            $query = $query->orderBy('total_price', 'asc');
        } else if ($sort == 'price_desc') {
            $query = $query->orderBy('total_price', 'desc');
        }
        $orders = $query->paginate(5); // 5 orders per page

        // serialize data
        foreach ($orders as $order) {
            $order->howmanydaysago = $order->howmanydaysago();
            $order->money = $order->money_type();
            if ($order->created_at->diffInDays() < 7) {
                $order->new = true;
            }
        }

        return response()->json(['order_for_ajax' => $orders]);
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


    public function payment_with_vnpay($order_id, $amount)
    {
        $vnp_TxnRef = $order_id;
        $vnp_Locale = "vn"; // language
        $vnp_BankCode = "NCB";  // bank code
        $vnp_IpAddr = request()->ip();  // ip address of client
        $vnp_TmnCode = env('VNP_TMN_CODE');

        $vnp_Returnurl =  config('app.url') . 'checkout/' . $order_id;
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_HashSecret = env('VNP_HASH_SECRET');

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD: " . $vnp_TxnRef,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
    public function checkout_order(CheckoutOrder $request)
    {
        // validate data
        $checkout = json_decode($request->input('checkout'), true);
        foreach ($checkout as $item) {
            $product = ProductDetail::where('sku', $item['sku'])->first();
            if (!$product) {
                return response()->json(['errors' => ['message' => ['Cannot find this product.']]], 400);
            }
            if ($product->quantities < $item['quantities']) {
                return response()->json(['errors' => ['message' => ['Not enough quantities for this product.']]], 400);
            }
        }

        // create order
        $order = Order::create([
            'total_price' => 0,
            'is_paid' => false,
            'status' => 0,
            'receiver_name' => $request->input('receiver_name'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'note' => $request->input('note'),
            'customer_id' => Auth::user()->user_id,
            'created_by' => null,
        ]);

        // create order detail
        $total_price = 0;
        foreach ($checkout as $item) {
            $order_detail = OrderDetail::create([
                'order_id' => $order->order_id,
                'sku' => $item['sku'],
                'quantities' => $item['quantities'],
                'unit_price' => $item['unit_price'],
            ]);
            ProductDetail::where('sku', $item['sku'])->decrement('quantities', $item['quantities']);
            $total_price += $order_detail->quantities * $order_detail->unit_price;
        }
        // Update the total_price in the order
        $order->update(['total_price' => $total_price]);

        if ($request->input('payment_method') == 'vnpay') {
            return OrderController::payment_with_vnpay($order->order_id, $order->total_price);
        } else {
            return config('app.url') . 'checkout/' . $order->order_id;
        }
    }

    public function cancel_order(CancelOrder $request)
    {
        $order_id = $request->route('order_id');
        $order = Order::where('order_id', $order_id)->first();
        if ($order) {
            $order->update([
                'status' => 4,
                'note' => $order->note . ' - Cancelled by customer',
            ]);
            return ['message' => 'Cancel order successfully', 'order' => $order];
        }
        return response()->json(['errors' => ['message' => ['Cannot find this order.']]], 400);
    }
}
