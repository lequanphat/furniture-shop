<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTag;
use App\Http\Requests\UpdateTag;
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

    public function update(UpdateTag $request)
    {
        $tag_id = $request->route('tag_id');
        $tag = Tag::find($tag_id);
        if ($tag) {
            // check if the tag name is already existed
            $check_tag = Tag::where('name', $request->input('name'))->where('tag_id', '<>', $tag_id)->first();
            if ($check_tag) {
                return response()->json(['errors' => ['message' => ['The tag name have already existed.']]], 400);
            }
            // update the tag
            $tag->name = $request->input('name');
            $tag->save();
            return ['message' => 'Updated tag successfully!', 'tag' => $tag];
        }
        return response()->json(['errors' => ['message' => ['Can not find this tag.']]], 400);
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
