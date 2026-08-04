@extends('admin.layouts.app')

@section('title', 'Pengajuan Lembur - Ruang Administrasi')
@section('page-title', 'Pengajuan Lembur')
@section('page-subtitle', 'Kelola persetujuan lembur pegawai')

@section('styles')
<style>
    /* Reuse same micro-animation system from attendance */
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
    html.dark .glass-card {
        background: rgba(20, 28, 51, 0.7);
    }

    .interactive-row {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .interactive-row:hover {
        transform: translateY(-2px) scale(1.005);
        box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.1);
        z-index: 10;
        position: relative;
    }
    html.dark .interactive-row:hover {
        box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.5);
    }

    .modal-overlay {
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease-out;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-content-box {
        transform: scale(0.95) translateY(10px);
        opacity: 0;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .modal-overlay.active .modal-content-box {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    .pulse-dot {
        animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }
    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(234, 179, 8, 0); }
        100% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0); }
    }
    
    /* Entry Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-slide-in {
        animation: slideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
</style>
@endsection

@section('content')
<div class="max-w-[container-max] mx-auto w-full">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700/50 rounded-xl flex items-center gap-3 animate-[fadeIn_0.3s_ease-out]">
            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-lg">check_circle</span>
            </div>
            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
        </div>
    @endif

    {{-- 1. WIDGET STATISTIK INTERAKTIF --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Card 1: Menunggu Persetujuan --}}
        <div class="glass-card rounded-2xl p-5 border border-outline-variant/40 dark:border-[#2A3654] shadow-sm flex items-center justify-between group hover:border-amber-500 transition-colors cursor-default animate-fade-in" style="animation-delay: 100ms;">
            <div>
                <p class="text-xs font-medium text-on-surface-variant dark:text-[#8B93A8] mb-1">Menunggu ACC</p>
                <h3 class="text-3xl font-bold text-on-surface dark:text-[#E8E6E0]">{{ $stats['pending'] }} <span class="text-sm font-normal text-on-surface-variant">pengajuan</span></h3>
            </div>
            <div class="w-11 h-11 rounded-full bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">more_time</span>
            </div>
        </div>

        {{-- Card 2: Disetujui --}}
        <div class="glass-card rounded-2xl p-5 border border-outline-variant/40 dark:border-[#2A3654] shadow-sm flex items-center justify-between group hover:border-emerald-500 transition-colors cursor-default animate-fade-in" style="animation-delay: 200ms;">
            <div>
                <p class="text-xs font-medium text-on-surface-variant dark:text-[#8B93A8] mb-1">Disetujui</p>
                <h3 class="text-3xl font-bold text-on-surface dark:text-[#E8E6E0]">{{ $stats['approved'] }} <span class="text-sm font-normal text-on-surface-variant">pengajuan</span></h3>
            </div>
            <div class="w-11 h-11 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">task_alt</span>
            </div>
        </div>

        {{-- Card 3: Ditolak --}}
        <div class="glass-card rounded-2xl p-5 border border-outline-variant/40 dark:border-[#2A3654] shadow-sm flex items-center justify-between group hover:border-red-500 transition-colors cursor-default animate-fade-in" style="animation-delay: 300ms;">
            <div>
                <p class="text-xs font-medium text-on-surface-variant dark:text-[#8B93A8] mb-1">Ditolak</p>
                <h3 class="text-3xl font-bold text-on-surface dark:text-[#E8E6E0]">{{ $stats['rejected'] }} <span class="text-sm font-normal text-on-surface-variant">pengajuan</span></h3>
            </div>
            <div class="w-11 h-11 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
        </div>

        {{-- Card 4: Total Bulan Ini --}}
        <div class="glass-card rounded-2xl p-5 border border-outline-variant/40 dark:border-[#2A3654] shadow-sm flex items-center justify-between group hover:border-indigo-500 transition-colors cursor-default animate-fade-in" style="animation-delay: 400ms;">
            <div>
                <p class="text-xs font-medium text-on-surface-variant dark:text-[#8B93A8] mb-1">Bulan Ini</p>
                <h3 class="text-3xl font-bold text-on-surface dark:text-[#E8E6E0]">{{ $stats['total_month'] }} <span class="text-sm font-normal text-on-surface-variant">total</span></h3>
            </div>
            <div class="w-11 h-11 rounded-full bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">calendar_month</span>
            </div>
        </div>
    </div>

    {{-- Header & Filter Form --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-6">
        <div>
            <h2 class="font-display-lg text-[24px] md:text-[28px] font-bold text-on-surface dark:text-[#E8E6E0] mb-1">Daftar Lembur</h2>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('overtime-requests.index') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-white dark:bg-[#141C33] p-1.5 rounded-xl border border-outline-variant/60 dark:border-[#2A3654] shadow-sm">
                
                <select name="employee_id" class="px-3 py-1.5 bg-transparent border-none text-xs font-semibold text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer">
                    <option value="">Semua Karyawan</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
                
                <div class="w-px h-5 bg-outline-variant/40 dark:bg-[#2A3654]"></div>
                
                <input type="month" name="month" value="{{ request('month') }}" class="px-3 py-1.5 bg-transparent border-none text-xs font-semibold text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer" title="Bulan Pengajuan">
                
                <div class="w-px h-5 bg-outline-variant/40 dark:bg-[#2A3654]"></div>
                
                <select name="status" class="px-3 py-1.5 bg-transparent border-none text-xs font-semibold text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                
                <button type="submit" class="bg-primary/10 hover:bg-primary text-primary hover:text-white dark:bg-ds-accent/10 dark:hover:bg-ds-accent dark:text-ds-accent dark:hover:text-[#0B1220] px-3 py-1.5 rounded-lg font-bold text-xs transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                    Filter
                </button>
                
                @if(request()->hasAny(['employee_id', 'month', 'status']))
                    <a href="{{ route('overtime-requests.index') }}" class="px-3 py-1.5 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg font-bold transition-colors">Reset</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="bg-white dark:bg-[#141C33] rounded-xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm overflow-visible animate-fade-in" style="animation-delay: 500ms;">
        {{-- Table Header --}}
        <div class="grid grid-cols-12 gap-4 px-6 py-4 border-b border-outline-variant/30 dark:border-[#2A3654] bg-slate-50/50 dark:bg-[#0F172E]/50 items-center text-[11px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider">
            <div class="col-span-3">Pegawai</div>
            <div class="col-span-2 text-center">Tanggal Lembur</div>
            <div class="col-span-2 text-center">Jam Kerja</div>
            <div class="col-span-2">Alasan</div>
            <div class="col-span-1 text-center">Status</div>
            <div class="col-span-2 text-right">Aksi</div>
        </div>

        {{-- Table Body --}}
        <div class="flex flex-col divide-y divide-outline-variant/20 dark:divide-[#2A3654]">
            @forelse($overtimeRequests as $overtime)
                <div class="interactive-row grid grid-cols-12 gap-4 px-6 py-4 items-center bg-white dark:bg-[#141C33] rounded-lg m-1 animate-slide-in" style="animation-delay: {{ 600 + ($loop->index * 50) }}ms;">
                    {{-- Employee --}}
                    <div class="col-span-3 flex items-center gap-3">
                        @if($overtime->employee && $overtime->employee->photo)
                            <img src="{{ asset('storage/' . $overtime->employee->photo) }}" alt="Photo" class="w-10 h-10 rounded-full border-2 border-white dark:border-[#2A3654] shadow-sm object-cover shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#091426] to-[#1e293b] dark:from-[#2A3654] dark:to-[#141C33] shadow-sm text-white flex items-center justify-center font-bold text-sm shrink-0 border border-outline-variant/30">
                                {{ strtoupper(substr($overtime->employee->name ?? '?', 0, 2)) }}
                            </div>
                        @endif
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm font-semibold text-on-surface dark:text-[#E8E6E0] truncate">{{ $overtime->employee->name ?? 'Unknown' }}</span>
                            <span class="text-[11px] text-on-surface-variant dark:text-[#8B93A8] font-mono mt-0.5">{{ $overtime->employee->nip ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Date --}}
                    <div class="col-span-2 text-center">
                        <div class="inline-flex flex-col items-center justify-center p-1.5 rounded-lg border border-outline-variant/50 dark:border-[#2A3654] bg-slate-50 dark:bg-[#0F172E] min-w-[80px]">
                            <span class="text-[10px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider mb-0.5">{{ \Carbon\Carbon::parse($overtime->date)->translatedFormat('l') }}</span>
                            <span class="text-sm font-bold text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($overtime->date)->format('d M') }}</span>
                        </div>
                    </div>

                    {{-- Time & Duration --}}
                    <div class="col-span-2 text-center flex flex-col items-center">
                        <div class="flex items-center gap-1.5 text-sm font-mono font-bold text-on-surface dark:text-[#E8E6E0]">
                            <span>{{ \Carbon\Carbon::parse($overtime->start_time)->format('H:i') }}</span>
                            <span class="material-symbols-outlined text-[14px] text-outline">arrow_forward</span>
                            <span>{{ \Carbon\Carbon::parse($overtime->end_time)->format('H:i') }}</span>
                        </div>
                        @php
                            $start = \Carbon\Carbon::parse($overtime->start_time);
                            $end = \Carbon\Carbon::parse($overtime->end_time);
                            // If end time is past midnight, add 1 day to end time
                            if($end->lt($start)) $end->addDay();
                            $hours = $start->diffInHours($end);
                            $mins = $start->diffInMinutes($end) % 60;
                            $durationText = $hours > 0 ? "{$hours}j " : "";
                            $durationText .= $mins > 0 ? "{$mins}m" : "";
                            if($durationText == "") $durationText = "0m";
                        @endphp
                        <span class="mt-1 inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-md bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800/50">
                            <span class="material-symbols-outlined text-[12px]">schedule</span>
                            {{ $durationText }}
                        </span>
                    </div>

                    {{-- Reason --}}
                    <div class="col-span-2">
                        <p class="text-xs text-on-surface-variant dark:text-[#8B93A8] line-clamp-2 leading-relaxed">{{ $overtime->reason ?? '-' }}</p>
                    </div>

                    {{-- Status --}}
                    <div class="col-span-1 flex justify-center">
                        @if($overtime->status == 'pending')
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-100/50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold border border-amber-200 dark:border-amber-700/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 pulse-dot"></span>
                                Pending
                            </div>
                        @elseif($overtime->status == 'approved')
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold border border-emerald-200 dark:border-emerald-800/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Disetujui
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-bold border border-red-200 dark:border-red-800/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Ditolak
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="col-span-2 flex justify-end gap-2">
                        @if($overtime->status == 'pending')
                            {{-- ACC Button --}}
                            <button onclick="openModal('approveModal-{{ $overtime->id }}')" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 font-semibold text-xs border border-emerald-200 dark:border-emerald-700/50 transition-all flex items-center gap-1 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">check</span>
                                ACC
                            </button>

                            {{-- Reject Button --}}
                            <button onclick="openModal('rejectModal-{{ $overtime->id }}')" class="px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-700 dark:text-red-400 font-semibold text-xs border border-red-200 dark:border-red-700/50 transition-all flex items-center gap-1 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">close</span>
                                Tolak
                            </button>
                        @else
                            {{-- Detail dropdown --}}
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown('dropdown-{{ $overtime->id }}', event)" class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-[#1D2847] flex items-center justify-center text-outline dark:text-[#8B93A8] hover:text-[#091426] dark:hover:text-white transition-colors focus:outline-none">
                                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                </button>
                                <div id="dropdown-{{ $overtime->id }}" class="action-dropdown hidden absolute right-0 mt-1 w-44 bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] rounded-xl shadow-lg z-[60] py-1 overflow-hidden">
                                    <button onclick="openModal('detailModal-{{ $overtime->id }}')" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-on-surface dark:text-[#E8E6E0] hover:bg-slate-50 dark:hover:bg-[#1D2847] flex items-center gap-2 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        Lihat Detail
                                    </button>
                                    @if($overtime->status == 'rejected' && $overtime->rejected_reason)
                                        <button onclick="openModal('reasonModal-{{ $overtime->id }}')" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">info</span>
                                            Alasan Penolakan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- MODALS --}}

                {{-- Approve Modal --}}
                <div id="approveModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
                        <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-emerald-50/50 dark:bg-emerald-900/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                    <span class="material-symbols-outlined">check_circle</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-on-surface dark:text-white text-lg">Setujui Pengajuan</h3>
                                    <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $overtime->employee->name }} — Lembur</p>
                                </div>
                            </div>
                            <button onclick="closeModal('approveModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-surface-container-low dark:hover:bg-[#0F172E]">
                                <span class="material-symbols-outlined text-xl">close</span>
                            </button>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-on-surface-variant dark:text-[#8B93A8] mb-6">
                                Anda akan menyetujui pengajuan lembur dari <strong>{{ $overtime->employee->name }}</strong>. Tindakan ini akan mengubah status lembur menjadi "Disetujui". Lanjutkan?
                            </p>
                            <form action="{{ route('overtime-requests.approve', $overtime->id) }}" method="POST">
                                @csrf
                                <div class="flex justify-end gap-3">
                                    <button type="button" onclick="closeModal('approveModal-{{ $overtime->id }}')" class="px-5 py-2.5 rounded-xl font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-lg shadow-emerald-500/30 transition-all active:scale-95">Ya, Setujui</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Reject Modal --}}
                <div id="rejectModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
                        <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-red-50/50 dark:bg-red-900/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                                    <span class="material-symbols-outlined">block</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-on-surface dark:text-white text-lg">Tolak Pengajuan</h3>
                                    <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $overtime->employee->name }} — Lembur</p>
                                </div>
                            </div>
                            <button onclick="closeModal('rejectModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-surface-container-low dark:hover:bg-[#0F172E]">
                                <span class="material-symbols-outlined text-xl">close</span>
                            </button>
                        </div>
                        <form action="{{ route('overtime-requests.reject', $overtime->id) }}" method="POST" class="p-6">
                            @csrf
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-on-surface dark:text-[#E8E6E0] mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                                <textarea name="rejected_reason" required rows="3" placeholder="Jelaskan alasan penolakan..." class="w-full px-4 py-3 bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/60 dark:border-[#2A3654] rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-on-surface dark:text-white text-sm resize-none"></textarea>
                            </div>
                            <div class="flex justify-end gap-3 pt-2">
                                <button type="button" onclick="closeModal('rejectModal-{{ $overtime->id }}')" class="px-5 py-2.5 rounded-xl font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold shadow-lg shadow-red-500/30 transition-all active:scale-95">Konfirmasi Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Detail Modal --}}
                <div id="detailModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
                        <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                    <span class="material-symbols-outlined">info</span>
                                </div>
                                <h3 class="font-bold text-on-surface dark:text-white text-lg">Detail Lembur</h3>
                            </div>
                            <button onclick="closeModal('detailModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-surface-container-low dark:hover:bg-[#0F172E]">
                                <span class="material-symbols-outlined text-xl">close</span>
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Pegawai</p>
                                    <p class="text-sm font-semibold text-on-surface dark:text-[#E8E6E0]">{{ $overtime->employee->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Tanggal Lembur</p>
                                    <p class="text-sm font-semibold text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($overtime->date)->translatedFormat('l, d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Jam Mulai</p>
                                    <p class="text-sm font-semibold text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($overtime->start_time)->format('H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Jam Selesai</p>
                                    <p class="text-sm font-semibold text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($overtime->end_time)->format('H:i') }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Keterangan Pekerjaan</p>
                                <p class="text-sm text-on-surface dark:text-[#E8E6E0] bg-slate-50 dark:bg-[#0F172E] p-3 rounded-lg border border-outline-variant/30 dark:border-[#2A3654]">{{ $overtime->reason ?? 'Tidak ada keterangan yang dicantumkan.' }}</p>
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
                    <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
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

            @empty
                <div class="px-6 py-16 flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 bg-indigo-50 dark:bg-indigo-900/10 rounded-full flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-5xl text-indigo-300 dark:text-indigo-500/50">more_time</span>
                    </div>
                    <h3 class="font-bold text-lg text-on-surface dark:text-[#E8E6E0] mb-1">Belum Ada Pengajuan Lembur</h3>
                    <p class="text-on-surface-variant dark:text-[#8B93A8] max-w-sm">Tidak ada permintaan lembur dari pegawai pada rentang waktu ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($overtimeRequests->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/30 dark:border-[#2A3654] bg-[#f8f9ff] dark:bg-[#0F172E]">
            {{ $overtimeRequests->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
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
