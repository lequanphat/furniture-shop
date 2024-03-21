<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Brand;

class BrandController extends Controller
{
    public $data = [
        'page' => 'Brands',
    ];
    //index
    public function index()
    {

        $brands = Brand::query()
            ->paginate(5);
        return view("admin.brands.index", compact('brands'), $this->data);
    }
    public function search(Request $request)
    {
        $search = $request->input('keyword');
        $brands = Brand::query()
            ->where('name', 'like', '%' . $search . '%')
            ->OrWhere('brand_id', $search)
            ->paginate(5);
        return view("admin.brands.index", compact("brands"), $this->data);
    }
    //form
    public function create()
    {
        return view("admin.brands.create", $this->data);
    }
    public function edit(Request $request)
    {
        $id = $request->route('id');
        $brand = Brand::where('brand_id', $id)->first();
        if (!$brand) {
            abort(404);
        }
        return view("admin.brands.edit", compact('brand'), $this->data);
    }
    public function show(Request $request)
    {
        $id = $request->route('id');
        $brand = Brand::where('brand_id', $id)->first();
        if (!$brand) {
            abort(404);
        }
        return view("admin.brands.show", compact("brand"), $this->data);
    }
    //Repositories
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|max:255",
            "description" => "required",
            "index" => "nullable|integer",
        ]);
        $validatedData['index'] = $validatedData["index"] ?? 0; // default is 0
        $brand = Brand::create($validatedData);
        return redirect()->route('brands.index', $brand->id)->with('success', '');
    }
    public function update(Request $request, Brand $brand)
    {
        $id = $request->route('id');
        $brand = Brand::where('brand_id', $id)->first();
        if (!$brand) {
            abort(404);
        }
        $validatedData = $request->validate([
            "name" => "required|max:255",
            "description" => "required",
            "index" => "nullable|integer",
        ]);
        $validatedData['index'] = $validatedData["index"] ?? 0; // default is 0
        $brand::where('brand_id', $id)->update($validatedData);
        return redirect()->route('brands.show', $brand->brand_id)->with('success', '');
    }
}
