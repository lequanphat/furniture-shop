<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateColor;
use App\Http\Requests\UpdateColor;
use App\Models\Color;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    //

    public function index()
    {
        $data = [
            'page' => 'Colors',
            'colors' => Color::paginate(16),
        ];
        return view('admin.colors.index', $data);
    }
    public function create(CreateColor $request)
    {
        $color = Color::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);
        // get permission of the admin
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'message' => 'Created color successfully!',
            'color' => $color,
            'can_update' => $admin->can('update color'),
            'can_delete' => $admin->can('delete color'),
        ];
        return response()->json($data, 201);
    }
    public function update(UpdateColor $request)
    {
        $color_id = $request->route('color_id');
        $color = Color::find($color_id);
        if ($color) {
            // check if the color name is already existed
            $check_color = Color::where('name', $request->input('name'))->where('color_id', '<>', $color_id)->first();
            if ($check_color) {
                return response()->json(['errors' => ['message' => ['The color name have already existed.']]], 400);
            }
            // update the color
            $color->name = $request->input('name');
            $color->code = $request->input('code');
            $color->save();
            if ($color->created_at->diffInDays() < 7) {
                $color->new = true;
            }
            // get permission of the admin
            $admin = User::where('user_id', Auth::id())->first();
            $data = [
                'message' => 'Updated color successfully!',
                'color' => $color,
                'can_update' => $admin->can('update color'),
                'can_delete' => $admin->can('delete color'),
            ];
            return response()->json($data, 200);
        }
        return response()->json(['errors' => ['message' => ['Cannot find this color.']]], 400);
    }
    public function delete(Request $request)
    {
        $color_id = $request->route('color_id');
        $color = Color::find($color_id);
        if ($color->detailed_products->count() > 0) {
            $message = 'Cannot delete color because it is associated with one or more product details.';
            return response()->json(['errors' => ['message' => [$message]]], 400);
        } else {
            $color->delete();
            return ['message' => 'Delete color successfully!'];
        }
        return response()->json(['errors' => ['message' => ['Cannot find this color.']]], 400);
    }
}
