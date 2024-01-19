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
        return view('products.index', compact('products'));
    }
    public function details(string $id): View {
        $array = [
            'product_id' => $id,
            'email' => 'lequanphat3579@gmail.com',
            'password' => '123123'

        ];
        return view('products.details', compact('array'));
    }
    public function createProduct(Request $request){
        Product::create([
            'name' => $request->input('name'),
            'price' => $request->input('price')
        ]);
        return redirect('/products');
        
    }
    public function deleteProduct(Request $request, string $id){
        $product = Product::find($id);
        $product->delete();
        return redirect('/products');
    }
}
