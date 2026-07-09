@extends('ceo.layouts.app')

@section('title', 'Review Persetujuan Surat - Ruang Administrasi')
@section('page-title', 'Review Surat Keluar')

@section('content')
<div class="mb-6">
    <a href="{{ url('ceo/letter-approvals') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Daftar Persetujuan
    </a>
</div>

<div class="bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden flex flex-col md:flex-row">
    <!-- Letter Details -->
    <div class="flex-1 p-8 border-b md:border-b-0 md:border-r border-outline-variant/50 bg-surface-container-lowest">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-outline-variant/30">
            <div>
                <span class="text-outline uppercase tracking-wider font-label-sm text-xs mb-1 block">Nomor Surat</span>
                <h3 class="font-h3 text-h3 text-on-surface font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">outbox</span>
                    {{ $outgoingLetter->letter_number }}
                </h3>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-label-md text-sm">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> PENDING
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
            <div class="col-span-1 md:col-span-2">
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1 text-[11px]">Tujuan (Penerima)</label>
                <div class="font-body-base text-on-surface text-lg bg-surface-container-low px-4 py-3 rounded-xl border border-outline-variant/30">
                    {{ $outgoingLetter->recipient ?? '-' }}
                </div>
            </div>
            
            <div class="col-span-1 md:col-span-2">
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1 text-[11px]">Perihal / Ringkasan</label>
                <div class="font-body-base text-on-surface font-semibold text-lg bg-surface-container-low px-4 py-3 rounded-xl border border-outline-variant/30">
                    {{ $outgoingLetter->subject ?? '-' }}
                </div>
            </div>

            <div>
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1 text-[11px]">Jenis Surat</label>
                <div class="font-body-md text-on-surface">{{ optional($outgoingLetter->letterType)->type_name ?? '-' }}</div>
            </div>

            <div>
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-1 text-[11px]">Diajukan Oleh</label>
                <div class="font-body-md text-on-surface flex flex-col">
                    <span>{{ optional($outgoingLetter->creator)->name ?? optional($outgoingLetter->creator)->nip ?? '-' }}</span>
                    <span class="text-xs text-outline">{{ \Carbon\Carbon::parse($outgoingLetter->created_at)->translatedFormat('l, d F Y - H:i') }}</span>
                </div>
            </div>
            
            <div class="col-span-1 md:col-span-2 mt-2">
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-2 text-[11px]">Isi Surat Lengkap</label>
                <div class="bg-surface-container-lowest border border-outline-variant/50 rounded-xl p-6 min-h-[200px] prose prose-slate max-w-none text-on-surface">
                    {!! $outgoingLetter->content ?? '<p class="text-outline italic">Tidak ada isi teks surat.</p>' !!}
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 mt-4 pt-6 border-t border-outline-variant/30">
                <label class="block font-label-sm text-outline uppercase tracking-wider mb-3 text-[11px]">Dokumen Terlampir</label>
                @if($outgoingLetter->file_path)
                    <a href="{{ asset('storage/' . $outgoingLetter->file_path) }}" target="_blank" class="inline-flex items-center gap-3 px-5 py-3 bg-primary-fixed/30 hover:bg-primary-fixed/50 border border-primary-fixed-dim rounded-xl transition-colors text-primary font-label-md">
                        <div class="p-2 bg-primary rounded-lg text-on-primary">
                            <span class="material-symbols-outlined text-[20px]">description</span>
                        </div>
                        <div>
                            <span class="block text-sm text-on-surface">Lihat Lampiran</span>
                            <span class="block text-xs text-outline">Buka di tab baru</span>
                        </div>
                    </a>
                @else
                    <div class="inline-flex items-center gap-3 px-5 py-3 bg-surface-container-low border border-outline-variant/30 rounded-xl text-outline font-body-sm">
                        <span class="material-symbols-outlined text-[20px]">block</span>
                        Tidak ada lampiran fisik
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Action Area -->
    <div class="w-full md:w-96 p-8 bg-surface-container-low flex flex-col justify-center border-l border-outline-variant/30">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-primary-container text-primary rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl">fact_check</span>
            </div>
            <h4 class="font-h4 text-h4 text-on-surface mb-1">Keputusan Persetujuan</h4>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Tinjau dengan saksama sebelum mengambil keputusan.</p>
        </div>
        
        <form method="POST" action="{{ url('ceo/letter-approvals/' . $outgoingLetter->id . '/approve') }}" class="mb-4">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-secondary text-on-secondary py-3.5 rounded-xl font-label-md text-label-md font-bold hover:opacity-90 hover:scale-[1.02] active:scale-[0.98] transition-all shadow-sm">
                <span class="material-symbols-outlined icon-fill">check_circle</span>
                Setujui Surat (ACC)
            </button>
        </form>
        
        <form method="POST" action="{{ url('ceo/letter-approvals/' . $outgoingLetter->id . '/reject') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-surface-container-lowest text-error border border-error/30 hover:bg-error-container/50 py-3.5 rounded-xl font-label-md text-label-md font-bold hover:scale-[1.02] active:scale-[0.98] transition-all shadow-sm">
                <span class="material-symbols-outlined icon-fill">cancel</span>
                Tolak Pengajuan
            </button>
        </form>
    </div>
</div>
@endsection
