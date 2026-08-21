@extends('admin.layouts.app')

@section('title', 'Ruang Administrasi - Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Header Section (Editorial Greeting) -->
<section class="flex flex-col md:flex-row justify-between items-start md:items-end gap-component-gap">
    <div>
        <h2 class="font-display-lg text-display-lg text-primary dark:text-ds-text-primary tracking-tight">Selamat {{ now()->hour < 10 ? 'pagi' : (now()->hour < 14 ? 'siang' : (now()->hour < 18 ? 'sore' : 'malam')) }}, {{ Auth::user()->employee->name ?? 'Admin' }}.</h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant dark:text-ds-text-secondary mt-4 max-w-2xl">Ringkasan aktivitas persuratan dan kegiatan anda hari ini. Pastikan untuk meninjau dokumen yang memerlukan persetujuan segera.</p>
    </div>
    <!-- Summary Card -->
    @if($outgoingPending > 0)
    <div class="editorial-card p-6 rounded-lg flex items-start gap-4 max-w-sm w-full">
        <div class="w-10 h-10 rounded bg-secondary-fixed/20 dark:bg-ds-accent/20 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-secondary dark:text-ds-accent">priority_high</span>
        </div>
        <div>
            <span class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-wider block mb-1">Perhatian Diperlukan</span>
            <p class="font-body-md text-body-md text-primary dark:text-ds-text-primary font-medium">Ada <span class="font-bold text-secondary dark:text-ds-accent">{{ $outgoingPending }} surat</span> yang memerlukan perhatian Anda hari ini.</p>
        </div>
    </div>
    @endif
</section>

<!-- Stats Row (Asymmetric 12-column Grid) -->
<section class="grid grid-cols-1 md:grid-cols-12 gap-component-gap">
    <!-- Hero Card: Menunggu Approval (col-span-5) -->
    <div class="md:col-span-5 editorial-card p-8 rounded-xl flex items-center justify-between relative overflow-hidden group hover:border-[#D9A441] dark:hover:border-ds-accent transition-colors">
        <div class="z-10 relative">
            <h3 class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-wider mb-4">Menunggu Approval</h3>
            <div class="flex items-baseline gap-2">
                <span class="font-display-lg text-[64px] leading-none font-bold text-primary dark:text-ds-text-primary">{{ $outgoingPending }}</span>
                <span class="font-body-md text-body-md text-on-surface-variant dark:text-ds-text-secondary">Dokumen</span>
            </div>
            <a href="{{ route('outgoing-letters.index') }}" class="mt-8 bg-primary dark:bg-ds-bg text-on-primary dark:text-ds-text-primary dark:border dark:border-ds-border px-6 py-2 rounded font-label-md text-label-md hover:bg-primary/90 dark:hover:bg-ds-hover transition-colors inline-flex items-center gap-2">
                Tinjau Sekarang
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
        <!-- Progress Ring -->
        @php
            $totalProcessed = $outgoingAcc + $outgoingPending + $outgoingReject;
            $completionPct = $totalProcessed > 0 ? round(($outgoingAcc / $totalProcessed) * 100) : 0;
            $circumference = 2 * 3.14159 * 45;
            $dashoffset = $circumference - ($circumference * $completionPct / 100);
        @endphp
        <div class="relative w-40 h-40 z-10 flex items-center justify-center">
            <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                <circle cx="50" cy="50" fill="none" r="45" stroke="currentColor" class="text-surface-container-low dark:text-ds-border" stroke-width="8"></circle>
                <circle class="transition-all duration-1000 ease-out" cx="50" cy="50" fill="none" r="45" stroke="#D9A441" stroke-dasharray="{{ round($circumference) }}" stroke-dashoffset="{{ round($dashoffset) }}" stroke-width="8" stroke-linecap="round"></circle>
            </svg>
            <div class="absolute flex flex-col items-center">
                <span class="font-headline-md text-headline-md font-bold text-primary dark:text-ds-text-primary">{{ $completionPct }}%</span>
                <span class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary text-[10px]">Terselesaikan</span>
            </div>
        </div>
        <!-- Glow effect -->
        <div class="absolute right-0 top-0 w-64 h-64 bg-secondary-fixed/10 dark:bg-ds-accent/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
    </div>

    <!-- Secondary Stats (col-span-7, 3 columns) -->
    <div class="md:col-span-7 grid grid-cols-1 sm:grid-cols-3 gap-component-gap">
        <!-- Surat Masuk -->
        <a href="{{ route('incoming-letters.index') }}" class="editorial-card stat-card p-6 rounded-lg flex flex-col justify-between cursor-pointer group">
            <div class="flex justify-between items-start mb-6">
                <h3 class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-wider">Surat Masuk</h3>
                <span class="material-symbols-outlined text-outline dark:text-ds-text-secondary stat-icon">mail</span>
            </div>
            <div>
                <span class="font-display-lg text-4xl font-bold text-primary dark:text-ds-text-primary stat-number">{{ $totalIncoming }}</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-2">Total masuk</p>
            </div>
        </a>
        <!-- Surat Keluar -->
        <a href="{{ route('outgoing-letters.index') }}" class="editorial-card stat-card p-6 rounded-lg flex flex-col justify-between cursor-pointer group">
            <div class="flex justify-between items-start mb-6">
                <h3 class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-wider">Surat Keluar</h3>
                <span class="material-symbols-outlined text-outline dark:text-ds-text-secondary stat-icon">send</span>
            </div>
            <div>
                <span class="font-display-lg text-4xl font-bold text-primary dark:text-ds-text-primary stat-number">{{ $totalOutgoing }}</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-2">Total keluar</p>
            </div>
        </a>
        <!-- Karyawan Aktif -->
        <a href="{{ route('employees.index') }}" class="editorial-card stat-card p-6 rounded-lg flex flex-col justify-between cursor-pointer group">
            <div class="flex justify-between items-start mb-6">
                <h3 class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-wider">Karyawan Aktif</h3>
                <span class="material-symbols-outlined text-outline dark:text-ds-text-secondary stat-icon">person</span>
            </div>
            <div>
                <span class="font-display-lg text-4xl font-bold text-primary dark:text-ds-text-primary stat-number">{{ $totalEmployees }}</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-2">Staf terdaftar</p>
            </div>
        </a>
    </div>
</section>

<!-- HR Summary Cards -->
<section class="mb-8">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-on-surface-variant dark:text-ds-text-secondary">group</span>
        <h3 class="font-headline-sm text-headline-sm text-primary dark:text-ds-text-primary">Ringkasan SDM</h3>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-component-gap">
        <!-- Absensi -->
        <a href="{{ route('attendances.index') }}" class="editorial-card rounded-xl p-5 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/30 dark:to-[#141C33] border border-emerald-200/60 dark:border-[#2A3654] flex items-center justify-between shadow-sm cursor-pointer hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Hadir Hari Ini</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $attendanceToday }} <span class="text-sm font-normal text-slate-500">pegawai</span></h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-white/60 dark:bg-slate-800/80 flex items-center justify-center text-emerald-600 dark:text-emerald-500 border border-emerald-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-xl">how_to_reg</span>
            </div>
        </a>

        <!-- Cuti Pending -->
        <a href="{{ route('leave-requests.index') }}" class="editorial-card rounded-xl p-5 bg-gradient-to-br from-blue-50 to-white dark:from-blue-900/30 dark:to-[#141C33] border border-blue-200/60 dark:border-[#2A3654] flex items-center justify-between shadow-sm cursor-pointer hover:border-blue-300 dark:hover:border-blue-700 transition-colors">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Cuti Pending</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $leavePending }} <span class="text-sm font-normal text-slate-500">pengajuan</span></h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-white/60 dark:bg-slate-800/80 flex items-center justify-center text-blue-600 dark:text-blue-500 border border-blue-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-xl">beach_access</span>
            </div>
        </a>

        <!-- Lembur Pending -->
        <a href="{{ route('overtime-requests.index') }}" class="editorial-card rounded-xl p-5 bg-gradient-to-br from-amber-50 to-white dark:from-amber-900/30 dark:to-[#141C33] border border-amber-200/60 dark:border-[#2A3654] flex items-center justify-between shadow-sm cursor-pointer hover:border-amber-300 dark:hover:border-amber-700 transition-colors">
            <div>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1 uppercase tracking-wider">Lembur Pending</p>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $overtimePending }} <span class="text-sm font-normal text-slate-500">pengajuan</span></h3>
            </div>
            <div class="w-10 h-10 rounded-lg bg-white/60 dark:bg-slate-800/80 flex items-center justify-center text-amber-600 dark:text-amber-500 border border-amber-100 dark:border-slate-700">
                <span class="material-symbols-outlined text-xl">more_time</span>
            </div>
        </a>
    </div>
