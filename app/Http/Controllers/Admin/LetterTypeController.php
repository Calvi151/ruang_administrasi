<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LetterTypeController extends Controller
{
    public function index()
    {
        $types = \App\Models\LetterType::all();
        return response()->json($types);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_code' => 'required|string|unique:letter_type',
            'type_name' => 'required|string',
        ]);

        $type = \App\Models\LetterType::create($validated);
        return response()->json($type, 201);
    }

    public function show(\App\Models\LetterType $letterType)
    {
        return response()->json($letterType);
    }

    public function update(Request $request, \App\Models\LetterType $letterType)
    {
        $validated = $request->validate([
            'letter_code' => 'sometimes|string|unique:letter_type,letter_code,' . $letterType->id,
            'type_name' => 'sometimes|string',
        ]);

        $letterType->update($validated);
        return response()->json($letterType);
    }

    public function destroy(\App\Models\LetterType $letterType)
    {
        $letterType->delete();
        return response()->json(null, 204);
    }
}
