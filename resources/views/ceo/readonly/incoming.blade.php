@extends('ceo.layouts.app')

@section('title', 'Surat Masuk')
@section('page-title', 'Surat Masuk')
@section('page-subtitle', 'Daftar semua surat masuk (Read-only)')

@section('content')
<div class="flex flex-col gap-1 mb-2">
    <h2 class="font-display text-display text-on-surface">Surat Masuk</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant">Arsip surat masuk perusahaan</p>
</div>

<!-- Search Form -->
<form method="GET" action="{{ url('/ceo/incoming-letters') }}" class="mb-4">
    <div class="flex items-center gap-2 max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal, atau pengirim..." class="w-full px-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-sm focus:border-primary focus:ring-2 focus:ring-primary-fixed-dim focus:outline-none transition-all">
        <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-xl font-label-md font-semibold hover:opacity-90 transition-opacity">Cari</button>
    </div>
</form>

<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wide">
                    <th class="py-4 px-6 font-semibold">Nomor Surat</th>
                    <th class="py-4 px-6 font-semibold">Pengirim</th>
                    <th class="py-4 px-6 font-semibold">Perihal</th>
                    <th class="py-4 px-6 font-semibold">Tanggal Surat</th>
                    <th class="py-4 px-6 font-semibold">Lampiran</th>
                </tr>
            </thead>
            <tbody class="font-body-base text-body-base">
                @forelse($letters as $letter)
                <tr class="border-b border-outline-variant/50 hover:bg-surface-container-low transition-colors">
                    <td class="py-4 px-6 font-semibold text-on-surface">{{ $letter->nomor_surat ?? $letter->letter_number ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ $letter->pengirim ?? $letter->sender ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant max-w-xs truncate">{{ $letter->perihal ?? $letter->subject ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ $letter->tanggal_surat ? \Carbon\Carbon::parse($letter->tanggal_surat)->format('d M Y') : '-' }}</td>
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
                    <td colspan="5" class="py-8 text-center text-outline">Data surat masuk tidak ditemukan.</td>
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
