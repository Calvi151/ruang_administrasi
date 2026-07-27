<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LetterApprovalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = \App\Models\OutgoingLetter::with(['letterType', 'creator', 'incomingLetter'])->where('status', 'pending');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('recipient', 'like', "%{$search}%")
                  ->orWhereHas('incomingLetter', function($sub) use ($search) {
                      $sub->where('letter_number', 'like', "%{$search}%")
                          ->orWhere('sender', 'like', "%{$search}%");
                  });
            });
        }
        
        $letters = $query->paginate(10);
        return view('ceo.approvals.index', compact('letters'));
    }

    public function show(\App\Models\OutgoingLetter $outgoingLetter)
    {
        $outgoingLetter->load(['letterType', 'creator', 'incomingLetter']);
        return view('ceo.approvals.show', compact('outgoingLetter'));
    }

    public function approve(Request $request, \App\Models\OutgoingLetter $outgoingLetter)
    {
        if ($outgoingLetter->status !== 'pending') {
            return back()->with('error', 'Surat sudah diproses.');
        }

        $outgoingLetter->update([
            'status'      => 'acc',
            'approved_at' => now()
        ]);
        return redirect('ceo/letter-approvals')->with('success', 'Surat berhasil disetujui & ditandatangani secara digital.');
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
