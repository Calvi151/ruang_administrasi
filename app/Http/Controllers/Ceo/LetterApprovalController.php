<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LetterApprovalController extends Controller
{
    public function index()
    {
        $letters = \App\Models\OutgoingLetter::with(['letterType', 'creator'])->where('status', 'pending')->paginate(10);
        return response()->json($letters);
    }

    public function show(\App\Models\OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load(['letterType', 'creator']);
        return response()->json($outgoingLetter);
    }

    public function approve(Request $request, \App\Models\OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            abort(403, 'Surat sudah diproses.');
        }

        $outgoingLetter->update(['status' => 'acc']);
        return response()->json(['message' => 'Surat berhasil di-ACC.', 'letter' => $outgoingLetter]);
    }

    public function reject(Request $request, \App\Models\OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            abort(403, 'Surat sudah diproses.');
        }

        $outgoingLetter->update(['status' => 'reject']);
        return response()->json(['message' => 'Surat berhasil ditolak.', 'letter' => $outgoingLetter]);
    }
}
