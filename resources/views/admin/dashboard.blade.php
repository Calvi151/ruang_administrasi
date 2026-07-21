@extends('admin.layouts.app')

@section('title', 'Ruang Administrasi - Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stat Cards Grid (sesuai Stitch: rounded-xl, p-6, simpel) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-8">
    <!-- Card 1: Surat Masuk -->
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/50 flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-primary-container/10 rounded-lg text-primary">
                <span class="material-symbols-outlined icon-fill">inbox</span>
            </div>
            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-secondary bg-secondary-container/30 px-2 py-1 rounded-full">
                <span class="material-symbols-outlined text-[14px]">trending_up</span> +12%
            </span>
        </div>
        <div>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Surat Masuk</p>
            <h2 class="font-display text-h1 text-on-surface">{{ $totalIncoming }}</h2>
        </div>
    </div>

    <!-- Card 2: Surat Keluar -->
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/50 flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-secondary/10 rounded-lg text-secondary">
                <span class="material-symbols-outlined icon-fill">send</span>
            </div>
            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-secondary bg-secondary-container/30 px-2 py-1 rounded-full">
                <span class="material-symbols-outlined text-[14px]">trending_up</span> +5%
            </span>
        </div>
        <div>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Surat Keluar</p>
            <h2 class="font-display text-h1 text-on-surface">{{ $totalOutgoing }}</h2>
        </div>
    </div>

    <!-- Card 3: Menunggu Approval -->
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/50 flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-amber-500/10 rounded-lg text-amber-600">
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

    <!-- Card 4: Karyawan Aktif -->
    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-outline-variant/50 flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-tertiary/10 rounded-lg text-tertiary">
                <span class="material-symbols-outlined icon-fill">badge</span>
            </div>
            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-2 py-1 rounded-full">
                <span class="material-symbols-outlined text-[14px]">horizontal_rule</span> Stabil
            </span>
        </div>
        <div>
            <p class="font-body-sm text-body-sm text-on-surface-variant mb-1">Karyawan Aktif</p>
            <h2 class="font-display text-h1 text-on-surface">{{ $totalEmployees }}</h2>
        </div>
    </div>
</div>

<!-- Tables Area (sesuai Stitch: tabel dengan header border-b) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
    <!-- Surat Masuk Terbaru -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
        <div class="px-6 py-5 border-b border-outline-variant/20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-2.5 h-2.5 rounded-full bg-primary"></div>
                <h3 class="font-h3 text-h3 text-on-surface font-bold">Surat Masuk Terbaru</h3>
            </div>
            <a href="{{ route('incoming-letters.index') }}" class="text-primary font-label-sm text-label-sm hover:underline flex items-center gap-1">Lihat Semua <span class="material-symbols-outlined text-[16px]">arrow_forward</span></a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container border-y border-outline-variant/30 font-label-sm text-[11px] uppercase tracking-wider text-on-surface-variant">
                        <th class="px-6 py-4 font-semibold">NO SURAT</th>
                        <th class="px-6 py-4 font-semibold">PENGIRIM</th>
                        <th class="px-6 py-4 font-semibold">PERIHAL</th>
                        <th class="px-6 py-4 font-semibold">TANGGAL</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm">
                    @forelse($recentIncoming as $letter)
                    <tr class="border-b border-outline-variant/20 hover:bg-black/5 dark:hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4 text-primary font-semibold">{{ $letter->letter_number }}</td>
                        <td class="px-6 py-4 text-on-surface font-semibold uppercase">{{ $letter->sender }}</td>
                        <td class="px-6 py-4 text-on-surface-variant truncate max-w-[150px]">{{ Str::limit(strip_tags($letter->subject), 30) }}</td>
                        <td class="px-6 py-4 text-on-surface-variant whitespace-nowrap">{{ \Carbon\Carbon::parse($letter->date_received)->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center">
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
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col">
        <div class="px-6 py-5 border-b border-outline-variant/20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-2.5 h-2.5 rounded-full bg-secondary"></div>
                <h3 class="font-h3 text-h3 text-on-surface font-bold">Surat Keluar Terbaru</h3>
            </div>
            <a href="{{ route('outgoing-letters.index') }}" class="text-primary font-label-sm text-label-sm hover:underline flex items-center gap-1">Lihat Semua <span class="material-symbols-outlined text-[16px]">arrow_forward</span></a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container border-y border-outline-variant/30 font-label-sm text-[11px] uppercase tracking-wider text-on-surface-variant">
                        <th class="px-6 py-4 font-semibold">NO SURAT</th>
                        <th class="px-6 py-4 font-semibold">PENERIMA</th>
                        <th class="px-6 py-4 font-semibold">PERIHAL</th>
                        <th class="px-6 py-4 font-semibold">STATUS</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm">
                    @forelse($recentOutgoing as $letter)
                    <tr class="border-b border-outline-variant/20 hover:bg-black/5 dark:hover:bg-white/5 transition-colors group">
                        <td class="px-6 py-4 text-secondary font-semibold">{{ $letter->letter_number }}</td>
                        <td class="px-6 py-4 text-on-surface font-semibold uppercase">{{ $letter->recipient }}</td>
                        <td class="px-6 py-4 text-on-surface-variant truncate max-w-[150px]">{{ Str::limit($letter->subject, 30) }}</td>
                        <td class="px-6 py-4">
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
                        <td colspan="4" class="px-6 py-8 text-center">
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
@endsection




