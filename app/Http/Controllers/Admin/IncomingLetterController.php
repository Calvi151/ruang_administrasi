<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomingLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\IncomingLetter::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('sender', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
        }
        $letters = $query->paginate(10);
        return response()->json($letters);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_number' => 'required|string|unique:incoming_letters',
            'date_received' => 'required|date',
            'sender' => 'required|string',
            'subject' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('incoming_letters', 'public');
        }

        $letter = \App\Models\IncomingLetter::create($validated);
        return response()->json($letter, 201);
    }

    public function show(\App\Models\IncomingLetter $incomingLetter)
    {
        return response()->json($incomingLetter);
    }

    public function update(Request $request, \App\Models\IncomingLetter $incomingLetter)
    {
        $validated = $request->validate([
            'letter_number' => 'sometimes|string|unique:incoming_letters,letter_number,' . $incomingLetter->id,
            'date_received' => 'sometimes|date',
            'sender' => 'sometimes|string',
            'subject' => 'sometimes|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('file')) {
            if ($incomingLetter->file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($incomingLetter->file);
            }
            $validated['file'] = $request->file('file')->store('incoming_letters', 'public');
        }

        $incomingLetter->update($validated);
        return response()->json($incomingLetter);
    }

    public function destroy(\App\Models\IncomingLetter $incomingLetter)
    {
        if ($incomingLetter->file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($incomingLetter->file);
        }
        $incomingLetter->delete();
        return response()->json(null, 204);
    }
}
