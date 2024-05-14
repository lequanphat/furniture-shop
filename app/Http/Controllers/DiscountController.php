<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDiscount;
use App\Http\Requests\UpdateDiscount;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductDetail;

use App\Models\ProductDiscounts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = request()->query('search');
        $type = request()->query('type');
        $status = request()->query('status');
        $discount = Discount::when($type === 'active', function ($query) {
            $query->where('is_active', 1);
        })
            ->when($type === 'blocked', function ($query) {
                $query->where('is_active', 0);
            })
            ->when($status === 'indate', function ($query) {
                $query->where('start_date', '<=', date('Y-m-d'))->Where('end_date', '>=', date('Y-m-d'));
            })
            ->when($status === 'outdate', function ($query) {
                $query->where('start_date', '<', date('Y-m-d'))->Where('end_date', '<', date('Y-m-d'));
            })
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('start_date', 'like', '%' . $search . '%')
                    ->orWhere('end_date', 'like', '%' . $search . '%');
            })->paginate(8);
        foreach ($discount as $item) {
            if ($item->created_at->diffInDays() < 7) {
                $item->new = true;
            }
        }
        $data = [
            'discounts' => $discount,
            'search' => $search,
            'status' => $status,
            'type'  =>  $type,
        ];
        return view('admin.discounts.index', $data);
    }


    public function create(CreateDiscount $request)
    {
        $discount = Discount::create([
            'title' => $request->input('title'),
            'is_active' => ($request->input('is_active') != null),
            'start_date' => $request->input('startdate'),
            'end_date' => $request->input('enddate'),
            'percentage' => $request->input('percentage'),
            'description' => 'no description',
        ]);
        return ['message' => 'Created discount successfully!'];
    }

    public function discount_detail()
    {
        $discount_id = request()->route('discount_id');
        $discount = Discount::find($discount_id);
        if ($discount) {
            $productDiscounts = new ProductDiscounts();
            $skuList = $productDiscounts->getProductSKUInDiscount($discount_id);
            $detailed_products_in_discount = ProductDetail::where('is_deleted', false)->whereIn('sku', $skuList)->paginate(4);

            $detailed_products_not_in_discount = ProductDetail::where('is_deleted', false)->whereNotIn('sku', $skuList)->paginate(4);
            $data = [
                'page' => 'Discount Details',
                'discount' =>  $discount,
                'products' => $detailed_products_in_discount,
                'products_not_in_discount' => $detailed_products_not_in_discount,
            ];
            return view('admin.discounts.discount_detail', $data);
        }
        abort(404);
    }

    public function get_products_not_in_discount(Request $request)
    {
        $search = $request->query('search');
        $discount_id = $request->route('discount_id');

        $productDiscounts = new ProductDiscounts();
        $skuList = $productDiscounts->getProductSKUInDiscount($discount_id);

        $products = ProductDetail::where('is_deleted', false)
            ->whereNotIn('sku', $skuList)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            })
            ->with('images', 'color')
            ->paginate(4);

        return response()->json(['products' => $products]);
    }


    public function add_product_to_discount(Request $request)
    {
        $discount_id = $request->route('discount_id');
        $sku = $request->route('sku');
        try {
            ProductDiscounts::create([
                'sku' => $sku,
                'discount_id' => $discount_id
            ]);
            return response()->json(['message' => 'Product added to discount successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred while adding product to discount']);
        }
    }

    public function remove_product_from_discount(Request $request)
    {
        $discount_id = $request->route('discount_id');
        $sku = $request->route('sku');
        try {
            ProductDiscounts::where('sku', $sku)->where('discount_id', $discount_id)->delete();
            return response()->json(['message' => 'Product removed from discount successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'An error occurred while removing product from discount']);
        }
    }

    public function update(UpdateDiscount $request)
    {
        $discount_id = request()->route('discount_id');
        $discount_find = Discount::where('discount_id', $discount_id)->first();
        if ($discount_find) {
            $discount_find->update([
                'title' => $request->input('title'),
                'description' => 'no description',
                'percentage' => $request->input('percentage'),
                'start_date' => $request->input('startdate'),
                'end_date' => $request->input('enddate'),
            ]);
        }
        return ['message' => 'update discount successfully!'];
    }

    public function destroy(Request $request)
    {
        $discount_id = $request->route('discount_id');
        $discount = Discount::where('discount_id', $discount_id)->first();
        if ($discount) {
            $discount->is_active = 0;
            $discount->save();
        }
        return response()->json(['message' => 'Discount blocked successfully']);
    }

    public function restore(Request $request)
    {
        $discount_id = $request->route('discount_id');
        $discount = Discount::where('discount_id', $discount_id)->first();
        if ($discount) {
            $discount->is_active = 1;
            $discount->save();
        }
        return response()->json(['message' => 'Discount restored successfully']);
    }
}
