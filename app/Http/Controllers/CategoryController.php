<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategory;
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
            'request'=>$request->all()
        ];
        return view('admin.categories.category', $data);
    }

    public function category_insert(CreateCategory $request)
    {
//        print_r("test Data Throw".$request);
//        print_r("---------".$request);

        $categoryData = [


            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'index' => $request->input('index'),
            'parent_id' =>$request->input('parent_id'),

//Test Button Submit ->  Work
//            'name' => "Test1",
//            'description' => "Test2",
//            'index' => "1",
//            'parent_id' => "1"
        ];

        $category = Category::create($categoryData);
        print_r("test-------.".$category);
        return ['message' => 'Created Category successfully!', 'user' => $category];


//        $category = new Category();
//        $category->category_id = $request->input('category_id');
//        $category->name = $request->input('name');
//        $category->description = $request->input('description');
//        $category->index = $request->input('index');
//        $category->parent = $request->input('parent_id');
//        $category->save();
//
//        return redirect('/admin/categories');
    }

    public function category_delete()

    {

    }

    public function category_update()
    {

    }
}
