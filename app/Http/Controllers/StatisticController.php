<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    //
    private $sqlDateFormat='Y-m-d';
    private $DateFormat='d-m-Y';
    public function RevenueDateByDate(Request $request)
    {
        $category = request()->input('category');//All or id category
        $start = request()->input('date_Start');
        $end = request()->input('date_End');
        
        $startDate=Carbon::parse($start)->format($this->sqlDateFormat);
        $endDate=Carbon::parse($end)->format($this->sqlDateFormat);


        $label="Revenue from " +Carbon::parse($start)->format($this->DateFormat) +" to " +Carbon::parse($end)->format($this->DateFormat);
        if($category=='All')
        {
            
            $query = DB::table('order_details as od')
            ->select(DB::raw('DATE(o.created_at) as label'), DB::raw('SUM(quantities * unit_price) as value'))
            ->join('orders as o', 'o.order_id', '=', 'od.order_id')
            ->where('o.is_paid', 1)
            ->whereBetween('o.created_at', [$startDate, $endDate])
            ->groupBy('label')
            ->orderBy('label','asc');
        }
        else
        {
            $query = DB::table('order_details as od')
            ->select(DB::raw('DATE(o.created_at) as label'), DB::raw('SUM(quantities * unit_price) as value'))
            ->join('orders as o', 'o.order_id', '=', 'od.order_id')
            ->whereIn('od.sku', function ($query) {
                $query->select('sku')
                    ->from('product_details')
                    ->whereIn('product_id', function ($query) {
                        $query->select('product_id')
                            ->from('products as p')
                            ->join('categories as c', 'p.category_id', '=', 'c.category_id')
                            ->join('categories as cp', 'c.category_id', '=', 'cp.category_id')
                            ->where('c.category_id',request()->input('category'))
                            ->orWhere('cp.category_id',request()->input('category'))
                            ->groupBy('product_id',);
                    });
            })
            ->where('o.is_paid', 1)
            ->whereBetween('o.created_at', [$startDate, $endDate])
            ->groupBy('label')
            ->orderBy('label','asc');
        }

        $results = $query->get();
        return response()->json([
            'labels' => $results->pluck('label'),
            'data'=> $results->pluck('value'),
            'label'=> $label
        ]);
    } 
    
}
