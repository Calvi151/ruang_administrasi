@extends('admin.layouts.app')

@section('title', 'Pengajuan Cuti & Izin - Ruang Administrasi')
@section('page-title', 'Pengajuan Cuti & Izin')
@section('page-subtitle', 'Kelola persetujuan cuti, izin, dan sakit pegawai')

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
                    <span class="material-symbols-outlined text-[22px]">hourglass_top</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-amber-200/40 dark:border-amber-500/20">
                <span class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 dark:border dark:border-amber-500/30 px-2 py-0.5 rounded font-bold">
                    Perlu Tindakan
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Pengajuan baru</span>
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
                    Selesai
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Telah di-ACC</span>
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
        <div class="bg-gradient-to-br from-blue-50/80 via-white to-white dark:from-blue-950/40 dark:via-[#141C33] dark:to-[#141C33] border border-blue-200/70 dark:border-blue-500/30 rounded-xl p-5 shadow-sm border-t-4 border-t-blue-600 dark:border-t-blue-400 relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-blue-900/70 dark:text-blue-400/80 uppercase tracking-wider mb-1 font-bold">Total Bulan Ini</p>
                    <h3 class="text-3xl font-extrabold text-blue-600 dark:text-blue-400 m-0">{{ $stats['total_month'] }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center border border-blue-200 dark:border-blue-500/40 shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">calendar_month</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-blue-200/40 dark:border-blue-500/20">
                <span class="text-xs bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-300 dark:border dark:border-blue-500/30 px-2 py-0.5 rounded font-bold">
                    Akumulasi
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Periode aktif</span>
            </div>
        </div>
    </div>

    {{-- 2. FILTER ROW --}}
    <div class="flex justify-between items-center mb-6 gap-4 flex-wrap">
        <form action="{{ route('leave-requests.index') }}" method="GET" class="flex items-center gap-3 flex-wrap">
            {{-- Karyawan --}}
            <div class="w-52 md:w-60">
                <select name="employee_id" class="w-full px-3 py-2 bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg text-xs md:text-sm font-medium text-slate-700 dark:text-slate-200 focus:border-[#0F1B3D] dark:focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 cursor-pointer outline-none transition-all shadow-sm" onchange="this.form.submit()">
                    <option value="" class="dark:bg-[#141C33]">Semua Karyawan</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }} class="dark:bg-[#141C33]">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Periode Bulan --}}
            <div class="w-44 md:w-52">
                <input type="month" name="month" value="{{ request('month') }}" class="w-full px-3 py-2 bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg text-xs md:text-sm font-medium text-slate-700 dark:text-slate-200 focus:border-[#0F1B3D] dark:focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 cursor-pointer outline-none transition-all shadow-sm" onchange="this.form.submit()" title="Pilih Bulan">
            </div>

            {{-- Jenis Pengajuan --}}
            <div class="w-36 md:w-44">
                <select name="type" class="w-full px-3 py-2 bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg text-xs md:text-sm font-medium text-slate-700 dark:text-slate-200 focus:border-[#0F1B3D] dark:focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 cursor-pointer outline-none transition-all shadow-sm" onchange="this.form.submit()">
                    <option value="" class="dark:bg-[#141C33]">Semua Jenis</option>
                    <option value="cuti" {{ request('type') == 'cuti' ? 'selected' : '' }} class="dark:bg-[#141C33]">🏖️ Cuti</option>
                    <option value="izin" {{ request('type') == 'izin' ? 'selected' : '' }} class="dark:bg-[#141C33]">📋 Izin</option>
                    <option value="sakit" {{ request('type') == 'sakit' ? 'selected' : '' }} class="dark:bg-[#141C33]">🏥 Sakit</option>
                </select>
            </div>

            {{-- Status Dropdown --}}
            <div class="w-36 md:w-44">
                <select name="status" class="w-full px-3 py-2 bg-white dark:bg-[#141C33] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg text-xs md:text-sm font-medium text-slate-700 dark:text-slate-200 focus:border-[#0F1B3D] dark:focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 cursor-pointer outline-none transition-all shadow-sm" onchange="this.form.submit()">
                    <option value="" class="dark:bg-[#141C33]">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="dark:bg-[#141C33]">Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }} class="dark:bg-[#141C33]">Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }} class="dark:bg-[#141C33]">Ditolak</option>
                </select>
            </div>

            @if(request()->hasAny(['employee_id', 'month', 'status', 'type']))
                <a href="{{ route('leave-requests.index') }}" class="text-xs font-bold text-red-500 hover:underline px-2 py-1">Reset Filter</a>
            @endif
        </form>
    </div>

    {{-- 3. MAIN TABLE CARD (Project 1 Design) --}}
    <div class="bg-surface-container-lowest dark:bg-ds-surface border border-outline-variant/60 dark:border-ds-border rounded-xl shadow-level-2 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-outline-variant/40 dark:border-ds-border flex justify-between items-center bg-surface-container-low/30 dark:bg-white/5">
            <h3 class="font-headline-sm text-base md:text-lg font-bold text-primary dark:text-white m-0">Daftar Pengajuan Cuti & Izin</h3>
            <span class="text-xs text-on-surface-variant dark:text-slate-400 font-medium">Total: {{ $leaveRequests->total() }} pengajuan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/60 dark:bg-black/20 border-b border-outline-variant/40 dark:border-ds-border text-on-surface-variant dark:text-slate-400 font-label-md text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Pegawai</th>
                        <th class="px-6 py-4 font-semibold">Jenis</th>
                        <th class="px-6 py-4 font-semibold text-center">Periode</th>
                        <th class="px-6 py-4 font-semibold text-center">Durasi</th>
                        <th class="px-6 py-4 font-semibold">Alasan</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/20 dark:divide-ds-border">
                    @forelse($leaveRequests as $leave)
                        <tr class="hover:bg-surface-container/50 dark:hover:bg-white/5 transition-colors">
                            {{-- Pegawai --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($leave->employee && $leave->employee->photo)
                                        <img src="{{ asset('storage/' . $leave->employee->photo) }}" alt="Photo" class="w-8 h-8 rounded-full border border-outline-variant/40 object-cover shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-primary-fixed dark:bg-blue-900/40 text-primary-container dark:text-blue-300 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($leave->employee->name ?? '?', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-medium text-sm text-on-surface dark:text-ds-text-primary truncate">{{ $leave->employee->name ?? 'Unknown' }}</span>
                                        <span class="text-xs text-on-surface-variant dark:text-slate-400">{{ $leave->employee->nip ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Jenis Badge --}}
                            <td class="px-6 py-4">
                                @php
                                    $typeConfig = match($leave->type) {
                                        'cuti'  => ['bg' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border-blue-200 dark:border-blue-800/50', 'icon' => 'beach_access', 'label' => 'Cuti'],
                                        'izin'  => ['bg' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 border-purple-200 dark:border-purple-800/50', 'icon' => 'description', 'label' => 'Izin'],
                                        'sakit' => ['bg' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300 border-orange-200 dark:border-orange-800/50', 'icon' => 'local_hospital', 'label' => 'Sakit'],
                                        default => ['bg' => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700', 'icon' => 'help', 'label' => ucfirst($leave->type)],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $typeConfig['bg'] }} border">
                                    <span class="material-symbols-outlined text-[14px]">{{ $typeConfig['icon'] }}</span>
                                    {{ $typeConfig['label'] }}
                                </span>
                            </td>

                            {{-- Periode --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap text-xs md:text-sm">
                                <div class="text-on-surface dark:text-slate-300 font-medium">
                                    {{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d M') }}
                                    <span class="text-slate-400 mx-1">-</span>
                                    {{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d M Y') }}
                                </div>
                            </td>

                            {{-- Durasi --}}
                            <td class="px-6 py-4 text-center">
                                @php
                                    $days = \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1;
                                @endphp
                                <span class="inline-flex items-center justify-center font-mono font-medium text-slate-700 dark:text-slate-200 bg-surface-container-low dark:bg-white/5 px-2.5 py-1 rounded-md text-xs border border-outline-variant/40">
                                    {{ $days }} <span class="text-[10px] ml-1 font-normal text-slate-500">hari</span>
                                </span>
                            </td>

                            {{-- Alasan & Lampiran --}}
                            <td class="px-6 py-4">
                                <p class="text-xs text-on-surface-variant dark:text-slate-300 line-clamp-2 max-w-[220px]">{{ $leave->reason ?? '-' }}</p>
                                @if($leave->attachment)
                                    <button onclick="openModal('attachModal-{{ $leave->id }}')" class="mt-1 inline-flex items-center gap-1 text-[11px] font-semibold text-primary dark:text-amber-400 hover:underline">
                                        <span class="material-symbols-outlined text-[14px]">attach_file</span>
                                        Lihat Dokumen
                                    </button>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                @if($leave->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border border-amber-200 dark:border-amber-800/50">
                                        Pending
                                    </span>
                                @elseif($leave->status == 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/50">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border border-red-200 dark:border-red-800/50">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-1.5 items-center">
                                    @if($leave->status == 'pending')
                                        <button onclick="openModal('editCategoryModal-{{ $leave->id }}')" class="p-1.5 rounded-lg hover:bg-surface-container-high dark:hover:bg-white/10 text-on-surface-variant dark:text-slate-300 transition-colors" title="Edit Kategori">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                        <button onclick="openModal('approveModal-{{ $leave->id }}')" class="px-2.5 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 font-bold text-xs border border-emerald-200 dark:border-emerald-800/50 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">check</span>
                                            ACC
                                        </button>
                                        <button onclick="openModal('rejectModal-{{ $leave->id }}')" class="px-2.5 py-1 rounded-lg bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-700 dark:text-red-400 font-bold text-xs border border-red-200 dark:border-red-800/50 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">close</span>
                                            Tolak
                                        </button>
                                    @else
                                        <div class="relative inline-block text-left">
                                            <button onclick="toggleDropdown('dropdown-{{ $leave->id }}', event)" class="w-8 h-8 rounded-full hover:bg-surface-container-high dark:hover:bg-white/10 flex items-center justify-center text-on-surface-variant dark:text-slate-300 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                            </button>
                                            <div id="dropdown-{{ $leave->id }}" class="action-dropdown hidden absolute right-0 mt-1 w-44 bg-surface-container-lowest dark:bg-ds-surface border border-outline-variant/60 dark:border-ds-border rounded-xl shadow-lg z-[60] py-1">
                                                <button onclick="openModal('detailModal-{{ $leave->id }}')" class="w-full text-left px-4 py-2 text-xs font-semibold text-on-surface dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-white/5 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                    Lihat Detail
                                                </button>
                                                <button onclick="openModal('editCategoryModal-{{ $leave->id }}')" class="w-full text-left px-4 py-2 text-xs font-semibold text-on-surface dark:text-slate-300 hover:bg-surface-container-low dark:hover:bg-white/5 flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                    Edit Kategori
                                                </button>
                                                @if($leave->status == 'rejected' && $leave->rejected_reason)
                                                    <button onclick="openModal('reasonModal-{{ $leave->id }}')" class="w-full text-left px-4 py-2 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2">
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">inbox</span>
                                    <h3 class="font-medium text-sm text-slate-900 dark:text-slate-200">Belum Ada Pengajuan</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Belum ada pegawai yang mengajukan cuti atau izin pada filter ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($leaveRequests->hasPages())
        <div class="px-6 py-3 border-t border-outline-variant/40 dark:border-ds-border flex justify-between items-center bg-surface-container-low/40 dark:bg-white/5">
            {{ $leaveRequests->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modals Container --}}
@foreach($leaveRequests as $leave)
    {{-- Approve Modal --}}
    <div id="approveModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border bg-emerald-50/50 dark:bg-emerald-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-base">Setujui Pengajuan</h3>
                        <p class="text-xs text-on-surface-variant dark:text-slate-400">{{ $leave->employee->name ?? 'Pegawai' }} — {{ ucfirst($leave->type) }}</p>
                    </div>
                </div>
                <button onclick="closeModal('approveModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-on-surface-variant dark:text-slate-300 mb-6">
                    Anda akan menyetujui pengajuan {{ $leave->type }} dari <strong>{{ $leave->employee->name ?? 'Pegawai' }}</strong>. Lanjutkan?
                </p>
                <form action="{{ route('leave-requests.approve', $leave->id) }}" method="POST">
                    @csrf
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('approveModal-{{ $leave->id }}')" class="px-4 py-2 rounded-lg font-semibold text-xs text-on-surface-variant dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all active:scale-95">Ya, Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div id="editCategoryModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border bg-surface-container-low/50 dark:bg-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-fixed-dim/20 flex items-center justify-center text-primary-container dark:text-amber-400">
                        <span class="material-symbols-outlined">edit</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-base">Edit Kategori</h3>
                        <p class="text-xs text-on-surface-variant dark:text-slate-400">{{ $leave->employee->name ?? 'Pegawai' }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('editCategoryModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            
            <div class="p-6">
                <form action="{{ route('leave-requests.update', $leave->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-on-surface dark:text-white mb-2 uppercase tracking-wider">Pilih Kategori Baru</label>
                        <select name="type" required class="w-full px-4 py-2.5 bg-surface-container-low/40 dark:bg-black/20 border border-outline-variant/60 dark:border-ds-border rounded-lg text-sm text-on-surface dark:text-white focus:ring-2 focus:ring-primary/20 dark:focus:ring-amber-400/20 focus:border-primary dark:focus:border-amber-400 transition-all outline-none">
                            <option value="cuti" {{ $leave->type == 'cuti' ? 'selected' : '' }} class="dark:bg-[#141C33]">🏖️ Cuti</option>
                            <option value="izin" {{ $leave->type == 'izin' ? 'selected' : '' }} class="dark:bg-[#141C33]">📋 Izin</option>
                            <option value="sakit" {{ $leave->type == 'sakit' ? 'selected' : '' }} class="dark:bg-[#141C33]">🏥 Sakit</option>
                        </select>
                    </div>

                    <div class="flex gap-3 justify-end mt-6">
                        <button type="button" onclick="closeModal('editCategoryModal-{{ $leave->id }}')" class="px-4 py-2 text-xs font-semibold text-on-surface-variant dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/10 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-primary-container hover:bg-primary-container/90 rounded-lg transition-all shadow-sm active:scale-95">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border bg-red-50/50 dark:bg-red-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined">cancel</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-base">Tolak Pengajuan</h3>
                        <p class="text-xs text-on-surface-variant dark:text-slate-400">{{ $leave->employee->name ?? 'Pegawai' }}</p>
                    </div>
                </div>
                <button onclick="closeModal('rejectModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6">
                <form action="{{ route('leave-requests.reject', $leave->id) }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-on-surface dark:text-white mb-2 uppercase tracking-wider">Alasan Penolakan</label>
                        <textarea name="rejected_reason" rows="3" required placeholder="Tuliskan alasan penolakan..." class="w-full px-4 py-2.5 bg-surface-container-low/40 dark:bg-black/20 border border-outline-variant/60 dark:border-ds-border rounded-lg text-sm text-on-surface dark:text-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all outline-none"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('rejectModal-{{ $leave->id }}')" class="px-4 py-2 rounded-lg font-semibold text-xs text-on-surface-variant dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition-all active:scale-95">Tolak Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-lg rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border">
                <h3 class="font-bold text-on-surface dark:text-white text-base">Detail Pengajuan</h3>
                <button onclick="closeModal('detailModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3 pb-4 border-b border-outline-variant/30">
                    <div class="w-12 h-12 rounded-full bg-primary-fixed dark:bg-blue-900/40 text-primary-container dark:text-blue-300 flex items-center justify-center font-bold text-sm shrink-0">
                        {{ strtoupper(substr($leave->employee->name ?? '?', 0, 2)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-on-surface dark:text-white text-base">{{ $leave->employee->name ?? 'Unknown' }}</h4>
                        <p class="text-xs text-on-surface-variant dark:text-slate-400">NIP: {{ $leave->employee->nip ?? '-' }} • {{ $leave->employee->position ?? 'Karyawan' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Mulai</p>
                        <p class="text-sm font-medium text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Selesai</p>
                        <p class="text-sm font-medium text-on-surface dark:text-[#E8E6E0]">{{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Alasan</p>
                    <p class="text-sm text-on-surface dark:text-[#E8E6E0] bg-slate-50 dark:bg-[#0F172E] p-3 rounded-lg border border-outline-variant/30 dark:border-[#2A3654]">{{ $leave->reason ?? 'Tidak ada alasan yang dicantumkan.' }}</p>
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Diajukan Pada</p>
                    <p class="text-sm text-on-surface dark:text-[#E8E6E0]">{{ $leave->created_at->translatedFormat('d M Y, H:i') }}</p>
                </div>
                @if($leave->status != 'pending' && $leave->approver)
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Diproses Oleh</p>
                        <p class="text-sm text-on-surface dark:text-[#E8E6E0]">Admin (NIP: {{ $leave->approver->nip ?? '-' }})</p>
                    </div>
                @endif
                @if($leave->status == 'rejected' && $leave->rejected_reason)
                    <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/50 rounded-lg p-3">
                        <p class="text-[11px] uppercase tracking-wider font-bold text-red-600 dark:text-red-400 mb-1">Alasan Penolakan</p>
                        <p class="text-sm text-red-700 dark:text-red-300">{{ $leave->rejected_reason }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Reason Modal (quick access) --}}
    @if($leave->status == 'rejected' && $leave->rejected_reason)
    <div id="reasonModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-sm rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-4 border-b border-outline-variant/20 dark:border-[#2A3654] bg-red-50/50 dark:bg-red-900/10">
                <h3 class="font-bold text-red-700 dark:text-red-400">Alasan Penolakan</h3>
                <button onclick="closeModal('reasonModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-5">
                <p class="text-sm text-on-surface dark:text-[#E8E6E0] leading-relaxed">{{ $leave->rejected_reason }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Attachment Modal --}}
    @if($leave->attachment)
    <div id="attachModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-sm rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-4 border-b border-outline-variant/20 dark:border-[#2A3654]">
                <h3 class="font-bold text-on-surface dark:text-white">Lampiran</h3>
                <button onclick="closeModal('attachModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-4 flex flex-col items-center bg-slate-50 dark:bg-[#0B1220]">
                <img src="{{ asset('storage/' . $leave->attachment) }}" alt="Lampiran" class="w-full max-h-64 object-contain rounded-xl border border-outline-variant/20 dark:border-[#2A3654]">
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
