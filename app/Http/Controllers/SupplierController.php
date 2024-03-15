<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\supplier;

class supplierController extends Controller
{
    public $data = [
        'page' => 'suppliers',
    ];
    //index
    public function index()
    {
        
        $suppliers = Supplier::query()
        ->paginate(5);
        return view("admin.suppliers.index", compact("suppliers"),$this->data);
    }
    public function search(Request $request)
    {
        $search = $request->input('keyword');
        $suppliers = Supplier::query()
        ->Orwhere('name','like','%'.$search.'%')
        ->paginate(5);
        return view("admin.suppliers.index", compact("suppliers"),$this->data);
    }
    //form
    public function create()
    {
        return view("admin.suppliers.create",$this->data);
    }
    public function edit(Request $request)
    {
        $id = $request->route('id');
        $supplier = Supplier::where('supplier_id', $id)->first();
        if(!$supplier){
            abort(404);
        }
        return view("admin.suppliers.edit", compact('supplier'),$this->data);
    }
    public function show(Request $request)
    {
        $id = $request->route('id');
        $supplier = Supplier::where('supplier_id', $id)->first();
        if(!$supplier){
            abort(404);
        }
        return view("admin.suppliers.show", compact("supplier"),$this->data);
    }
    //Repositories
    public function store(Request $request)
    {
        $validatedData = $request ->validate([
            "name"=> "required|max:255",
            "description" => "required",
            'address'=>"required",
            'phone_number' => "required|min:10|max:10",
        ]);
        $supplier = Supplier::create($validatedData);
        return redirect()->route('suppliers.index', $supplier->supplier_id)->with('success','');
    }
    public function update(Request $request)
    {
        $id = $request->route('id');
        $supplier = Supplier::where('supplier_id', $id)->first();
        if(!$supplier){
            abort(404);
        }
        $validatedData = $request ->validate([
            "name"=> "required|max:255",
            "description" => "required",
            'address'=>"required",
            'phone_number' => 'required|min:10|max:10',
        ]);
        $supplier::where('supplier_id',$id)->update($validatedData);
        return redirect()->route('suppliers.show', $supplier->supplier_id)->with('success','');
    }
}
