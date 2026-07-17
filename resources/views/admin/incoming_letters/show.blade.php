@extends('admin.layouts.app')

@section('title', 'Detail Surat Masuk - Ruang Administrasi')
@section('page-title', 'Detail Surat Masuk')
@section('page-subtitle', 'Informasi lengkap terkait surat masuk')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('incoming-letters.index') }}" class="inline-flex items-center gap-4 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
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
                
                <div class="mt-6 flex gap-4">
                    <a href="{{ route('incoming-letters.edit', $incomingLetter->id) }}" class="px-5 py-2.5 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Surat
                    </a>
                </div>
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







