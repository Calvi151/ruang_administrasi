<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LetterApprovalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = \App\Models\OutgoingLetter::with(['letterType', 'creator'])->where('status', 'pending');
        
        if ($search) {
            $query->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
        }
        
        $letters = $query->paginate(10);
        return view('ceo.approvals.index', compact('letters'));
    }

    public function show(\App\Models\OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load(['letterType', 'creator']);
        return view('ceo.approvals.show', compact('outgoingLetter'));
    }

    public function approve(Request $request, \App\Models\OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            return back()->with('error', 'Surat sudah diproses.');
        }

        $outgoingLetter->update(['status' => 'acc']);
        return redirect('ceo/letter-approvals')->with('success', 'Surat berhasil disetujui.');
    }

    public function reject(Request $request, \App\Models\OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            return back()->with('error', 'Surat sudah diproses.');
        }

        $outgoingLetter->update(['status' => 'reject']);
        return redirect('ceo/letter-approvals')->with('success', 'Surat berhasil ditolak.');
    }
}
