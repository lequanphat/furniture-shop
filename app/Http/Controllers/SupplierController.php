<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSupplier;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function supplier_ui(Request $request)
    {
        $data = [
            'page' => 'Suppliers',
            'suppliers' =>  Supplier::query()
                ->paginate(6),
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
                ->paginate(6),
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
        $supplier = Supplier::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
        ]);
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'message' => 'Created supplier successfully!',
            'supplier' =>  $supplier,
            'can_update' => $admin->can('update supplier'),
            'can_delete' => $admin->can('delete supplier'),
        ];
        return response()->json($data);
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
            if ($supplier->created_at->diffInDays() < 7) {
                $supplier->new = true;
            }
            $admin = User::where('user_id', Auth::id())->first();
            $data = [
                'message' => 'Updated supplier successfully!',
                'supplier' =>  $supplier,
                'can_update' => $admin->can('update supplier'),
                'can_delete' => $admin->can('delete supplier'),
            ];
            return response()->json($data);
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
        return ['message' => 'Deleted supplier successfully!', 'supplier' => $supplier];
    }
    public function supplier_pagination()
    {
        $search = request()->input('search');
        $suppliers = Supplier::where('name', 'LIKE', '%' . $search . '%')
            ->paginate(5);
        foreach ($suppliers as $supplier) {
            if ($supplier->created_at->diffInDays() < 7) {
                $supplier->new = true;
            }
        }
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'page' => 'suppliers',
            'suppliers' => $suppliers,
            'search' => $search,
            'can_update' => $admin->can('update supplier'),
            'can_delete' => $admin->can('delete supplier'),
        ];
        return response()->json($data);
    }
}
