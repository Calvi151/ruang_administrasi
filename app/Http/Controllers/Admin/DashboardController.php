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

        // 6 Bulan terakhir secara realtime untuk Chart.js
        $months = [];
        $monthlyIncomingData = [];
        $monthlyOutgoingData = [];
        $monthlyLeaveData = [];
        $monthlyOvertimeData = [];

        for ($i = 5; $i >= 0; $i--) {
            $dt = now()->subMonths($i);
            $months[] = $dt->locale('id')->isoFormat('MMM Y');

            $inCount = \App\Models\IncomingLetter::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
            $outCount = \App\Models\OutgoingLetter::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
            
            $leaveCount = \App\Models\LeaveRequest::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
                
            $overtimeCount = \App\Models\OvertimeRequest::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();

            $monthlyIncomingData[] = $inCount;
            $monthlyOutgoingData[] = $outCount;
            $monthlyLeaveData[] = $leaveCount;
            $monthlyOvertimeData[] = $overtimeCount;
        }

        // HR Data Summary
        $todayStr = now()->format('Y-m-d');
        $attendanceToday = \App\Models\Attendance::where('date', $todayStr)->count();
        $leavePending = \App\Models\LeaveRequest::where('status', 'pending')->count();
        $overtimePending = \App\Models\OvertimeRequest::where('status', 'pending')->count();

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
            'months', 'monthlyIncomingData', 'monthlyOutgoingData', 'categoryData',
            'attendanceToday', 'leavePending', 'overtimePending',
            'monthlyLeaveData', 'monthlyOvertimeData'
        ));
    }
}
