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

        $attendances = $query->orderBy('date', 'desc')->paginate(15);
        
        // Cepat Hitung Statistik Harian (Konsep Laporan yang lebih hidup)
        $today = \Carbon\Carbon::today();
        $stats = [
            'total_today' => Attendance::whereDate('date', $today)->count(),
            'late_today' => Attendance::whereDate('date', $today)->where('check_in_status', 'late')->count(),
            'missing_checkout' => Attendance::whereNull('check_out_time')->count(),
        ];

        return view('admin.attendances.index', compact('attendances', 'stats'));
    }
}
