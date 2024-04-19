<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTag;
use App\Http\Requests\UpdateTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // get permission of the admin
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'message' => 'Created tag successfully!',
            'tag' =>  $tag,
            'can_update' => $admin->can('update color'),
            'can_delete' => $admin->can('delete color'),
        ];
        return response()->json($data, 201);
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
            if ($tag->created_at->diffInDays() < 7) {
                $tag->new = true;
            }
            // get permission of the admin
            $admin = User::where('user_id', Auth::id())->first();
            $data = [
                'message' => 'Created tag successfully!',
                'tag' =>  $tag,
                'can_update' => $admin->can('update color'),
                'can_delete' => $admin->can('delete color'),
            ];
            return response()->json($data, 201);
        }
        return response()->json(['errors' => ['message' => ['Can not find this tag.']]], 400);
    }

    public function delete(Request $request)
    {
        $tag_id = $request->route('tag_id');
        $tag = Tag::find($tag_id);

        if ($tag) {
            if ($tag->product_tags->count() > 0) {
                $message = 'Cannot delete this tag because it is being used in some products.';
                return response()->json(['errors' => ['message' => [$message]]], 400);
            } else {
                $tag->delete();
                return ['message' => 'Delete tag successfully!'];
            }
        }


        abort(400, 'Cannot find this tag.');
    }
}
