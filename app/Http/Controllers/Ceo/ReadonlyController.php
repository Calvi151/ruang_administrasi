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
            $query->where(function($q) use ($search) {
                $q->where('letter_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('sender', 'like', "%{$search}%");
            });
        }
        
        $letters = $query->paginate(10)->appends($request->all());
        return view('ceo.readonly.incoming', compact('letters'));
    }

    public function outgoingLetters(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $category = $request->input('category');
        
        $query = \App\Models\OutgoingLetter::with(['letterType', 'creator', 'incomingLetter']);
        
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

        if ($category && in_array($category, ['umum', 'balasan'])) {
            $query->where('category', $category);
        }

        if ($status && in_array($status, ['pending', 'acc', 'reject', 'delivered'])) {
            $query->where('status', $status);
        }
        
        $letters = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());
        
        $totalAll = \App\Models\OutgoingLetter::count();
        $countUmum = \App\Models\OutgoingLetter::where('category', 'umum')->count();
        $countBalasan = \App\Models\OutgoingLetter::where('category', 'balasan')->count();

        return view('ceo.readonly.outgoing', compact('letters', 'totalAll', 'countUmum', 'countBalasan'));
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
