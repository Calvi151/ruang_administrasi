@extends('ceo.layouts.app')

@section('title', 'Surat Keluar - Ruang Administrasi')
@section('page-title', 'Surat Keluar & Balasan')
@section('page-subtitle', 'Arsip dan status seluruh surat keluar perusahaan & balasan surat masuk (Read-only)')

@section('content')
@php
    $totalOutgoingCount = \App\Models\OutgoingLetter::count();
    $pendingOutgoingCount = \App\Models\OutgoingLetter::where('status', 'pending')->count();
    $deliveredCount = \App\Models\OutgoingLetter::where('status', 'delivered')->count();
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
                <span class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase font-bold tracking-wider">Menunggu ACC Pimpinan</span>
                <div class="w-10 h-10 bg-brand-amber/20 dark:bg-brand-amber/15 rounded-xl text-brand-navy dark:text-brand-amber flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                    <span class="material-symbols-outlined text-[22px]">pending_actions</span>
                </div>
            </div>
            <div class="font-stat-number text-3xl md:text-4xl font-extrabold text-brand-navy dark:text-ds-text-primary group-hover:text-brand-amber transition-colors">{{ $pendingOutgoingCount }}</div>
        </div>
        <p class="font-body-md text-xs text-brand-navy dark:text-brand-amber font-bold mt-2 flex items-center gap-1 group-hover:underline">
            <span>Filter surat menunggu ACC</span>
            <span class="material-symbols-outlined text-[14px] transform group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
        </p>
    </div>

    <!-- Card 3: Telah Terkirim (Delivered) -->
    <div class="bg-white dark:bg-[#141C33] p-6 rounded-2xl shadow-[0_4px_20px_rgba(15,27,61,0.07)] hover:shadow-lg transition-all border border-[#CCC7BD] dark:border-[#2A3654] group cursor-pointer flex flex-col justify-between" onclick="window.location.href='{{ url('ceo/outgoing-letters?status=delivered') }}'">
        <div>
            <div class="flex justify-between items-start mb-3">
                <span class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase font-bold tracking-wider">Surat Terkirim (Delivered)</span>
                <div class="w-10 h-10 bg-blue-500/10 dark:bg-blue-950/60 rounded-xl text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform shrink-0">
                    <span class="material-symbols-outlined text-[22px]">local_shipping</span>
                </div>
            </div>
            <div class="font-stat-number text-3xl md:text-4xl font-extrabold text-brand-navy dark:text-ds-text-primary group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $deliveredCount }}</div>
        </div>
        <p class="font-body-md text-xs text-gray-500 dark:text-gray-400 mt-2 group-hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px] text-blue-500">done_all</span>
            <span>Surat selesai diedarkan & sampai tujuan</span>
        </p>
    </div>
</div>

