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
            abort(400, $message);
        } else {
            $color->delete();
            return ['message' => 'Delete color successfully!'];
        }
        abort(400, 'Cannot find this color.');
    }
}
