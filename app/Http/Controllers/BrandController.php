<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\CreateBrand;

class BrandController extends Controller
{

    public function brand_ui(Request $request)
    {
        $data = [
            'page' => 'Brands',
            'brands' =>  Brand::query()
                ->paginate(5),
        ];
        return view('admin.brands.brand', $data);
    }
    public function brand_search_ui(Request $request)
    {

        $search = $request->input('search');
        $data = [
            'page' => 'Brands',
            'brands' =>  Brand::where('name', 'LIKE', '%' . $search . '%')
                ->paginate(5),
            'search' => $search,
        ];
        return view('admin.brands.brand', $data);
    }
    public function update_brand_ui(Request $request)
    {

        $brand_id = $request->route('brand_id');
        $data = [
            'page' => 'Brands',
            'action' => 'Update' . $brand_id
        ];
        return view('admin.brands.update_brand', $data);
    }
    public function brand_create(CreateBrand $request)
    {
        $brandData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'index' => $request->input('index'),
        ];
        $brand = Brand::create($brandData);
        return ['message' => 'Created brand successfully!', 'brand' => $brand];
    }
    public function brand_update(Request $request)
    {
        $brand = brand::where('brand_id', $request->input('brand_id'))->first();
        if ($brand) {
            $brand->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'index' => $request->input('index'),

            ]);
            return ['message' => 'Updated brand successfully!', 'brand' => $brand];
        } else {
            abort(404);
        }
    }
}
