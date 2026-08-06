<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function today(Request $request)
    {
        $employeeId = $request->user()->employee->id;
        $today = Carbon::today();

        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();

        return response()->json([
            'attendance' => $attendance
        ]);
    }

    public function history(Request $request)
    {
        $employeeId = $request->user()->employee->id;
        
        $query = Attendance::where('employee_id', $employeeId);

        if ($request->has('month')) {
            $month = explode('-', $request->month);
            if (count($month) == 2) {
                $query->whereYear('date', $month[0])
                      ->whereMonth('date', $month[1]);
            }
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        return response()->json([
            'attendances' => $attendances
        ]);
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'check_in_photo' => 'required|image|max:5120', // Max 5MB
            'check_in_latitude' => 'required|numeric',
            'check_in_longitude' => 'required|numeric',
        ]);

        $employeeId = $request->user()->employee->id;
        $today = Carbon::today();
        $now = Carbon::now();

        // Check if already checked in today
        $existing = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Anda sudah melakukan check-in hari ini.'], 400);
        }

        // Store photo
        $photoPath = $request->file('check_in_photo')->store('attendances/check-in', 'public');

        // Determine status (example logic: > 08:00 is late)
        $officeStartTime = Carbon::today()->setHour(8)->setMinute(0);
        $status = $now->greaterThan($officeStartTime) ? 'late' : 'on_time';

        $attendance = Attendance::create([
            'employee_id' => $employeeId,
            'date' => $today,
            'check_in_time' => $now->format('H:i:s'),
            'check_in_photo' => $photoPath,
            'check_in_latitude' => $request->check_in_latitude,
            'check_in_longitude' => $request->check_in_longitude,
            'check_in_status' => $status,
        ]);

        return response()->json([
            'message' => 'Check-in berhasil.',
            'attendance' => $attendance
        ]);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'check_out_photo' => 'required|image|max:5120',
            'check_out_latitude' => 'required|numeric',
            'check_out_longitude' => 'required|numeric',
        ]);

        $employeeId = $request->user()->employee->id;
        $today = Carbon::today();
        $now = Carbon::now();

        $attendance = Attendance::where('employee_id', $employeeId)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'Anda belum check-in hari ini.'], 400);
        }

        if ($attendance->check_out_time) {
            return response()->json(['message' => 'Anda sudah melakukan check-out hari ini.'], 400);
        }

        $photoPath = $request->file('check_out_photo')->store('attendances/check-out', 'public');

        // Example logic: < 17:00 is early
        $officeEndTime = Carbon::today()->setHour(17)->setMinute(0);
        $status = $now->lessThan($officeEndTime) ? 'early' : 'on_time';

        $attendance->update([
            'check_out_time' => $now->format('H:i:s'),
            'check_out_photo' => $photoPath,
            'check_out_latitude' => $request->check_out_latitude,
            'check_out_longitude' => $request->check_out_longitude,
            'check_out_status' => $status,
        ]);

        return response()->json([
            'message' => 'Check-out berhasil.',
            'attendance' => $attendance
        ]);
    }
}
