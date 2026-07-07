<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReadonlyController extends Controller
{
    public function incomingLetters(Request $request)
    {
        $search = $request->input('search');
        $query = \App\Models\IncomingLetter::query();
        
        if ($search) {
            $query->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('pengirim', 'like', "%{$search}%");
        }
        
        $letters = $query->paginate(10);
        return view('ceo.readonly.incoming', compact('letters'));
    }

    public function outgoingLetters(Request $request)
    {
        $search = $request->input('search');
        $query = \App\Models\OutgoingLetter::with(['letterType', 'creator']);
        
        if ($search) {
            $query->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%");
        }
        
        $letters = $query->paginate(10);
        return view('ceo.readonly.outgoing', compact('letters'));
    }

    public function employees(Request $request)
    {
        $search = $request->input('search');
        $query = \App\Models\Employee::with('user');
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('nip', 'like', "%{$search}%");
                  });
        }
        
        $employees = $query->get();
        return view('ceo.readonly.employees', compact('employees'));
    }
}
