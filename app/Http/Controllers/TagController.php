<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTag;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //

    public function index()
    {
        $data = [
            'page' => 'Tags',
            'tags' => Tag::paginate(6),
        ];
        return view('admin.tags.index', $data);
    }
    public function create(CreateTag $request)
    {
        $tag = Tag::create([
            'name' => $request->input('name'),
        ]);
        return ['message' => 'Created tag successfully!', 'tag' => $tag];
    }
}
