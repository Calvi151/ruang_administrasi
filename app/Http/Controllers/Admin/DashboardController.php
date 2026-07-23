<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncoming   = \App\Models\IncomingLetter::count();
        $totalOutgoing   = \App\Models\OutgoingLetter::count();
        $outgoingPending = \App\Models\OutgoingLetter::where('status', 'pending')->count();
        $outgoingAcc     = \App\Models\OutgoingLetter::where('status', 'acc')->count();
        $outgoingReject  = \App\Models\OutgoingLetter::where('status', 'reject')->count();
        $totalEmployees  = \App\Models\Employee::count();
        $recentOutgoing  = \App\Models\OutgoingLetter::latest()->take(5)->get();
        $recentIncoming  = \App\Models\IncomingLetter::latest()->take(5)->get();

        // Tren bulanan (tahun ini) untuk line chart
        $monthlyIncoming = \App\Models\IncomingLetter::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $monthlyOutgoing = \App\Models\OutgoingLetter::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        // Kategori surat per jenis (untuk donut chart)
        $categoryData = \App\Models\OutgoingLetter::selectRaw('letter_type_id, COUNT(*) as total')
            ->groupBy('letter_type_id')
            ->get()
            ->map(function ($item) {
                $item->type_name = $item->letter_type_id 
                    ? (\App\Models\LetterType::find($item->letter_type_id)?->type_name ?? 'Lainnya')
                    : 'Lainnya';
                return $item;
            });

        return view('admin.dashboard', compact(
            'totalIncoming', 'totalOutgoing',
            'outgoingPending', 'outgoingAcc', 'outgoingReject',
            'totalEmployees', 'recentOutgoing', 'recentIncoming',
            'monthlyIncoming', 'monthlyOutgoing', 'categoryData'
        ));
    }
}

