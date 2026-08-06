<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OvertimeRequest;
use Illuminate\Http\Request;

class OvertimeRequestController extends Controller
{
    public function index(Request $request)
    {
        $employeeId = $request->user()->employee->id;
        
        $overtimeRequests = OvertimeRequest::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'overtime_requests' => $overtimeRequests
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'required|string',
        ]);

        $overtimeRequest = OvertimeRequest::create([
            'employee_id' => $request->user()->employee->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Pengajuan lembur berhasil dikirim.',
            'overtime_request' => $overtimeRequest
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $employeeId = $request->user()->employee->id;
        $overtimeRequest = OvertimeRequest::where('employee_id', $employeeId)->findOrFail($id);

        return response()->json([
            'overtime_request' => $overtimeRequest
        ]);
    }
}
