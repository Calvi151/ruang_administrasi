@extends('ceo.layouts.app')

@section('title', 'Surat Keluar - Ruang Administrasi')
@section('page-title', 'Surat Keluar')
@section('page-subtitle', 'Arsip dan status seluruh surat keluar perusahaan (Read-only)')

@section('content')
@php
    $totalOutgoingCount = \App\Models\OutgoingLetter::count();
    $pendingOutgoingCount = \App\Models\OutgoingLetter::where('status', 'pending')->count();
    $approvedMonthCount = \App\Models\OutgoingLetter::where('status', 'acc')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
@endphp

<!-- Stat Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card 1: Total Surat Keluar (Klik untuk filter Semua) -->
    <div class="bg-white dark:bg-[#141C33] p-6 rounded-2xl shadow-[0_4px_20px_rgba(15,27,61,0.07)] hover:shadow-lg transition-all border border-[#CCC7BD] dark:border-[#2A3654] group cursor-pointer flex flex-col justify-between" onclick="window.location.href='{{ url('ceo/outgoing-letters') }}'">
        <div>
            <div class="flex justify-between items-start mb-3">
                <span class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase font-bold tracking-wider">Total Surat Keluar</span>
                <div class="w-10 h-10 bg-brand-navy/10 dark:bg-[#1D2847] rounded-xl text-brand-navy dark:text-brand-amber flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                    <span class="material-symbols-outlined text-[22px]">description</span>
                </div>
            </div>
            <div class="font-stat-number text-3xl md:text-4xl font-extrabold text-brand-navy dark:text-ds-text-primary group-hover:text-brand-amber transition-colors">{{ $totalOutgoingCount }}</div>
        </div>
        <p class="font-body-md text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1 group-hover:underline">
            <span class="material-symbols-outlined text-[14px] text-emerald-600 dark:text-emerald-400">check</span>
            <span>Seluruh arsip terdaftar</span>
        </p>
    </div>

    <!-- Card 2: Menunggu Persetujuan (Klik untuk filter Menunggu) -->
    <div class="bg-white dark:bg-[#141C33] p-6 rounded-2xl shadow-[0_4px_20px_rgba(15,27,61,0.07)] hover:shadow-lg transition-all border border-[#CCC7BD] dark:border-[#2A3654] border-l-[5px] border-l-brand-amber dark:border-l-brand-amber group cursor-pointer flex flex-col justify-between" onclick="window.location.href='{{ url('ceo/outgoing-letters?status=pending') }}'">
        <div>
            <div class="flex justify-between items-start mb-3">
                <span class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase font-bold tracking-wider">Menunggu Persetujuan</span>
                <div class="w-10 h-10 bg-brand-amber/20 dark:bg-brand-amber/15 rounded-xl text-brand-navy dark:text-brand-amber flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                    <span class="material-symbols-outlined text-[22px]">pending_actions</span>
                </div>
            </div>
            <div class="font-stat-number text-3xl md:text-4xl font-extrabold text-brand-navy dark:text-ds-text-primary group-hover:text-brand-amber transition-colors">{{ $pendingOutgoingCount }}</div>
        </div>
        <p class="font-body-md text-xs text-brand-navy dark:text-brand-amber font-bold mt-2 flex items-center gap-1 group-hover:underline">
            <span>Filter surat menunggu</span>
            <span class="material-symbols-outlined text-[14px] transform group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
        </p>
    </div>

    <!-- Card 3: Disetujui Bulan Ini (Klik untuk filter Disetujui) -->
    <div class="bg-white dark:bg-[#141C33] p-6 rounded-2xl shadow-[0_4px_20px_rgba(15,27,61,0.07)] hover:shadow-lg transition-all border border-[#CCC7BD] dark:border-[#2A3654] group cursor-pointer flex flex-col justify-between" onclick="window.location.href='{{ url('ceo/outgoing-letters?status=acc') }}'">
        <div>
            <div class="flex justify-between items-start mb-3">
                <span class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase font-bold tracking-wider">Disetujui Bulan Ini</span>
                <div class="w-10 h-10 bg-emerald-500/10 dark:bg-emerald-950/60 rounded-xl text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                    <span class="material-symbols-outlined text-[22px]">check_circle</span>
                </div>
            </div>
            <div class="font-stat-number text-3xl md:text-4xl font-extrabold text-brand-navy dark:text-ds-text-primary group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $approvedMonthCount }}</div>
        </div>
        <p class="font-body-md text-xs text-gray-500 dark:text-gray-400 mt-2 group-hover:underline">Disahkan periode {{ now()->locale('id')->isoFormat('MMMM Y') }}</p>
    </div>
