<?php

namespace App\Http\Controllers;

use App\Models\Discount;
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
            'discounts' => Discount::all(),
            //            'request' => 'request'
        ];
        return view('admin.discounts.discountUI', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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
        return "Success";
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
    public function update(Request $request)
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
        return "Update_Done";
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
