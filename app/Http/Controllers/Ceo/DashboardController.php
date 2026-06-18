<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncoming = \App\Models\IncomingLetter::count();
        $outgoingPending = \App\Models\OutgoingLetter::where('status', 'pending')->count();

        return response()->json([
            'total_incoming' => $totalIncoming,
            'outgoing_pending' => $outgoingPending,
        ]);
    }
}
