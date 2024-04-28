<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{

    //
    private $sqlDateFormat='Y-m-d';
    private $DateFormat='d-m-Y';
    public function statistic_ui(Request $request)
    {

        $data = [
            'page' => 'Statistic',
        ];
        return view('admin.statistics.statistics', $data);
    }
    public function overviewLast7day()
    {
        $solds=[];
        $orders=[];
        $revenues=[];
        $dates=[];
        for ($i = 7; $i >= 0; $i--) {
            $time=now()->subDays($i);
            $sold=OrderDetail::whereDate('created_at',$time)->sum('quantities');
            $order=Order::whereDate('created_at',$time)->get()->count();
            $date=now()->subDays(($i));
            $revenue=Order::whereDate('created_at',$time)->where('is_paid',1)->sum('total_price');
            array_push($orders,$order);
            array_push($revenues,$revenue);
            array_push($solds,$sold);
            array_push($dates,$date);
        }
        return response()->json(
            [
                'solds'=>$solds,
                'orders'=>$orders,
                'revenues'=>$revenues,
                'labels'=>$dates,
            ]
        ) ;



    }
    public function RevenueDateByDate(Request $request)
    {
        $category = request()->input('category_id');//All or id category
        $start =Carbon::parse(request()->input('start-date'));
        $end = Carbon::parse(request()->input('end-date'));
        if($start>$end)
        {
            return response()->json(['errors' => ['message' => ['Can not statistic when start day > end day']]], 400);
        }
        $current=$start;
        $days=[];
        $revenues=[];
        $quantities=[];
        while ($current<=$end)
        {
            if($category==-1)
            {
                $query=OrderDetail::whereDate('created_at',$current->format($this->sqlDateFormat));
                $quantity=$query->sum('quantities');
                $revenue = $quantity*$query->average('unit_price');
                array_push($revenues,$revenue);
                array_push($quantities,$quantity);
                array_push($days,$current);
            }
            else
            {
                $query=OrderDetail::with('detailed_product.product.category.parent')->whereDate('created_at',$current->format($this->sqlDateFormat))
                ->where('detailed_product.product.category.category_id', $category);
                $quantity=$query->sum('quantities');
                $revenue = $quantity*$query->average('unit_price');
                array_push($revenues,$revenue);
                array_push($quantities,$quantity);
                array_push($days,$current);
            }
            $current=$current->addDay();
        }
        return response()->json(
            [
                'labels'=>$days,
                'solds'=>$quantities,
                'revenues'=>$revenues,
            ]
        ) ;
    }

    public function SellingProductPie(Request $request){
        $name=[];
        $quantities=[];
        $other=0;
        $products = Product::with('detailed_products.order_details')->get();//eager load mối quan hệ liên kết với model Product, là khi truy xuất mỗi Product, dữ liệu liên quan từ các bảng detailed_products và order_details được tải cùng luôn.

        //tính ra số lượng các product
        $total_quantities = OrderDetail::all()->sum('quantities');//lấy tổng sl để tính %, dưới 5% tổng sản phẩm thì vô other hết
        foreach($products as $product){ //xét trên mỗi product
            $order = OrderDetail::with('detailed_product.product')->get()->where('detailed_product.product.product_id', $product->product_id);
            $quantity = $order->sum('quantities');
            if(($quantity/$total_quantities) < 0.03){
                $other = $other + $quantity;
            } else {
                array_push($name, $product->name);
                array_push($quantities, $quantity);
            }
        }
        array_push($name, 'Others');
        array_push($quantities, $other);



        //$product_name = $products->pluck('name');
        return response()->json(
            [
                'labels'=>$name,
                'number_of_product'=>$quantities,
            ]
        );
    }

}
