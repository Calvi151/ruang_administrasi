@extends('ceo.layouts.app')

@section('title', 'Surat Masuk - Ruang Administrasi')
@section('page-title', 'Surat Masuk')
@section('page-subtitle', 'Arsip dan histori surat masuk perusahaan (Read-only)')

@section('content')
@php
    $totalIncomingCount = \App\Models\IncomingLetter::count();
    $monthIncomingCount = \App\Models\IncomingLetter::whereMonth('date_received', now()->month)->whereYear('date_received', now()->year)->count();
    $todayIncomingCount = \App\Models\IncomingLetter::whereDate('created_at', today())->count();
@endphp

<!-- Stat Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1: Total Surat Masuk -->
    <div class="bg-white dark:bg-[#141C33] p-6 rounded-2xl shadow-[0_4px_20px_rgba(15,27,61,0.07)] hover:shadow-lg transition-all border border-[#CCC7BD] dark:border-[#2A3654] flex items-center justify-between group">
        <div>
            <p class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase font-bold tracking-wider mb-1">Total Surat Masuk</p>
            <p class="font-stat-number text-3xl md:text-4xl font-extrabold text-brand-navy dark:text-ds-text-primary group-hover:text-brand-amber transition-colors">{{ $totalIncomingCount }}</p>
            <span class="inline-flex items-center gap-1 text-xs text-emerald-700 dark:text-emerald-400 font-semibold mt-1">
                <span class="material-symbols-outlined text-[14px]">verified</span> Arsip Perusahaan
            </span>
        </div>
        <div class="w-14 h-14 rounded-xl bg-brand-navy/10 dark:bg-[#1D2847] flex items-center justify-center text-brand-navy dark:text-brand-amber group-hover:scale-110 transition-transform shadow-inner shrink-0">
            <span class="material-symbols-outlined text-3xl">inbox</span>
        </div>
    </div>

    <!-- Card 2: Surat Bulan Ini -->
    <div class="bg-white dark:bg-[#141C33] p-6 rounded-2xl shadow-[0_4px_20px_rgba(15,27,61,0.07)] hover:shadow-lg transition-all border border-[#CCC7BD] dark:border-[#2A3654] flex items-center justify-between group">
        <div>
            <p class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase font-bold tracking-wider mb-1">Surat Bulan Ini</p>
            <p class="font-stat-number text-3xl md:text-4xl font-extrabold text-brand-navy dark:text-ds-text-primary group-hover:text-brand-amber transition-colors">{{ $monthIncomingCount }}</p>
            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Periode {{ now()->locale('id')->isoFormat('MMMM Y') }}</span>
        </div>
        <div class="w-14 h-14 rounded-xl bg-brand-navy/10 dark:bg-[#1D2847] flex items-center justify-center text-brand-navy dark:text-brand-amber group-hover:scale-110 transition-transform shadow-inner shrink-0">
            <span class="material-symbols-outlined text-3xl">calendar_today</span>
        </div>
    </div>

    <!-- Card 3: Masuk Hari Ini (Highlighted) -->
    <div class="bg-white dark:bg-[#141C33] p-6 rounded-2xl shadow-[0_4px_20px_rgba(15,27,61,0.07)] hover:shadow-lg transition-all border-2 border-brand-amber dark:border-brand-amber flex items-center justify-between relative overflow-hidden group">
        <div class="absolute right-0 top-0 w-32 h-32 bg-brand-amber/10 dark:bg-brand-amber/15 rounded-full blur-xl -mr-8 -mt-8 pointer-events-none"></div>
        <div class="relative z-10">
            <p class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase font-bold tracking-wider mb-1">Masuk Hari Ini</p>
            <p class="font-stat-number text-3xl md:text-4xl font-extrabold text-brand-amber dark:text-brand-amber">{{ $todayIncomingCount }}</p>
            <span class="inline-flex items-center gap-1 text-xs text-brand-navy dark:text-ds-text-primary font-medium mt-1">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-amber animate-pulse"></span> Data Terupdate
            </span>
        </div>
        <div class="w-14 h-14 rounded-xl bg-brand-amber/20 dark:bg-brand-amber/20 flex items-center justify-center text-brand-navy dark:text-brand-amber relative z-10 group-hover:scale-110 transition-transform shadow-inner shrink-0">
            <span class="material-symbols-outlined text-3xl">priority_high</span>
        </div>
    </div>
</div>

