<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function category_ui()
    {
        $data = [
            'page' => 'Categories',
            'categories' => Category::with('parent')->paginate(8),
        ];
        return view('admin.categories.index', $data);
    }
    public function getAll()
    {
        $categories = Category::with('parent')->get();
        return response()->json(
            ['categories' => $categories],
        );
    }

    public function create(CreateCategory $request)
    {
        $categoryData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'index' => $request->input('index'),
            'parent_id' => $request->input('parent_id') == -1 ? null : $request->input('parent_id'),
        ];
        $category = Category::create($categoryData);
        // Load the parent relationship
        $category->load('parent');
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'message' => 'Created category successfully!',
            'category' => $category,
            'can_update' => $admin->can('update category'),
            'can_delete' => $admin->can('delete category'),
        ];
        return response()->json($data);
    }

    public function delete(Request $request)
    {
        $category_id = $request->route('category_id');
        $category = Category::where('category_id', $category_id)->first();
        if ($category->products->count() > 0) {
            return response()->json(['errors' => ['message' => ['Can not delete this category because it has products.']]], 400);
        }
        if ($category->children_categories->count() > 0) {
            return response()->json(['errors' => ['message' => ['Can not delete this category because it has children categories.']]], 400);
        }
        $category->delete();
        return ['message' => 'Deleted category successfully!'];
    }

    public function update(CreateCategory $request)
    {
        $category_id = $request->route('category_id');
        $category = Category::where('category_id', $category_id)->first();
        if ($category) {
            $category->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'index' => $request->input('index'),
                'parent_id' => $request->input('parent_id') == -1 ? null : $request->input('parent_id'),
            ]);
            $category->load('parent');
            $admin = User::where('user_id', Auth::id())->first();
            $data = [
                'message' => 'Updated category successfully!',
                'category' => $category,
                'can_update' => $admin->can('update category'),
                'can_delete' => $admin->can('delete category'),
            ];
            // response
            return response()->json($data);
        }
        return response()->json(['errors' => ['message' => ['Can not find this category.']]], 400);
    }

    public function getCategory(Request $request)
    {
        $category_id = $request->route('category_id');
        $category = Category::where('category_id', $category_id)->first();
        $categories = Category::all();
        if ($category) {
            $data = [
                'category' => $category,
                'categories' => $categories,
            ];
            return response()->json($data);
        }
    }
}