</section>

<!-- Tables Row (2 equal columns) -->
<section class="grid grid-cols-1 md:grid-cols-2 gap-component-gap">
    <!-- Surat Masuk Terbaru -->
    <div class="editorial-card rounded-xl overflow-hidden">
        <div class="p-6 border-b border-outline/10 dark:border-ds-border flex justify-between items-center">
            <h3 class="font-headline-sm text-headline-sm text-primary dark:text-ds-text-primary">Surat Masuk Terbaru</h3>
            <a href="{{ route('incoming-letters.index') }}" class="text-primary dark:text-ds-text-primary font-label-md text-label-md hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-low dark:bg-ds-bg">
                    <tr>
                        <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase">No Surat</th>
                        <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase">Pengirim</th>
                        <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase">Perihal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline/10 dark:divide-ds-border">
                    @forelse($recentIncoming as $letter)
                    <tr onclick="window.location='{{ route('incoming-letters.show', $letter->id) }}'" class="table-row-hover transition-colors cursor-pointer group hover:bg-blue-50/40 dark:hover:bg-white/5" title="Klik untuk membuka detail surat ini">
                        <td class="px-6 py-4 font-body-sm text-body-sm font-semibold text-[#0055CC] dark:text-ds-accent group-hover:underline">{{ $letter->letter_number }}</td>
                        <td class="px-6 py-4 font-body-sm text-body-sm font-medium text-on-surface dark:text-ds-text-primary uppercase">{{ $letter->sender }}</td>
                        <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary truncate max-w-[180px]">{{ Str::limit(strip_tags($letter->subject), 30) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center gap-2 text-on-surface-variant dark:text-ds-text-secondary">
                                <span class="material-symbols-outlined text-[40px] opacity-40">drafts</span>
                                <p class="font-body-sm text-body-sm">Belum ada surat masuk</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Surat Keluar Terbaru -->
    <div class="editorial-card rounded-xl overflow-hidden">
        <div class="p-6 border-b border-outline/10 dark:border-ds-border flex justify-between items-center">
            <h3 class="font-headline-sm text-headline-sm text-primary dark:text-ds-text-primary">Surat Keluar Terbaru</h3>
            <a href="{{ route('outgoing-letters.index') }}" class="text-primary dark:text-ds-text-primary font-label-md text-label-md hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface-container-low dark:bg-ds-bg">
                    <tr>
                        <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase">No Surat</th>
                        <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase">Penerima</th>
                        <th class="px-6 py-3 font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline/10 dark:divide-ds-border">
                    @forelse($recentOutgoing as $letter)
                    <tr onclick="window.location='{{ route('outgoing-letters.show', $letter->id) }}'" class="table-row-hover transition-colors cursor-pointer group hover:bg-blue-50/40 dark:hover:bg-white/5" title="Klik untuk membuka detail surat ini">
                        <td class="px-6 py-4 font-body-sm text-body-sm font-semibold text-[#0055CC] dark:text-ds-accent group-hover:underline">{{ $letter->letter_number }}</td>
                        <td class="px-6 py-4 font-body-sm text-body-sm font-medium text-on-surface dark:text-ds-text-primary uppercase">{{ $letter->recipient }}</td>
                        <td class="px-6 py-4">
                            @if($letter->status == 'acc')
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#2e7d32] dark:bg-[#4caf50]"></span>
                                    <span class="font-label-md text-label-md text-[#2e7d32] dark:text-[#4caf50]">Disetujui</span>
                                </div>
                            @elseif($letter->status == 'pending')
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-secondary dark:bg-ds-accent"></span>
                                    <span class="font-label-md text-label-md text-secondary dark:text-ds-accent">Menunggu</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-error"></span>
                                    <span class="font-label-md text-label-md text-error dark:text-[#ff7070]">Ditolak</span>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center gap-2 text-on-surface-variant dark:text-ds-text-secondary">
                                <span class="material-symbols-outlined text-[40px] opacity-40">send</span>
                                <p class="font-body-sm text-body-sm">Belum ada surat keluar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Charts Row (7:5 split) -->
