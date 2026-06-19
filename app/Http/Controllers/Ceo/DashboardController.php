<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncoming   = \App\Models\IncomingLetter::count();
        $totalOutgoing   = \App\Models\OutgoingLetter::count();
        $outgoingPending = \App\Models\OutgoingLetter::where('status', 'pending')->count();
        $totalEmployees  = \App\Models\Employee::count();
        $recentOutgoing  = \App\Models\OutgoingLetter::latest()->take(5)->get();
        $recentIncoming  = \App\Models\IncomingLetter::latest()->take(5)->get();

        return view('ceo.dashboard', compact(
            'totalIncoming', 'totalOutgoing', 'outgoingPending',
            'totalEmployees', 'recentOutgoing', 'recentIncoming'
        ));
    }
}
