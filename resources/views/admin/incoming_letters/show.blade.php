@extends('admin.layouts.app')

@section('title', 'Detail Surat Masuk - Ruang Administrasi')
@section('page-title', 'Detail Surat Masuk')
@section('page-subtitle', 'Informasi lengkap terkait surat masuk')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('incoming-letters.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant dark:text-ds-text-primary dark:hover:text-ds-accent hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
        Kembali ke Surat Masuk
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
    <!-- Info Card -->
    <div class="lg:col-span-2 flex flex-col gap-4">
        <div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-4 relative overflow-hidden">
            <div class="absolute right-4 top-4 text-primary/10 dark:text-primary/5 pointer-events-none select-none">
                <span class="material-symbols-outlined text-[80px] icon-fill">drafts</span>
            </div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-5 pb-6 border-b border-border-muted">
                    <div class="w-16 h-16 rounded-2xl bg-primary-fixed text-primary flex items-center justify-center shadow-inner">
                        <span class="material-symbols-outlined text-[48px] icon-fill">mark_email_read</span>
                    </div>
                    <div>
                        <h3 class="font-headline-md text-headline-md text-on-background font-bold tracking-tight">{{ $incomingLetter->letter_number }}</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant flex items-center gap-4 mt-1">
                            <span class="material-symbols-outlined text-[14px]">domain</span>
                            {{ $incomingLetter->sender }}
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h4 class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-2">Tanggal Diterima</h4>
                        <div class="flex items-center gap-4 font-body-lg text-body-lg text-on-background bg-surface-container-low px-2 py-1 rounded-3xl inline-flex border border-border-muted/50">
                            <span class="material-symbols-outlined text-primary">calendar_month</span>
                            {{ \Carbon\Carbon::parse($incomingLetter->date_received)->translatedFormat('d F Y') }}
                        </div>
                    </div>

                    <div>
                        <h4 class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-2">Perihal / Ringkasan</h4>
                        <div class="bg-surface-bright border border-border-muted rounded-2xl p-4">
                            <div class="font-body-lg text-body-lg text-on-background leading-relaxed prose prose-slate max-w-none">
                                {!! $incomingLetter->subject !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex flex-wrap gap-4">
                    <a href="{{ route('outgoing-letters.create', ['reply_to' => $incomingLetter->id]) }}" class="px-5 py-2.5 rounded-full bg-amber-400 text-[#0B1220] font-bold font-label-md text-label-md hover:shadow-lg hover:shadow-amber-400/30 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">reply</span>
                        Balas Surat Ini
                    </a>
                    <a href="{{ route('incoming-letters.edit', $incomingLetter->id) }}" class="px-5 py-2.5 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Surat
                    </a>
                </div>
            </div>
        </div>

        <!-- Gmail-style Thread Balasan -->
        <div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-6 relative">
            <h3 class="font-headline-sm text-headline-sm text-on-background font-bold mb-4 flex items-center gap-2 border-b border-border-muted pb-4">
                <span class="material-symbols-outlined text-primary dark:text-ds-accent">forum</span>
                <span>Thread Balasan (Gmail Style)</span>
                @if($incomingLetter->replies && $incomingLetter->replies->count() > 0)
                    <span class="px-2.5 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800 font-bold ml-2">
                        {{ $incomingLetter->replies->count() }} Balasan
                    </span>
                @else
                    <span class="px-2.5 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400 font-bold ml-2">
                        0 Balasan
                    </span>
                @endif
            </h3>

            <div class="space-y-4">
                @forelse($incomingLetter->replies as $reply)
                    <div class="p-4 rounded-2xl bg-surface-container-low border border-outline-variant/50 dark:border-ds-border hover:border-primary/50 transition-all">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 border-b border-outline-variant/30 pb-3 mb-3">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-brand-amber">shortcut</span>
                                <div>
                                    <h4 class="font-headline-sm font-bold text-sm text-on-background">{{ $reply->letter_number }}</h4>
                                    <span class="text-xs text-on-surface-variant">Kepada: <strong>{{ $reply->recipient }}</strong></span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if($reply->status == 'pending')
                                    <span class="px-2.5 py-1 text-[11px] font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/30 rounded-full flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu ACC
                                    </span>
                                @elseif($reply->status == 'acc')
                                    <span class="px-2.5 py-1 text-[11px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 rounded-full flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[13px]">check_circle</span> Disetujui (Siap Kirim)
                                    </span>
                                @elseif($reply->status == 'delivered')
                                    <span class="px-2.5 py-1 text-[11px] font-bold bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/30 rounded-full flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[13px]">local_shipping</span> Terkirim (Delivered)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-[11px] font-bold bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/30 rounded-full">Ditolak</span>
                                @endif
                                <span class="text-xs text-on-surface-variant ml-2">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="text-xs text-on-background line-clamp-2 mb-3 bg-white/50 dark:bg-black/20 p-3 rounded-xl border border-outline-variant/20">
                            {!! strip_tags($reply->content) !!}
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] text-on-surface-variant flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                Tgl Surat: {{ \Carbon\Carbon::parse($reply->date_sent)->translatedFormat('d M Y') }}
                            </span>
                            <div class="flex gap-2">
                                <a href="{{ route('outgoing-letters.show', $reply->id) }}" class="px-3 py-1 bg-primary/10 text-primary dark:text-ds-accent hover:bg-primary hover:text-white rounded-lg text-xs font-semibold transition-colors inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">visibility</span> Lihat Balasan
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-on-surface-variant dark:text-ds-text-secondary">
                        <span class="material-symbols-outlined text-4xl opacity-40 mb-2">mark_email_unread</span>
                        <p class="text-sm font-semibold">Belum ada surat balasan untuk surat masuk ini.</p>
                        <p class="text-xs opacity-80 mt-1">Klik "Balas Surat Ini" di atas untuk membuat tanggapan secara langsung.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Attachment Card -->
    <div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-4">
        <h3 class="font-headline-md text-headline-md text-on-background font-bold mb-4 flex items-center gap-4 border-b border-border-muted pb-4">
            <span class="material-symbols-outlined text-primary">attachment</span>
            Lampiran Surat
        </h3>
        
        @if($incomingLetter->file_path)
            <div class="bg-primary-fixed/20 border border-primary-fixed-dim/30 rounded-2xl p-4 flex flex-col items-center text-center gap-4 transition-all hover:bg-primary-fixed/40 hover:border-primary/20 group">
                <div class="w-16 h-16 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[48px]">picture_as_pdf</span>
                </div>
                <div>
                    <h4 class="font-label-md text-label-md text-on-background font-bold truncate max-w-[200px]" title="{{ basename($incomingLetter->file_path) }}">File Dokumen</h4>
                    <p class="font-label-sm text-label-sm text-outline mt-1">Format PDF</p>
                </div>
                <a href="{{ asset('storage/' . $incomingLetter->file_path) }}" target="_blank" class="mt-2 w-full px-5 py-2.5 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-container transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                    Buka Dokumen
                </a>
            </div>
        @else
            <div class="bg-surface-container-low border border-dashed border-border-muted rounded-2xl p-4 flex flex-col items-center text-center gap-4">
                <div class="w-16 h-16 rounded-full bg-surface-variant text-outline flex items-center justify-center">
                    <span class="material-symbols-outlined text-[48px]">description</span>
                </div>
                <div>
                    <h4 class="font-label-md text-label-md text-on-background">Tidak ada lampiran</h4>
                    <p class="font-label-sm text-label-sm text-outline mt-1">Dokumen fisik belum didigitalisasi.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection







