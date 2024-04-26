<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSupplier;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function supplier_ui(Request $request)
    {
        $data = [
            'page' => 'Suppliers',
            'suppliers' =>  Supplier::query()
                ->paginate(5),
                 'search' => request()->query("search"),
        ];
        return view('admin.suppliers.supplier', $data);
    }
    public function supplier_search_ui(Request $request)
    {
        $search = $request->input('search');
        $data = [
            'page' => 'suppliers',
            'suppliers' =>  Supplier::where('name', 'LIKE', '%' . $search . '%')
                ->paginate(5),
            'search' => $search,
        ];
        return view('admin.suppliers.supplier', $data);
    }
    public function update_supplier_ui(Request $request)
    {
        $supplier_id = $request->route('supplier_id');
        $data = [
            'page' => 'Suppliers',
            'action' => 'Update' . $supplier_id
        ];
        return view('admin.brands.update_brand', $data);
    }
    public function supplier_create(CreateSupplier $request)
    {
        $supplierData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
        ];
        $supplier = Supplier::create($supplierData);
        return ['message' => 'Created supplier successfully!', 'supplier' => $supplier];
    }
    public function supplier_update(Request $request)
    {
        $supplier = Supplier::where('supplier_id', $request->input('supplier_id'))->first();
        if ($supplier) {
            $supplier->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),

            ]);
            return ['message' => 'Updated brand successfully!', 'supplier' => $supplier];
        } else {
            return ['message' => $request->input('supplier_id')];
        }
    }
    public function supplier_delete(Request $request)
    {
        $supplier_id = $request->route('supplier_id');
        $supplier = Supplier::where('supplier_id', $supplier_id)->first();
        if ($supplier->receivingReports->count() > 0) {
            return response()->json(['errors' => ['message' => ['Can not delete this supplier because it has receivingreports.']]], 400);
        }
        $supplier->delete();
        return ['message' => 'Deleted supplier successfully!','supplier'=>$supplier];
    }
    public function supplier_pagination()
    {
        $search = request()->input('search');
        $data = [
            'page' => 'suppliers',
            'suppliers' =>  Supplier::where('name', 'LIKE', '%' . $search . '%')
                ->paginate(5),
            'search' => $search,
        ];
        return response()->json($data);
    }
}
