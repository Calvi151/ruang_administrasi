@extends('ceo.layouts.app')

@section('title', 'Surat Keluar')
@section('page-title', 'Surat Keluar')
@section('page-subtitle', 'Daftar semua surat keluar (Read-only)')

@section('content')
<div class="flex flex-col gap-1 mb-2">
    <h2 class="font-display text-display text-on-surface">Surat Keluar</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant">Arsip surat keluar perusahaan</p>
</div>

<!-- Search Form -->
<form method="GET" action="{{ url('/ceo/outgoing-letters') }}" class="mb-4">
    <div class="flex items-center gap-2 max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal..." class="w-full px-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-sm focus:border-primary focus:ring-2 focus:ring-primary-fixed-dim focus:outline-none transition-all">
        <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-xl font-label-md font-semibold hover:opacity-90 transition-opacity">Cari</button>
    </div>
</form>

<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wide">
                    <th class="py-4 px-6 font-semibold">Nomor Surat</th>
                    <th class="py-4 px-6 font-semibold">Perihal</th>
                    <th class="py-4 px-6 font-semibold">Tujuan</th>
                    <th class="py-4 px-6 font-semibold">Status</th>
                    <th class="py-4 px-6 font-semibold">Tanggal</th>
                    <th class="py-4 px-6 font-semibold">Lampiran</th>
                </tr>
            </thead>
            <tbody class="font-body-base text-body-base">
                @forelse($letters as $letter)
                <tr class="border-b border-outline-variant/50 hover:bg-surface-container-low transition-colors">
                    <td class="py-4 px-6 font-semibold text-on-surface">{{ $letter->letter_number ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant max-w-xs truncate">{{ $letter->subject ?? $letter->perihal ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ $letter->destination ?? '-' }}</td>
                    <td class="py-4 px-6">
                        @if($letter->status === 'acc')
                            <span class="bg-secondary-container/20 text-secondary px-3 py-1 rounded-full font-label-sm text-label-sm font-semibold">Disetujui</span>
                        @elseif($letter->status === 'reject')
                            <span class="bg-error-container/20 text-error px-3 py-1 rounded-full font-label-sm text-label-sm font-semibold">Ditolak</span>
                        @else
                            <span class="bg-tertiary-container/20 text-tertiary px-3 py-1 rounded-full font-label-sm text-label-sm font-semibold">Pending</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</td>
                    <td class="py-4 px-6">
                        @if($letter->file_path)
                            <a href="{{ Storage::url($letter->file_path) }}" target="_blank" class="text-primary hover:underline font-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">download</span> Unduh
                            </a>
                        @else
                            <span class="text-outline italic text-sm">Tidak ada</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-outline">Data surat keluar tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $letters->links() }}
</div>
@endsection
