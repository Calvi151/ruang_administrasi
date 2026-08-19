@extends('admin.layouts.app')

@section('title', 'Pengajuan Lembur - Ruang Administrasi')
@section('page-title', 'Pengajuan Lembur')
@section('page-subtitle', 'Kelola persetujuan dan rekapitulasi lembur pegawai')

@section('styles')
<style>
    .shadow-level-2 {
        box-shadow: 0px 4px 12px rgba(15, 27, 61, 0.05);
    }
    html.dark .shadow-level-2 {
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    .focus-ring:focus-within {
        border-color: #0F1B3D;
        box-shadow: 0 0 0 2px #ffbf00;
    }
    html.dark .focus-ring:focus-within {
        border-color: #ffbf00;
        box-shadow: 0 0 0 2px rgba(255, 191, 0, 0.3);
    }

    .modal-overlay {
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease-out;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-content-box {
        transform: scale(0.95) translateY(10px);
        opacity: 0;
        transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .modal-overlay.active .modal-content-box {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
</style>
@endsection

@section('content')
<div class="max-w-[1440px] mx-auto w-full">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700/50 rounded-xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-lg">check_circle</span>
            </div>
            <p class="text-sm font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
        </div>
    @endif

    {{-- 1. STAT CARDS (Project 1 Modern Redesign with Rich Vibrant Dark Mode) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Card 1: Menunggu Persetujuan --}}
        <div class="bg-gradient-to-br from-amber-50/80 via-white to-white dark:from-amber-950/40 dark:via-[#141C33] dark:to-[#141C33] border border-amber-200/70 dark:border-amber-500/30 rounded-xl p-5 shadow-sm border-t-4 border-t-amber-500 dark:border-t-amber-400 relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-amber-900/70 dark:text-amber-400/80 uppercase tracking-wider mb-1 font-bold">Menunggu ACC</p>
                    <h3 class="text-3xl font-extrabold text-amber-600 dark:text-amber-400 m-0">{{ $stats['pending'] }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center border border-amber-200 dark:border-amber-500/40 shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">more_time</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-amber-200/40 dark:border-amber-500/20">
                <span class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 dark:border dark:border-amber-500/30 px-2 py-0.5 rounded font-bold">
                    Perlu Tindakan
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Pengajuan lembur</span>
            </div>
        </div>

        {{-- Card 2: Disetujui --}}
        <div class="bg-gradient-to-br from-emerald-50/80 via-white to-white dark:from-emerald-950/40 dark:via-[#141C33] dark:to-[#141C33] border border-emerald-200/70 dark:border-emerald-500/30 rounded-xl p-5 shadow-sm border-t-4 border-t-emerald-500 dark:border-t-emerald-400 relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-emerald-900/70 dark:text-emerald-400/80 uppercase tracking-wider mb-1 font-bold">Disetujui</p>
                    <h3 class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 m-0">{{ $stats['approved'] }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center border border-emerald-200 dark:border-emerald-500/40 shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">task_alt</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-emerald-200/40 dark:border-emerald-500/20">
                <span class="text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300 dark:border dark:border-emerald-500/30 px-2 py-0.5 rounded font-bold">
                    Disetujui
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Lembur disahkan</span>
            </div>
        </div>

        {{-- Card 3: Ditolak --}}
        <div class="bg-gradient-to-br from-red-50/80 via-white to-white dark:from-red-950/40 dark:via-[#141C33] dark:to-[#141C33] border border-red-200/70 dark:border-red-500/30 rounded-xl p-5 shadow-sm border-t-4 border-t-red-500 dark:border-t-red-400 relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-red-900/70 dark:text-red-400/80 uppercase tracking-wider mb-1 font-bold">Ditolak</p>
                    <h3 class="text-3xl font-extrabold text-red-600 dark:text-red-400 m-0">{{ $stats['rejected'] }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 flex items-center justify-center border border-red-200 dark:border-red-500/40 shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">cancel</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-red-200/40 dark:border-red-500/20">
                <span class="text-xs bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300 dark:border dark:border-red-500/30 px-2 py-0.5 rounded font-bold">
                    Ditolak
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Tidak disetujui</span>
            </div>
        </div>

        {{-- Card 4: Total Bulan Ini --}}
        <div class="bg-gradient-to-br from-indigo-50/80 via-white to-white dark:from-indigo-950/40 dark:via-[#141C33] dark:to-[#141C33] border border-indigo-200/70 dark:border-indigo-500/30 rounded-xl p-5 shadow-sm border-t-4 border-t-indigo-600 dark:border-t-indigo-400 relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-indigo-900/70 dark:text-indigo-400/80 uppercase tracking-wider mb-1 font-bold">Total Bulan Ini</p>
                    <h3 class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 m-0">{{ $stats['total_month'] }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center border border-indigo-200 dark:border-indigo-500/40 shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">calendar_month</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-indigo-200/40 dark:border-indigo-500/20">
                <span class="text-xs bg-indigo-100 text-indigo-800 dark:bg-indigo-500/20 dark:text-indigo-300 dark:border dark:border-indigo-500/30 px-2 py-0.5 rounded font-bold">
                    Akumulasi
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Periode berjalan</span>
            </div>
        </div>
    </div>

    {{-- 2. FILTER ROW --}}
    <div class="flex justify-between items-center mb-6 gap-4 flex-wrap">
        <form action="{{ route('overtime-requests.index') }}" method="GET" class="flex items-center gap-3 flex-wrap">
            {{-- Karyawan --}}
            <div class="w-56 md:w-64">
                <select name="employee_id" class="w-full px-3 py-2 bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg text-xs md:text-sm font-medium text-slate-700 dark:text-slate-200 focus:border-[#0F1B3D] dark:focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 cursor-pointer outline-none transition-all shadow-sm" onchange="this.form.submit()">
                    <option value="" class="dark:bg-[#141C33]">Semua Karyawan</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }} class="dark:bg-[#141C33]">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Periode Bulan --}}
            <div class="w-48 md:w-56">
                <input type="month" name="month" value="{{ request('month') }}" class="w-full px-3 py-2 bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg text-xs md:text-sm font-medium text-slate-700 dark:text-slate-200 focus:border-[#0F1B3D] dark:focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 cursor-pointer outline-none transition-all shadow-sm" onchange="this.form.submit()" title="Pilih Bulan">
            </div>

            {{-- Status Dropdown --}}
            <div class="w-40 md:w-48">
                <select name="status" class="w-full px-3 py-2 bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg text-xs md:text-sm font-medium text-slate-700 dark:text-slate-200 focus:border-[#0F1B3D] dark:focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 cursor-pointer outline-none transition-all shadow-sm" onchange="this.form.submit()">
                    <option value="" class="dark:bg-[#141C33]">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="dark:bg-[#141C33]">Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }} class="dark:bg-[#141C33]">Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }} class="dark:bg-[#141C33]">Ditolak</option>
                </select>
            </div>

            @if(request()->hasAny(['employee_id', 'month', 'status']))
                <a href="{{ route('overtime-requests.index') }}" class="text-xs font-bold text-red-500 hover:underline px-2 py-1">Reset Filter</a>
            @endif
        </form>
    </div>

    {{-- 3. MAIN TABLE CARD (Project 1 Design) --}}
    <div class="bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-outline-variant/40 dark:border-[#2A3654] flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/40">
            <h3 class="text-base md:text-lg font-bold text-slate-900 dark:text-white m-0">Daftar Pengajuan Lembur</h3>
            <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Total: {{ $overtimeRequests->total() }} pengajuan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 border-b border-outline-variant/40 dark:border-[#2A3654] text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider font-semibold">
                        <th class="px-6 py-4">Pegawai</th>
                        <th class="px-6 py-4 text-center">Tanggal Lembur</th>
                        <th class="px-6 py-4 text-center">Jam & Durasi</th>
                        <th class="px-6 py-4">Alasan Lembur</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 dark:divide-[#2A3654] text-sm text-slate-800 dark:text-slate-200">
                    @forelse($overtimeRequests as $overtime)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors">
                            {{-- Pegawai --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($overtime->employee && $overtime->employee->photo)
                                        <img src="{{ asset('storage/' . $overtime->employee->photo) }}" alt="Photo" class="w-9 h-9 rounded-full border border-outline-variant/40 object-cover shrink-0">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 flex items-center justify-center font-bold text-xs shrink-0 border border-blue-200/50 dark:border-blue-700/50">
                                            {{ strtoupper(substr($overtime->employee->name ?? '?', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-bold text-sm text-slate-900 dark:text-white truncate">{{ $overtime->employee->name ?? 'Unknown' }}</span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ $overtime->employee->nip ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Tanggal Lembur --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="text-slate-900 dark:text-white font-semibold text-xs md:text-sm">
                                    {{ \Carbon\Carbon::parse($overtime->date)->translatedFormat('d M Y') }}
                                </div>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($overtime->date)->translatedFormat('l') }}</span>
                            </td>

                            {{-- Jam & Durasi --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center gap-1.5 text-xs md:text-sm font-mono font-medium text-slate-700 dark:text-slate-300">
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
                                    <span class="mt-1 inline-flex items-center justify-center bg-indigo-50 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-500/30 px-2 py-0.5 rounded text-[11px] font-bold">
                                        {{ $durationText }}
                                    </span>
                                </div>
                            </td>

                            {{-- Alasan --}}
                            <td class="px-6 py-4">
                                <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-2 max-w-[240px]">{{ $overtime->reason ?? '-' }}</p>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                @if($overtime->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30">
                                        Pending
                                    </span>
                                @elseif($overtime->status == 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 dark:bg-red-500/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-500/30">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1.5 items-center">
                                    @if($overtime->status == 'pending')
                                        <button onclick="openModal('approveModal-{{ $overtime->id }}')" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-500/20 dark:hover:bg-emerald-500/30 text-emerald-700 dark:text-emerald-400 font-bold text-xs border border-emerald-200 dark:border-emerald-500/40 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">check</span>
                                            ACC
                                        </button>
                                        <button onclick="openModal('rejectModal-{{ $overtime->id }}')" class="px-2.5 py-1 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-500/20 dark:hover:bg-red-500/30 text-red-700 dark:text-red-400 font-bold text-xs border border-red-200 dark:border-red-500/40 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">close</span>
                                            Tolak
                                        </button>
                                    @else
                                        <div class="relative inline-block text-left">
                                            <button onclick="toggleDropdown('dropdown-{{ $overtime->id }}', event)" class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                            </button>
                                            <div id="dropdown-{{ $overtime->id }}" class="action-dropdown hidden absolute right-0 mt-1 w-44 bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-xl shadow-lg z-[60] py-1">
                                                <button onclick="openModal('detailModal-{{ $overtime->id }}')" class="w-full text-left px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                    Lihat Detail
                                                </button>
                                                @if($overtime->status == 'rejected' && $overtime->rejected_reason)
                                                    <button onclick="openModal('reasonModal-{{ $overtime->id }}')" class="w-full text-left px-4 py-2 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2">
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
                                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">more_time</span>
                                    <h3 class="font-medium text-sm text-slate-900 dark:text-slate-200">Belum Ada Pengajuan Lembur</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tidak ada permintaan lembur dari pegawai pada rentang waktu ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($overtimeRequests->hasPages())
        <div class="px-6 py-3 border-t border-outline-variant/40 dark:border-ds-border flex justify-between items-center bg-surface-container-low/40 dark:bg-white/5">
            {{ $overtimeRequests->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modals Container --}}
@foreach($overtimeRequests as $overtime)
    {{-- Approve Modal --}}
    <div id="approveModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border bg-emerald-50/50 dark:bg-emerald-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-base">Setujui Lembur</h3>
                        <p class="text-xs text-on-surface-variant dark:text-slate-400">{{ $overtime->employee->name ?? 'Pegawai' }}</p>
                    </div>
                </div>
                <button onclick="closeModal('approveModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-on-surface-variant dark:text-slate-300 mb-6">
                    Anda akan menyetujui pengajuan lembur dari <strong>{{ $overtime->employee->name ?? 'Pegawai' }}</strong>. Lanjutkan?
                </p>
                <form action="{{ route('overtime-requests.approve', $overtime->id) }}" method="POST">
                    @csrf
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('approveModal-{{ $overtime->id }}')" class="px-4 py-2 rounded-lg font-semibold text-xs text-on-surface-variant dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all active:scale-95">Ya, Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border bg-red-50/50 dark:bg-red-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined">cancel</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-base">Tolak Lembur</h3>
                        <p class="text-xs text-on-surface-variant dark:text-slate-400">{{ $overtime->employee->name ?? 'Pegawai' }}</p>
                    </div>
                </div>
                <button onclick="closeModal('rejectModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('overtime-requests.reject', $overtime->id) }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-on-surface dark:text-white mb-2 uppercase tracking-wider">Alasan Penolakan</label>
                        <textarea name="rejected_reason" rows="3" required placeholder="Tuliskan alasan penolakan..." class="w-full px-4 py-2.5 bg-surface-container-low/40 dark:bg-black/20 border border-outline-variant/60 dark:border-ds-border rounded-lg text-sm text-on-surface dark:text-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all outline-none"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('rejectModal-{{ $overtime->id }}')" class="px-4 py-2 rounded-lg font-semibold text-xs text-on-surface-variant dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition-all active:scale-95">Tolak Lembur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-lg rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border">
                <h3 class="font-bold text-on-surface dark:text-white text-base">Detail Pengajuan Lembur</h3>
                <button onclick="closeModal('detailModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3 pb-4 border-b border-outline-variant/30">
                    <div class="w-12 h-12 rounded-full bg-primary-fixed dark:bg-blue-900/40 text-primary-container dark:text-blue-300 flex items-center justify-center font-bold text-sm shrink-0">
                        {{ strtoupper(substr($overtime->employee->name ?? '?', 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-on-surface dark:text-white text-base">{{ $overtime->employee->name ?? 'Unknown' }}</h4>
                        <p class="text-xs text-on-surface-variant dark:text-slate-400">NIP: {{ $overtime->employee->nip ?? '-' }} • {{ $overtime->employee->position ?? 'Karyawan' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs text-on-surface-variant dark:text-slate-400 block mb-0.5">Tanggal Lembur</span>
                        <span class="font-semibold text-sm text-on-surface dark:text-white">{{ \Carbon\Carbon::parse($overtime->date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-on-surface-variant dark:text-slate-400 block mb-0.5">Status</span>
                        <span class="font-semibold text-sm {{ $overtime->status == 'approved' ? 'text-emerald-600' : ($overtime->status == 'rejected' ? 'text-red-600' : 'text-amber-600') }} uppercase">{{ $overtime->status }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-on-surface-variant dark:text-slate-400 block mb-0.5">Jam Mulai</span>
                        <span class="font-semibold text-sm font-mono text-on-surface dark:text-white">{{ \Carbon\Carbon::parse($overtime->start_time)->format('H:i') }} WIB</span>
                    </div>
                    <div>
                        <span class="text-xs text-on-surface-variant dark:text-slate-400 block mb-0.5">Jam Selesai</span>
                        <span class="font-semibold text-sm font-mono text-on-surface dark:text-white">{{ \Carbon\Carbon::parse($overtime->end_time)->format('H:i') }} WIB</span>
                    </div>
                </div>

                <div>
                    <span class="text-xs text-on-surface-variant dark:text-slate-400 block mb-1">Alasan Lembur</span>
                    <p class="text-sm text-on-surface dark:text-slate-200 bg-surface-container-low/40 dark:bg-black/20 p-3 rounded-lg border border-outline-variant/40">{{ $overtime->reason ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Reason Modal --}}
    @if($overtime->status == 'rejected' && $overtime->rejected_reason)
    <div id="reasonModal-{{ $overtime->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border bg-red-50/50 dark:bg-red-900/10">
                <h3 class="font-bold text-red-700 dark:text-red-400 text-base">Alasan Penolakan</h3>
                <button onclick="closeModal('reasonModal-{{ $overtime->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-on-surface dark:text-slate-200 bg-red-50/30 dark:bg-red-900/10 p-3 rounded-lg border border-red-200/50 dark:border-red-900/30">{{ $overtime->rejected_reason }}</p>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection

@section('scripts')
<script>
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

    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            });
            document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        }
    });

    function toggleDropdown(id, event) {
        event.stopPropagation();
        const dropdown = document.getElementById(id);
        const isHidden = dropdown.classList.contains('hidden');
        document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        if (isHidden) {
            dropdown.classList.remove('hidden');
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-dropdown') && !e.target.closest('button[onclick^="toggleDropdown"]')) {
            document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        }
    });
</script>
@endsection