<section class="grid grid-cols-1 md:grid-cols-12 gap-component-gap">
    <!-- Tren Volume Surat (col-span-7) -->
    <div class="md:col-span-7 editorial-card p-8 rounded-xl flex flex-col">
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-headline-sm text-headline-sm text-primary dark:text-ds-text-primary">Tren Volume Surat</h3>
            <div class="flex gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-primary dark:bg-ds-text-secondary"></span>
                    <span class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary">Masuk</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-secondary dark:bg-ds-accent"></span>
                    <span class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary">Keluar</span>
                </div>
            </div>
        </div>
        <div style="position:relative; height:260px;">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Kategori Surat (col-span-5) -->
    <div class="md:col-span-5 editorial-card p-8 rounded-xl flex flex-col">
        <h3 class="font-headline-sm text-headline-sm text-primary dark:text-ds-text-primary mb-8">Kategori Surat</h3>
        <div class="flex flex-col md:flex-row items-center gap-8">
            <!-- SVG Donut Chart -->
            @php
                $catTotal = $categoryData->sum('total');
                $catColors = ['#000210', '#7d5700', '#c6c6cf', '#3a4569', '#76869e'];
                $catColorsDark = ['#8B93A8', '#E5B04D', '#5D6A85', '#bac5f0', '#76869e'];
                $catCircumference = 2 * 3.14159 * 40;
                $catOffset = 0;
            @endphp
            <div class="relative w-48 h-48 shrink-0">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 100 100">
                    @if($catTotal > 0)
                        @foreach($categoryData as $i => $cat)
                            @php
                                $catPct = $cat->total / $catTotal;
                                $catDash = $catCircumference * $catPct;
                                $color = $catColors[$i % count($catColors)];
                            @endphp
                            <circle cx="50" cy="50" fill="none" r="40"
                                stroke="{{ $color }}"
                                stroke-dasharray="{{ round($catDash, 1) }} {{ round($catCircumference - $catDash, 1) }}"
                                stroke-dashoffset="{{ round(-$catOffset, 1) }}"
                                stroke-width="12"
                                class="transition-all duration-500"></circle>
                            @php $catOffset += $catDash; @endphp
                        @endforeach
                    @else
                        <circle cx="50" cy="50" fill="none" r="40" stroke="currentColor" class="text-outline-variant dark:text-ds-border" stroke-width="12"></circle>
                    @endif
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-headline-sm text-headline-sm text-primary dark:text-ds-text-primary">{{ $catTotal }}</span>
                    <span class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary">Total</span>
                </div>
            </div>
            <!-- Legend -->
            <div class="flex flex-col gap-4 flex-1">
                @foreach($categoryData as $i => $cat)
                @php
                    $color = $catColors[$i % count($catColors)];
                    $pct = $catTotal > 0 ? round(($cat->total / $catTotal) * 100) : 0;
                @endphp
                <div class="flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $color }}"></span>
                    <div class="flex flex-col">
                        <span class="font-body-sm font-semibold text-primary dark:text-ds-text-primary">{{ $cat->type_name }}</span>
                        <span class="font-label-md text-on-surface-variant dark:text-ds-text-secondary">{{ $cat->total }} Dokumen ({{ $pct }}%)</span>
                    </div>
                </div>
                @endforeach
                @if($categoryData->isEmpty())
                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary">Belum ada data kategori</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- HR Chart Row -->
