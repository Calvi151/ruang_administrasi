@extends('admin.layouts.app')

@section('title', 'Detail Surat Keluar - Ruang Administrasi')
@section('page-title', 'Detail Surat Keluar')

@section('content')
<div class="mb-6 animate-fade-in" style="animation-delay: 50ms;">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-[#141C33] border border-outline-variant/30 dark:border-[#2A3654] text-on-surface-variant dark:text-ds-text-secondary hover:text-primary dark:hover:text-ds-accent hover:border-primary/30 dark:hover:border-ds-accent/30 hover:shadow-md transition-all font-label-md text-label-md group">
        <span class="material-symbols-outlined text-[16px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
        Kembali ke Surat Keluar
    </a>
</div>

<div class="w-full">
    <!-- Main Detail Card -->
    <div class="flex flex-col gap-6">
        <div class="glass-card bg-white dark:bg-[#141C33] rounded-3xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm relative overflow-hidden animate-fade-in" style="animation-delay: 100ms;">
            <!-- Decorative Glow -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 dark:bg-ds-accent/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
            
            <div class="p-8 relative z-10">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 mb-8 pb-8 border-b border-outline-variant/20 dark:border-[#2A3654]">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 dark:from-ds-accent/20 dark:to-ds-accent/5 text-primary dark:text-ds-accent flex items-center justify-center shadow-inner shrink-0 border border-primary/10 dark:border-ds-accent/10">
                            <span class="material-symbols-outlined text-[40px] icon-fill">outbox</span>
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary dark:text-ds-accent border border-primary/20 dark:border-ds-accent/20 text-[11px] font-bold tracking-wide uppercase mb-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary dark:bg-ds-accent animate-pulse"></span>
                                Surat Keluar
                            </div>
                            <h3 class="font-headline-md text-2xl md:text-3xl text-on-background dark:text-[#E8E6E0] font-bold tracking-tight mb-2">{{ $outgoingLetter->letter_number }}</h3>
                            <p class="font-body-md text-on-surface-variant dark:text-ds-text-secondary flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px]">business</span>
                                Tujuan: {{ $outgoingLetter->recipient }}
                            </p>
                        </div>
                    </div>
                    <div>
                        @if($outgoingLetter->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/30 font-bold text-[12px] uppercase shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> MENUNGGU ACC
                            </span>
                        @elseif($outgoingLetter->status == 'acc')
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 font-bold text-[12px] uppercase shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">check_circle</span> DISETUJUI
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/30 font-bold text-[12px] uppercase shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">cancel</span> DITOLAK
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Content Details -->
                <div class="space-y-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Date -->
                        <div>
                            <h4 class="font-label-sm text-[11px] text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-widest font-bold mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[14px] text-primary dark:text-ds-accent">calendar_month</span>
                                Tanggal Surat
                            </h4>
                            <div class="inline-flex items-center gap-3 px-4 py-2.5 bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/30 dark:border-[#2A3654] rounded-xl text-on-background dark:text-[#E8E6E0] font-medium shadow-sm w-full sm:w-auto">
                                <span class="text-primary dark:text-ds-accent font-bold">{{ \Carbon\Carbon::parse($outgoingLetter->date_sent)->translatedFormat('d') }}</span>
                                <span class="w-px h-4 bg-outline-variant/30 dark:bg-[#2A3654]"></span>
                                <span>{{ \Carbon\Carbon::parse($outgoingLetter->date_sent)->translatedFormat('F Y') }}</span>
                            </div>
                        </div>

                        <!-- Letter Type -->
                        <div>
                            <h4 class="font-label-sm text-[11px] text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-widest font-bold mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[14px] text-primary dark:text-ds-accent">category</span>
                                Jenis Surat
                            </h4>
                            <div class="inline-flex items-center gap-3 px-4 py-2.5 bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/30 dark:border-[#2A3654] rounded-xl text-on-background dark:text-[#E8E6E0] font-medium shadow-sm w-full sm:w-auto">
                                <span>{{ $outgoingLetter->letterType->type_name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div>
                        <h4 class="font-label-sm text-[11px] text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-widest font-bold mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[14px] text-primary dark:text-ds-accent">subject</span>
                            Perihal
                        </h4>
                        <div class="bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/30 dark:border-[#2A3654] rounded-2xl p-5 shadow-sm">
                            <p class="font-body-lg text-on-background dark:text-[#E8E6E0] font-bold">{{ $outgoingLetter->subject }}</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <h4 class="font-label-sm text-[11px] text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-widest font-bold mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[14px] text-primary dark:text-ds-accent">description</span>
                            Isi Surat / Keterangan
                        </h4>
                        
                        <style>
                            .dark .prose-letter table, .dark .prose-letter tr, .dark .prose-letter td, .dark .prose-letter th, .dark .prose-letter div, .dark .prose-letter p, .dark .prose-letter span {
                                background-color: transparent !important;
                                color: #E8E6E0 !important;
                            }
                            .dark .prose-letter strong, .dark .prose-letter b, .dark .prose-letter h1, .dark .prose-letter h2, .dark .prose-letter h3, .dark .prose-letter h4 {
                                color: #FFFFFF !important;
                            }
                        </style>
                        <div class="bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/30 dark:border-[#2A3654] rounded-2xl p-6 shadow-sm group hover:border-primary/30 dark:hover:border-ds-accent/30 transition-colors prose-letter text-on-surface dark:text-[#E8E6E0]">
                            <div class="font-body-lg leading-relaxed whitespace-pre-wrap">{!! $outgoingLetter->content !!}</div>

                            <!-- The signature blocks were removed per user request -->
                        </div>
                    </div>
                </div>
                
                <!-- Footer Actions -->
                <div class="mt-10 pt-8 border-t border-outline-variant/20 dark:border-[#2A3654] flex flex-wrap gap-4 items-center justify-end">
                    @if($outgoingLetter->file_path)
                    <a href="{{ asset('storage/' . $outgoingLetter->file_path) }}" target="_blank" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-[#1A2440] text-on-surface dark:text-[#E8E6E0] border border-outline-variant/30 dark:border-[#2A3654] font-bold text-sm hover:border-primary dark:hover:border-ds-accent hover:text-primary dark:hover:text-ds-accent transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">attachment</span>
                        Lihat Lampiran
                    </a>
                    @endif
                    @if($outgoingLetter->status == 'pending')
                    <a href="{{ route('outgoing-letters.edit', $outgoingLetter->id) }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-[#1A2440] text-on-surface dark:text-[#E8E6E0] border border-outline-variant/30 dark:border-[#2A3654] font-bold text-sm hover:border-primary dark:hover:border-ds-accent hover:text-primary dark:hover:text-ds-accent transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                        Edit Surat
                    </a>
                    @endif
                    <a href="{{ route('outgoing-letters.export-word', $outgoingLetter->id) }}" class="px-6 py-3 rounded-xl bg-[#2B579A] text-white font-bold text-sm hover:shadow-lg hover:shadow-[#2B579A]/30 hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">description</span>
                        Export Word
                    </a>
                    <a href="{{ route('outgoing-letters.export-pdf', $outgoingLetter->id) }}" target="_blank" class="px-6 py-3 rounded-xl bg-primary dark:bg-ds-accent text-on-primary dark:text-[#0B1220] font-bold text-sm hover:shadow-lg hover:shadow-primary/30 dark:hover:shadow-ds-accent/30 hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                        Cetak PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
