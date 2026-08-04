@extends('admin.layouts.app')

@section('title', 'Detail Surat Masuk - Ruang Administrasi')
@section('page-title', 'Detail Surat Masuk')
@section('page-subtitle', 'Informasi lengkap terkait surat masuk')

@section('content')
<!-- Back Button -->
<div class="mb-6 animate-fade-in" style="animation-delay: 50ms;">
    <a href="{{ route('incoming-letters.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-[#141C33] border border-outline-variant/30 dark:border-[#2A3654] text-on-surface-variant dark:text-ds-text-secondary hover:text-primary dark:hover:text-ds-accent hover:border-primary/30 dark:hover:border-ds-accent/30 hover:shadow-md transition-all font-label-md text-label-md group">
        <span class="material-symbols-outlined text-[16px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
        Kembali ke Daftar Surat
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <!-- Main Info Card -->
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="glass-card bg-white dark:bg-[#141C33] rounded-3xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm relative overflow-hidden animate-fade-in" style="animation-delay: 100ms;">
            <!-- Decorative Glow -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 dark:bg-ds-accent/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
            
            <div class="p-8 relative z-10">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-6 mb-8 pb-8 border-b border-outline-variant/20 dark:border-[#2A3654]">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-primary/10 to-primary/5 dark:from-ds-accent/20 dark:to-ds-accent/5 text-primary dark:text-ds-accent flex items-center justify-center shadow-inner shrink-0 border border-primary/10 dark:border-ds-accent/10">
                        <span class="material-symbols-outlined text-[40px] icon-fill">mark_email_read</span>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-[11px] font-bold tracking-wide uppercase mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Surat Masuk
                        </div>
                        <h3 class="font-headline-md text-2xl md:text-3xl text-on-background dark:text-[#E8E6E0] font-bold tracking-tight mb-2">{{ $incomingLetter->letter_number }}</h3>
                        <p class="font-body-md text-on-surface-variant dark:text-ds-text-secondary flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px]">domain</span>
                            {{ $incomingLetter->sender }}
                        </p>
                    </div>
                </div>

                <!-- Content Details -->
                <div class="space-y-8">
                    <!-- Date -->
                    <div>
                        <h4 class="font-label-sm text-[11px] text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-widest font-bold mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[14px] text-primary dark:text-ds-accent">calendar_month</span>
                            Tanggal Diterima
                        </h4>
                        <div class="inline-flex items-center gap-3 px-4 py-2.5 bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/30 dark:border-[#2A3654] rounded-xl text-on-background dark:text-[#E8E6E0] font-medium shadow-sm">
                            <span class="text-primary dark:text-ds-accent font-bold">{{ \Carbon\Carbon::parse($incomingLetter->date_received)->translatedFormat('d') }}</span>
                            <span class="w-px h-4 bg-outline-variant/30 dark:bg-[#2A3654]"></span>
                            <span>{{ \Carbon\Carbon::parse($incomingLetter->date_received)->translatedFormat('F Y') }}</span>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div>
                        <h4 class="font-label-sm text-[11px] text-on-surface-variant dark:text-ds-text-secondary uppercase tracking-widest font-bold mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[14px] text-primary dark:text-ds-accent">subject</span>
                            Perihal / Ringkasan
                        </h4>
                        <div class="bg-slate-50 dark:bg-[#0F172E] border border-outline-variant/30 dark:border-[#2A3654] rounded-2xl p-6 shadow-sm group hover:border-primary/30 dark:hover:border-ds-accent/30 transition-colors">
                            <div class="font-body-lg text-on-background dark:text-[#E8E6E0] leading-relaxed prose prose-slate dark:prose-invert max-w-none">
                                {!! $incomingLetter->subject !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-10 pt-8 border-t border-outline-variant/20 dark:border-[#2A3654] flex flex-wrap gap-4 items-center">
                    @if($incomingLetter->replies->isNotEmpty())
                    <button type="button" onclick="alert('✅ Surat ini sudah dibalas (No: {{ $incomingLetter->replies->first()->letter_number }}).');" class="px-6 py-3 rounded-xl bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/30 font-bold text-sm cursor-not-allowed flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        Sudah Dibalas ({{ $incomingLetter->replies->count() }}x)
                    </button>
                    @else
                    <a href="{{ route('outgoing-letters.create', ['reply_to' => $incomingLetter->id]) }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-400 text-white dark:text-[#0B1220] font-bold text-sm hover:shadow-lg hover:shadow-amber-500/30 hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">reply</span>
                        Balas Surat Ini
                    </a>
                    @endif
                    <a href="{{ route('incoming-letters.edit', $incomingLetter->id) }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-[#1A2440] text-on-surface dark:text-[#E8E6E0] border border-outline-variant/30 dark:border-[#2A3654] font-bold text-sm hover:border-primary dark:hover:border-ds-accent hover:text-primary dark:hover:text-ds-accent transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">edit</span>
                        Edit Surat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Attachment Side Card -->
    <div class="glass-card bg-white dark:bg-[#141C33] rounded-3xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm p-6 animate-fade-in" style="animation-delay: 200ms;">
        <h3 class="font-headline-sm text-lg text-on-background dark:text-[#E8E6E0] font-bold mb-5 flex items-center gap-3 border-b border-outline-variant/20 dark:border-[#2A3654] pb-4">
            <div class="w-8 h-8 rounded-lg bg-primary/10 dark:bg-ds-accent/10 text-primary dark:text-ds-accent flex items-center justify-center">
                <span class="material-symbols-outlined text-[18px]">attachment</span>
            </div>
            Lampiran Dokumen
        </h3>
        
        @if($incomingLetter->file_path)
            <div class="bg-gradient-to-b from-slate-50 to-white dark:from-[#0F172E] dark:to-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] rounded-2xl p-6 flex flex-col items-center text-center gap-4 transition-all hover:shadow-md hover:border-primary/40 dark:hover:border-ds-accent/40 group relative overflow-hidden">
                <!-- Hover Glow -->
                <div class="absolute inset-0 bg-primary/5 dark:bg-ds-accent/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="w-20 h-20 rounded-2xl bg-white dark:bg-[#1A2440] shadow-sm border border-outline-variant/30 dark:border-[#2A3654] text-red-500 dark:text-red-400 flex items-center justify-center group-hover:scale-110 group-hover:-rotate-3 transition-all duration-300 relative z-10">
                    <span class="material-symbols-outlined text-[48px] icon-fill">picture_as_pdf</span>
                </div>
                <div class="relative z-10 mt-2">
                    <h4 class="font-bold text-on-background dark:text-[#E8E6E0] truncate max-w-[180px]" title="{{ basename($incomingLetter->file_path) }}">File Resmi</h4>
                    <p class="text-xs text-on-surface-variant dark:text-ds-text-secondary mt-1">Dokumen PDF Terlampir</p>
                </div>
                <a href="{{ asset('storage/' . $incomingLetter->file_path) }}" target="_blank" class="mt-4 w-full px-5 py-2.5 rounded-xl bg-primary dark:bg-ds-accent text-on-primary dark:text-[#0B1220] font-bold text-sm hover:shadow-lg hover:shadow-primary/30 dark:hover:shadow-ds-accent/30 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 relative z-10">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                    Buka Dokumen
                </a>
            </div>
        @else
            <div class="bg-slate-50 dark:bg-[#0F172E] border-2 border-dashed border-outline-variant/40 dark:border-[#2A3654] rounded-2xl p-8 flex flex-col items-center text-center gap-4">
                <div class="w-16 h-16 rounded-full bg-surface-variant dark:bg-[#1A2440] text-outline dark:text-ds-text-secondary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[32px]">description_empty</span>
                </div>
                <div>
                    <h4 class="font-bold text-on-background dark:text-[#E8E6E0]">Tidak Ada Dokumen</h4>
                    <p class="text-xs text-on-surface-variant dark:text-ds-text-secondary mt-2 max-w-[200px] mx-auto leading-relaxed">
                        Surat fisik belum didigitalisasi ke dalam bentuk file PDF.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
