@extends('admin.layouts.app')

@section('title', 'Ruang Administrasi - Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Header Section (Editorial Greeting) -->
<section class="flex flex-col md:flex-row justify-between items-start md:items-end gap-component-gap">
    <div>
        <h2 class="font-display-lg text-display-lg text-primary dark:text-ds-text-primary tracking-tight">Selamat {{ now()->hour < 12 ? 'pagi' : (now()->hour < 15 ? 'siang' : (now()->hour < 18 ? 'sore' : 'malam')) }}, {{ Auth::user()->employee->name ?? 'Admin' }}.</h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant dark:text-ds-text-secondary mt-4 max-w-2xl">Ringkasan aktivitas persuratan Anda hari ini. Pastikan untuk meninjau dokumen yang memerlukan persetujuan segera.</p>
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
        <div class="editorial-card p-6 rounded-lg flex flex-col justify-between hover:border-[#D9A441] dark:hover:border-ds-accent transition-colors">
            <div class="flex justify-between items-start mb-6">
                <h3 class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-wider">Surat Masuk</h3>
                <span class="material-symbols-outlined text-outline dark:text-ds-text-secondary">mail</span>
            </div>
            <div>
                <span class="font-display-lg text-4xl font-bold text-primary dark:text-ds-text-primary">{{ $totalIncoming }}</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-2">Total masuk</p>
            </div>
        </div>
        <!-- Surat Keluar -->
        <div class="editorial-card p-6 rounded-lg flex flex-col justify-between hover:border-[#D9A441] dark:hover:border-ds-accent transition-colors">
            <div class="flex justify-between items-start mb-6">
                <h3 class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-wider">Surat Keluar</h3>
                <span class="material-symbols-outlined text-outline dark:text-ds-text-secondary">send</span>
            </div>
            <div>
                <span class="font-display-lg text-4xl font-bold text-primary dark:text-ds-text-primary">{{ $totalOutgoing }}</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-2">Total keluar</p>
            </div>
        </div>
        <!-- Karyawan Aktif -->
        <div class="editorial-card p-6 rounded-lg flex flex-col justify-between hover:border-[#D9A441] dark:hover:border-ds-accent transition-colors">
            <div class="flex justify-between items-start mb-6">
                <h3 class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-wider">Karyawan Aktif</h3>
                <span class="material-symbols-outlined text-outline dark:text-ds-text-secondary">person</span>
            </div>
            <div>
                <span class="font-display-lg text-4xl font-bold text-primary dark:text-ds-text-primary">{{ $totalEmployees }}</span>
                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-2">Staf terdaftar</p>
            </div>
        </div>
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
                    <tr class="table-row-hover transition-colors">
                        <td class="px-6 py-4 font-body-sm text-body-sm font-semibold text-secondary dark:text-ds-accent">{{ $letter->letter_number }}</td>
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
                    <tr class="table-row-hover transition-colors">
                        <td class="px-6 py-4 font-body-sm text-body-sm font-semibold text-secondary dark:text-ds-accent">{{ $letter->letter_number }}</td>
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
@endsection

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

    // --- Monthly data from controller ---
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    const currentMonth = new Date().getMonth(); // 0-indexed
    const displayMonths = months.slice(0, currentMonth + 1);

    const monthlyIn = @json($monthlyIncoming);
    const monthlyOut = @json($monthlyOutgoing);

    const incomingData = displayMonths.map((_, i) => monthlyIn[i + 1] || 0);
    const outgoingData = displayMonths.map((_, i) => monthlyOut[i + 1] || 0);

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
});
</script>
@endsection
