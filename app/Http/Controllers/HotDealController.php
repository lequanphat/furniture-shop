<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotDealController extends Controller
{
    public function get_Deal_of_Date_product(Request $request)
    {
        $product = Product::select([
            'products.product_id',
            'products.name',
            'product_details.sku',
            'product_images.url',
            DB::raw('round(product_details.original_price,0) AS old_price'),
            DB::raw('round(product_details.original_price * (1 - discounts.percentage/100),0) AS new_price'),
            DB::raw('round(discounts.percentage,0) AS discount_percent'),
        ])
        ->distinct()
        ->join('product_details', 'products.product_id', '=', 'product_details.product_id')
        ->leftjoin('product_images', 'product_details.sku', '=', 'product_images.sku')
        ->join('product_discounts', 'product_details.sku', '=', 'product_discounts.sku')
        ->join('discounts', 'product_discounts.discount_id', '=', 'discounts.discount_id')
        ->where(function ($query) {
            $query->where('discounts.is_active', '!=', 0)
                  ->where('discounts.amount', '!=', 0)
                  ->whereDate('discounts.start_date', '<=', now())
                  ->whereDate('discounts.end_date', '>=', now());
        })
        ->where('products.is_deleted', false)
        ->orderBy('discounts.percentage', 'desc')
        ->limit(5)
        ->get();
        return response()->json($product);
    }
    public function get_BestSellerProduct()
    {
        $query = Product::with(
            'detailed_products.images',
            'detailed_products.product_discounts.discount',
        )->where('is_deleted', false);
    }
}
