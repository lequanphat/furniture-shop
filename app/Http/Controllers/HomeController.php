<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ReceivingReport;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    //

    public function index()
    {
        $sevenDaysAgo = now()->subDays(7);
        $total_orders = Order::whereDate('created_at', '>=', $sevenDaysAgo)
            ->count();
        $waiting_payments = Order::where('is_paid', false)
            ->whereDate('created_at', '>=', $sevenDaysAgo)
            ->count();

        $shipped_orders = Order::where('status', 3)
            ->whereDate('created_at', '>=', $sevenDaysAgo)
            ->count();
        $total_revenue = Order::where('is_paid', true)
            ->whereDate('created_at', '>=', $sevenDaysAgo)
            ->sum('total_price');


        $total_revenue_30day = Order::where('is_paid', true)
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->sum('total_price');
        $total_users = User::where('is_active', true)->where('is_staff', false)->count();
        $new_users = User::where('is_active', true)->where('is_staff', false)->whereDate('created_at', '>=', $sevenDaysAgo)->count();
        $data = [
            'page' => 'Admin Dashboard',
            'total_orders' => $total_orders,
            'waiting_payments' => $waiting_payments,
            'shipped_orders' => $shipped_orders,
            'total_users' => $total_users,
            'new_users' => $new_users,
            'total_revenue' => $total_revenue,
            'total_revenue_30day' => $total_revenue_30day,
        ];
        return view('admin.dashboard.index', $data);
    }

    public function getOrdersStatistic()
    {
        $endDate = now();
        $startDate = now()->subDays(30);
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d');
            });

        $orderCount = [];
        foreach ($orders as $key => $value) {
            $orderCount[(int)$key] = count($value);
        }

        ksort($orderCount);
        for ($i = 1; $i <= 30; $i++) {
            if (!isset($orderCount[$i])) {
                $orderCount[$i] = 0;
            }
        }

        ksort($orderCount);

        $orderCount = array_values($orderCount);
        $orderCount = array_reverse($orderCount);

        // receipt
        $receipt = ReceivingReport::whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('d');
            });

        $receiptCount = [];
        foreach ($receipt as $key => $value) {
            $receiptCount[(int)$key] = count($value);
        }

        ksort($receiptCount);

        for ($i = 1; $i <= 30; $i++) {
            if (!isset($receiptCount[$i])) {
                $receiptCount[$i] = 0;
            }
        }

        ksort($receiptCount);

        $receiptCount = array_values($receiptCount);
        $receiptCount  = array_reverse($receiptCount);

        return response()->json(['orders' => $orderCount, 'receipts' => $receiptCount]);
    }
}
