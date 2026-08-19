@extends('admin.layouts.app')

@section('title', 'Laporan Absensi - Ruang Administrasi')
@section('page-title', 'Laporan Absensi')
@section('page-subtitle', 'Rekapitulasi dan log kehadiran harian pegawai')

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

    .pulse-dot {
        animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }
    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(234, 179, 8, 0); }
        100% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0); }
    }
</style>
@endsection

@section('content')
<div class="max-w-[1440px] mx-auto w-full">

    {{-- 1. STAT CARDS (Project 1 Modern Redesign with Rich Vibrant Dark Mode) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total Kehadiran -->
        <div class="bg-gradient-to-br from-amber-50/80 via-white to-white dark:from-amber-950/40 dark:via-[#141C33] dark:to-[#141C33] border border-amber-200/70 dark:border-amber-500/30 rounded-xl p-5 shadow-sm border-t-4 border-t-amber-500 dark:border-t-amber-400 relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-amber-900/70 dark:text-amber-400/80 uppercase tracking-wider mb-1 font-bold">Total Kehadiran Hari Ini</p>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-amber-600 dark:text-amber-400 m-0">{{ $stats['total_today'] ?? 0 }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-500/40 shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">how_to_reg</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-amber-200/40 dark:border-amber-500/20">
                <span class="text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-300 dark:border dark:border-emerald-500/30 px-2 py-0.5 rounded font-bold flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span>
                    Aktif
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Pegawai tercatat hadir</span>
            </div>
        </div>

        <!-- Card 2: Terlambat -->
        <div class="bg-gradient-to-br from-red-50/80 via-white to-white dark:from-red-950/40 dark:via-[#141C33] dark:to-[#141C33] border border-red-200/70 dark:border-red-500/30 rounded-xl p-5 shadow-sm border-t-4 border-t-red-500 dark:border-t-red-400 relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-red-900/70 dark:text-red-400/80 uppercase tracking-wider mb-1 font-bold">Terlambat Masuk</p>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-red-600 dark:text-red-400 m-0">{{ $stats['late_today'] ?? 0 }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-red-600 dark:text-red-400 border border-red-200 dark:border-red-500/40 shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">schedule</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-red-200/40 dark:border-red-500/20">
                <span class="text-xs bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-300 dark:border dark:border-red-500/30 px-2 py-0.5 rounded font-bold flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">warning</span>
                    Perlu Evaluasi
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Melewati jam masuk</span>
            </div>
        </div>

        <!-- Card 3: Belum Pulang -->
        <div class="bg-gradient-to-br from-amber-50/80 via-white to-white dark:from-amber-950/40 dark:via-[#141C33] dark:to-[#141C33] border {{ request('missing_checkout') ? 'border-amber-500 ring-2 ring-amber-500/30' : 'border-amber-200/70 dark:border-amber-500/30' }} rounded-xl p-5 shadow-sm border-t-4 border-t-amber-500 dark:border-t-amber-400 relative overflow-hidden flex flex-col justify-between group hover:shadow-md transition-all cursor-pointer" onclick="window.location.href='{{ route('attendances.index', array_merge(request()->query(), ['missing_checkout' => request('missing_checkout') ? null : 'true'])) }}'">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs text-amber-900/70 dark:text-amber-400/80 uppercase tracking-wider mb-1 font-bold flex items-center gap-1.5">
                        Belum Pulang 
                        <span class="w-2 h-2 rounded-full bg-amber-500 pulse-dot"></span>
                    </p>
                    <h3 class="text-3xl md:text-4xl font-extrabold text-amber-600 dark:text-amber-400 m-0">{{ $stats['missing_checkout'] ?? 0 }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-500/40 shadow-sm">
                    <span class="material-symbols-outlined text-[22px]">pending_actions</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mt-auto pt-3 border-t border-amber-200/40 dark:border-amber-500/20">
                <span class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-300 dark:border dark:border-amber-500/30 px-2 py-0.5 rounded font-bold">
                    {{ request('missing_checkout') ? 'Filter Aktif' : 'Klik untuk filter' }}
                </span>
                <span class="text-xs text-slate-500 dark:text-slate-400">Belum absen keluar</span>
            </div>
        </div>
    </div>

    {{-- 2. FILTER ROW & ACTIONS --}}
    <div class="flex justify-between items-center mb-6 gap-4 flex-wrap">
        <form action="{{ route('attendances.index') }}" method="GET" class="flex items-center gap-3 flex-wrap">
            {{-- Karyawan Dropdown --}}
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
                    <option value="on_time" {{ request('status') == 'on_time' ? 'selected' : '' }} class="dark:bg-[#141C33]">Tepat Waktu</option>
                    <option value="late" {{ request('status') == 'late' ? 'selected' : '' }} class="dark:bg-[#141C33]">Terlambat</option>
                </select>
            </div>

            @if(request()->hasAny(['employee_id', 'month', 'status', 'missing_checkout']))
                <a href="{{ route('attendances.index') }}" class="text-xs font-bold text-red-500 hover:underline px-2 py-1">Reset Filter</a>
            @endif
        </form>

        <a href="{{ route('attendances.export', request()->query()) }}" class="bg-primary-container text-white dark:bg-primary-fixed dark:text-on-primary-fixed font-label-md text-xs md:text-sm px-5 py-2.5 rounded-lg hover:bg-primary-container/90 transition-all flex items-center gap-2 shadow-sm active:scale-95 shrink-0">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Unduh Laporan
        </a>
    </div>

    {{-- 3. MAIN TABLE CARD (Project 1 Design) --}}
    <div class="bg-surface-container-lowest dark:bg-ds-surface border border-outline-variant/60 dark:border-ds-border rounded-xl shadow-level-2 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-outline-variant/40 dark:border-ds-border flex justify-between items-center bg-surface-container-low/30 dark:bg-white/5">
            <h3 class="font-headline-sm text-base md:text-lg font-bold text-primary dark:text-white m-0">Log Kehadiran Pegawai</h3>
            <span class="text-xs text-on-surface-variant dark:text-slate-400 font-medium">Total: {{ $attendances->total() }} record</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low/60 dark:bg-black/20 border-b border-outline-variant/40 dark:border-ds-border text-on-surface-variant dark:text-slate-400 font-label-md text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Nama Karyawan</th>
                        <th class="px-6 py-4 font-semibold">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-center">Jam Masuk</th>
                        <th class="px-6 py-4 font-semibold text-center">Jam Keluar</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/20 dark:divide-ds-border">
                    @forelse($attendances as $attendance)
                        <tr class="hover:bg-surface-container/50 dark:hover:bg-white/5 transition-colors cursor-pointer" onclick="openModal('editModal-{{ $attendance->id }}')">
                            {{-- Nama Karyawan --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($attendance->employee && $attendance->employee->photo)
                                        <img src="{{ asset('storage/' . $attendance->employee->photo) }}" alt="Photo" class="w-8 h-8 rounded-full border border-outline-variant/40 object-cover shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-primary-fixed dark:bg-blue-900/40 text-primary-container dark:text-blue-300 flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($attendance->employee->name ?? '?', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-medium text-sm text-on-surface dark:text-ds-text-primary truncate">{{ $attendance->employee->name ?? 'Unknown' }}</span>
                                        <span class="text-xs text-on-surface-variant dark:text-slate-400">{{ $attendance->employee->nip ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-4 text-on-surface-variant dark:text-slate-300 text-xs md:text-sm whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y') }}
                            </td>

                            {{-- Jam Masuk --}}
                            <td class="px-6 py-4 text-center font-medium text-xs md:text-sm">
                                @if($attendance->check_in_time)
                                    <span class="font-mono {{ $attendance->check_in_status == 'late' ? 'text-red-600 dark:text-red-400 font-semibold' : 'text-slate-700 dark:text-slate-200' }}">
                                        {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}
                                    </span>
                                @else
                                    <span class="text-outline">-</span>
                                @endif
                            </td>

                            {{-- Jam Keluar --}}
                            <td class="px-6 py-4 text-center text-xs md:text-sm">
                                @if($attendance->check_out_time)
                                    <span class="font-mono font-medium text-slate-700 dark:text-slate-200">
                                        {{ \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') }}
                                    </span>
                                @else
                                    <span class="text-outline">-</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                @if(!$attendance->check_out_time)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 border border-amber-200 dark:border-amber-800/50">
                                        Belum Pulang
                                    </span>
                                @elseif($attendance->check_in_status == 'late')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border border-red-200 dark:border-red-800/50">
                                        Terlambat
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 border border-green-200 dark:border-green-800/50">
                                        Tepat Waktu
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5" onclick="event.stopPropagation()">
                                    @if($attendance->check_in_photo)
                                        <button onclick="openModal('photoModal-{{ $attendance->id }}')" class="p-1.5 rounded-lg hover:bg-surface-container-high dark:hover:bg-white/10 text-on-surface-variant dark:text-slate-300 transition-colors" title="Lihat Foto Bukti">
                                            <span class="material-symbols-outlined text-[18px]">photo_camera</span>
                                        </button>
                                    @endif
                                    <button onclick="openModal('editModal-{{ $attendance->id }}')" class="p-1.5 rounded-lg hover:bg-surface-container-high dark:hover:bg-white/10 text-on-surface-variant dark:text-slate-300 transition-colors" title="Input Jam Pulang">
                                        <span class="material-symbols-outlined text-[18px]">edit_calendar</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">event_available</span>
                                    <h3 class="font-medium text-sm text-slate-900 dark:text-slate-200">Belum Ada Data Absensi</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Tidak ada rekaman kehadiran pegawai pada filter yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($attendances->hasPages())
        <div class="px-6 py-3 border-t border-outline-variant/40 dark:border-ds-border flex justify-between items-center bg-surface-container-low/40 dark:bg-white/5">
            {{ $attendances->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

{{-- Modals Container --}}
@foreach($attendances as $attendance)
    <!-- Photo Modal -->
    <div id="photoModal-{{ $attendance->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-sm rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-4 border-b border-outline-variant/40 dark:border-ds-border">
                <h3 class="font-bold text-on-surface dark:text-white text-sm">Bukti Foto Masuk</h3>
                <button onclick="closeModal('photoModal-{{ $attendance->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <div class="p-4 flex flex-col items-center bg-surface-container-low/30 dark:bg-black/20">
                @if($attendance->check_in_photo)
                    <img src="{{ asset('storage/' . $attendance->check_in_photo) }}" alt="Foto Absen" class="w-full max-h-64 object-cover rounded-lg border border-outline-variant/30">
                @else
                    <div class="w-full h-48 flex flex-col items-center justify-center border-2 border-dashed border-outline-variant/50 rounded-lg text-outline">
                        <span class="material-symbols-outlined text-4xl mb-2 opacity-50">no_photography</span>
                        <span class="text-sm">Tidak ada foto terekam</span>
                    </div>
                @endif
                <p class="text-xs text-on-surface-variant dark:text-slate-400 mt-3 font-mono">Waktu Absen: {{ $attendance->check_in_time ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Edit Jam Pulang Modal -->
    <div id="editModal-{{ $attendance->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-surface-container-lowest dark:bg-ds-surface w-full max-w-md rounded-xl shadow-xl overflow-hidden border border-outline-variant/40 dark:border-ds-border">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/40 dark:border-ds-border bg-amber-50/50 dark:bg-amber-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-base">Input Jam Pulang Manual</h3>
                        <p class="text-xs text-on-surface-variant dark:text-slate-400">{{ $attendance->employee->name ?? 'Pegawai' }}</p>
                    </div>
                </div>
                <button onclick="closeModal('editModal-{{ $attendance->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-slate-100 dark:hover:bg-white/10">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <form action="#" method="POST" class="p-6" onsubmit="event.preventDefault(); alert('Demo: Data jam pulang berhasil disimpan!'); closeModal('editModal-{{ $attendance->id }}');">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label class="block text-xs font-bold text-on-surface dark:text-white mb-2 uppercase tracking-wider">Pilih Jam Pulang</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">schedule</span>
                        <input type="time" name="check_out_time" value="16:00" required class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low/40 dark:bg-black/20 border border-outline-variant/60 dark:border-ds-border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all text-on-surface dark:text-white font-mono text-base">
                    </div>
                    <p class="text-xs text-on-surface-variant dark:text-slate-400 mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">info</span>
                        Tindakan ini akan mencatat waktu checkout manual.
                    </p>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('editModal-{{ $attendance->id }}')" class="px-4 py-2 rounded-lg font-semibold text-xs text-on-surface-variant dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-sm transition-all active:scale-95">Simpan Jam</button>
                </div>
            </form>
        </div>
    </div>
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
        }
    });
</script>
@endsection

