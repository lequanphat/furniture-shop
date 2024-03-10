<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function category_ui()
    {

        $data = [
            'page' => 'Categories',
            'categories' => Category::all()
        ];
        return view('admin.categories.category', $data);
    }

    public function category_insert()
    {

    }

    public function category_delete()

    {

    }

    public function category_update()
    {

    }
}
