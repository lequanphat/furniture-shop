<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    //
    public function index(): View {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }
   
    public function createProduct(Request $request){
        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price')
        ]);
        return back();
        
    }
    public function deleteProduct(Request $request, string $id){
        $product = Product::find($id);
        $product->delete();
        return back();
    }
}
