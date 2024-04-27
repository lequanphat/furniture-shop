<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\CreateBrand;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{

    public function brand_ui(Request $request)
    {
        $search = request()->query('search');
        $data = [
            'page' => 'Brands',
            'brands' =>  Brand::query()
                ->paginate(5),
            'search' => $search,
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

        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'message' => 'Created color successfully!',
            'brand' => $brand,
            'can_update' => $admin->can('update brand'),
            'can_delete' => $admin->can('delete brand'),
        ];
        return response()->json($data, 200);
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
            if ($brand->created_at->diffInDays() < 7) {
                $brand->new = true;
            }
            // get permission of the admin
            $admin = User::where('user_id', Auth::id())->first();
            $data = [
                'message' => 'Updated color successfully!',
                'brand' => $brand,
                'can_update' => $admin->can('update brand'),
                'can_delete' => $admin->can('delete brand'),
            ];
            return response()->json($data, 200);
        }
        return response()->json(['errors' => ['message' => ['Cannot find this brand.']]], 400);
    }
    public function brand_delete(Request $request)
    {
        $brand_id = $request->route('brand_id');
        $brand = Brand::where('brand_id', $brand_id)->first();
        if ($brand->products->count() > 0) {
            return response()->json(['errors' => ['message' => ['Can not detete this brand because it has products.']]], 400);
        }
        $brand->delete();
        return ['message' => 'Deleted brand successfully!','brand'=>$brand];
    }
    public function brands_pagination()
    {
        $search = request()->query('search');
        $brands = Brand::where('name', 'LIKE', '%' . $search . '%')->paginate(5);
        foreach ($brands as $brand) {
            if ($brand->created_at->diffInDays() < 7) {
                $brand->new = true;
            }
        }
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'page' => 'Brands',
            'brands' =>  $brands,
            'search' => $search,
            'can_update' => $admin->can('update brand'),
            'can_delete' => $admin->can('delete brand'),
        ];
        return response()->json($data);
    }
}
