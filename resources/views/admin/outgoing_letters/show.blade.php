@extends('admin.layouts.app')

@section('title', 'Detail Surat Keluar - Ruang Administrasi')
@section('page-title', 'Detail Surat Keluar')

@section('content')
<div class="mb-6">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
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
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-label-sm text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> PENDING
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
                <div class="bg-surface-container-low border border-outline-variant/30 rounded-lg p-4">
                    <div class="font-body-sm text-body-sm text-on-surface leading-relaxed whitespace-pre-wrap">{!! $outgoingLetter->content !!}</div>
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
            @if($outgoingLetter->status == 'acc')
            <a href="{{ route('outgoing-letters.export-word', $outgoingLetter->id) }}" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">description</span>
                Export Word
            </a>
            <a href="{{ route('outgoing-letters.export-pdf', $outgoingLetter->id) }}" target="_blank" class="px-4 py-2 bg-surface-container-lowest border border-primary text-primary rounded-lg font-label-md text-label-md hover:bg-primary-fixed transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                Cetak PDF
            </a>
            @endif
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
