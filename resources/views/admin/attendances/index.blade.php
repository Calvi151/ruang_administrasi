@extends('admin.layouts.app')

@section('title', 'Laporan Absensi Harian - Ruang Administrasi')
@section('page-title', 'Laporan Absensi')
@section('page-subtitle', 'Rekapitulasi & interaksi absensi harian pegawai')

@section('styles')
<style>
    /* Micro-animations & Smooth UX */
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
    
    <!-- 1. KONSEP BARU: Widget Statistik Interaktif -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total Hadir -->
        <div class="glass-card rounded-2xl p-6 border border-outline-variant/40 dark:border-[#2A3654] shadow-sm flex items-center justify-between group hover:border-[#2563eb] transition-colors cursor-default animate-fade-in" style="animation-delay: 100ms;">
            <div>
                <p class="text-sm font-medium text-on-surface-variant dark:text-[#8B93A8] mb-1">Hadir Hari Ini</p>
                <h3 class="text-3xl font-bold text-on-surface dark:text-[#E8E6E0]">{{ $stats['total_today'] ?? 0 }} <span class="text-sm font-normal text-on-surface-variant">pegawai</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">how_to_reg</span>
            </div>
        </div>
        
        <!-- Card 2: Terlambat -->
        <div class="glass-card rounded-2xl p-6 border border-outline-variant/40 dark:border-[#2A3654] shadow-sm flex items-center justify-between group hover:border-red-500 transition-colors cursor-default animate-fade-in" style="animation-delay: 200ms;">
            <div>
                <p class="text-sm font-medium text-on-surface-variant dark:text-[#8B93A8] mb-1">Terlambat Masuk</p>
                <h3 class="text-3xl font-bold text-on-surface dark:text-[#E8E6E0]">{{ $stats['late_today'] ?? 0 }} <span class="text-sm font-normal text-on-surface-variant">pegawai</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">timer_off</span>
            </div>
        </div>
        
        <!-- Card 3: Anomali / Belum Pulang -->
        <div class="glass-card rounded-2xl p-6 border {{ request('missing_checkout') ? 'border-amber-500 bg-amber-500/5 dark:bg-amber-500/10' : 'border-outline-variant/40 dark:border-[#2A3654]' }} shadow-sm flex items-center justify-between group hover:border-amber-500 transition-colors cursor-pointer animate-fade-in" style="animation-delay: 300ms;" onclick="window.location.href='{{ route('attendances.index', array_merge(request()->query(), ['missing_checkout' => request('missing_checkout') ? null : 'true'])) }}'">
            <div>
                <p class="text-sm font-medium text-on-surface-variant dark:text-[#8B93A8] mb-1 flex items-center gap-2">Belum Pulang <span class="w-2 h-2 rounded-full bg-amber-500 pulse-dot"></span></p>
                <h3 class="text-3xl font-bold text-on-surface dark:text-[#E8E6E0]">{{ $stats['missing_checkout'] ?? 0 }} <span class="text-sm font-normal text-on-surface-variant">tindakan</span></h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-2xl">warning</span>
            </div>
        </div>
    </div>

    <!-- Page Header & Filters -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-6">
        <div>
            <h2 class="font-display-lg text-[24px] md:text-[28px] font-bold text-on-surface mb-1">Detail Absensi</h2>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <!-- Filter Interaktif -->
            <form action="{{ route('attendances.index') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-white dark:bg-[#141C33] p-1.5 rounded-xl border border-outline-variant/60 dark:border-[#2A3654] shadow-sm">
                
                <select name="employee_id" class="px-3 py-1.5 bg-transparent border-none text-sm font-medium text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer">
                    <option value="">Semua Karyawan</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{ request('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->name }}</option>
                    @endforeach
                </select>
                
                <div class="w-px h-5 bg-outline-variant/40 dark:bg-[#2A3654]"></div>
                
                <input type="month" name="month" value="{{ request('month') }}" class="px-3 py-1.5 bg-transparent border-none text-sm font-medium text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer" title="Bulan Absensi">
                
                <div class="w-px h-5 bg-outline-variant/40 dark:bg-[#2A3654]"></div>
                
                <select name="status" class="px-3 py-1.5 bg-transparent border-none text-sm font-medium text-on-surface dark:text-[#E8E6E0] focus:ring-0 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="on_time" {{ request('status') == 'on_time' ? 'selected' : '' }}>Tepat Waktu</option>
                    <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Terlambat</option>
                </select>
                
                <button type="submit" class="bg-primary/10 hover:bg-primary text-primary hover:text-white dark:bg-ds-accent/10 dark:hover:bg-ds-accent dark:text-ds-accent dark:hover:text-[#0B1220] px-3 py-1.5 rounded-lg font-bold text-xs transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">filter_list</span>
                    Filter
                </button>
                
                @if(request()->hasAny(['employee_id', 'month', 'status']))
                    <a href="{{ route('attendances.index') }}" class="px-3 py-1.5 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-lg font-bold transition-colors">Reset</a>
                @endif
            </form>
            
            <a href="{{ route('attendances.export', request()->query()) }}" class="bg-[#2563eb] hover:bg-[#1d4ed8] text-white px-4 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2 shadow-sm shadow-blue-500/30 active:scale-95 hover:shadow-blue-500/50">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Export Data
            </a>
        </div>
    </div>
    
    <!-- Data Table Card -->
    <div class="bg-white dark:bg-[#141C33] rounded-xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm overflow-visible animate-fade-in" style="animation-delay: 400ms;">
        <!-- Table Header -->
        <div class="grid grid-cols-12 gap-4 px-6 py-4 border-b border-outline-variant/30 dark:border-[#2A3654] bg-slate-50/50 dark:bg-[#0F172E]/50 items-center text-[11px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider">
            <div class="col-span-3">Pegawai</div>
            <div class="col-span-2">Tanggal</div>
            <div class="col-span-2 text-center">Masuk</div>
            <div class="col-span-1 text-center">Pulang</div>
            <div class="col-span-2 text-center">Status</div>
            <div class="col-span-1 text-center">Bukti</div>
            <div class="col-span-1 text-right">Aksi</div>
        </div>
        
        <!-- Table Body -->
        <div class="flex flex-col divide-y divide-outline-variant/20 dark:divide-[#2A3654]">
            @forelse($attendances as $attendance)
                <div class="interactive-row grid grid-cols-12 gap-4 px-6 py-4 items-center bg-white dark:bg-[#141C33] rounded-lg m-1 animate-slide-in" style="animation-delay: {{ 500 + ($loop->index * 50) }}ms;">
                    <!-- Employee -->
                    <div class="col-span-3 flex items-center gap-3">
                        @if($attendance->employee->photo)
                            <img src="{{ asset('storage/' . $attendance->employee->photo) }}" alt="Photo" class="w-10 h-10 rounded-full border-2 border-white dark:border-[#2A3654] shadow-sm object-cover shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#091426] to-[#1e293b] dark:from-[#2A3654] dark:to-[#141C33] shadow-sm text-white flex items-center justify-center font-bold text-sm shrink-0 border border-outline-variant/30">
                                {{ strtoupper(substr($attendance->employee->name ?? '?', 0, 2)) }}
                            </div>
                        @endif
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm font-semibold text-on-surface dark:text-[#E8E6E0] truncate">{{ $attendance->employee->name ?? 'Unknown' }}</span>
                            <span class="text-[11px] text-on-surface-variant dark:text-[#8B93A8] font-mono mt-0.5">{{ $attendance->employee->nip ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <!-- Date -->
                    <div class="col-span-2 text-sm text-on-surface-variant dark:text-[#8B93A8]">
                        {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y') }}
                    </div>
                    
                    <!-- Time In -->
                    <div class="col-span-2 text-center">
                        @if($attendance->check_in_time)
                            <span class="inline-block font-mono font-bold text-[#2563eb] dark:text-[#60a5fa] bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-md border border-blue-100 dark:border-blue-800/50">{{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}</span>
                        @else
                            <span class="font-mono text-outline font-light">-</span>
                        @endif
                    </div>
                    
                    <!-- Time Out -->
                    <div class="col-span-1 text-center">
                        @if($attendance->check_out_time)
                            <span class="inline-block font-mono font-bold text-[#059669] dark:text-[#34d399] bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-md border border-emerald-100 dark:border-emerald-800/50">{{ \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') }}</span>
                        @else
                            <span class="font-mono text-outline font-light">-</span>
                        @endif
                    </div>
                    
                    <!-- Status -->
                    <div class="col-span-2 flex justify-center">
                        @if(!$attendance->check_out_time)
                            <!-- Gantung / Belum Pulang -->
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-100/50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold border border-amber-200 dark:border-amber-700/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 pulse-dot"></span>
                                Belum Pulang
                            </div>
                        @elseif($attendance->check_in_status == 'late')
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-bold border border-red-200 dark:border-red-800/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                Terlambat
                            </div>
                        @else
                            <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-xs font-bold border border-emerald-200 dark:border-emerald-800/50">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Tepat Waktu
                            </div>
                        @endif
                    </div>
                    
                    <!-- Proof Chips (Interactive Modals) -->
                    <div class="col-span-1 flex justify-center gap-2">
                        <!-- Photo Button -->
                        <button onclick="openModal('photoModal-{{ $attendance->id }}')" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-[#0F172E] hover:bg-[#2563eb] hover:text-white dark:hover:bg-[#2563eb] border border-outline-variant/30 dark:border-[#2A3654] flex items-center justify-center text-on-surface-variant dark:text-[#8B93A8] transition-all transform hover:scale-110 hover:rotate-3 shadow-sm tooltip" title="Lihat Foto">
                            <span class="material-symbols-outlined text-[16px]">photo_camera</span>
                        </button>
                        
                        <!-- Map Button -->
                        <button onclick="openModal('mapModal-{{ $attendance->id }}')" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-[#0F172E] hover:bg-[#059669] hover:text-white dark:hover:bg-[#059669] border border-outline-variant/30 dark:border-[#2A3654] flex items-center justify-center text-on-surface-variant dark:text-[#8B93A8] transition-all transform hover:scale-110 hover:-rotate-3 shadow-sm tooltip" title="Lihat Lokasi">
                            <span class="material-symbols-outlined text-[16px]">location_on</span>
                        </button>
                    </div>
                    
                    <!-- Action -->
                    <div class="col-span-1 flex justify-end">
                        @if(!$attendance->check_out_time)
                            <!-- Tombol Edit Cepat (Interaktif) -->
                            <button onclick="openModal('editModal-{{ $attendance->id }}')" class="px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/20 dark:hover:bg-amber-900/40 text-amber-700 dark:text-amber-400 font-semibold text-xs border border-amber-200 dark:border-amber-700/50 transition-all flex items-center gap-1 active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">pending_actions</span>
                                Edit
                            </button>
                        @else
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown('dropdown-{{ $attendance->id }}', event)" class="w-8 h-8 rounded-full hover:bg-slate-100 dark:hover:bg-[#1D2847] flex items-center justify-center text-outline dark:text-[#8B93A8] hover:text-[#091426] dark:hover:text-white transition-colors focus:outline-none">
                                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                </button>
                                <!-- Dropdown Menu -->
                                <div id="dropdown-{{ $attendance->id }}" class="action-dropdown hidden absolute right-0 mt-1 w-40 bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] rounded-xl shadow-lg z-[60] py-1 overflow-hidden transform transition-all origin-top-right">
                                    <button onclick="alert('Fitur Detail sedang dikembangkan')" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-on-surface dark:text-[#E8E6E0] hover:bg-slate-50 dark:hover:bg-[#1D2847] flex items-center gap-2 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                        Lihat Detail
                                    </button>
                                    <button onclick="alert('Fitur Edit Data sedang dikembangkan')" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-on-surface dark:text-[#E8E6E0] hover:bg-slate-50 dark:hover:bg-[#1D2847] flex items-center gap-2 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">edit_note</span>
                                        Edit Data
                                    </button>
                                    <div class="border-t border-outline-variant/20 dark:border-[#2A3654] my-1"></div>
                                    <button type="button" onclick="openModal('deleteModal-{{ $attendance->id }}')" class="w-full text-left px-4 py-2.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center gap-2 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- MODALS FOR THIS ROW (Rendered out of flow) -->
                
                {{-- Delete Modal --}}
                <div id="deleteModal-{{ $attendance->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
                        <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-red-50/50 dark:bg-red-900/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                                    <span class="material-symbols-outlined">delete_forever</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-on-surface dark:text-white text-lg">Hapus Riwayat Absensi</h3>
                                    <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $attendance->employee->name ?? '-' }}</p>
                                </div>
                            </div>
                            <button type="button" onclick="closeModal('deleteModal-{{ $attendance->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-surface-container-low dark:hover:bg-[#0F172E]">
                                <span class="material-symbols-outlined text-xl">close</span>
                            </button>
                        </div>
                        <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="p-6">
                            @csrf
                            @method('DELETE')
                            <div class="mb-6">
                                <p class="text-sm text-on-surface dark:text-[#E8E6E0]">Apakah Anda yakin ingin menghapus riwayat absensi ini secara permanen? Data yang dihapus tidak dapat dikembalikan.</p>
                            </div>
                            <div class="flex justify-end gap-3 pt-2">
                                <button type="button" onclick="closeModal('deleteModal-{{ $attendance->id }}')" class="px-5 py-2.5 rounded-xl font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold shadow-lg shadow-red-500/30 transition-all active:scale-95">Ya, Hapus Data</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Photo Modal -->
                <div id="photoModal-{{ $attendance->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
                        <div class="flex justify-between items-center p-4 border-b border-outline-variant/20 dark:border-[#2A3654]">
                            <h3 class="font-bold text-on-surface dark:text-white">Bukti Foto Masuk</h3>
                            <button onclick="closeModal('photoModal-{{ $attendance->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-surface-container-low dark:hover:bg-[#0F172E]">
                                <span class="material-symbols-outlined text-xl">close</span>
                            </button>
                        </div>
                        <div class="p-4 flex flex-col items-center bg-slate-50 dark:bg-[#0B1220]">
                            @if($attendance->check_in_photo)
                                <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Foto Absen" class="w-full max-h-64 object-cover rounded-xl shadow-inner border border-outline-variant/20 dark:border-[#2A3654]">
                            @else
                                <div class="w-full h-48 flex flex-col items-center justify-center border-2 border-dashed border-outline-variant/50 dark:border-[#2A3654] rounded-xl text-outline dark:text-[#5D6A85]">
                                    <span class="material-symbols-outlined text-4xl mb-2 opacity-50">no_photography</span>
                                    <span class="text-sm">Tidak ada foto terekam</span>
                                </div>
                            @endif
                            <p class="text-xs text-on-surface-variant dark:text-[#8B93A8] mt-4 font-mono">Timestamp: {{ $attendance->check_in_time ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Edit Jam Pulang Modal -->
                <div id="editModal-{{ $attendance->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
                        <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-amber-50/50 dark:bg-amber-900/10">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                                    <span class="material-symbols-outlined">pending_actions</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-on-surface dark:text-white text-lg">Input Jam Pulang Manual</h3>
                                    <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $attendance->employee->name }}</p>
                                </div>
                            </div>
                            <button onclick="closeModal('editModal-{{ $attendance->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-surface-container-low dark:hover:bg-[#0F172E]">
                                <span class="material-symbols-outlined text-xl">close</span>
                            </button>
                        </div>
                        <form action="#" method="POST" class="p-6" onsubmit="event.preventDefault(); alert('Demo: Data jam pulang berhasil disimpan secara instan via API!'); closeModal('editModal-{{ $attendance->id }}');">
                            @csrf
                            @method('PUT')
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-on-surface dark:text-[#E8E6E0] mb-2">Pilih Jam Pulang</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">schedule</span>
                                    <input type="time" name="check_out_time" value="16:00" required class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/60 dark:border-[#2A3654] rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all text-on-surface dark:text-white font-mono text-lg">
                                </div>
                                <p class="text-xs text-on-surface-variant dark:text-[#5D6A85] mt-2 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">info</span>
                                    Tindakan ini akan mem-bypass validasi lokasi dan foto.
                                </p>
                            </div>
                            <div class="flex justify-end gap-3 pt-2">
                                <button type="button" onclick="closeModal('editModal-{{ $attendance->id }}')" class="px-5 py-2.5 rounded-xl font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold shadow-lg shadow-amber-500/30 transition-all active:scale-95">Simpan Jam</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Modals -->

            @empty
                <div class="px-6 py-16 flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 bg-blue-50 dark:bg-blue-900/10 rounded-full flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-5xl text-blue-300 dark:text-blue-500/50">event_available</span>
                    </div>
                    <h3 class="font-bold text-lg text-on-surface dark:text-[#E8E6E0] mb-1">Rekap Kosong</h3>
                    <p class="text-on-surface-variant dark:text-[#8B93A8] max-w-sm">Belum ada pegawai yang melakukan absensi pada rentang tanggal ini.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($attendances->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/30 dark:border-[#2A3654] bg-[#f8f9ff] dark:bg-[#0F172E]">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Vanilla JS Modal Controller for maximum performance and zero dependencies
    function openModal(id) {
        const modal = document.getElementById(id);
        if(modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden'; // prevent background scrolling
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if(modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Close modal when clicking outside the box
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
            // Close all dropdowns
            document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        }
    });

    // Dropdown Controller
    function toggleDropdown(id, event) {
        event.stopPropagation();
        const dropdown = document.getElementById(id);
        const isHidden = dropdown.classList.contains('hidden');
        
        // Hide all other dropdowns first
        document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        
        // Toggle the clicked one
        if (isHidden) {
            dropdown.classList.remove('hidden');
        }
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.action-dropdown') && !e.target.closest('button[onclick^="toggleDropdown"]')) {
            document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
        }
    });
</script>
@endsection
