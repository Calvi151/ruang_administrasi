<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $employeeId = $request->user()->employee->id;
        
        $leaveRequests = LeaveRequest::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'leave_requests' => $leaveRequests
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:sick,annual,permission',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave-requests', 'public');
        }

        $leaveRequest = LeaveRequest::create([
            'employee_id' => $request->user()->employee->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Pengajuan cuti/izin berhasil dikirim.',
            'leave_request' => $leaveRequest
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $employeeId = $request->user()->employee->id;
        $leaveRequest = LeaveRequest::where('employee_id', $employeeId)->findOrFail($id);

        return response()->json([
            'leave_request' => $leaveRequest
        ]);
    }
}
