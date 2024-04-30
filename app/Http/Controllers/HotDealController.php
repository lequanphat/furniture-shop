<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotDealController extends Controller
{

    public function get_LastestProduct()
    {
        $query = Product::with(
            'category',
            'brand',
            'detailed_products.images',
            'detailed_products.product_discounts.discount',
        )->where('is_deleted', false);
        $query->orderBy('created_at', 'desc');
        $products = $query->paginate(8);
        foreach ($products as $product) {
            $total_discount_percentage = 0;
            foreach ($product->detailed_products as $detailed_product) {
                foreach ($detailed_product->product_discounts as $product_discount) {
                    if ($product_discount->discount->is_currently_active()) {
                        $total_discount_percentage += $product_discount->discount->percentage;
                    }
                }
                $detailed_product->total_discount_percentage = $total_discount_percentage;
            }
        }
        $today = now();
        foreach ($products as $product) {
            $detailed_product =
                $product->detailed_products
                ->sortByDesc(function ($detailed_product) use ($today) {
                    return $detailed_product->product_discounts
                        ->where('discount.start_date', '<=', $today)
                        ->where('discount.end_date', '>=', $today)
                        ->sum('discount.percentage');
                })
                ->first() ?? $product->detailed_products->first();

            if (isset($detailed_product->images->first()->url)) {
                $detailed_product->image = $detailed_product->images->first()->url;
                $detailed_product->setRelation('images', null);
            }
            $product->detailed_product = $detailed_product;
            $total_quantities = $product->detailed_products->sum('quantities');
            $product->setRelation('detailed_products', null);
            $product->total_quantities = $total_quantities;
        }
        return response()->json([
            'products' => $products
        ]);
    }
    public function get_BestSeller()
    {
        $query = Product::with([
            'category',
            'brand',
            'detailed_products.images',
            'detailed_products.product_discounts.discount',
            'detailed_products.order_details',
        ])
            ->where('is_deleted', false);
        $products = $query->paginate(8);
        foreach ($products as $product) {
            $total_discount_percentage = 0;
            foreach ($product->detailed_products as $detailed_product) {
                foreach ($detailed_product->product_discounts as $product_discount) {
                    if ($product_discount->discount->is_currently_active()) {
                        $total_discount_percentage += $product_discount->discount->percentage;
                    }
                }
                $detailed_product->total_discount_percentage = $total_discount_percentage;
            }
        }
        foreach ($products as $product) {
            $total_sold = 0;
            foreach ($product->detailed_products as $detailed_product) {
                foreach ($detailed_product->order_details as $order_detail) {
                    $total_sold += $order_detail->quantities;
                }
                $product->sold = $total_sold;
            }
        }
        $today = now();
        foreach ($products as $product) {
            $detailed_product =
                $product->detailed_products
                ->sortByDesc(function ($detailed_product) use ($today) {
                    return $detailed_product->product_discounts
                        ->where('discount.start_date', '<=', $today)
                        ->where('discount.end_date', '>=', $today)
                        ->sum('discount.percentage');
                })
                ->first() ?? $product->detailed_products->first();

            if (isset($detailed_product->images->first()->url)) {
                $detailed_product->image = $detailed_product->images->first()->url;
                $detailed_product->setRelation('images', null);
            }
            $product->detailed_product = $detailed_product;
            $total_quantities = $product->detailed_products->sum('quantities');
            $product->setRelation('detailed_products', null);
            $product->total_quantities = $total_quantities;
        }
        return response()->json([
            'products' => $products
        ]);
    }
}
