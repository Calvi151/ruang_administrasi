@extends('admin.layouts.app')

@section('title', 'Pengajuan Lembur - Ruang Administrasi')
@section('page-title', 'Pengajuan Lembur')
@section('page-subtitle', 'Kelola persetujuan lembur pegawai')

@section('styles')
<style>
    /* Minimalist Styles */
    .modal-overlay {
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease-out;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-content-box {
        transform: scale(0.98) translateY(5px);
        opacity: 0;
        transition: all 0.2s ease-out;
    }
    .modal-overlay.active .modal-content-box {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
</style>
@endsection

@section('content')
<div class="max-w-[container-max] mx-auto w-full">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-800/50 rounded-lg flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">check_circle</span>
            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
        </div>
    @endif

    {{-- 1. STAT CARDS (Clean UI) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        {{-- Card 1: Menunggu Persetujuan --}}
        <div class="rounded-lg p-5 bg-gradient-to-br from-amber-50 to-white dark:from-amber-900/30 dark:to-[#141C33] border border-amber-200/60 dark:border-[#2A3654] flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Menunggu ACC</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['pending'] }}</h3>
            </div>
            <div class="w-8 h-8 rounded-md bg-white/60 dark:bg-slate-800/80 flex items-center justify-center text-amber-600 dark:text-amber-500 border border-amber-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-[18px]">more_time</span>
            </div>
        </div>

        {{-- Card 2: Disetujui --}}
        <div class="rounded-lg p-5 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/30 dark:to-[#141C33] border border-emerald-200/60 dark:border-[#2A3654] flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Disetujui</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['approved'] }}</h3>
            </div>
            <div class="w-8 h-8 rounded-md bg-white/60 dark:bg-slate-800/80 flex items-center justify-center text-emerald-600 dark:text-emerald-500 border border-emerald-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-[18px]">task_alt</span>
            </div>
        </div>

        {{-- Card 3: Ditolak --}}
        <div class="rounded-lg p-5 bg-gradient-to-br from-red-50 to-white dark:from-red-900/30 dark:to-[#141C33] border border-red-200/60 dark:border-[#2A3654] flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Ditolak</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['rejected'] }}</h3>
            </div>
            <div class="w-8 h-8 rounded-md bg-white/60 dark:bg-slate-800/80 flex items-center justify-center text-red-600 dark:text-red-500 border border-red-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-[18px]">cancel</span>
            </div>
        </div>

        {{-- Card 4: Total Bulan Ini --}}
        <div class="rounded-lg p-5 bg-gradient-to-br from-indigo-50 to-white dark:from-indigo-900/30 dark:to-[#141C33] border border-indigo-200/60 dark:border-[#2A3654] flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Total Bulan Ini</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_month'] }}</h3>
            </div>
            <div class="w-8 h-8 rounded-md bg-white/60 dark:bg-slate-800/80 flex items-center justify-center text-indigo-600 dark:text-indigo-500 border border-indigo-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-[18px]">calendar_month</span>
            </div>
        </div>
    </div>

    {{-- Header & Filter Form --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Daftar Lembur</h2>
        
        <form action="{{ route('overtime-requests.index') }}" method="GET" class="flex items-center gap-2">
            <select name="employee_id" class="px-3 py-1.5 bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] rounded-md text-xs font-medium text-slate-700 dark:text-slate-300 focus:ring-0 cursor-pointer h-8">
                <option value="">Semua Karyawan</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                @endforeach
            </select>
            
            <input type="month" name="month" value="{{ request('month') }}" class="px-3 py-1.5 bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] rounded-md text-xs font-medium text-slate-700 dark:text-slate-300 focus:ring-0 cursor-pointer h-8">
            
            <select name="status" class="px-3 py-1.5 bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] rounded-md text-xs font-medium text-slate-700 dark:text-slate-300 focus:ring-0 cursor-pointer h-8">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            
            <button type="submit" class="bg-white dark:bg-[#141C33] hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 border border-outline-variant/40 dark:border-[#2A3654] px-3 py-1.5 rounded-md font-medium text-xs transition-colors flex items-center gap-1 h-8">
                <span class="material-symbols-outlined text-[14px]">filter_list</span> Filter
            </button>
            
            @if(request()->hasAny(['employee_id', 'month', 'status']))
                <a href="{{ route('overtime-requests.index') }}" class="text-xs text-red-500 hover:text-red-700 font-medium px-2">Reset</a>
            @endif
        </form>
    </div>

    {{-- Data Table Card --}}
    <div class="bg-white dark:bg-[#141C33] rounded-xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <!-- Table Header -->
                <thead>
                    <tr class="bg-slate-50 border-y border-outline-variant/30 dark:border-[#2A3654] dark:bg-[#0F172E]/50 text-[11px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-3">Pegawai</th>
                        <th class="px-6 py-3 text-center">Tanggal Lembur</th>
                        <th class="px-6 py-3 text-center">Jam Kerja</th>
                        <th class="px-6 py-3">Alasan</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody class="divide-y divide-outline-variant/20 dark:divide-[#2A3654]">
                    @forelse($overtimeRequests as $overtime)
                        <tr class="hover:bg-slate-50 dark:hover:bg-[#1D2847]/50 transition-colors">
                            <!-- Employee -->
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    @if($overtime->employee && $overtime->employee->photo)
                                        <img src="{{ asset('storage/' . $overtime->employee->photo) }}" alt="Photo" class="w-8 h-8 rounded-full border border-outline-variant/30 dark:border-[#2A3654] object-cover shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-[#2A3654] text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-xs shrink-0 border border-outline-variant/30">
                                            {{ strtoupper(substr($overtime->employee->name ?? '?', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-sm font-semibold text-on-surface dark:text-[#E8E6E0] truncate">{{ $overtime->employee->name ?? 'Unknown' }}</span>
                                        <span class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $overtime->employee->nip ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Date -->
                            <td class="px-6 py-3 text-center">
                                <div class="text-sm text-slate-700 dark:text-slate-300">
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($overtime->date)->translatedFormat('d M Y') }}</span>
                                    <span class="block text-xs text-slate-500">{{ \Carbon\Carbon::parse($overtime->date)->translatedFormat('l') }}</span>
                                </div>
                            </td>
                            
                            <!-- Time & Duration -->
                            <td class="px-6 py-3 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center gap-1.5 text-sm font-mono font-medium text-slate-700 dark:text-slate-300">
                                        <span>{{ \Carbon\Carbon::parse($overtime->start_time)->format('H:i') }}</span>
                                        <span class="text-slate-400">-</span>
                                        <span>{{ \Carbon\Carbon::parse($overtime->end_time)->format('H:i') }}</span>
                                    </div>
                                    @php
                                        $start = \Carbon\Carbon::parse($overtime->start_time);
                                        $end = \Carbon\Carbon::parse($overtime->end_time);
                                        if($end->lt($start)) $end->addDay();
                                        $hours = $start->diffInHours($end);
                                        $mins = $start->diffInMinutes($end) % 60;
                                        $durationText = $hours > 0 ? "{$hours}j " : "";
                                        $durationText .= $mins > 0 ? "{$mins}m" : "";
                                        if($durationText == "") $durationText = "0m";
                                    @endphp
                                    <span class="mt-1 inline-flex items-center justify-center bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 border border-indigo-200/60 dark:border-indigo-800/50 px-2 py-0.5 rounded text-[11px] font-medium">
                                        {{ $durationText }}
                                    </span>
                                </div>
                            </td>
                            
                            <!-- Reason -->
                            <td class="px-6 py-3">
                                <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 max-w-[200px]">{{ $overtime->reason ?? '-' }}</p>
                            </td>
                            
                            <!-- Status -->
                            <td class="px-6 py-3 text-center">
                                @if($overtime->status == 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-amber-50 dark:bg-amber-900/10 text-amber-700 dark:text-amber-400 text-[11px] font-semibold border border-amber-200/50 dark:border-amber-800/30">
                                        Pending
                                    </span>
                                @elseif($overtime->status == 'approved')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-900/10 text-emerald-700 dark:text-emerald-400 text-[11px] font-semibold border border-emerald-200/50 dark:border-emerald-800/30">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-red-50 dark:bg-red-900/10 text-red-700 dark:text-red-400 text-[11px] font-semibold border border-red-200/50 dark:border-red-800/30">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-3 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    @if($overtime->status == 'pending')
                                        <button onclick="openModal('approveModal-{{ $overtime->id }}')" class="px-2 py-1 rounded bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 font-medium text-xs border border-emerald-200/60 dark:border-emerald-800/50 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">check</span>
                                            ACC
                                        </button>
                                        <button onclick="openModal('rejectModal-{{ $overtime->id }}')" class="px-2 py-1 rounded bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-700 dark:text-red-400 font-medium text-xs border border-red-200/60 dark:border-red-800/50 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">close</span>
                                            Tolak
                                        </button>
                                    @else
                                        <div class="relative inline-block text-left">
                                            <button onclick="toggleDropdown('dropdown-{{ $overtime->id }}', event)" class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center justify-center text-slate-500 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                            </button>
                                            <div id="dropdown-{{ $overtime->id }}" class="action-dropdown hidden absolute right-0 mt-1 w-40 bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] rounded-lg shadow-lg z-[60] py-1">
                                                <button onclick="openModal('detailModal-{{ $overtime->id }}')" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                    Lihat Detail
                                                </button>
                                                @if($overtime->status == 'rejected' && $overtime->rejected_reason)
                                                    <button onclick="openModal('reasonModal-{{ $overtime->id }}')" class="w-full text-left px-4 py-2 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2">
                                                        <span class="material-symbols-outlined text-[16px]">info</span>
                                                        Alasan Penolakan
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-3">more_time</span>
                                    <h3 class="font-medium text-sm text-slate-900 dark:text-slate-200">Belum Ada Pengajuan Lembur</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Tidak ada permintaan lembur dari pegawai pada rentang waktu ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($overtimeRequests->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/30 dark:border-[#2A3654] bg-slate-50/50 dark:bg-[#0F172E]/30">
            {{ $overtimeRequests->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modals Container (Rendered outside table) --}}
@foreach($overtimeRequests as $overtime)
    {{-- Approve Modal --}}
    <div id="approveModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-emerald-50/50 dark:bg-emerald-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-lg">Setujui Lembur</h3>
                        <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $overtime->employee->name }}</p>
                    </div>
                </div>
                <button onclick="closeModal('approveModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-[#0F172E]">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-on-surface-variant dark:text-[#8B93A8] mb-6">
                    Anda akan menyetujui pengajuan lembur dari <strong>{{ $overtime->employee->name }}</strong>. Lanjutkan?
                </p>
                <form action="{{ route('overtime-requests.approve', $overtime->id) }}" method="POST">
                    @csrf
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('approveModal-{{ $overtime->id }}')" class="px-5 py-2.5 rounded-lg font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium shadow-sm transition-all active:scale-95">Ya, Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-red-50/50 dark:bg-red-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined">block</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-lg">Tolak Pengajuan</h3>
                        <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $overtime->employee->name }}</p>
                    </div>
                </div>
                <button onclick="closeModal('rejectModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-[#0F172E]">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <form action="{{ route('overtime-requests.reject', $overtime->id) }}" method="POST" class="p-6">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-on-surface dark:text-[#E8E6E0] mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="rejected_reason" required rows="3" placeholder="Jelaskan alasan penolakan..." class="w-full px-4 py-3 bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-on-surface dark:text-white text-sm resize-none"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('rejectModal-{{ $overtime->id }}')" class="px-5 py-2.5 rounded-lg font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-red-500 hover:bg-red-600 text-white font-medium shadow-sm transition-all active:scale-95">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-lg rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined">info</span>
                    </div>
                    <h3 class="font-bold text-on-surface dark:text-white text-lg">Detail Pengajuan Lembur</h3>
                </div>
                <button onclick="closeModal('detailModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-[#0F172E]">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Pegawai</p>
                        <p class="text-sm font-medium text-on-surface dark:text-[#E8E6E0]">{{ $overtime->employee->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Tanggal</p>
                        <p class="text-sm font-medium text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($overtime->date)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Jam Mulai</p>
                        <p class="text-sm font-medium text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($overtime->start_time)->format('H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Jam Selesai</p>
                        <p class="text-sm font-medium text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($overtime->end_time)->format('H:i') }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Alasan</p>
                    <p class="text-sm text-on-surface dark:text-[#E8E6E0] bg-slate-50 dark:bg-[#0F172E] p-3 rounded-lg border border-outline-variant/30 dark:border-[#2A3654]">{{ $overtime->reason ?? 'Tidak ada alasan yang dicantumkan.' }}</p>
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Diajukan Pada</p>
                    <p class="text-sm text-on-surface dark:text-[#E8E6E0]">{{ $overtime->created_at->translatedFormat('d M Y, H:i') }}</p>
                </div>
                @if($overtime->status != 'pending' && $overtime->approver)
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Diproses Oleh</p>
                        <p class="text-sm text-on-surface dark:text-[#E8E6E0]">Admin (NIP: {{ $overtime->approver->nip ?? '-' }})</p>
                    </div>
                @endif
                @if($overtime->status == 'rejected' && $overtime->rejected_reason)
                    <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/50 rounded-lg p-3">
                        <p class="text-[11px] uppercase tracking-wider font-bold text-red-600 dark:text-red-400 mb-1">Alasan Penolakan</p>
                        <p class="text-sm text-red-700 dark:text-red-300">{{ $overtime->rejected_reason }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Reason Modal (quick access) --}}
    @if($overtime->status == 'rejected' && $overtime->rejected_reason)
    <div id="reasonModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-sm rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-4 border-b border-outline-variant/20 dark:border-[#2A3654] bg-red-50/50 dark:bg-red-900/10">
                <h3 class="font-bold text-red-700 dark:text-red-400">Alasan Penolakan</h3>
                <button onclick="closeModal('reasonModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-5">
                <p class="text-sm text-on-surface dark:text-[#E8E6E0] leading-relaxed">{{ $overtime->rejected_reason }}</p>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection

@section('scripts')
<script>
    // Modal Controller
    function openModal(id) {
        const modal = document.getElementById(id);
        if(modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if(modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Close modal on overlay click
    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
            document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        }
    });

    // Dropdown Controller
    function toggleDropdown(id, event) {
        event.stopPropagation();
        const dropdown = document.getElementById(id);
        const isHidden = dropdown.classList.contains('hidden');
        document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        if (isHidden) {
            dropdown.classList.remove('hidden');
        }
    }

    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-dropdown') && !e.target.closest('button[onclick^="toggleDropdown"]')) {
            document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        }
    });
</script>
@endsection
