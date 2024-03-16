<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategory;
use App\Models\Address;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    //

    public function category_ui(Request $request)
    {


        $data = [
            'page' => 'Categories',
            'categories' => Category::all(),
            'request' => $request->all()
        ];
        return view('admin.categories.category', $data);
    }

    public function category_insert(CreateCategory $request)
    {

        $categoryData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'index' => $request->input('index'),
            'parent_id' => $request->input('parent_id'),
        ];
        $category = Category::create($categoryData);
        return ['message' => 'Created Category successfully!', 'category' => $category];
    }

    public function category_delete()

    {
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
            return ['message' => 'Updated Category successfully!', 'category' => $cate];
        }
    }
}