<!-- Action & Search Bar with Status Filter Tabs -->
<div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
    <div class="flex items-center gap-2.5">
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-brand-navy/10 text-brand-navy dark:bg-brand-amber/10 dark:text-brand-amber">
            <span class="material-symbols-outlined text-xl">outbox</span>
        </span>
        <div>
            <h3 class="font-headline-md text-lg font-bold text-on-surface dark:text-ds-text-primary">Arsip Surat Keluar (Mailroom)</h3>
            <p class="font-body-md text-xs text-on-surface-variant dark:text-ds-text-secondary">Daftar surat yang dikirim ke eksternal maupun internal</p>
        </div>
    </div>

    <!-- Filter Pills & Search Input -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
        <!-- Status Filter Pills -->
        <div class="inline-flex items-center p-1 bg-gray-100 dark:bg-[#0F172E] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl text-xs font-bold overflow-x-auto shrink-0 shadow-xs">
            @php $currentStatus = request('status'); @endphp
            
            <!-- All -->
            <a href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => null]) }}" 
               class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 whitespace-nowrap {{ !$currentStatus ? 'bg-brand-navy text-white dark:bg-brand-amber dark:text-brand-navy shadow-xs font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-brand-navy dark:hover:text-brand-amber' }}">
                <span class="material-symbols-outlined text-[15px]">apps</span>
                <span>Semua</span>
            </a>

            <!-- Pending -->
            <a href="{{ request()->fullUrlWithQuery(['status' => 'pending', 'page' => null]) }}" 
               class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 whitespace-nowrap {{ $currentStatus === 'pending' ? 'bg-brand-amber text-brand-navy shadow-xs font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-brand-amber' }}">
                <span class="w-2 h-2 rounded-full bg-brand-amber animate-pulse"></span>
                <span>Menunggu</span>
            </a>

            <!-- Approved (acc) -->
            <a href="{{ request()->fullUrlWithQuery(['status' => 'acc', 'page' => null]) }}" 
               class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 whitespace-nowrap {{ $currentStatus === 'acc' ? 'bg-emerald-600 text-white dark:bg-emerald-500 dark:text-brand-navy shadow-xs font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-emerald-600' }}">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Disetujui</span>
            </a>

            <!-- Delivered -->
            <a href="{{ request()->fullUrlWithQuery(['status' => 'delivered', 'page' => null]) }}" 
               class="px-3 py-1.5 rounded-lg transition-all flex items-center gap-1.5 whitespace-nowrap {{ $currentStatus === 'delivered' ? 'bg-blue-600 text-white dark:bg-blue-500 dark:text-white shadow-xs font-bold' : 'text-gray-600 dark:text-gray-400 hover:text-blue-600' }}">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                <span>Terkirim (Delivered)</span>
            </a>

            <!-- Rejected (reject) -->
            <a href="{{ request()->fullUrlWithQuery(['status' => 'reject', 'page' => null]) }}" 
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
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-brand-navy dark:group-focus-within:text-brand-amber transition-colors text-[20px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal, ref nomor..." class="w-full pl-11 pr-4 py-2 bg-white dark:bg-[#141C33] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl font-body-md text-xs text-on-surface dark:text-[#E8E6E0] focus:border-brand-navy dark:focus:border-brand-amber focus:ring-2 focus:ring-brand-navy/10 dark:focus:ring-brand-amber/20 focus:outline-none transition-all shadow-xs placeholder:text-gray-400 dark:placeholder:text-gray-500">
            </form>
        </div>
    </div>
</div>

<!-- Gmail-Style Inbox Table Card -->
<div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden transition-all duration-300">
    <!-- Gmail Category Tabs -->
    <div class="flex border-b border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA]/50 dark:bg-[#0C1326] overflow-x-auto">
        <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => null]) }}"
           class="flex items-center gap-2.5 px-6 py-3.5 border-b-2 font-bold text-xs md:text-sm whitespace-nowrap transition-all {{ !request('category') ? 'border-brand-navy text-brand-navy dark:border-brand-amber dark:text-brand-amber bg-white dark:bg-[#141C33] shadow-sm' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-brand-navy hover:bg-black/5' }}">
            <span class="material-symbols-outlined text-[18px]">inbox</span>
            <span>Semua Surat</span>
            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-black/10 dark:bg-white/10">{{ $totalAll ?? 0 }}</span>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['category' => 'umum', 'page' => null]) }}"
           class="flex items-center gap-2.5 px-6 py-3.5 border-b-2 font-bold text-xs md:text-sm whitespace-nowrap transition-all {{ request('category') == 'umum' ? 'border-brand-navy text-brand-navy dark:border-brand-amber dark:text-brand-amber bg-white dark:bg-[#141C33] shadow-sm' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-brand-navy hover:bg-black/5' }}">
            <span class="material-symbols-outlined text-[18px] text-blue-600 dark:text-blue-400">domain</span>
            <span>Surat Perusahaan (Umum)</span>
            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-blue-500/10 text-blue-600 dark:text-blue-400">{{ $countUmum ?? 0 }}</span>
        </a>
        <a href="{{ request()->fullUrlWithQuery(['category' => 'balasan', 'page' => null]) }}"
           class="flex items-center gap-2.5 px-6 py-3.5 border-b-2 font-bold text-xs md:text-sm whitespace-nowrap transition-all {{ request('category') == 'balasan' ? 'border-brand-navy text-brand-navy dark:border-brand-amber dark:text-brand-amber bg-white dark:bg-[#141C33] shadow-sm' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-brand-navy hover:bg-black/5' }}">
            <span class="material-symbols-outlined text-[18px] text-brand-amber">reply</span>
            <span>Surat Balasan (Reply)</span>
            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400">{{ $countBalasan ?? 0 }}</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="border-b-2 border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA] dark:bg-[#0C1326] text-brand-navy dark:text-brand-amber font-label-md text-[11px] uppercase tracking-wider font-extrabold">
                    <th class="py-4 px-6 font-extrabold w-3/12">1. Klasifikasi & No. Surat</th>
                    <th class="py-4 px-6 font-extrabold w-3/12">2. Tujuan & Rujukan Balasan</th>
                    <th class="py-4 px-6 font-extrabold w-3/12">3. Subjek Perihal & Ringkasan</th>
                    <th class="py-4 px-6 font-extrabold w-2/12 text-center">4. Status Pengesahan</th>
                    <th class="py-4 px-6 font-extrabold w-1/12 text-right">5. Detail</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-sm text-on-surface dark:text-ds-text-primary divide-y divide-[#E0DED8] dark:divide-[#2A3654] bg-white dark:bg-[#141C33]">
                @forelse($letters as $letter)
                @php
                    $rawText = trim(strip_tags($letter->content));
                    $cleanSummary = preg_replace('/^(Nomor\s*[:=].*?Perihal\s*[:=].*?|Yth\..*?di\s*Tempat)/is', '', $rawText);
                    $cleanSummary = trim(preg_replace('/\s+/', ' ', $cleanSummary));
                    if(empty($cleanSummary) || strlen($cleanSummary) < 15) {
                        $cleanSummary = $rawText;
                    }
                @endphp
                <tr onclick="window.location='{{ url('ceo/letter-approvals/' . $letter->id) }}'" class="hover:bg-[#F2F6FC] dark:hover:bg-[#1D2847] transition-all duration-200 cursor-pointer group" title="Klik untuk membuka detail surat ini">
                    <!-- 1. KLASIFIKASI & NOMOR -->
                    <td class="py-5 px-6 vertical-align-top">
                        <div class="flex flex-wrap items-center gap-1.5 mb-2">
                            @if($letter->category === 'balasan')
                                <span class="px-2.5 py-0.5 text-[10px] font-black rounded-md bg-amber-500/20 text-amber-700 dark:text-amber-300 uppercase border border-amber-500/40 tracking-wide flex items-center gap-1" title="Surat Balasan Atas Surat Masuk">
                                    <span class="material-symbols-outlined text-[13px]">reply_all</span>
                                    <span>Surat Balasan</span>
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 text-[10px] font-black rounded-md bg-blue-500/20 text-blue-700 dark:text-blue-300 uppercase border border-blue-500/40 tracking-wide flex items-center gap-1" title="Surat Keluar Perusahaan (Utama)">
                                    <span class="material-symbols-outlined text-[13px]">corporate_fare</span>
                                    <span>Surat Perusahaan</span>
                                </span>
                            @endif
                        </div>
                        <div class="font-extrabold text-on-surface dark:text-white text-sm tracking-tight group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            {{ optional($letter->letterType)->type_name ?? 'Dokumen Umum' }}
                        </div>
                        <div class="mt-1.5 font-mono font-bold text-brand-navy dark:text-brand-amber text-xs bg-[#EBF0FA] dark:bg-[#0A1020] px-2.5 py-1 rounded-md border border-brand-navy/20 dark:border-brand-amber/30 inline-block">
                            {{ $letter->letter_number ?? '-' }}
                        </div>
                        <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                            <span>{{ $letter->date_sent ? \Carbon\Carbon::parse($letter->date_sent)->translatedFormat('d M Y') : \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d M Y') }}</span>
                        </div>
                    </td>

                    <!-- 2. TUJUAN & RUJUKAN -->
                    <td class="py-5 px-6 vertical-align-top">
                        <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold block mb-1">Kepada Yth. (Instansi/Penerima):</span>
                        <div class="flex items-start gap-1.5 text-on-surface dark:text-[#F3F1EC] font-extrabold text-sm uppercase leading-snug">
                            <span class="material-symbols-outlined text-[18px] text-blue-600 dark:text-amber-400 shrink-0 mt-0.5">business_center</span>
                            <span class="underline decoration-blue-500/30 dark:decoration-amber-400/30 underline-offset-2">{{ $letter->recipient ?? '-' }}</span>
                        </div>
                        @if($letter->incoming_letter_id && $letter->incomingLetter)
                            <div class="mt-3 p-2.5 rounded-xl bg-amber-50/90 dark:bg-[#1A243E] border border-amber-300 dark:border-amber-400/30 text-xs shadow-xs" onclick="event.stopPropagation();">
                                <div class="flex items-center gap-1.5 text-amber-800 dark:text-amber-300 font-extrabold mb-1 text-[11px]">
                                    <span class="material-symbols-outlined text-[14px]">link</span>
                                    <span>Rujukan Surat Masuk:</span>
                                </div>
                                <div class="text-on-surface dark:text-gray-200 font-semibold text-[11px] mb-1">
                                    Dari: <strong>{{ $letter->incomingLetter->sender }}</strong>
                                </div>
                                <a href="{{ $letter->incomingLetter->file_path ? asset('storage/' . $letter->incomingLetter->file_path) : url('/ceo/incoming-letters?search=' . urlencode($letter->incomingLetter->letter_number)) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-emerald-600 dark:text-emerald-400 hover:underline font-extrabold bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20" title="Buka Dokumen Asli (New Tab)">
                                    <span class="material-symbols-outlined text-[13px]">{{ $letter->incomingLetter->file_path ? 'description' : 'search' }}</span>
                                    <span>Buka Dokumen #{{ $letter->incomingLetter->letter_number }} ↗</span>
                                </a>
                            </div>
                        @endif
                    </td>

                    <!-- 3. PERIHAL & RINGKASAN -->
                    <td class="py-5 px-6 vertical-align-top">
                        <div class="text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-1">Perihal Utama:</div>
                        <div class="font-extrabold text-brand-navy dark:text-white text-sm mb-2 leading-tight group-hover:underline">
                            {{ $letter->subject ?? '-' }}
                        </div>
                        <div class="text-[12px] text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-[#0B1222]/80 p-2.5 rounded-lg border border-gray-200 dark:border-gray-800 line-clamp-3 font-normal leading-relaxed italic">
                            "{{ Str::limit($cleanSummary, 120, '...') }}"
                        </div>
                    </td>

                    <!-- 4. STATUS -->
                    <td class="py-5 px-6 text-center vertical-align-top">
                        <div class="flex flex-col items-center justify-center gap-1 pt-1">
                            @if($letter->status === 'acc')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/70 text-emerald-800 dark:text-emerald-300 font-label-md text-[11px] font-bold border border-emerald-300 dark:border-emerald-700 shadow-xs">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600 dark:bg-emerald-400"></span> DISETUJUI
                                </span>
                                <span class="text-[10px] text-gray-500 font-semibold">Siap Dikirim Admin</span>
                            @elseif($letter->status === 'delivered')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-950/70 text-blue-800 dark:text-blue-300 font-label-md text-[11px] font-bold border border-blue-300 dark:border-blue-700 shadow-xs" title="Via: {{ $letter->delivery_method }}">
                                    <span class="material-symbols-outlined text-[14px] text-blue-600 dark:text-blue-400">local_shipping</span> TERKIRIM
                                </span>
                                <span class="text-[10px] text-gray-500 font-semibold">Via {{ $letter->delivery_method ?? 'Ekspedisi/Kurir' }}</span>
                            @elseif($letter->status === 'reject')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 dark:bg-red-950/70 text-red-800 dark:text-red-300 font-label-md text-[11px] font-bold border border-red-300 dark:border-red-700 shadow-xs">
                                    <span class="w-2 h-2 rounded-full bg-red-600 dark:bg-red-400"></span> DITOLAK
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-amber/20 dark:bg-brand-amber/15 text-brand-navy dark:text-brand-amber font-label-md text-[11px] font-bold tracking-wider border border-brand-amber/40 shadow-xs">
                                    <span class="w-2 h-2 rounded-full bg-brand-amber animate-ping"></span> MENUNGGU ACC
                                </span>
                            @endif
                        </div>
                    </td>

                    <!-- 5. DETAIL -->
                    <td class="py-5 px-6 text-right vertical-align-top" onclick="event.stopPropagation();">
                        <div class="flex flex-col items-end justify-start gap-2">
                            <a href="{{ url('ceo/letter-approvals/' . $letter->id) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-[#EAF0FA] text-brand-navy dark:bg-[#1A2440] dark:text-brand-amber hover:bg-brand-navy hover:text-white dark:hover:bg-brand-amber dark:hover:text-brand-navy rounded-xl font-bold text-xs transition-all border border-brand-navy/15 dark:border-brand-amber/30" title="Buka Detail & Arsip Dokumen">
                                <span>Lihat Detail</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward_ios</span>
                            </a>
                            @if($letter->file_path)
                                <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="text-[11px] font-extrabold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center gap-0.5" title="Download File Lampiran">
                                    <span class="material-symbols-outlined text-[14px]">attachment</span>
                                    <span>Lampiran</span>
                                </a>
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