<section class="mt-8 mb-8">
    <div class="editorial-card p-8 rounded-xl flex flex-col">
        <div class="flex justify-between items-center mb-8">
            <h3 class="font-headline-sm text-headline-sm text-primary dark:text-ds-text-primary">Aktivitas SDM: Cuti vs Lembur</h3>
            <div class="flex gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500 dark:bg-blue-400"></span>
                    <span class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary">Cuti/Izin</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-amber-500 dark:bg-amber-400"></span>
                    <span class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary">Lembur</span>
                </div>
            </div>
        </div>
        <div style="position:relative; height:260px;">
            <canvas id="hrChart"></canvas>
        </div>
    </div>
</section>
@endsection

@php
    $defaultMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
    $defaultZeros  = [0, 0, 0, 0, 0, 0];
    $jsonMonths    = json_encode(!empty($months) ? $months : $defaultMonths);
    $jsonIncoming  = json_encode(!empty($monthlyIncomingData) ? $monthlyIncomingData : $defaultZeros);
    $jsonOutgoing  = json_encode(!empty($monthlyOutgoingData) ? $monthlyOutgoingData : $defaultZeros);
    $jsonLeave     = json_encode(!empty($monthlyLeaveData) ? $monthlyLeaveData : $defaultZeros);
    $jsonOvertime  = json_encode(!empty($monthlyOvertimeData) ? $monthlyOvertimeData : $defaultZeros);
