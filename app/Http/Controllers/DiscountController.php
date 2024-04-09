<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDiscount;
use App\Http\Requests\UpdateDiscount;
use App\Models\Discount;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductDiscounts;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = [
            'page' => 'Discount Site',
            'discounts' => Discount::paginate(8),
        ];
        return view('admin.discounts.discountUI', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateDiscount $request)
    {
        //


        $DiscountData =
            [
                'title' => $request->input('title'),
                'amount' => $request->input('amount'),
                'is_active' => $request->input('active'),
                'start_date' => $request->input('startdate'),
                'end_date' => $request->input('enddate'),
                'percentage' => $request->input('percentage'),
                'description' => $request->input('description')
            ];
        $Discount = Discount::create($DiscountData);
        //print_r($request);
        return ['message' => 'Created discount successfully!'];
    }

    public function discount_detail()
    {
        $discount_id = request()->route('discount_id');

        $productDiscounts = new ProductDiscounts();

//        lay tat ca cac sku co discount_id
        $sku = $productDiscounts->getSkuForDiscountId($discount_id);

//        $product_id_productDetail = ProductDetail::where('sku', $sku)->pluck('product_id');
        $product_ids = ProductDetail::whereIn('sku', $sku)->pluck('product_id');
        $checkIdProduct = Product::whereIn('product_id', $product_ids)->pluck('product_id');





        $data = [
            'page' => 'Discount Details And List Discount Item',
            //        ,

            'discount' => Discount::find($discount_id),
            'product' => Product::all(),

            'Registor' => $checkIdProduct,

        ];


        return view('admin.discounts.discount_detail', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscount $request)
    {
        //

        $discount_find = Discount::where('discount_id', $request->input('discount_id'))->first();

        if ($discount_find) {
            $discount_find->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'percentage' => $request->input('percentage'),
                'amount' => $request->input('amount'),
                'start_date' => $request->input('startdate'),
                'end_date' => $request->input('enddate'),
                'is_active' => $request->input('active')
            ]);
            // response

        }
        return ['message' => 'update discount successfully!'];
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $discount = Discount::find($id);
        $discount->delete();

        return redirect('/admin/discounts');
        //        return "Take It";

    }

    public function deleteProductDiscountCheck(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $isChecked = $request->input('is_checked');
            $discountId = $request->input('discount_id');

            // Retrieve SKU directly, checking for existence
            $findSku = ProductDetail::where('product_id', $productId)->value('sku');
            $deletedRows = ProductDiscounts::where('sku', $findSku)->where('discount_id', $discountId)->forceDelete();
//


            if ($deletedRows > 0) {
                return response()->json(['message' => 'Checkbox delete successfully'], 200);
            } else {
                return response()->json(['error' => 'No matching discount found to delete.'], 404); // Return 404 if no matching discount found
            }

        } catch (\Exception $e) {
            // Log the exception for detailed debugging
            Log::error($e);
            return response()->json(['error' => 'An error occurred while deleting the discount.'], 500);
        }
    }

    public function updateProductDiscount(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $isChecked = $request->input('is_checked');
            $discountId = $request->input('discount_id');
            $findSku_true = ProductDetail::where('product_id', $productId)->first();


            if ($findSku_true) {
                $findSku = ProductDetail::where('product_id', $productId)->first()->sku;


                $DiscountCheckBox =
                    [
                        'sku' => $findSku,
                        'discount_id' => $discountId,

                    ];


                $Discount = ProductDiscounts::create($DiscountCheckBox);
                return response()->json(['message' => 'Checkbox change saved successfully']);
            } else {
                return response()->json(['message' => 'Khong Ton Tai SKU Cua San Pham Vui Long Them']);
            }


        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while saving the checkbox change']);
        }


    }


}
