<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OvertimeRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OvertimeRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = OvertimeRequest::with('employee', 'approver');

        // Search filter
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
                $query->whereYear('created_at', $month[0])
                      ->whereMonth('created_at', $month[1]);
            }
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $overtimeRequests = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'pending'  => OvertimeRequest::where('status', 'pending')->count(),
            'approved' => OvertimeRequest::where('status', 'approved')->count(),
            'rejected' => OvertimeRequest::where('status', 'rejected')->count(),
            'total_month' => OvertimeRequest::whereMonth('created_at', Carbon::now()->month)
                                            ->whereYear('created_at', Carbon::now()->year)
                                            ->count(),
        ];
        $employees = \App\Models\Employee::orderBy('name')->get();

        return view('admin.overtime-requests.index', compact('overtimeRequests', 'stats', 'employees'));
    }

    public function approve(Request $request, OvertimeRequest $overtimeRequest)
    {
        $overtimeRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('overtime-requests.index')
            ->with('success', 'Pengajuan lembur atas nama ' . $overtimeRequest->employee->name . ' telah disetujui.');
    }

    public function reject(Request $request, OvertimeRequest $overtimeRequest)
    {
        $request->validate([
            'rejected_reason' => 'required|string|max:500',
        ]);

        $overtimeRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'rejected_reason' => $request->rejected_reason,
        ]);

        return redirect()->route('overtime-requests.index')
            ->with('success', 'Pengajuan lembur atas nama ' . $overtimeRequest->employee->name . ' telah ditolak.');
    }

    public function destroy(OvertimeRequest $overtimeRequest)
    {
        $overtimeRequest->delete();
        return redirect()->route('overtime-requests.index')->with('success', 'Data pengajuan lembur berhasil dihapus.');
    }
}
