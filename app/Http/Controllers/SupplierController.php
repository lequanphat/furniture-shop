<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public $data = [
        'page' => 'Suppliers',
    ];
    //index
    public function index()
    {
        
        $Suppliers = Supplier::all();
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;
        $Suppliers = $Suppliers->slice(($currentPage - 1) * $perPage, $perPage);
        return view("admin.Suppliers.index", compact("Suppliers"),$this->data);
    }
    public function search(Request $request)
    {
        $search = $request->input('keyword');
        $Suppliers = Supplier::query()
        ->where('name','like','%'.$search.'%')
        ->OrWhere('Supplier_id',$search)
        ->paginate(10);
        return view("admin.Suppliers.index", compact("Suppliers"),$this->data);
    }
    //form
    public function create()
    {
        return view("admin.Suppliers.create",$this->data);
    }
    public function edit(Request $request)
    {
        $id = $request->route('id');
        $Supplier = Supplier::where('Supplier_id', $id)->first();
        if(!$Supplier){
            abort(404);
        }
        return view("admin.Suppliers.edit", compact('Supplier'),$this->data);
    }
    public function show(Request $request)
    {
        $id = $request->route('id');
        $Supplier = Supplier::where('Supplier_id', $id)->first();
        if(!$Supplier){
            abort(404);
        }
        return view("admin.Suppliers.show", compact("Supplier"),$this->data);
    }
    //Repositories
    public function store(Request $request)
    {
        $validatedData = $request ->validate([
            "name"=> "required|max:255",
            "description" => "required",
            "index"=> "nullable|integer",
        ]);
        $validatedData['index'] = $validatedData["index"] ?? 0; // default is 0
        $Supplier = Supplier::create($validatedData);
        return redirect()->route('Suppliers.index', $Supplier->id)->with('success','');
    }
    public function update(Request $request,Supplier $Supplier)
    {
        $Supplier = Supplier::where('Supplier_id', $Supplier->id)->first();
        if(!$Supplier){
            abort(404);
        }
        $validatedData = $request ->validate([
            "name"=> "required|max:255",
            "description" => "required",
            "index"=> "nullable|integer",
        ]);
        $validatedData['index'] = $validatedData["index"] ?? 0;// default is 0
        $Supplier ->update($validatedData);
        return redirect()->route('Suppliers.index', $Supplier->id)->with('success','');
    }
}