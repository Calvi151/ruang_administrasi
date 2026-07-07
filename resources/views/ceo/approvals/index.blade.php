@extends('ceo.layouts.app')

@section('title', 'Persetujuan Surat')
@section('page-title', 'Persetujuan Surat')
@section('page-subtitle', 'Daftar surat yang menunggu persetujuan')

@section('content')
<div class="flex flex-col gap-1 mb-2">
    <h2 class="font-display text-display text-on-surface">Persetujuan Surat</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant">Kelola persetujuan surat keluar</p>
</div>

<!-- Search Form -->
<form method="GET" action="{{ url('/ceo/letter-approvals') }}" class="mb-4">
    <div class="flex items-center gap-2 max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal surat..." class="w-full px-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-sm focus:border-primary focus:ring-2 focus:ring-primary-fixed-dim focus:outline-none transition-all">
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
                    <th class="py-4 px-6 font-semibold">Pembuat</th>
                    <th class="py-4 px-6 font-semibold">Tanggal</th>
                    <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-base text-body-base">
                @forelse($letters as $letter)
                <tr class="border-b border-outline-variant/50 hover:bg-surface-container-low transition-colors">
                    <td class="py-4 px-6 font-semibold text-on-surface">{{ $letter->letter_number }}</td>
                    <td class="py-4 px-6 text-on-surface-variant max-w-xs truncate">{{ $letter->subject ?? $letter->perihal }}</td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ optional($letter->creator)->nip ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</td>
                    <td class="py-4 px-6 text-right">
                        <a href="{{ url('ceo/letter-approvals/' . $letter->id) }}" class="inline-flex items-center gap-2 bg-primary-container text-on-primary-container px-3 py-1.5 rounded-lg font-label-sm hover:opacity-90 transition-opacity">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                            Review
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-outline">Tidak ada surat yang menunggu persetujuan.</td>
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
