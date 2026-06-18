<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReadonlyController extends Controller
{
    public function incomingLetters()
    {
        $letters = \App\Models\IncomingLetter::paginate(10);
        return response()->json($letters);
    }

    public function outgoingLetters()
    {
        $letters = \App\Models\OutgoingLetter::with(['letterType', 'creator'])->paginate(10);
        return response()->json($letters);
    }

    public function employees()
    {
        $employees = \App\Models\Employee::with('user')->get();
        return response()->json($employees);
    }
}