</div>

<!-- Action & Search Bar with Status Filter Tabs -->
<div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
    <div class="flex items-center gap-2.5">
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-brand-navy/10 text-brand-navy dark:bg-brand-amber/10 dark:text-brand-amber">
            <span class="material-symbols-outlined text-xl">outbox</span>
        </span>
        <div>
            <h3 class="font-headline-md text-lg font-bold text-on-surface dark:text-ds-text-primary">Arsip Surat Keluar</h3>
            <p class="font-body-md text-xs text-on-surface-variant dark:text-ds-text-secondary">Daftar surat yang dikirim ke eksternal maupun internal</p>
        </div>
    </div>

    <!-- Filter Pills & Search Input -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
        <!-- Status Filter Pills -->
        <div class="inline-flex items-center p-1 bg-gray-100 dark:bg-[#0F172E] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl text-xs font-bold overflow-x-auto shrink-0 shadow-xs">
            @php $currentStatus = request('status'); @endphp
            
            <!-- All -->
            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" 
               class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 whitespace-nowrap {{ !$currentStatus ? 'bg-brand-navy text-white dark:bg-brand-amber dark:text-brand-navy shadow-xs font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-brand-navy dark:hover:text-brand-amber' }}">
                <span class="material-symbols-outlined text-[15px]">apps</span>
                <span>Semua</span>
            </a>

            <!-- Pending -->
            <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" 
               class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 whitespace-nowrap {{ $currentStatus === 'pending' ? 'bg-brand-amber text-brand-navy shadow-xs font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-brand-amber' }}">
                <span class="w-2 h-2 rounded-full bg-brand-amber animate-pulse"></span>
                <span>Menunggu</span>
            </a>

            <!-- Approved (acc) -->
            <a href="{{ request()->fullUrlWithQuery(['status' => 'acc']) }}" 
               class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 whitespace-nowrap {{ $currentStatus === 'acc' ? 'bg-emerald-600 text-white dark:bg-emerald-500 dark:text-brand-navy shadow-xs font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-emerald-600' }}">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Disetujui</span>
            </a>

            <!-- Rejected (reject) -->
            <a href="{{ request()->fullUrlWithQuery(['status' => 'reject']) }}" 
               class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 whitespace-nowrap {{ $currentStatus === 'reject' ? 'bg-red-600 text-white shadow-xs font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-red-600' }}">
                <span class="w-2 h-2 rounded-full bg-red-500"></span>
                <span>Ditolak</span>
            </a>
        </div>

        <!-- Search Bar -->
        <div class="w-full sm:w-64 relative group">
            <form action="{{ url('/ceo/outgoing-letters') }}" method="GET">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-brand-navy dark:group-focus-within:text-brand-amber transition-colors text-[20px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal, tujuan..." class="w-full pl-11 pr-4 py-2 bg-white dark:bg-[#141C33] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl font-body-md text-xs text-on-surface dark:text-[#E8E6E0] focus:border-brand-navy dark:focus:border-brand-amber focus:ring-2 focus:ring-brand-navy/10 dark:focus:ring-brand-amber/20 focus:outline-none transition-all shadow-xs placeholder:text-gray-400 dark:placeholder:text-gray-500">
            </form>
        </div>
    </div>
</div>

<!-- Table Card (Dengan Border Tegas & Background Kontras) -->
<div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden transition-all duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA] dark:bg-[#0C1326] text-brand-navy dark:text-brand-amber font-label-md text-xs uppercase tracking-wider font-bold">
                    <th class="py-4 px-6 font-bold w-1/6">Nomor Surat</th>
                    <th class="py-4 px-6 font-bold w-1/4">Perihal</th>
                    <th class="py-4 px-6 font-bold w-1/6">Tujuan</th>
                    <th class="py-4 px-6 font-bold w-1/6 text-center">Status</th>
                    <th class="py-4 px-6 font-bold w-1/6">Tanggal</th>
                    <th class="py-4 px-6 font-bold w-1/6 text-right">Lampiran</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-sm text-on-surface dark:text-ds-text-primary divide-y divide-[#E0DED8] dark:divide-[#2A3654] bg-white dark:bg-[#141C33]">
                @forelse($letters as $letter)
                <tr class="hover:bg-[#F2F6FC] dark:hover:bg-[#1A2440]/70 transition-all duration-200 group">
                    <td class="py-4 px-6">
                        <span class="font-semibold text-brand-navy dark:text-brand-amber font-mono text-xs md:text-sm bg-[#EBF0FA] dark:bg-brand-amber/10 px-2.5 py-1 rounded-md border border-brand-navy/15 dark:border-brand-amber/20 block w-fit">
                            {{ $letter->letter_number ?? '-' }}
                        </span>
                    </td>
                    <td class="py-4 px-6 font-medium text-on-surface dark:text-[#E8E6E0]">
                        <div class="max-w-[240px] truncate font-semibold" title="{{ $letter->subject }}">
                            {{ $letter->subject ?? '-' }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600 dark:text-gray-300 font-medium">
                        <div class="flex items-center gap-1.5 text-on-surface dark:text-[#E8E6E0]">
                            <span class="material-symbols-outlined text-[16px] text-gray-400">person_pin</span>
                            <span>{{ $letter->recipient ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-center">
                        @if($letter->status === 'acc')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/70 text-emerald-800 dark:text-emerald-300 font-label-md text-[11px] font-bold border border-emerald-300 dark:border-emerald-700 shadow-xs">
                                <span class="w-2 h-2 rounded-full bg-emerald-600 dark:bg-emerald-400"></span> DISETUJUI
                            </span>
                        @elseif($letter->status === 'reject')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 dark:bg-red-950/70 text-red-800 dark:text-red-300 font-label-md text-[11px] font-bold border border-red-300 dark:border-red-700 shadow-xs">
                                <span class="w-2 h-2 rounded-full bg-red-600 dark:bg-red-400"></span> DITOLAK
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-amber/20 dark:bg-brand-amber/15 text-brand-navy dark:text-brand-amber font-label-md text-[11px] font-bold tracking-wider border border-brand-amber/40 shadow-xs">
                                <span class="w-2 h-2 rounded-full bg-brand-amber animate-ping"></span> MENUNGGU
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-xs font-medium">
                        <div class="flex items-center gap-1.5 text-gray-600 dark:text-gray-300">
                            <span class="material-symbols-outlined text-[16px] text-gray-400">calendar_month</span>
                            {{ $letter->date_sent ? \Carbon\Carbon::parse($letter->date_sent)->translatedFormat('d M Y') : \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d M Y') }}
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
                    <td colspan="6" class="py-16 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-[#1D2847] flex items-center justify-center text-gray-400 dark:text-ds-text-secondary shadow-inner border border-gray-200 dark:border-[#2A3654]">
                                <span class="material-symbols-outlined text-4xl">send</span>
                            </div>
                            <div class="max-w-sm">
                                <p class="font-label-md text-base text-brand-navy dark:text-ds-text-primary font-bold">Belum Ada Data Surat Keluar</p>
                                <p class="font-body-md text-xs text-gray-500 dark:text-ds-text-secondary mt-1">Daftar arsip surat keluar saat ini masih kosong.</p>
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