<!-- Action & Search Bar -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-2.5">
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-brand-navy/10 text-brand-navy dark:bg-brand-amber/10 dark:text-brand-amber">
            <span class="material-symbols-outlined text-xl">move_to_inbox</span>
        </span>
        <div>
            <h3 class="font-headline-md text-lg font-bold text-on-surface dark:text-ds-text-primary">Daftar Surat Masuk</h3>
            <p class="font-body-md text-xs text-on-surface-variant dark:text-ds-text-secondary">Seluruh dokumen yang diterima oleh perusahaan</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="w-full sm:w-80 relative group">
        <form action="{{ url('/ceo/incoming-letters') }}" method="GET">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-brand-navy dark:group-focus-within:text-brand-amber transition-colors text-[20px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal, atau pengirim..." class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-[#141C33] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl font-body-md text-sm text-on-surface dark:text-[#E8E6E0] focus:border-brand-navy dark:focus:border-brand-amber focus:ring-2 focus:ring-brand-navy/10 dark:focus:ring-brand-amber/20 focus:outline-none transition-all shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500">
        </form>
    </div>
</div>

<!-- Table Container (Dengan Border Tegas & Background Kontras) -->
<div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden transition-all duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA] dark:bg-[#0C1326] text-brand-navy dark:text-brand-amber font-label-md text-xs uppercase tracking-wider font-bold">
                    <th class="py-4 px-6 font-bold w-1/5">Nomor Surat</th>
                    <th class="py-4 px-6 font-bold w-1/5">Pengirim</th>
                    <th class="py-4 px-6 font-bold w-2/5">Perihal</th>
                    <th class="py-4 px-6 font-bold w-1/5">Tanggal Diterima</th>
                    <th class="py-4 px-6 font-bold w-1/5 text-right">Lampiran</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-sm text-on-surface dark:text-ds-text-primary divide-y divide-[#E0DED8] dark:divide-[#2A3654] bg-white dark:bg-[#141C33]">
                @forelse($letters as $letter)
                <tr class="hover:bg-[#F2F6FC] dark:hover:bg-[#1A2440]/70 transition-all duration-200 group">
                    <td class="py-4 px-6">
                        <span class="font-semibold text-brand-navy dark:text-brand-amber font-mono text-xs md:text-sm bg-[#EBF0FA] dark:bg-brand-amber/10 px-2.5 py-1 rounded-md border border-brand-navy/15 dark:border-brand-amber/20 block w-fit">
                            {{ $letter->letter_number }}
                        </span>
                    </td>
                    <td class="py-4 px-6 font-semibold text-on-surface dark:text-[#E8E6E0]">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-brand-navy/10 dark:bg-brand-amber/20 text-brand-navy dark:text-brand-amber text-xs font-extrabold flex items-center justify-center uppercase shrink-0 border border-brand-navy/15 dark:border-brand-amber/30">
                                {{ substr($letter->sender ?? 'S', 0, 1) }}
                            </div>
                            <span>{{ $letter->sender }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="max-w-[280px] md:max-w-[340px] truncate font-medium text-on-surface dark:text-[#E8E6E0]" title="{{ $letter->subject }}">
                            {{ $letter->subject }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-xs font-medium">
                        <div class="flex items-center gap-1.5 text-gray-600 dark:text-gray-300">
                            <span class="material-symbols-outlined text-[16px] text-gray-400">calendar_today</span>
                            {{ \Carbon\Carbon::parse($letter->date_received)->translatedFormat('d M Y') }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($letter->file_path)
                                <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="p-2 bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-500 dark:hover:text-brand-navy rounded-xl transition-all duration-200 inline-flex items-center justify-center shadow-xs hover:shadow-sm" title="Buka File / Lihat Lampiran">
                                    <span class="material-symbols-outlined text-[20px]">attachment</span>
                                </a>
                            @else
                                <span class="text-gray-400 dark:text-gray-500 text-xs italic px-2 py-1 bg-gray-100 dark:bg-[#1A2440]/40 rounded-lg border border-gray-200 dark:border-[#2A3654]">Tidak ada</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-[#1D2847] flex items-center justify-center text-gray-400 dark:text-ds-text-secondary shadow-inner border border-gray-200 dark:border-[#2A3654]">
                                <span class="material-symbols-outlined text-4xl">inbox</span>
                            </div>
                            <div class="max-w-sm">
                                <p class="font-label-md text-base text-brand-navy dark:text-ds-text-primary font-bold">Belum Ada Data Surat Masuk</p>
                                <p class="font-body-md text-xs text-gray-500 dark:text-ds-text-secondary mt-1">Belum ada surat masuk yang tercatat di dalam basis data perusahaaan.</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($letters->hasPages())
    <div class="px-6 py-4 border-t border-[#CCC7BD] dark:border-[#2A3654] bg-[#F8F9FC] dark:bg-[#0E1628]">
        {{ $letters->links() }}
    </div>
    @endif
</div>
@endsection
