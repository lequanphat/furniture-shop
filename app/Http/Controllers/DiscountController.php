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

    public function  discount_detail()
    {
        $discount_id = request()->route('discount_id');
    //  $product = ProductDiscounts::with('sku', 'discount')->find($discount_id);
        // $sku = ProductDiscounts::where('discount_id', $discount_id) ->pluck('sku')
        // ->first();

        // $find_sku = ProductDiscounts::where('discount_id',$discount_id)->select('sku')->first();
        $find_product_id = ProductDiscounts::with('sku', 'discount')->find($discount_id);




// $find_product_detail = ProductDetail::with('product')->find($sku);



        $data = [
            'page' => 'Discount Details And List Discount Item',
            //        ,

            'discount' => Discount::find($discount_id),
            'product' => Product::all(),
            'check' => $find_product_id,


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
}
