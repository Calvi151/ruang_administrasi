@extends('admin.layouts.app')

@section('title', 'Detail Surat Keluar - Ruang Administrasi')
@section('page-title', 'Detail Surat Keluar')

@section('content')
<div class="mb-6">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant dark:text-ds-text-primary dark:hover:text-ds-accent hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Surat Keluar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter items-start">
    <!-- Main Detail Card -->
    <div class="lg:col-span-2 bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-outline-variant/30 bg-surface-container-lowest flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary-container/10 rounded-lg text-primary">
                    <span class="material-symbols-outlined icon-fill">outbox</span>
                </div>
                <div>
                    <h3 class="font-h3 text-h3 text-on-surface">{{ $outgoingLetter->letter_number }}</h3>
                    <p class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                        <span class="material-symbols-outlined text-[14px]">business</span>
                        Tujuan: {{ $outgoingLetter->recipient }}
                    </p>
                </div>
            </div>
            @if($outgoingLetter->status == 'pending')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-label-sm text-[11px] font-bold tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> MENUNGGU
                </span>
            @elseif($outgoingLetter->status == 'acc')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-container/40 text-on-secondary-container font-label-sm text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> DISETUJUI
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-error-container/40 text-error font-label-sm text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span> DITOLAK
                </span>
            @endif
        </div>

        <!-- Body -->
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h4 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-1.5">Tanggal Surat</h4>
                    <div class="flex items-center gap-2 font-body-sm text-body-sm text-on-surface bg-surface-container-low px-3 py-2 rounded-lg border border-outline-variant/30 inline-flex">
                        <span class="material-symbols-outlined text-primary text-[18px]">calendar_month</span>
                        {{ \Carbon\Carbon::parse($outgoingLetter->date_sent)->translatedFormat('d F Y') }}
                    </div>
                </div>
                <div>
                    <h4 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-1.5">Jenis Surat</h4>
                    <div class="flex items-center gap-2 font-body-sm text-body-sm text-on-surface bg-surface-container-low px-3 py-2 rounded-lg border border-outline-variant/30 inline-flex">
                        <span class="material-symbols-outlined text-primary text-[18px]">category</span>
                        {{ $outgoingLetter->letterType->type_name ?? '-' }}
                    </div>
                </div>
            </div>

            <div>
                <h4 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-1.5">Perihal</h4>
                <div class="bg-surface-container-low border border-outline-variant/30 rounded-lg p-4">
                    <p class="font-body-sm text-body-sm text-on-surface font-medium">{{ $outgoingLetter->subject }}</p>
                </div>
            </div>

            <div>
                <h4 class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mb-1.5">Isi Surat / Keterangan</h4>
                <style>
                    .dark .prose-letter table, .dark .prose-letter tr, .dark .prose-letter td, .dark .prose-letter th, .dark .prose-letter div, .dark .prose-letter p, .dark .prose-letter span {
                        background-color: transparent !important;
                        color: #E8E6E0 !important;
                    }
                    .dark .prose-letter strong, .dark .prose-letter b, .dark .prose-letter h1, .dark .prose-letter h2, .dark .prose-letter h3, .dark .prose-letter h4 {
                        color: #FFFFFF !important;
                    }
                </style>
                <div class="bg-surface-container-low dark:bg-[#0F172B] border border-outline-variant/30 dark:border-[#2A3654] rounded-lg p-4 prose-letter text-on-surface dark:text-[#E8E6E0]">
                    <div class="font-body-sm text-body-sm leading-relaxed whitespace-pre-wrap">{!! $outgoingLetter->content !!}</div>

                    <!-- Kolom Tanda Tangan & Cap Stempel -->
                    <div class="mt-8 pt-6 border-t border-dashed border-outline-variant dark:border-[#2A3654] grid grid-cols-1 sm:grid-cols-2 gap-4 font-sans">
                        <div class="p-4 rounded-xl bg-surface sm:bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] flex flex-col items-center justify-center text-center shadow-xs">
                            <span class="text-[11px] font-bold text-on-surface-variant dark:text-gray-400 uppercase tracking-wider mb-2">Kolom Cap Stempel Perusahaan</span>
                            @if(in_array($outgoingLetter->status, ['acc', 'delivered']))
                                <div class="w-40 h-20 border-2 border-dashed border-blue-600 dark:border-blue-400 rounded-xl flex flex-col items-center justify-center bg-blue-50/50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300">
                                    <span class="material-symbols-outlined text-2xl mb-0.5">verified</span>
                                    <span class="text-[11px] font-bold uppercase">Stempel Digital</span>
                                </div>
                            @else
                                <div class="w-40 h-20 border-2 border-dashed border-outline-variant dark:border-gray-600 rounded-xl flex flex-col items-center justify-center text-on-surface-variant dark:text-gray-500 bg-surface-container-lowest dark:bg-[#080E1A]">
                                    <span class="material-symbols-outlined text-2xl opacity-50 mb-0.5">account_balance</span>
                                    <span class="text-[11px] font-bold uppercase">[ Kolom Cap Stempel ]</span>
                                </div>
                            @endif
                            <span class="text-[10px] text-on-surface-variant dark:text-gray-400 mt-2 font-semibold">Otorisasi Stempel Resmi</span>
                        </div>

                        <div class="p-4 rounded-xl bg-surface sm:bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] flex flex-col items-center justify-center text-center shadow-xs">
                            <span class="text-[11px] font-bold text-on-surface-variant dark:text-gray-400 uppercase tracking-wider mb-2">Kolom Tanda Tangan Pimpinan</span>
                            @if(in_array($outgoingLetter->status, ['acc', 'delivered']))
                                <div class="w-48 h-20 border-2 border-dashed border-emerald-600 dark:border-emerald-400 rounded-xl flex flex-col items-center justify-center bg-emerald-50/50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300">
                                    <span class="material-symbols-outlined text-2xl mb-0.5">draw</span>
                                    <span class="text-[11px] font-bold uppercase">Signed by CEO</span>
                                    @if($outgoingLetter->approved_at)
                                        <span class="text-[9px] font-medium opacity-90 mt-0.5">{{ \Carbon\Carbon::parse($outgoingLetter->approved_at)->format('d/m/Y - H:i') }} WIB</span>
                                    @endif
                                </div>
                            @else
                                <div class="w-48 h-20 border-2 border-dashed border-outline-variant dark:border-gray-600 rounded-xl flex flex-col items-center justify-center text-on-surface-variant dark:text-gray-500 bg-surface-container-lowest dark:bg-[#080E1A]">
                                    <span class="material-symbols-outlined text-2xl opacity-50 mb-0.5">history_edu</span>
                                    <span class="text-[11px] font-bold uppercase">[ Kolom Tanda Tangan ]</span>
                                </div>
                            @endif
                            <span class="text-[12px] font-bold text-on-surface dark:text-white mt-2 underline">Chief Executive Officer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/30 flex flex-wrap gap-3 justify-end">
            @if($outgoingLetter->status == 'pending')
            <a href="{{ route('outgoing-letters.edit', $outgoingLetter->id) }}" class="px-4 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface-variant rounded-lg font-label-md text-label-md hover:bg-surface transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                Edit Surat
            </a>
            @endif
            <a href="{{ route('outgoing-letters.export-word', $outgoingLetter->id) }}" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">description</span>
                Export Word
            </a>
            <a href="{{ route('outgoing-letters.export-pdf', $outgoingLetter->id) }}" target="_blank" class="px-4 py-2 bg-surface-container-lowest border border-primary text-primary rounded-lg font-label-md text-label-md hover:bg-primary-fixed transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                Cetak PDF
            </a>
        </div>
    </div>

    <!-- Attachment Sidebar -->
    <div class="bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-outline-variant/30 bg-surface-container-lowest">
            <h3 class="font-h3 text-h3 text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[20px]">attachment</span>
                Lampiran
            </h3>
        </div>
        <div class="p-6">
            @if($outgoingLetter->file_path)
            <div class="bg-primary-fixed/20 border border-primary-fixed-dim/30 rounded-lg p-4 flex flex-col items-center text-center gap-3 hover:bg-primary-fixed/30 transition-colors">
                <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[28px]">picture_as_pdf</span>
                </div>
                <div>
                    <h4 class="font-label-md text-label-md text-on-surface">File Dokumen</h4>
                    <p class="font-label-sm text-label-sm text-on-surface-variant mt-0.5">Format PDF</p>
                </div>
                <a href="{{ asset('storage/' . $outgoingLetter->file_path) }}" target="_blank" class="w-full px-4 py-2 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:opacity-90 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                    Buka Dokumen
                </a>
            </div>
            @else
            <div class="border-2 border-dashed border-outline-variant rounded-lg p-6 flex flex-col items-center text-center gap-2">
                <span class="material-symbols-outlined text-[40px] text-outline/30">description</span>
                <p class="font-label-md text-label-md text-on-surface-variant">Tidak ada lampiran</p>
                <p class="font-label-sm text-label-sm text-outline">Surat ini tidak memiliki file lampiran.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
