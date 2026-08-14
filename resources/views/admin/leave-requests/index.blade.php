@extends('admin.layouts.app')

@section('title', 'Pengajuan Cuti & Izin - Ruang Administrasi')
@section('page-title', 'Pengajuan Cuti & Izin')
@section('page-subtitle', 'Kelola persetujuan cuti, izin, dan sakit pegawai')

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

    /* Status tab styling */
    .status-tab {
        transition: all 0.2s ease;
    }
    .status-tab:hover {
        transform: translateY(-1px);
    }
    .status-tab.active-tab {
        border-bottom: 2px solid currentColor;
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
                <span class="material-symbols-outlined text-2xl">hourglass_top</span>
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
        <div class="glass-card rounded-2xl p-5 border border-outline-variant/40 dark:border-[#2A3654] shadow-sm flex items-center justify-between group hover:border-blue-500 transition-colors cursor-default animate-fade-in" style="animation-delay: 400ms;">
            <div>
                <p class="text-xs font-medium text-on-surface-variant dark:text-[#8B93A8] mb-1">Bulan Ini</p>
                <h3 class="text-3xl font-bold text-on-surface dark:text-[#E8E6E0]">{{ $stats['total_month'] }} <span class="text-sm font-normal text-on-surface-variant">total</span></h3>
            </div>
            <div class="w-11 h-11 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">date_range</span>
            </div>
        </div>
    </div>

    {{-- Header & Filter Form --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-6">
        <div>
            <h2 class="font-display-lg text-[24px] md:text-[28px] font-bold text-on-surface dark:text-[#E8E6E0] mb-1">Daftar Pengajuan</h2>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('leave-requests.index') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-white dark:bg-[#141C33] p-1.5 rounded-xl border border-outline-variant/60 dark:border-[#2A3654] shadow-sm">
                
                <select name="employee_id" class="px-3 py-1.5 bg-transparent border-none text-xs font-semibold text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer">
                    <option value="">Semua Karyawan</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
                
                <div class="w-px h-5 bg-outline-variant/40 dark:bg-[#2A3654]"></div>
                
                <input type="month" name="month" value="{{ request('month') }}" class="px-3 py-1.5 bg-transparent border-none text-xs font-semibold text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer" title="Bulan Pengajuan">
                
                <div class="w-px h-5 bg-outline-variant/40 dark:bg-[#2A3654]"></div>
                
                <select name="type" class="px-3 py-1.5 bg-transparent border-none text-xs font-semibold text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer">
                    <option value="">Semua Jenis</option>
                    <option value="cuti" {{ request('type') == 'cuti' ? 'selected' : '' }}>🏖️ Cuti</option>
                    <option value="izin" {{ request('type') == 'izin' ? 'selected' : '' }}>📋 Izin</option>
                    <option value="sakit" {{ request('type') == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                </select>
                
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
                
                @if(request()->hasAny(['employee_id', 'month', 'status', 'type']))
                    <a href="{{ route('leave-requests.index') }}" class="px-3 py-1.5 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg font-bold transition-colors">Reset</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Data Table Card --}}
    <div class="bg-white dark:bg-[#141C33] rounded-xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <!-- Table Header -->
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-[#0F172E]/50 border-b border-outline-variant/30 dark:border-[#2A3654] text-[11px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Pegawai</th>
                        <th class="px-6 py-4 font-semibold">Jenis</th>
                        <th class="px-6 py-4 font-semibold text-center">Periode</th>
                        <th class="px-6 py-4 font-semibold text-center">Durasi</th>
                        <th class="px-6 py-4 font-semibold">Alasan</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="divide-y divide-outline-variant/20 dark:divide-[#2A3654]">
                    @forelse($leaveRequests as $leave)
                        <tr class="hover:bg-slate-50 dark:hover:bg-[#1D2847]/50 transition-colors">
                            <!-- Employee -->
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-3">
                                    @if($leave->employee && $leave->employee->photo)
                                        <img src="{{ asset('storage/' . $leave->employee->photo) }}" alt="Photo" class="w-8 h-8 rounded-full border border-outline-variant/30 dark:border-[#2A3654] object-cover shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-[#2A3654] text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-xs shrink-0 border border-outline-variant/30">
                                            {{ strtoupper(substr($leave->employee->name ?? '?', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-sm font-semibold text-on-surface dark:text-[#E8E6E0] truncate">{{ $leave->employee->name ?? 'Unknown' }}</span>
                                        <span class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $leave->employee->nip ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Type Badge -->
                            <td class="px-6 py-3">
                                @php
                                    $typeConfig = match($leave->type) {
                                        'cuti'  => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'text' => 'text-blue-700 dark:text-blue-400', 'border' => 'border-blue-200/60 dark:border-blue-800/50', 'icon' => 'beach_access', 'label' => 'Cuti'],
                                        'izin'  => ['bg' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-700 dark:text-purple-400', 'border' => 'border-purple-200/60 dark:border-purple-800/50', 'icon' => 'description', 'label' => 'Izin'],
                                        'sakit' => ['bg' => 'bg-orange-50 dark:bg-orange-900/20', 'text' => 'text-orange-700 dark:text-orange-400', 'border' => 'border-orange-200/60 dark:border-orange-800/50', 'icon' => 'local_hospital', 'label' => 'Sakit'],
                                        default => ['bg' => 'bg-slate-50 dark:bg-slate-900/20', 'text' => 'text-slate-700 dark:text-slate-400', 'border' => 'border-slate-200/60 dark:border-slate-800/50', 'icon' => 'help', 'label' => ucfirst($leave->type)],
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md {{ $typeConfig['bg'] }} {{ $typeConfig['text'] }} {{ $typeConfig['border'] }} border text-[11px] font-medium">
                                    <span class="material-symbols-outlined text-[14px]">{{ $typeConfig['icon'] }}</span>
                                    {{ $typeConfig['label'] }}
                                </span>
                            </td>
                            
                            <!-- Period -->
                            <td class="px-6 py-3 text-center whitespace-nowrap">
                                <div class="text-sm text-slate-700 dark:text-slate-300">
                                    {{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d M') }}
                                    <span class="text-slate-400 mx-1">-</span>
                                    {{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d M Y') }}
                                </div>
                            </td>
                            
                            <!-- Duration -->
                            <td class="px-6 py-3 text-center">
                                @php
                                    $days = \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1;
                                @endphp
                                <span class="inline-flex items-center justify-center font-mono font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded text-sm border border-slate-200 dark:border-slate-700">
                                    {{ $days }} <span class="text-[10px] ml-1 font-normal text-slate-500">hari</span>
                                </span>
                            </td>
                            
                            <!-- Reason -->
                            <td class="px-6 py-3">
                                <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 max-w-[200px]">{{ $leave->reason ?? '-' }}</p>
                                @if($leave->attachment)
                                    <button onclick="openModal('attachModal-{{ $leave->id }}')" class="mt-1 inline-flex items-center gap-1 text-[11px] font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                        <span class="material-symbols-outlined text-[14px]">attach_file</span>
                                        Lampiran
                                    </button>
                                @endif
                            </td>
                            
                            <!-- Status -->
                            <td class="px-6 py-3 text-center">
                                @if($leave->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 text-xs font-medium border border-amber-200/60 dark:border-amber-800/50">
                                        Pending
                                    </span>
                                @elseif($leave->status == 'approved')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 text-xs font-medium border border-emerald-200/60 dark:border-emerald-800/50">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 text-xs font-medium border border-red-200/60 dark:border-red-800/50">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-3 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    @if($leave->status == 'pending')
                                        <button onclick="openModal('editCategoryModal-{{ $leave->id }}')" class="px-2 py-1 rounded bg-slate-50 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 font-medium text-xs border border-slate-200/60 dark:border-slate-700 transition-colors flex items-center gap-1" title="Edit Kategori">
                                            <span class="material-symbols-outlined text-[14px]">edit</span>
                                            Edit
                                        </button>
                                        <button onclick="openModal('approveModal-{{ $leave->id }}')" class="px-2 py-1 rounded bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 font-medium text-xs border border-emerald-200/60 dark:border-emerald-800/50 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">check</span>
                                            ACC
                                        </button>
                                        <button onclick="openModal('rejectModal-{{ $leave->id }}')" class="px-2 py-1 rounded bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 text-red-700 dark:text-red-400 font-medium text-xs border border-red-200/60 dark:border-red-800/50 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">close</span>
                                            Tolak
                                        </button>
                                    @else
                                        <div class="relative inline-block text-left">
                                            <button onclick="toggleDropdown('dropdown-{{ $leave->id }}', event)" class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-[#1D2847] flex items-center justify-center text-slate-500 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                            </button>
                                            <div id="dropdown-{{ $leave->id }}" class="action-dropdown hidden absolute right-0 mt-1 w-40 bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] rounded-lg shadow-lg z-[60] py-1">
                                                <button onclick="openModal('detailModal-{{ $leave->id }}')" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-[#1D2847] flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                    Lihat Detail
                                                </button>
                                                <button onclick="openModal('editCategoryModal-{{ $leave->id }}')" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-[#1D2847] flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                    Edit Kategori
                                                </button>
                                                @if($leave->status == 'rejected' && $leave->rejected_reason)
                                                    <button onclick="openModal('reasonModal-{{ $leave->id }}')" class="w-full text-left px-4 py-2 text-xs font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2">
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
                                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-3">inbox</span>
                                    <h3 class="font-medium text-sm text-slate-900 dark:text-slate-200">Belum Ada Pengajuan</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Belum ada pegawai yang mengajukan cuti, izin, atau sakit pada periode ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($leaveRequests->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/30 dark:border-[#2A3654] bg-slate-50/50 dark:bg-[#0F172E]/30">
            {{ $leaveRequests->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modals Container (Rendered outside table) --}}
@foreach($leaveRequests as $leave)
    {{-- Approve Modal --}}
    <div id="approveModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-emerald-50/50 dark:bg-emerald-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-lg">Setujui Pengajuan</h3>
                        <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $leave->employee->name }} — {{ ucfirst($leave->type) }}</p>
                    </div>
                </div>
                <button onclick="closeModal('approveModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-[#0F172E]">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-on-surface-variant dark:text-[#8B93A8] mb-6">
                    Anda akan menyetujui pengajuan {{ $leave->type }} dari <strong>{{ $leave->employee->name }}</strong>. Lanjutkan?
                </p>
                <form action="{{ route('leave-requests.approve', $leave->id) }}" method="POST">
                    @csrf
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('approveModal-{{ $leave->id }}')" class="px-5 py-2.5 rounded-lg font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-medium shadow-sm transition-all active:scale-95">Ya, Setujui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Category Modal --}}
    <div id="editCategoryModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-slate-50/50 dark:bg-slate-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined">edit</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-[#E8E6E0] text-lg leading-tight">Edit Kategori</h3>
                        <p class="text-xs text-on-surface-variant dark:text-[#8B93A8] mt-0.5">{{ $leave->employee->name ?? 'Pegawai' }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('editCategoryModal-{{ $leave->id }}')" class="w-8 h-8 rounded-full bg-surface-variant/50 dark:bg-[#2A3654]/50 hover:bg-surface-variant dark:hover:bg-[#2A3654] text-on-surface-variant dark:text-[#E8E6E0] flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            
            <div class="p-6">
                <form action="{{ route('leave-requests.update', $leave->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-slate-700 dark:text-[#E8E6E0] mb-2">Pilih Kategori Baru</label>
                        <select name="type" required class="w-full px-4 py-2.5 bg-white dark:bg-[#0F172E] border border-outline-variant/60 dark:border-[#2A3654] rounded-xl text-sm text-slate-700 dark:text-[#E8E6E0] focus:ring-2 focus:ring-primary/20 dark:focus:ring-ds-accent/20 focus:border-primary dark:focus:border-ds-accent transition-all">
                            <option value="cuti" {{ $leave->type == 'cuti' ? 'selected' : '' }}>🏖️ Cuti</option>
                            <option value="izin" {{ $leave->type == 'izin' ? 'selected' : '' }}>📋 Izin</option>
                            <option value="sakit" {{ $leave->type == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                        </select>
                    </div>

                    <div class="flex gap-3 justify-end mt-6">
                        <button type="button" onclick="closeModal('editCategoryModal-{{ $leave->id }}')" class="px-5 py-2.5 text-sm font-bold text-on-surface-variant dark:text-[#8B93A8] bg-surface dark:bg-[#1A2440] hover:bg-surface-variant dark:hover:bg-[#2A3654] rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-ds-accent dark:text-[#0B1220] hover:bg-slate-800 dark:hover:bg-amber-400 rounded-xl transition-colors shadow-sm">
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-red-50/50 dark:bg-red-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined">block</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-lg">Tolak Pengajuan</h3>
                        <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $leave->employee->name }} — {{ ucfirst($leave->type) }}</p>
                    </div>
                </div>
                <button onclick="closeModal('rejectModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-[#0F172E]">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <form action="{{ route('leave-requests.reject', $leave->id) }}" method="POST" class="p-6">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-on-surface dark:text-[#E8E6E0] mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="rejected_reason" required rows="3" placeholder="Jelaskan alasan penolakan..." class="w-full px-4 py-3 bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/60 dark:border-[#2A3654] rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all text-on-surface dark:text-white text-sm resize-none"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('rejectModal-{{ $leave->id }}')" class="px-5 py-2.5 rounded-lg font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-red-500 hover:bg-red-600 text-white font-medium shadow-sm transition-all active:scale-95">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div id="detailModal-{{ $leave->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-lg rounded-2xl shadow-xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined">info</span>
                    </div>
                    <h3 class="font-bold text-on-surface dark:text-white text-lg">Detail Pengajuan</h3>
                </div>
                <button onclick="closeModal('detailModal-{{ $leave->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-[#0F172E]">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Pegawai</p>
                        <p class="text-sm font-medium text-on-surface dark:text-[#E8E6E0]">{{ $leave->employee->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider font-bold text-on-surface-variant dark:text-[#8B93A8] mb-1">Jenis</p>
                        <p class="text-sm font-medium text-on-surface dark:text-[#E8E6E0]">{{ ucfirst($leave->type) }}</p>
                    </div>
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
