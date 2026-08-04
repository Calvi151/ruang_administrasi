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
        
        // Missing checkout filter
        if ($request->filled('missing_checkout')) {
            $query->whereNull('check_out_time');
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

    public function export(Request $request)
    {
        $query = Attendance::with('employee');

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        
        if ($request->filled('month')) {
            $month = explode('-', $request->month);
            if (count($month) == 2) {
                $query->whereYear('date', $month[0])
                      ->whereMonth('date', $month[1]);
            }
        }
        
        if ($request->filled('status')) {
            $query->where('check_in_status', $request->status);
        }
        
        if ($request->filled('missing_checkout')) {
            $query->whereNull('check_out_time');
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        $fileName = 'laporan_absensi_' . date('Y-m-d_H-i') . '.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Tanggal', 'Nama Pegawai', 'NIP', 'Jam Masuk', 'Status Masuk', 'Jam Pulang', 'Status Pulang');

        $callback = function() use($attendances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendances as $attendance) {
                $checkInStatus = match($attendance->check_in_status) {
                    'on_time' => 'Tepat Waktu',
                    'late' => 'Terlambat',
                    default => $attendance->check_in_status
                };
                
                $checkOutStatus = match($attendance->check_out_status) {
                    'early' => 'Pulang Cepat',
                    'on_time' => 'Sesuai Waktu',
                    'overtime' => 'Lembur',
                    default => $attendance->check_out_status ?? '-'
                };

                $row['Tanggal'] = $attendance->date;
                $row['Nama Pegawai'] = $attendance->employee->name ?? '-';
                $row['NIP'] = $attendance->employee->nip ?? '-';
                $row['Jam Masuk'] = $attendance->check_in_time ?? '-';
                $row['Status Masuk'] = $checkInStatus;
                $row['Jam Pulang'] = $attendance->check_out_time ?? '-';
                $row['Status Pulang'] = $checkOutStatus;

                fputcsv($file, array($row['Tanggal'], $row['Nama Pegawai'], $row['NIP'], $row['Jam Masuk'], $row['Status Masuk'], $row['Jam Pulang'], $row['Status Pulang']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
