<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncoming = \App\Models\IncomingLetter::count();
        $totalOutgoing = \App\Models\OutgoingLetter::count();
        $outgoingPending = \App\Models\OutgoingLetter::where('status', 'pending')->count();
        $outgoingAcc = \App\Models\OutgoingLetter::where('status', 'acc')->count();
        $outgoingReject = \App\Models\OutgoingLetter::where('status', 'reject')->count();

        return response()->json([
            'total_incoming' => $totalIncoming,
            'total_outgoing' => $totalOutgoing,
            'outgoing_by_status' => [
                'pending' => $outgoingPending,
                'acc' => $outgoingAcc,
                'reject' => $outgoingReject
            ]
        ]);
    }
}
