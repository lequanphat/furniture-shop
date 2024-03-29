<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateColor;
use App\Http\Requests\UpdateColor;
use App\Models\Color;
use Illuminate\Http\Request;

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
        return ['message' => 'Created color successfully!', 'color' => $color];
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
        }
        return ['message' => 'Updated color successfully!', 'color' => $color];
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
