<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
    private $sqlDateFormat = 'Y-m-d';
    private $DateFormat = 'd-m-Y';
    private $round = 1000000;
    public function statistic_ui(Request $request)
    {

        $data = [
            'page' => 'Statistic',
        ];
        return view('admin.statistics.statistics', $data);
    }
    public function overviewLast7day()
    {
        $solds = [];
        $orders = [];
        $revenues = [];
        $dates = [];
        for ($i = 7; $i >= 0; $i--) {
            $time = now()->subDays($i);
            $sold = OrderDetail::whereDate('created_at', $time)->sum('quantities');
            $order = Order::whereDate('created_at', $time)->get()->count();
            $date = now()->subDays(($i));
            $revenue = Order::whereDate('created_at', $time)->where('is_paid', 1)->sum('total_price');

            array_push($orders, $order);
            array_push($revenues, $revenue / $this->round);
            array_push($solds, $sold);
            array_push($dates, $date->format($this->DateFormat));
        }
        return response()->json(
            [
                'solds' => $solds,
                'orders' => $orders,
                'revenues' => $revenues,
                'labels' => $dates,
            ]
        );
    }
    public function RevenueDateByDate(Request $request)
    {
        $categoryID = request()->input('category_id');
        $start = Carbon::parse(request()->input('start-date'));
        $end = Carbon::parse(request()->input('end-date'));
        if ($start > $end) {
            return response()->json(['errors' => ['message' => ['Can not statistic when start day > end day']]], 400);
        }
        $current = $start;
        $days = [];
        $revenues = [];
        $quantities = [];


        if ($categoryID == -1) //-1 mean All
        {
            while ($current <= $end) {
                $query = OrderDetail::whereDate('created_at', $current->format($this->sqlDateFormat));
                //calc value
                $quantity = $query->sum('quantities');
                $revenue = $quantity * $query->average('unit_price');

                array_push($revenues, $revenue / $this->round);
                array_push($quantities, $quantity);
                array_push($days, $current->format($this->DateFormat));
                $current = $current->addDay();
            }
        } else {
            //get categories and child_categories by id
            $categories = Category::where('category_id', $categoryID)->Orwhere('parent_id', $categoryID);
            if ($categories->count() != 0) {
                while ($current <= $end) {

                    $query = OrderDetail::with('detailed_product.product', 'detailed_product.product.category.parent')->whereDate('created_at', $current->format($this->sqlDateFormat))->get()
                        ->whereIN('detailed_product.product.category_id', $categories->pluck('category_id'));
                    //calc value
                    $quantity = $query->sum('quantities');
                    $revenue = $quantity * $query->average('unit_price');

                    array_push($revenues, $revenue / $this->round);
                    array_push($quantities, $quantity);
                    array_push($days, $current->format($this->DateFormat));
                    $current = $current->addDay();
                }
            } else {
                return response()->json(['errors' => ['message' => ['Can not statistic when not found categories']]], 400);
            }
        }
        return response()->json(
            [
                'labels' => $days,
                'solds' => $quantities,
                'revenues' => $revenues,
            ]
        );
    }

    public function SellingProductPie(Request $request)
    {
        $day_first = $request->query('dayfirst');
        $day_last = $request->query('daylast');
        $time_frame = $request->query('timeframe');
        $whichpiechart = $request->query('piechart');
        //$number_of_products = $request->query('numberofproducts') ?? 5;

        $name = [];
        $quantities = [];
        $other = 0;
        $time = null;
        $time2 = null;

        if (isset($time_frame)) {
            switch ($time_frame) {
                case '1w':
                    $time = now()->subWeek();
                    break;
                case '1m':
                    $time = now()->subMonth();
                    break;
                case '3m':
                    $time = now()->subQuarter();
                    break;
                case '1y':
                    $time = now()->subYear();
                    break;
            }
            $time2 = now();
        }

        //thanh tìm kiếm
        if (isset($day_first) || isset($day_last)) {
            if (!isset($day_first)) {
                $day_first = Carbon::create(1900, 1, 1);
            }
            if (isset($day_last)) {
                $day_last = Carbon::parse($day_last)->addDay();
            } else {
                $day_last = Carbon::tomorrow();
            }
            $time = $day_first;
            $time2 = $day_last;
        }


        //lấy tổng sl để tính %, dưới 5% tổng sản phẩm thì vô other hết
        $total_quantities = OrderDetail::all()->whereBetween('created_at', [$time, $time2])->sum('quantities');
        if ($whichpiechart == '1') { //dữ liệu cho biểu đồ tròn thứ nhất
            //lấy các product tồn tại, cho vào lặp trên từng loại product để tính số lượng
            $products = Product::with('detailed_products.order_details')->get(); //eager load mối quan hệ liên kết với model Product, là khi truy xuất mỗi Product, dữ liệu liên quan từ các bảng detailed_products và order_details được tải cùng luôn.
            //xét trên mỗi product và tính tổng
            foreach ($products as $product) {
                $order = OrderDetail::with('detailed_product.product')->get()->whereBetween('created_at', [$time, $time2])->where('detailed_product.product.product_id', $product->product_id);
                $quantity = $order->sum('quantities');
                if (($quantity / $total_quantities) < 0.05) {
                    $other = $other + $quantity;
                } else {
                    array_push($name, $product->name);
                    array_push($quantities, $quantity);
                }
            }
        } elseif ($whichpiechart == '2') { //dữ liệu cho biểu đồ tròn thứ hai
            //lấy các loại category tồn tại, lặp để tính số lượng
            $categories = Category::with('products.detailed_products.order_details')->get();
            foreach ($categories as $category) {
                $order = OrderDetail::with('detailed_product.product.category')->get()->whereBetween('created_at', [$time, $time2])->where('detailed_product.product.category.category_id', $category->category_id);
                $quantity = $order->sum('quantities');
                if (($quantity / $total_quantities) < 0.05) {
                    $other = $other + $quantity;
                } else {
                    array_push($name, $category->name);
                    array_push($quantities, $quantity);
                }
            }
        }
        //nếu có các sản phẩm nhỏ quá
        if ($other > 0) {
            array_push($name, 'Others');
            array_push($quantities, $other);
        }

        //$product_name = $products->pluck('name');
        return response()->json(
            [
                'labels' => $name,
                'number_of_product' => $quantities,
            ]
        );
    }


    public function getBestSellerProducts(Request $request)

    {
        $numbers = $request->query('numbers') ?? 5;
        $query = Product::with(
            [
                'detailed_products' => function ($query) {
                    $query->where('is_deleted', 0)->with('images', 'product_discounts.discount');
                },
            ]
        )->where('is_deleted', false)->has('detailed_products');
        $best_seller_products = $query->orderByDesc('amount_sold')->paginate($numbers);
        return response()->json(['products' => $best_seller_products]);
    }
}
