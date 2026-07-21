@extends('ceo.layouts.app')

@section('title', 'Surat Keluar - Ruang Administrasi')
@section('page-title', 'Surat Keluar')

@section('content')
<div class="flex flex-col gap-1 mb-6">
    <h2 class="font-h2 text-h2 text-on-surface">Surat Keluar</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant">Arsip surat keluar perusahaan</p>
</div>

<!-- Action Bar -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <!-- Search -->
    <div class="w-full md:w-96 relative group">
        <form action="{{ url('/ceo/outgoing-letters') }}" method="GET">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[20px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal..." class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant/60 rounded-xl font-body-sm text-body-sm text-on-surface focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none transition-all shadow-sm placeholder:text-outline/70">
        </form>
    </div>
</div>

<div class="bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/30 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="py-4 px-6 font-semibold w-1/6">Nomor Surat</th>
                    <th class="py-4 px-6 font-semibold w-1/4">Perihal</th>
                    <th class="py-4 px-6 font-semibold w-1/6">Tujuan</th>
                    <th class="py-4 px-6 font-semibold w-1/6">Status</th>
                    <th class="py-4 px-6 font-semibold w-1/6">Tanggal</th>
                    <th class="py-4 px-6 font-semibold w-1/6">Lampiran</th>
                </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/30">
                @forelse($letters as $letter)
                <tr class="hover:bg-surface-container-lowest/50 transition-colors group">
                    <td class="py-4 px-6">
                        <span class="font-semibold text-on-surface">{{ $letter->letter_number ?? '-' }}</span>
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">
                        <div class="max-w-xs truncate" title="{{ $letter->subject }}">
                            {{ $letter->subject ?? '-' }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">
                        {{ $letter->recipient ?? '-' }}
                    </td>
                    <td class="py-4 px-6">
                        @if($letter->status === 'acc')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-container/40 text-on-secondary-container font-label-sm text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> DISETUJUI
                            </span>
                        @elseif($letter->status === 'reject')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-error-container/40 text-error font-label-sm text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span> DITOLAK
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-label-sm text-[11px] font-bold tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> MENUNGGU
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-outline">calendar_today</span>
                            {{ $letter->date_sent ? \Carbon\Carbon::parse($letter->date_sent)->translatedFormat('d M Y') : \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d M Y') }}
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            @if($letter->file_path)
                                <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors inline-flex items-center gap-1 font-label-sm" title="Lihat Lampiran">
                                    <span class="material-symbols-outlined text-[18px]">attachment</span>
                                </a>
                            @else
                                <span class="text-outline text-xs italic px-2">Tidak ada</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-outline">
                                <span class="material-symbols-outlined text-3xl">send</span>
                            </div>
                            <p class="font-label-md text-label-md text-on-surface-variant">Belum ada data surat keluar</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($letters->hasPages())
    <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-lowest">
        {{ $letters->links() }}
    </div>
    @endif
</div>
@endsection
