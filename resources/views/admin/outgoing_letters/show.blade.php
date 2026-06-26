@extends('admin.layouts.app')

@section('title', 'Detail Surat Keluar - Ruang Administrasi')
@section('page-title', 'Detail Surat Keluar')
@section('page-subtitle', 'Informasi lengkap terkait surat keluar')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-4 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
        Kembali ke Surat Keluar
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
    <!-- Info Card -->
    <div class="lg:col-span-2 flex flex-col gap-4">
        <div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-4 relative overflow-hidden">
            <div class="absolute -right-6 -top-4 text-primary-fixed-dim/10">
                <span class="material-symbols-outlined text-[150px] icon-fill">send</span>
            </div>
            
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-5 pb-6 border-b border-border-muted">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-primary-fixed text-primary flex items-center justify-center shadow-inner">
                            <span class="material-symbols-outlined text-[48px] icon-fill">outbox</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-headline-md text-on-background font-bold tracking-tight">{{ $outgoingLetter->letter_number }}</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant flex items-center gap-4 mt-1">
                                <span class="material-symbols-outlined text-[14px]">business</span>
                                Tujuan: {{ $outgoingLetter->recipient }}
                            </p>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    @if($outgoingLetter->status == 'pending')
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-status-peach text-tertiary-container font-label-md text-label-md border border-tertiary-fixed shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                            Menunggu Persetujuan
                        </span>
                    @elseif($outgoingLetter->status == 'acc')
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-status-mint text-secondary font-label-md text-label-md border border-secondary-fixed shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-secondary"></span>
                            Disetujui
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-error-container text-on-error-container font-label-md text-label-md border border-error-container/50 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-error"></span>
                            Ditolak
                        </span>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="flex gap-12">
                        <div>
                            <h4 class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-2">Tanggal Surat</h4>
                            <div class="flex items-center gap-4 font-body-lg text-body-lg text-on-background bg-surface-container-low px-2 py-1 rounded-3xl inline-flex border border-border-muted/50">
                                <span class="material-symbols-outlined text-primary">calendar_month</span>
                                {{ \Carbon\Carbon::parse($outgoingLetter->date_sent)->translatedFormat('d F Y') }}
                            </div>
                        </div>
                        <div>
                            <h4 class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-2">Jenis Surat</h4>
                            <div class="flex items-center gap-4 font-body-lg text-body-lg text-on-background bg-surface-container-low px-2 py-1 rounded-3xl inline-flex border border-border-muted/50">
                                <span class="material-symbols-outlined text-primary">category</span>
                                {{ $outgoingLetter->letterType->type_name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-2">Perihal</h4>
                        <div class="bg-surface-bright border border-border-muted rounded-2xl p-4">
                            <p class="font-body-lg text-body-lg text-on-background leading-relaxed font-bold">
                                {{ $outgoingLetter->subject }}
                            </p>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-2">Isi Surat / Keterangan</h4>
                        <div class="bg-surface-bright border border-border-muted rounded-2xl p-4">
                            <p class="font-body-md text-body-md text-on-background leading-relaxed whitespace-pre-wrap">{{ $outgoingLetter->content }}</p>
                        </div>
                    </div>
                </div>
                
                @if($outgoingLetter->status == 'pending')
                <div class="mt-6 flex gap-4 border-t border-border-muted pt-6">
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'ceo')
                        <!-- Approval Actions for Admin/CEO -->
                        <form action="{{ route('outgoing-letters.update-status', $outgoingLetter->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="acc">
                            <button type="submit" class="px-2 py-1 rounded-full bg-secondary text-on-secondary font-label-md text-label-md hover:shadow-lg hover:shadow-secondary/20 hover:-translate-y-0.5 transition-all flex items-center gap-4" onclick="return confirm('Setujui surat keluar ini?');">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                Setujui (ACC)
                            </button>
                        </form>
                        
                        <form action="{{ route('outgoing-letters.update-status', $outgoingLetter->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="px-2 py-1 rounded-full bg-error text-on-error font-label-md text-label-md hover:shadow-lg hover:shadow-error/20 hover:-translate-y-0.5 transition-all flex items-center gap-4" onclick="return confirm('Tolak surat keluar ini?');">
                                <span class="material-symbols-outlined text-[14px]">cancel</span>
                                Tolak
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('outgoing-letters.edit', $outgoingLetter->id) }}" class="px-2 py-1 rounded-full bg-primary-fixed text-primary font-label-md text-label-md hover:bg-primary-fixed-dim transition-all flex items-center gap-4 ml-auto">
                        <span class="material-symbols-outlined text-[14px]">edit</span>
                        Edit Surat
                    </a>
                </div>
                @endif
                
                <!-- Print/Export Actions -->
                @if($outgoingLetter->status == 'acc')
                <div class="mt-6 flex gap-4 border-t border-border-muted pt-6">
                    <a href="{{ route('outgoing-letters.export-word', $outgoingLetter->id) }}" class="px-2 py-1 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all flex items-center gap-4">
                        <span class="material-symbols-outlined text-[14px]">description</span>
                        Export Word Document
                    </a>
                    <a href="{{ route('outgoing-letters.export-pdf', $outgoingLetter->id) }}" target="_blank" class="px-2 py-1 rounded-full border border-primary text-primary font-label-md text-label-md hover:bg-primary-fixed transition-all flex items-center gap-4">
                        <span class="material-symbols-outlined text-[14px]">picture_as_pdf</span>
                        Cetak PDF
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Attachment Card -->
    <div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-4">
        <h3 class="font-headline-md text-headline-md text-on-background font-bold mb-4 flex items-center gap-4 border-b border-border-muted pb-4">
            <span class="material-symbols-outlined text-primary">attachment</span>
            Lampiran Surat
        </h3>
        
        @if($outgoingLetter->file_path)
            <div class="bg-primary-fixed/20 border border-primary-fixed-dim/30 rounded-2xl p-4 flex flex-col items-center text-center gap-4 transition-all hover:bg-primary-fixed/40 hover:border-primary/20 group">
                <div class="w-16 h-16 rounded-full bg-primary/10 text-primary flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[48px]">picture_as_pdf</span>
                </div>
                <div>
                    <h4 class="font-label-md text-label-md text-on-background font-bold truncate max-w-[200px]" title="{{ basename($outgoingLetter->file_path) }}">File Dokumen</h4>
                    <p class="font-label-sm text-label-sm text-outline mt-1">Format PDF</p>
                </div>
                <a href="{{ asset('storage/' . $outgoingLetter->file_path) }}" target="_blank" class="mt-2 w-full px-2 py-1.5 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-container transition-colors flex items-center justify-center gap-4">
                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
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
                    <p class="font-label-sm text-label-sm text-outline mt-1">Surat ini tidak memiliki file lampiran tambahan.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection







