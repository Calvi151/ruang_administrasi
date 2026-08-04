<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        // Simple search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }
        
        // Employee filter
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        
        // Month filter (format YYYY-MM)
        if ($request->filled('month')) {
            $month = explode('-', $request->month);
            if (count($month) == 2) {
                $query->whereYear('date', $month[0])
                      ->whereMonth('date', $month[1]);
            }
        }
        
        // Status filter (check_in_status)
        if ($request->filled('status')) {
            $query->where('check_in_status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();
        
        // Cepat Hitung Statistik Harian (Konsep Laporan yang lebih hidup)
        $today = \Carbon\Carbon::today();
        $stats = [
            'total_today' => Attendance::whereDate('date', $today)->count(),
            'late_today' => Attendance::whereDate('date', $today)->where('check_in_status', 'late')->count(),
            'missing_checkout' => Attendance::whereNull('check_out_time')->count(),
        ];
        
        $employees = \App\Models\Employee::orderBy('name')->get();

        return view('admin.attendances.index', compact('attendances', 'stats', 'employees'));
    }
}