@endphp

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');

    // Color tokens
    const primaryLine = isDark ? '#8B93A8' : '#000210';
    const primaryArea = isDark ? 'rgba(139,147,168,0.1)' : 'rgba(0,2,16,0.08)';
    const secondaryLine = isDark ? '#E5B04D' : '#7d5700';
    const secondaryArea = isDark ? 'rgba(229,176,77,0.1)' : 'rgba(125,87,0,0.08)';
    const gridColor = isDark ? 'rgba(42,54,84,0.5)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#8B93A8' : '#45464e';

    // --- Realtime Monthly data from controller ---
    const displayMonths = {!! $jsonMonths !!};
    const incomingData = {!! $jsonIncoming !!};
    const outgoingData = {!! $jsonOutgoing !!};
    const leaveData = {!! $jsonLeave !!};
    const overtimeData = {!! $jsonOvertime !!};

    // --- Line Chart: Tren Volume Surat ---
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: displayMonths,
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: incomingData,
                    borderColor: primaryLine,
                    backgroundColor: primaryArea,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: primaryLine
                },
                {
                    label: 'Surat Keluar',
                    data: outgoingData,
                    borderColor: secondaryLine,
                    backgroundColor: secondaryArea,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: secondaryLine
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: { 
                    grid: { color: gridColor }, 
                    ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 11 } } 
                },
                y: { 
                    grid: { color: gridColor }, 
                    ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 11 } }, 
                    beginAtZero: true 
                }
            }
        }
    });

    // --- Bar Chart: HR Activity (Cuti vs Lembur) ---
    const hrCtx = document.getElementById('hrChart').getContext('2d');
    
    // Colorful pastel colors for HR chart
    const blueColor = isDark ? '#60A5FA' : '#3B82F6';
    const amberColor = isDark ? '#FBBF24' : '#F59E0B';

    new Chart(hrCtx, {
        type: 'bar',
        data: {
            labels: displayMonths,
            datasets: [
                {
                    label: 'Cuti / Izin',
                    data: leaveData,
                    backgroundColor: blueColor,
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                },
                {
                    label: 'Lembur',
                    data: overtimeData,
                    backgroundColor: amberColor,
                    borderRadius: 4,
                    barPercentage: 0.6,
                    categoryPercentage: 0.8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: { 
                    grid: { display: false }, 
                    ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 11 } } 
                },
                y: { 
                    grid: { color: gridColor, borderDash: [4, 4] }, 
                    ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 11 }, stepSize: 1 }, 
                    beginAtZero: true 
                }
            }
        }
    });
});
</script>
@endsection
