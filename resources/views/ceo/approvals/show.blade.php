@extends('ceo.layouts.app')

@section('title', 'Review Persetujuan Surat - Ruang Administrasi')
@section('page-title', 'Review & Persetujuan Surat')
@section('page-subtitle', 'Tinjau detail surat keluar sebelum menandatangani secara digital')

@section('content')
<div class="mb-6">
    <a href="{{ url('ceo/letter-approvals') }}" class="inline-flex items-center gap-2 text-on-surface-variant dark:text-ds-text-secondary hover:text-brand-navy dark:hover:text-brand-amber transition-colors font-label-md text-label-md font-semibold">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Daftar Persetujuan
    </a>
</div>

<div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden flex flex-col lg:flex-row">
    <!-- Letter Details -->
    <div class="flex-1 p-6 md:p-8 border-b lg:border-b-0 lg:border-r border-[#B3AEA3] dark:border-[#2A3654]">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-4 border-b border-[#E0DED8] dark:border-[#2A3654]">
            <div>
                <span class="text-gray-500 dark:text-gray-400 uppercase font-bold text-xs mb-1 block tracking-wider">Nomor Surat</span>
                <h3 class="font-mono text-xl md:text-2xl font-extrabold text-brand-navy dark:text-brand-amber flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-blue dark:text-brand-amber text-2xl">outbox</span>
                    <span>{{ $outgoingLetter->letter_number }}</span>
                </h3>
            </div>
            <div class="flex items-center gap-2">
                @if($outgoingLetter->category === 'balasan')
                    <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-amber-500/20 text-amber-700 dark:text-amber-300 uppercase border border-amber-500/40 shadow-xs">↩️ Surat Balasan</span>
                @else
                    <span class="px-3 py-1 text-xs font-extrabold rounded-full bg-blue-500/20 text-blue-700 dark:text-blue-300 uppercase border border-blue-500/40 shadow-xs">🏢 Surat Umum</span>
                @endif
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300 font-label-md text-xs font-bold border border-amber-300 dark:border-amber-700">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span> MENUNGGU ACC
                </span>
            </div>
        </div>

        <!-- Banner Khusus Surat Balasan -->
        @if($outgoingLetter->category === 'balasan' && $outgoingLetter->incomingLetter)
            <div class="mb-6 p-5 rounded-2xl bg-amber-50 dark:bg-[#1A233B] border-2 border-amber-300 dark:border-amber-500/40 shadow-xs">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <span class="text-xs font-extrabold text-amber-700 dark:text-amber-300 uppercase tracking-wide flex items-center gap-1 mb-1">
                            <span class="material-symbols-outlined text-[18px]">mark_email_read</span>
                            <span>Informasi Balasan Surat Masuk</span>
                        </span>
                        <h4 class="font-bold text-base text-on-surface dark:text-white">
                            Surat ini ditujukan untuk membalas surat dari <span class="text-brand-navy dark:text-amber-300 font-extrabold">{{ $outgoingLetter->incomingLetter->sender }}</span>
                        </h4>
                        <p class="text-xs text-gray-600 dark:text-gray-300 mt-1">
                            <strong>Ref Nomor:</strong> #{{ $outgoingLetter->incomingLetter->letter_number }} &nbsp;|&nbsp; <strong>Perihal Asli:</strong> {{ strip_tags($outgoingLetter->incomingLetter->subject) }}
                        </p>
                    </div>
                    <button type="button" onclick="document.getElementById('modal-incoming-preview').classList.remove('hidden')" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shrink-0 flex items-center gap-1.5 shadow-lg shadow-emerald-600/20 transition-all hover:scale-105">
                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                        <span>Lihat Dokumen Asli</span>
                    </button>
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-6">
            <!-- Tujuan Surat -->
            <div class="col-span-1 md:col-span-2">
                <label class="block font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 text-xs">Tujuan (Penerima Surat Keluar)</label>
                <div class="font-extrabold text-on-surface dark:text-white text-lg bg-gray-50 dark:bg-[#0F172B] px-4 py-3 rounded-xl border border-[#CCC7BD] dark:border-[#2A3654] uppercase flex items-center gap-2">
                    <span class="material-symbols-outlined text-brand-blue dark:text-brand-amber">business_center</span>
                    <span>{{ $outgoingLetter->recipient ?? '-' }}</span>
                </div>
            </div>
            
            <!-- Perihal -->
            <div class="col-span-1 md:col-span-2">
                <label class="block font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 text-xs">Perihal / Subject Surat</label>
                <div class="font-extrabold text-on-surface dark:text-white text-base md:text-lg bg-gray-50 dark:bg-[#0F172B] px-4 py-3 rounded-xl border border-[#CCC7BD] dark:border-[#2A3654]">
                    {{ $outgoingLetter->subject ?? '-' }}
                </div>
            </div>

            <!-- Jenis Surat -->
            <div>
                <label class="block font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 text-xs">Jenis Surat</label>
                <div class="text-sm font-bold text-on-surface dark:text-ds-text-primary p-3 rounded-xl bg-gray-50 dark:bg-[#0F172B] border border-[#CCC7BD] dark:border-[#2A3654]">
                    {{ optional($outgoingLetter->letterType)->type_name ?? '-' }} ({{ optional($outgoingLetter->letterType)->letter_code ?? '-' }})
                </div>
            </div>

            <!-- Admin Pembuat -->
            <div>
                <label class="block font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5 text-xs">Admin / Staf Pembuat Surat</label>
                <div class="p-3 rounded-xl bg-blue-50/60 dark:bg-[#1A2440] border border-blue-200 dark:border-[#2A3654] flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white dark:bg-amber-400 dark:text-[#0B1220] font-extrabold flex items-center justify-center shrink-0 text-sm shadow-xs">
                        {{ strtoupper(substr(optional($outgoingLetter->creator)->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-xs text-on-surface dark:text-white">{{ optional($outgoingLetter->creator)->name ?? 'Staf Admin Office' }}</span>
                        <span class="text-[11px] text-gray-500 dark:text-gray-300">{{ optional($outgoingLetter->creator)->email ?? 'Admin Kantor' }}</span>
                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-semibold mt-0.5">Diajukan: {{ \Carbon\Carbon::parse($outgoingLetter->created_at)->translatedFormat('d F Y - H:i') }} WIB</span>
                    </div>
                </div>
            </div>
            
            <!-- Isi Surat Lengkap -->
            <div class="col-span-1 md:col-span-2 mt-2">
                <label class="block font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 text-xs">Isi Dokumen / Teks Surat</label>
                <style>
                    .dark .prose-letter table, .dark .prose-letter tr, .dark .prose-letter td, .dark .prose-letter th, .dark .prose-letter div, .dark .prose-letter p, .dark .prose-letter span {
                        background-color: transparent !important;
                        color: #E8E6E0 !important;
                    }
                    .dark .prose-letter strong, .dark .prose-letter b, .dark .prose-letter h1, .dark .prose-letter h2, .dark .prose-letter h3, .dark .prose-letter h4 {
                        color: #FFFFFF !important;
                    }
                </style>
                <div class="bg-gray-50 dark:bg-[#0F172B] border border-[#CCC7BD] dark:border-[#2A3654] rounded-2xl p-6 min-h-[240px] prose prose-slate max-w-none text-on-surface dark:text-[#E8E6E0] prose-letter">
                    {!! $outgoingLetter->content ?? '<p class="text-gray-400 italic">Tidak ada isi teks surat.</p>' !!}

                    <!-- Kolom Tanda Tangan & Cap Stempel (Placeholder & Status Otorisasi) -->
                    <div class="mt-10 pt-8 border-t-2 border-dashed border-gray-300 dark:border-[#2A3654] grid grid-cols-1 sm:grid-cols-2 gap-6 font-sans not-prose">
                        <div class="p-4 rounded-xl bg-white dark:bg-[#141C33] border border-gray-200 dark:border-[#2A3654] flex flex-col items-center justify-center text-center shadow-xs">
                            <span class="text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Kolom Cap Stempel Perusahaan</span>
                            @if(in_array($outgoingLetter->status, ['acc', 'delivered']))
                                <div class="w-40 h-20 border-2 border-dashed border-blue-600 dark:border-blue-400 rounded-xl flex flex-col items-center justify-center bg-blue-50/60 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300">
                                    <span class="material-symbols-outlined text-2xl mb-0.5">verified</span>
                                    <span class="text-[11px] font-extrabold uppercase">Stempel Digital Resmi</span>
                                </div>
                            @else
                                <div class="w-40 h-20 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl flex flex-col items-center justify-center text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-[#080E1A]">
                                    <span class="material-symbols-outlined text-2xl opacity-50 mb-0.5">account_balance</span>
                                    <span class="text-[11px] font-bold uppercase">[ Kolom Cap Stempel ]</span>
                                </div>
                            @endif
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 mt-2 font-semibold">Otorisasi Stempel PT The Prime Tekhnologi</span>
                        </div>

                        <div class="p-4 rounded-xl bg-white dark:bg-[#141C33] border border-gray-200 dark:border-[#2A3654] flex flex-col items-center justify-center text-center shadow-xs">
                            <span class="text-[11px] font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Kolom Tanda Tangan Pimpinan</span>
                            @if(in_array($outgoingLetter->status, ['acc', 'delivered']))
                                <div class="w-48 h-20 border-2 border-dashed border-emerald-600 dark:border-emerald-400 rounded-xl flex flex-col items-center justify-center bg-emerald-50/60 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300">
                                    <span class="material-symbols-outlined text-2xl mb-0.5">draw</span>
                                    <span class="text-[11px] font-extrabold uppercase">Signed by CEO</span>
                                    @if($outgoingLetter->approved_at)
                                        <span class="text-[9px] font-bold opacity-90 mt-0.5">{{ \Carbon\Carbon::parse($outgoingLetter->approved_at)->format('d/m/Y - H:i') }} WIB</span>
                                    @endif
                                </div>
                            @else
                                <div class="w-48 h-20 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl flex flex-col items-center justify-center text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-[#080E1A]">
                                    <span class="material-symbols-outlined text-2xl opacity-50 mb-0.5">history_edu</span>
                                    <span class="text-[11px] font-bold uppercase">[ Kolom Tanda Tangan ]</span>
                                </div>
                            @endif
                            <span class="text-[12px] font-extrabold text-on-surface dark:text-white mt-2 underline">Chief Executive Officer</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lampiran Fisik -->
            <div class="col-span-1 md:col-span-2 mt-2 pt-4 border-t border-[#E0DED8] dark:border-[#2A3654]">
                <label class="block font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 text-xs">Dokumen Terlampir dari Admin</label>
                @if($outgoingLetter->file_path)
                    <a href="{{ asset('storage/' . $outgoingLetter->file_path) }}" target="_blank" class="inline-flex items-center gap-3 px-5 py-3 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/50 dark:hover:bg-blue-900/60 border border-blue-200 dark:border-blue-700 rounded-xl transition-all text-blue-700 dark:text-blue-300 font-bold text-xs shadow-sm">
                        <div class="p-2 bg-blue-600 text-white dark:bg-blue-500 rounded-lg">
                            <span class="material-symbols-outlined text-[20px]">description</span>
                        </div>
                        <div>
                            <span class="block font-extrabold text-sm">Lihat File Lampiran</span>
                            <span class="block text-[11px] opacity-80">Buka dokumen lampiran di tab baru</span>
                        </div>
                    </a>
                @else
                    <div class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 dark:bg-[#0F172B] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl text-gray-500 text-xs font-semibold">
                        <span class="material-symbols-outlined text-[18px]">block</span>
                        <span>Tidak ada file lampiran yang disertakan admin</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Action Area (Right Column) -->
    <div class="w-full lg:w-96 p-6 md:p-8 bg-[#F8FAFC] dark:bg-[#0E1628] flex flex-col justify-center border-t lg:border-t-0 border-[#B3AEA3] dark:border-[#2A3654]">
        <div class="text-center mb-8">
            @if($outgoingLetter->status === 'pending')
                <div class="w-20 h-20 bg-brand-navy/10 dark:bg-brand-amber/15 text-brand-navy dark:text-brand-amber rounded-3xl flex items-center justify-center mx-auto mb-4 border border-brand-navy/20 dark:border-brand-amber/30 shadow-sm animate-pulse">
                    <span class="material-symbols-outlined text-4xl">history_edu</span>
                </div>
                <h4 class="font-headline-md text-lg font-extrabold text-brand-navy dark:text-white mb-2">Pengesahan Pimpinan</h4>
                <p class="font-body-md text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Menyetujui surat ini akan membuhkan <strong>Tanda Tangan & Cap Stempel Digital Otomatis</strong> pada dokumen cetak (PDF/Word).
                </p>
            @elseif(in_array($outgoingLetter->status, ['acc', 'delivered']))
                <div class="w-20 h-20 bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/30 shadow-sm">
                    <span class="material-symbols-outlined text-4xl">verified</span>
                </div>
                <h4 class="font-headline-md text-lg font-extrabold text-emerald-700 dark:text-emerald-400 mb-2">Dokumen Telah Sah</h4>
                <p class="font-body-md text-xs text-gray-600 dark:text-gray-300 leading-relaxed font-bold">
                    Surat ini telah disetujui (ACC) dan dibubuhi tanda tangan serta cap stempel digital pada {{ \Carbon\Carbon::parse($outgoingLetter->approved_at ?? $outgoingLetter->updated_at)->translatedFormat('d M Y, H:i') }} WIB.
                </p>
            @else
                <div class="w-20 h-20 bg-red-500/15 text-red-600 dark:text-red-400 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-red-500/30 shadow-sm">
                    <span class="material-symbols-outlined text-4xl">cancel</span>
                </div>
                <h4 class="font-headline-md text-lg font-extrabold text-red-600 dark:text-red-400 mb-2">Pengajuan Ditolak</h4>
                <p class="font-body-md text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Surat keluar ini tidak disetujui dan dikembalikan ke Staf Admin.
                </p>
            @endif
        </div>
        
        <div class="space-y-4">
            @if($outgoingLetter->status === 'pending')
                <form method="POST" action="{{ url('ceo/letter-approvals/' . $outgoingLetter->id . '/approve') }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyetujui (ACC) surat ini dan melekahkan tanda tangan digital?');" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600 text-white dark:text-[#0B1220] py-4 rounded-xl font-bold text-sm hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg shadow-emerald-500/20">
                        <span class="material-symbols-outlined text-[20px]">verified</span>
                        <span>Setujui (ACC) & Tandatangani</span>
                    </button>
                </form>
                
                <form method="POST" action="{{ url('ceo/letter-approvals/' . $outgoingLetter->id . '/reject') }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin MENOLAK surat ini?');" class="w-full flex items-center justify-center gap-2 bg-white dark:bg-[#141C33] text-red-600 dark:text-red-400 border-2 border-red-500/50 hover:bg-red-50 dark:hover:bg-red-950/30 py-3.5 rounded-xl font-bold text-sm hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xs">
                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                        <span>Tolak Pengajuan Surat</span>
                    </button>
                </form>
            @else
                <a href="{{ url()->previous() }}" class="w-full flex items-center justify-center gap-2 bg-[#F2F6FC] hover:bg-gray-200 dark:bg-[#1A2440] dark:hover:bg-[#2A3654] text-brand-navy dark:text-white py-3.5 rounded-xl font-bold text-sm transition-all border border-gray-300 dark:border-gray-700">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    <span>Kembali ke Daftar Surat</span>
                </a>
            @endif
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-[#2A3654] text-center text-[11px] text-gray-400 dark:text-gray-500">
            <p>🔒 Keputusan Anda akan tercatat dengan timestamp resmi dalam sistem audit.</p>
        </div>
    </div>
</div>

@if($outgoingLetter->category === 'balasan' && $outgoingLetter->incomingLetter)
<!-- Modal Preview Surat Masuk Asli -->
<div id="modal-incoming-preview" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm hidden transition-opacity">
    <div class="bg-white dark:bg-[#141C33] rounded-3xl max-w-4xl w-full max-h-[90vh] flex flex-col shadow-2xl border border-gray-200 dark:border-[#2A3654] overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 bg-emerald-700 dark:bg-[#162923] text-white dark:text-emerald-300 border-b border-emerald-600 dark:border-emerald-800/60 flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <span class="p-2.5 bg-white/20 dark:bg-emerald-500/20 rounded-2xl flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl text-white dark:text-emerald-400">mark_email_read</span>
                </span>
                <div>
                    <h3 class="font-extrabold text-base md:text-lg text-white">Dokumen Surat Masuk (Referensi Balasan)</h3>
                    <p class="text-xs text-emerald-100 dark:text-emerald-300/80 font-medium">Surat asli dari pengirim sebelum diterjemahkan / dijawab ke surat keluar ini</p>
                </div>
            </div>
            <button type="button" onclick="document.getElementById('modal-incoming-preview').classList.add('hidden')" class="p-2 hover:bg-white/20 dark:hover:bg-emerald-500/20 rounded-xl transition-colors text-white">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-6 overflow-y-auto flex-1 space-y-6">
            <!-- Summary Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4.5 rounded-2xl bg-gray-50 dark:bg-[#0C1326] border border-gray-200 dark:border-[#2A3654]">
                <div>
                    <span class="text-[11px] font-extrabold uppercase text-gray-400 block mb-1">Nomor Surat Masuk</span>
                    <span class="font-mono font-bold text-sm text-brand-navy dark:text-brand-amber bg-white dark:bg-[#1A2440] px-3 py-1.5 rounded-lg border border-gray-200 dark:border-[#2A3654] inline-block shadow-xs">
                        {{ $outgoingLetter->incomingLetter->letter_number }}
                    </span>
                </div>
                <div>
                    <span class="text-[11px] font-extrabold uppercase text-gray-400 block mb-1">Dari Pengirim</span>
                    <span class="font-bold text-sm text-on-surface dark:text-white flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-brand-blue text-[18px]">business_center</span>
                        {{ $outgoingLetter->incomingLetter->sender }}
                    </span>
                </div>
                <div>
                    <span class="text-[11px] font-extrabold uppercase text-gray-400 block mb-1">Tanggal Diterima</span>
                    <span class="font-bold text-sm text-gray-700 dark:text-gray-300 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-emerald-500 text-[18px]">calendar_today</span>
                        {{ \Carbon\Carbon::parse($outgoingLetter->incomingLetter->date_received)->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div class="col-span-1 md:col-span-3 pt-3 mt-1 border-t border-gray-200 dark:border-[#2A3654]">
                    <span class="text-[11px] font-extrabold uppercase text-gray-400 block mb-1">Perihal Surat Masuk</span>
                    <span class="font-extrabold text-sm md:text-base text-on-surface dark:text-white block bg-white dark:bg-[#1A2440] p-3 rounded-xl border border-gray-200 dark:border-[#2A3654]">
                        {{ $outgoingLetter->incomingLetter->subject }}
                    </span>
                </div>
            </div>

            <!-- Embedded Document Preview -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="font-extrabold text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px] text-emerald-500">description</span>
                        <span>Preview Berkas Lampiran dari Pengirim</span>
                    </span>
                    @if($outgoingLetter->incomingLetter->file_path)
                        <a href="{{ asset('storage/' . $outgoingLetter->incomingLetter->file_path) }}" target="_blank" class="px-3.5 py-1.5 bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 rounded-lg text-xs font-extrabold hover:bg-emerald-200 transition-colors flex items-center gap-1.5 border border-emerald-300 dark:border-emerald-700 shadow-xs">
                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            <span>Buka File Full Screen (Tab Baru)</span>
                        </a>
                    @endif
                </div>
                
                @if($outgoingLetter->incomingLetter->file_path)
                    <div class="w-full h-[520px] rounded-2xl border-2 border-gray-300 dark:border-[#2A3654] overflow-hidden bg-gray-100 dark:bg-[#080E1A] shadow-inner relative">
                        <iframe src="{{ asset('storage/' . $outgoingLetter->incomingLetter->file_path) }}#toolbar=1" class="w-full h-full border-none"></iframe>
                    </div>
                @else
                    <div class="py-16 text-center bg-gray-50 dark:bg-[#0C1326] rounded-2xl border border-dashed border-gray-300 dark:border-[#2A3654]">
                        <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 mx-auto block mb-3">no_sim</span>
                        <p class="font-extrabold text-base text-gray-700 dark:text-gray-300">File Dokumen Scan Tidak Disertakan</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 max-w-md mx-auto">Admin/Tata Usaha tidak melampirkan berkas scan PDF/foto untuk surat masuk ini saat registrasi.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-100 dark:bg-[#0C1326] border-t border-gray-200 dark:border-[#2A3654] flex justify-end">
            <button type="button" onclick="document.getElementById('modal-incoming-preview').classList.add('hidden')" class="px-6 py-2.5 rounded-xl bg-gray-700 hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-extrabold text-xs shadow-sm transition-all">
                Tutup Jendela
            </button>
        </div>
    </div>
</div>
@endif
@endsection
