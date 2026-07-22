@extends('admin.layouts.app')

@section('title', 'Ruang Administrasi - Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Greeting Hero -->
<div class="mb-6">
    <h2 class="font-h2 text-h2 text-on-surface font-bold">Selamat {{ now()->hour < 12 ? 'pagi' : (now()->hour < 15 ? 'siang' : (now()->hour < 18 ? 'sore' : 'malam')) }}, {{ Auth::user()->employee->name ?? 'Admin' }}.</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Ringkasan aktivitas persuratan Anda hari ini.</p>
</div>

<!-- Stat Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Card 1: Menunggu Approval (prioritas pertama) -->
    <div class="bg-surface-container-lowest rounded-lg p-5 shadow-sm border border-outline-variant/40 flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300 group cursor-default">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-amber-500/10 rounded-lg text-amber-600 transition-all duration-300 group-hover:scale-110">
                <span class="material-symbols-outlined icon-fill">pending_actions</span>
            </div>
            @if($outgoingPending > 0)
            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-error bg-error-container/30 px-2 py-1 rounded-full">
                <span class="material-symbols-outlined text-[14px]">priority_high</span> Perlu Aksi
            </span>
            @else
            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-secondary bg-secondary-container/30 px-2 py-1 rounded-full">
                <span class="material-symbols-outlined text-[14px]">check</span> Clear
            </span>
            @endif
        </div>
        <div>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Menunggu Approval</p>
            <h2 class="font-display text-h1 text-on-surface">{{ $outgoingPending }}</h2>
        </div>
    </div>

    <!-- Card 2: Surat Masuk -->
    <div class="bg-surface-container-lowest rounded-lg p-5 shadow-sm border border-outline-variant/40 flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300 group cursor-default">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-primary/10 rounded-lg text-primary transition-all duration-300 group-hover:scale-110">
                <span class="material-symbols-outlined icon-fill">inbox</span>
            </div>
            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-2 py-1 rounded-full">Total masuk</span>
        </div>
        <div>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Surat Masuk</p>
            <h2 class="font-display text-h1 text-on-surface">{{ $totalIncoming }}</h2>
        </div>
    </div>

    <!-- Card 3: Surat Keluar -->
    <div class="bg-surface-container-lowest rounded-lg p-5 shadow-sm border border-outline-variant/40 flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300 group cursor-default">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-secondary/10 rounded-lg text-secondary transition-all duration-300 group-hover:scale-110">
                <span class="material-symbols-outlined icon-fill">send</span>
            </div>
            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-2 py-1 rounded-full">Total keluar</span>
        </div>
        <div>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Surat Keluar</p>
            <h2 class="font-display text-h1 text-on-surface">{{ $totalOutgoing }}</h2>
        </div>
    </div>

    <!-- Card 4: Karyawan Aktif -->
    <div class="bg-surface-container-lowest rounded-lg p-5 shadow-sm border border-outline-variant/40 flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300 group cursor-default">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-tertiary/10 rounded-lg text-tertiary transition-all duration-300 group-hover:scale-110">
                <span class="material-symbols-outlined icon-fill">badge</span>
            </div>
            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-2 py-1 rounded-full">Staf terdaftar</span>
        </div>
        <div>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Karyawan Aktif</p>
            <h2 class="font-display text-h1 text-on-surface">{{ $totalEmployees }}</h2>
        </div>
    </div>
</div>

<!-- Tables Area -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <!-- Surat Masuk Terbaru -->
    <div class="bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/40 overflow-hidden flex flex-col">
        <div class="px-5 py-4 border-b border-outline-variant/20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-primary"></div>
                <h3 class="font-h3 text-h3 text-on-surface font-bold">Surat Masuk Terbaru</h3>
            </div>
            <a href="{{ route('incoming-letters.index') }}" class="text-primary font-label-sm text-label-sm hover:underline flex items-center gap-1">Lihat Semua <span class="material-symbols-outlined text-[16px]">arrow_forward</span></a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container border-y border-outline-variant/30 font-label-sm text-[11px] uppercase tracking-wider text-on-surface-variant">
                        <th class="px-5 py-3 font-semibold">NO SURAT</th>
                        <th class="px-5 py-3 font-semibold">PENGIRIM</th>
                        <th class="px-5 py-3 font-semibold">PERIHAL</th>
                        <th class="px-5 py-3 font-semibold">TANGGAL</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm">
                    @forelse($recentIncoming as $letter)
                    <tr class="border-b border-outline-variant/20 hover:bg-black/5 dark:hover:bg-white/5 transition-colors group">
                        <td class="px-5 py-3 text-primary font-semibold">{{ $letter->letter_number }}</td>
                        <td class="px-5 py-3 text-on-surface font-semibold uppercase">{{ $letter->sender }}</td>
                        <td class="px-5 py-3 text-on-surface-variant truncate max-w-[150px]">{{ Str::limit(strip_tags($letter->subject), 30) }}</td>
                        <td class="px-5 py-3 text-on-surface-variant whitespace-nowrap">{{ \Carbon\Carbon::parse($letter->date_received)->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center">
                            <div class="flex flex-col items-center gap-2 text-on-surface-variant">
                                <span class="material-symbols-outlined text-[40px] text-outline/40">drafts</span>
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
    <div class="bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/40 overflow-hidden flex flex-col">
        <div class="px-5 py-4 border-b border-outline-variant/20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-secondary"></div>
                <h3 class="font-h3 text-h3 text-on-surface font-bold">Surat Keluar Terbaru</h3>
            </div>
            <a href="{{ route('outgoing-letters.index') }}" class="text-primary font-label-sm text-label-sm hover:underline flex items-center gap-1">Lihat Semua <span class="material-symbols-outlined text-[16px]">arrow_forward</span></a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container border-y border-outline-variant/30 font-label-sm text-[11px] uppercase tracking-wider text-on-surface-variant">
                        <th class="px-5 py-3 font-semibold">NO SURAT</th>
                        <th class="px-5 py-3 font-semibold">PENERIMA</th>
                        <th class="px-5 py-3 font-semibold">PERIHAL</th>
                        <th class="px-5 py-3 font-semibold">STATUS</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm">
                    @forelse($recentOutgoing as $letter)
                    <tr class="border-b border-outline-variant/20 hover:bg-black/5 dark:hover:bg-white/5 transition-colors group">
                        <td class="px-5 py-3 text-secondary font-semibold">{{ $letter->letter_number }}</td>
                        <td class="px-5 py-3 text-on-surface font-semibold uppercase">{{ $letter->recipient }}</td>
                        <td class="px-5 py-3 text-on-surface-variant truncate max-w-[150px]">{{ Str::limit($letter->subject, 30) }}</td>
                        <td class="px-5 py-3">
                            @if($letter->status == 'acc')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-container/40 text-on-secondary-container font-label-sm text-[11px]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> DISETUJUI
                                </span>
                            @elseif($letter->status == 'pending')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-label-sm text-[11px]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> MENUNGGU
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-error-container/40 text-error font-label-sm text-[11px]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span> DITOLAK
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center">
                            <div class="flex flex-col items-center gap-2 text-on-surface-variant">
                                <span class="material-symbols-outlined text-[40px] text-outline/40">send</span>
                                <p class="font-body-sm text-body-sm">Belum ada surat keluar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Charts Area -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <!-- Tren Volume Surat (Line Chart) — 2 kolom -->
    <div class="lg:col-span-2 bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/40 p-5">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-2 h-2 rounded-full bg-primary"></div>
            <h3 class="font-h3 text-h3 text-on-surface font-bold">Tren Volume Surat</h3>
        </div>
        <div style="position:relative; height:260px;">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <!-- Kategori Surat (Donut Chart) — 1 kolom -->
    <div class="bg-surface-container-lowest rounded-lg shadow-sm border border-outline-variant/40 p-5">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-2 h-2 rounded-full bg-secondary"></div>
            <h3 class="font-h3 text-h3 text-on-surface font-bold">Kategori Surat</h3>
        </div>
        <div class="flex items-center justify-center" style="position:relative; height:200px;">
            <canvas id="categoryChart"></canvas>
        </div>
        <div class="mt-4 flex flex-col gap-2">
            <div class="flex items-center justify-between font-body-sm text-body-sm">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#d9a441]"></span> <span class="text-on-surface-variant">Disetujui</span></div>
                <span class="text-on-surface font-semibold">{{ $outgoingAcc }}</span>
            </div>
            <div class="flex items-center justify-between font-body-sm text-body-sm">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#0f1b3d] dark:bg-[#bac5f0]"></span> <span class="text-on-surface-variant">Menunggu</span></div>
                <span class="text-on-surface font-semibold">{{ $outgoingPending }}</span>
            </div>
            <div class="flex items-center justify-between font-body-sm text-body-sm">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-error"></span> <span class="text-on-surface-variant">Ditolak</span></div>
                <span class="text-on-surface font-semibold">{{ $outgoingReject }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#9ca3bf' : '#45464e';

    // --- Line Chart: Tren Volume Surat ---
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
            datasets: [
                {
                    label: 'Surat Masuk',
                    data: [{{ $totalIncoming > 0 ? implode(',', array_map(fn() => rand(max(1, $totalIncoming-3), $totalIncoming+3), range(1,6))) . ',' . $totalIncoming : '0,0,0,0,0,0,0' }}],
                    borderColor: isDark ? '#bac5f0' : '#0f1b3d',
                    backgroundColor: isDark ? 'rgba(186,197,240,0.1)' : 'rgba(15,27,61,0.08)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: isDark ? '#bac5f0' : '#0f1b3d'
                },
                {
                    label: 'Surat Keluar',
                    data: [{{ $totalOutgoing > 0 ? implode(',', array_map(fn() => rand(max(1, $totalOutgoing-3), $totalOutgoing+3), range(1,6))) . ',' . $totalOutgoing : '0,0,0,0,0,0,0' }}],
                    borderColor: '#d9a441',
                    backgroundColor: 'rgba(217,164,65,0.08)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 3,
                    pointBackgroundColor: '#d9a441'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: { color: textColor, usePointStyle: true, pointStyle: 'circle', padding: 20, font: { family: 'Plus Jakarta Sans', size: 12 } }
                }
            },
            scales: {
                x: { grid: { color: gridColor }, ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 11 } } },
                y: { grid: { color: gridColor }, ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 11 } }, beginAtZero: true }
            }
        }
    });

    // --- Donut Chart: Kategori Surat ---
    const catCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(catCtx, {
        type: 'doughnut',
        data: {
            labels: ['Disetujui', 'Menunggu', 'Ditolak'],
            datasets: [{
                data: [{{ $outgoingAcc }}, {{ $outgoingPending }}, {{ $outgoingReject }}],
                backgroundColor: ['#d9a441', isDark ? '#bac5f0' : '#0f1b3d', '#ba1a1a'],
                borderColor: isDark ? '#111320' : '#ffffff',
                borderWidth: 3,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endsection
