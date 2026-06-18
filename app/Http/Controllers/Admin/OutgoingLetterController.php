<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OutgoingLetterController extends Controller
{
    public function index(Request $request)
    {
        $letters = \App\Models\OutgoingLetter::with(['letterType', 'creator'])->paginate(10);
        return response()->json($letters);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_number' => 'required|string|unique:outgoing_letters',
            'date_sent' => 'required|date',
            'letter_type_id' => 'required|exists:letter_type,id',
            'recipient' => 'required|string',
            'subject' => 'required|string',
            'content' => 'required|string',
        ]);

        $validated['status'] = 'pending';
        $validated['creator_id'] = auth()->id() ?? 1; // Fallback to 1 if not auth for testing

        $letter = \App\Models\OutgoingLetter::create($validated);
        return response()->json($letter, 201);
    }

    public function show(\App\Models\OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load(['letterType', 'creator']);
        return response()->json($outgoingLetter);
    }

    public function update(Request $request, \App\Models\OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            abort(403, 'Hanya surat berstatus pending yang dapat diubah.');
        }

        $validated = $request->validate([
            'letter_number' => 'sometimes|string|unique:outgoing_letters,letter_number,' . $outgoingLetter->id,
            'date_sent' => 'sometimes|date',
            'letter_type_id' => 'sometimes|exists:letter_type,id',
            'recipient' => 'sometimes|string',
            'subject' => 'sometimes|string',
            'content' => 'sometimes|string',
        ]);

        $outgoingLetter->update($validated);
        return response()->json($outgoingLetter);
    }

    public function destroy(\App\Models\OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            abort(403, 'Hanya surat berstatus pending yang dapat dihapus.');
        }

        $outgoingLetter->delete();
        return response()->json(null, 204);
    }
}
