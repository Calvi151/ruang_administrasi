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

        // Data Realtime Aktivitas 6 Hari Terakhir untuk Sparkline Bar Chart
        $sparklineData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = \App\Models\IncomingLetter::whereDate('created_at', $date)->count();
            $sparklineData->push([
                'date' => $date,
                'count' => $count,
            ]);
        }
        $maxCount = max($sparklineData->pluck('count')->max(), 1);
        $sparklineHeights = $sparklineData->map(function ($item) use ($maxCount) {
            $pct = round(($item['count'] / $maxCount) * 100);
            return max($pct, 15); // minimal 15% tinggi visual bar
        });

        // Persentase pertumbuhan Realtime: Bulan Ini vs Bulan Lalu
        $thisMonthCount = \App\Models\IncomingLetter::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $lastMonthCount = \App\Models\IncomingLetter::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();
        $growthPct = $lastMonthCount > 0 
            ? round((($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100) 
            : ($thisMonthCount > 0 ? 100 : 0);

        return view('ceo.dashboard', compact(
            'totalIncoming', 'totalOutgoing', 'outgoingPending',
            'totalEmployees', 'recentOutgoing', 'recentIncoming',
            'sparklineHeights', 'growthPct'
        ));
    }
}
