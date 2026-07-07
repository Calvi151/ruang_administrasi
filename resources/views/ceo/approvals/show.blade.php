@extends('ceo.layouts.app')

@section('title', 'Review Surat')
@section('page-title', 'Review Surat')
@section('page-subtitle', 'Detail surat keluar untuk disetujui atau ditolak')

@section('content')
<div class="mb-4">
    <a href="{{ url('ceo/letter-approvals') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Daftar
    </a>
</div>

<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden flex flex-col md:flex-row">
    <!-- Letter Details -->
    <div class="flex-1 p-8 border-b md:border-b-0 md:border-r border-outline-variant">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Detail Surat</h3>
            <span class="bg-tertiary-container/20 text-tertiary px-3 py-1 rounded-full font-label-sm font-semibold uppercase tracking-wide">
                {{ $outgoingLetter->status }}
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1">Nomor Surat</label>
                <div class="font-body-base text-on-surface font-semibold">{{ $outgoingLetter->letter_number }}</div>
            </div>
            <div>
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1">Jenis Surat</label>
                <div class="font-body-base text-on-surface">{{ optional($outgoingLetter->letterType)->name ?? '-' }}</div>
            </div>
            <div class="md:col-span-2">
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1">Tujuan</label>
                <div class="font-body-base text-on-surface">{{ $outgoingLetter->destination ?? '-' }}</div>
            </div>
            <div class="md:col-span-2">
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1">Perihal / Subject</label>
                <div class="font-body-base text-on-surface font-semibold">{{ $outgoingLetter->subject ?? $outgoingLetter->perihal ?? '-' }}</div>
            </div>
            <div class="md:col-span-2">
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1">Pembuat</label>
                <div class="font-body-base text-on-surface">{{ optional($outgoingLetter->creator)->nip ?? '-' }} ({{ \Carbon\Carbon::parse($outgoingLetter->created_at)->format('d F Y, H:i') }})</div>
            </div>
            
            <div class="md:col-span-2 mt-4 pt-4 border-t border-outline-variant">
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-2">Lampiran (File)</label>
                @if($outgoingLetter->file_path)
                    <a href="{{ Storage::url($outgoingLetter->file_path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-high hover:bg-surface-dim rounded-xl font-body-sm transition-colors text-on-surface">
                        <span class="material-symbols-outlined text-[20px] text-primary">description</span>
                        Lihat Dokumen Terlampir
                    </a>
                @else
                    <p class="font-body-sm text-outline italic">Tidak ada lampiran dokumen.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Action Area -->
    <div class="w-full md:w-80 p-8 bg-surface-bright flex flex-col justify-center">
        <h4 class="font-label-md text-on-surface mb-4 text-center">Tindakan Persetujuan</h4>
        
        <form method="POST" action="{{ url('ceo/letter-approvals/' . $outgoingLetter->id . '/approve') }}" class="mb-3">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-secondary text-on-secondary py-3 rounded-xl font-label-md font-bold hover:opacity-90 transition-opacity shadow-sm">
                <span class="material-symbols-outlined icon-fill">check_circle</span>
                Setujui Surat (ACC)
            </button>
        </form>
        
        <form method="POST" action="{{ url('ceo/letter-approvals/' . $outgoingLetter->id . '/reject') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-error text-on-error py-3 rounded-xl font-label-md font-bold hover:opacity-90 transition-opacity shadow-sm">
                <span class="material-symbols-outlined icon-fill">cancel</span>
                Tolak Surat
            </button>
        </form>
    </div>
</div>
@endsection
