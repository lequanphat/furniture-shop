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
            'tags' => Tag::paginate(16),
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

    public function update(CreateTag $request)
    {
        $tag_id = $request->route('tag_id');
        $tag = Tag::find($tag_id);
        if ($tag) {
            $tag->name = $request->input('name');
            $tag->save();
            return ['message' => 'Updated tag successfully!', 'tag' => $tag];
        }
        abort(400, 'Cannot find this tag.');
    }

    public function delete(Request $request)
    {
        $tag_id = $request->route('tag_id');
        $tag = Tag::find($tag_id);
        if ($tag) {
            $tag->delete();
            return ['message' => 'Deleted tag successfully!'];
        }
        abort(400, 'Cannot find this tag.');
    }
}
