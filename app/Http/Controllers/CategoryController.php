<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    //

    public function category_ui()
    {


        $data = [
            'page' => 'Categories',
            'categories' => Category::all(),
            'request' => 'request'
        ];
        return view('admin.categories.category', $data);
    }

    public function category_insert(Request $request)
    {
        $categoryData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'index' => $request->input('index'),
            'parent_id' => $request->input('parent_id'),
        ];

        $category = Category::create($categoryData);
        return ['message' => 'Created Category successfully!', 'user' => $category];
    }

    public function category_delete($id)

    {


        if (Product::where('id', $id)->exists()) {
            return " Khong The Xoa";
        } else {
            Category::find($id)->delete();
            $product = Category::findOrFail($id);

            $product->delete();
            return " Xoa Thanh cong";

        }


    }

    public function category_update(Request $request)
    {
        $cate = Category::where('category_id', $request->input('category_id'))->first();
        if ($cate) {
            $cate->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'index' => $request->input('index'),
                'parent_id' => $request->input('parent_id'),

            ]);
            // response
            return "say_hello";
        }
    }
}
