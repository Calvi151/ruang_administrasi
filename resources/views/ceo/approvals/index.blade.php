@extends('ceo.layouts.app')

@section('title', 'Persetujuan Surat - Ruang Administrasi')
@section('page-title', 'Persetujuan Surat')

@section('content')
<div class="flex flex-col gap-1 mb-6">
    <h2 class="font-h2 text-h2 text-on-surface">Persetujuan Surat</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant">Kelola persetujuan surat keluar dari staf</p>
</div>

<!-- Action Bar -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <!-- Search -->
    <div class="w-full md:w-96 relative group">
        <form action="{{ url('/ceo/letter-approvals') }}" method="GET">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors text-[20px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal, atau tujuan..." class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant/60 rounded-xl font-body-sm text-body-sm text-on-surface focus:border-primary focus:ring-4 focus:ring-primary/10 focus:outline-none transition-all shadow-sm placeholder:text-outline/70">
        </form>
    </div>
</div>

<div class="bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant/30 bg-surface-container-lowest text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wider">
                    <th class="py-4 px-6 font-semibold w-1/5">Nomor Surat</th>
                    <th class="py-4 px-6 font-semibold w-1/4">Perihal</th>
                    <th class="py-4 px-6 font-semibold w-1/5">Tujuan</th>
                    <th class="py-4 px-6 font-semibold w-1/6">Pembuat</th>
                    <th class="py-4 px-6 font-semibold w-1/6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm text-on-surface divide-y divide-outline-variant/30">
                @forelse($letters as $letter)
                <tr class="hover:bg-surface-container-lowest/50 transition-colors group">
                    <td class="py-4 px-6">
                        <span class="font-semibold text-on-surface">{{ $letter->letter_number }}</span>
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">
                        <div class="max-w-[200px] truncate" title="{{ $letter->subject }}">
                            {{ $letter->subject ?? '-' }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">
                        {{ $letter->recipient ?? '-' }}
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">
                        <div class="flex flex-col">
                            <span>{{ optional($letter->creator)->name ?? optional($letter->creator)->nip ?? '-' }}</span>
                            <span class="text-xs text-outline">{{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d M Y') }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <a href="{{ url('ceo/letter-approvals/' . $letter->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-opacity shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">rule</span>
                            Review
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-outline">
                                <span class="material-symbols-outlined text-3xl">fact_check</span>
                            </div>
                            <p class="font-label-md text-label-md text-on-surface-variant">Tidak ada surat yang menunggu persetujuan</p>
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
