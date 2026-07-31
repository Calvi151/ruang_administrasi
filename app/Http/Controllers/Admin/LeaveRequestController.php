<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with('employee', 'approver');

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Type filter
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $leaveRequests = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats
        $stats = [
            'pending'  => LeaveRequest::where('status', 'pending')->count(),
            'approved' => LeaveRequest::where('status', 'approved')->count(),
            'rejected' => LeaveRequest::where('status', 'rejected')->count(),
            'total_month' => LeaveRequest::whereMonth('created_at', Carbon::now()->month)
                                         ->whereYear('created_at', Carbon::now()->year)
                                         ->count(),
        ];

        return view('admin.leave-requests.index', compact('leaveRequests', 'stats'));
    }

    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('leave-requests.index')
            ->with('success', 'Pengajuan cuti/izin atas nama ' . $leaveRequest->employee->name . ' telah disetujui.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'rejected_reason' => 'required|string|max:500',
        ]);

        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'rejected_reason' => $request->rejected_reason,
        ]);

        return redirect()->route('leave-requests.index')
            ->with('success', 'Pengajuan cuti/izin atas nama ' . $leaveRequest->employee->name . ' telah ditolak.');
    }
}
