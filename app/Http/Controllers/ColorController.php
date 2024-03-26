<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateColor;
use App\Models\Color;

class ColorController extends Controller
{
    //

    public function index()
    {
        $data = [
            'page' => 'Colors',
            'colors' => Color::paginate(6),
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
}
