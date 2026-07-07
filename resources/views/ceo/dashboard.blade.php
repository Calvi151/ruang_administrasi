@extends('ceo.layouts.app')

@section('title','Dashboard Pimpinan')

@section('content')

<!-- Page Header -->
<div class="flex flex-col gap-1">
    <h2 class="font-bold text-[24px] text-on-surface leading-tight">Dashboard Pimpinan</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant">
        {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
    </p>
</div>

<!-- 2-Column Stat Grid (matches Stitch exactly) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-gutter">
    <!-- Card 1: Total Surat Masuk -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between border-l-[3px] border-l-primary group cursor-pointer" onclick="window.location.href='{{ url('ceo/incoming-letters') }}'">
        <div class="flex flex-col gap-1">
            <span class="font-label-md text-label-md text-on-surface-variant">Total Surat Masuk</span>
            <div class="flex items-end gap-3 mt-1">
                <span class="font-bold text-[28px] text-on-surface leading-none">{{ $totalIncoming }}</span>
                <span class="bg-secondary-container/30 text-secondary px-2 py-0.5 rounded-full font-label-sm text-label-sm flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">trending_up</span> +12%
                </span>
            </div>
        </div>
        <div class="w-14 h-14 bg-primary-fixed rounded-xl flex items-center justify-center text-primary group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined icon-fill" style="font-size: 28px;">inbox</span>
        </div>
    </div>

    <!-- Card 2: Menunggu Persetujuan -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow flex items-center justify-between border-l-[3px] border-l-tertiary group cursor-pointer" onclick="window.location.href='{{ url('ceo/letter-approvals') }}'">
        <div class="flex flex-col gap-1">
            <span class="font-label-md text-label-md text-on-surface-variant">Menunggu Persetujuan</span>
            <div class="flex items-end gap-3 mt-1">
                <span class="font-bold text-[28px] text-on-surface leading-none">{{ $outgoingPending }}</span>
            </div>
            <span class="font-body-sm text-body-sm text-outline mt-1">Surat perlu tindakan Anda</span>
        </div>
        <div class="w-14 h-14 bg-tertiary-fixed rounded-xl flex items-center justify-center text-tertiary group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined icon-fill" style="font-size: 28px;">schedule</span>
        </div>
    </div>
</div>

<!-- Surat Menunggu Persetujuan — Main Panel (matches Stitch) -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 shadow-sm flex flex-col gap-5 border-l-[3px] border-l-tertiary relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-tertiary-fixed/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex items-center justify-between z-10">
        <h3 class="text-[18px] font-bold text-on-surface flex items-center gap-2">
            🔔 Surat Menunggu Persetujuan
        </h3>
        <span class="bg-tertiary-container/20 text-tertiary px-3 py-1 rounded-full font-label-sm text-label-sm font-semibold">Prioritas Tinggi</span>
    </div>

    <div class="overflow-x-auto z-10">
        @if($recentOutgoing->count())
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wide">
                    <th class="pb-3 font-semibold w-1/3">No Surat</th>
                    <th class="pb-3 font-semibold w-1/3">Pengirim</th>
                    <th class="pb-3 font-semibold">Tanggal</th>
                    <th class="pb-3 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-base text-body-base">
                @foreach($recentOutgoing as $letter)
                <tr class="border-b border-outline-variant/50 hover:bg-surface-container-lowest transition-colors group">
                    <td class="py-4 font-semibold text-on-surface">{{ $letter->letter_number ?? '-' }}</td>
                    <td class="py-4 text-on-surface-variant">{{ optional($letter->creator)->nip ?? Str::limit($letter->subject ?? '-', 20) }}</td>
                    <td class="py-4 text-on-surface-variant text-sm">{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y, H:i') }}</td>
                    <td class="py-4 text-right">
                        <a href="{{ url('ceo/letter-approvals/' . $letter->id) }}" class="p-2 hover:bg-surface-container-high rounded-lg text-primary transition-colors inline-block">
                            <span class="material-symbols-outlined">visibility</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-8 text-outline font-body-sm">Tidak ada surat yang menunggu persetujuan.</div>
        @endif
    </div>

    <div class="mt-2 flex justify-start z-10">
        <a href="{{ url('ceo/letter-approvals') }}" class="bg-primary hover:opacity-90 text-on-primary rounded-xl px-5 py-2.5 font-label-md font-semibold transition-all shadow-sm inline-flex items-center gap-2">
            Proses Persetujuan
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
        </a>
    </div>
</div>

<!-- Surat Masuk Terbaru -->
<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 shadow-sm flex flex-col gap-5 border-l-[3px] border-l-primary relative overflow-hidden">
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-fixed/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="flex items-center justify-between z-10">
        <h3 class="text-[18px] font-bold text-on-surface">Surat Masuk Terbaru</h3>
        <a href="{{ url('/ceo/incoming-letters') }}" class="font-label-sm text-label-sm font-semibold text-primary hover:underline">Lihat Semua</a>
    </div>

    <div class="overflow-x-auto z-10">
        @if($recentIncoming->count())
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wide">
                    <th class="pb-3 font-semibold w-1/3">No Surat</th>
                    <th class="pb-3 font-semibold w-1/3">Pengirim</th>
                    <th class="pb-3 font-semibold">Perihal</th>
                    <th class="pb-3 font-semibold">Tanggal</th>
                </tr>
            </thead>
            <tbody class="font-body-base text-body-base">
                @foreach($recentIncoming as $letter)
                <tr class="border-b border-outline-variant/50 hover:bg-surface-container-lowest transition-colors">
                    <td class="py-4 font-semibold text-on-surface">{{ $letter->letter_number ?? $letter->nomor_surat ?? '-' }}</td>
                    <td class="py-4 text-on-surface-variant">{{ $letter->sender ?? $letter->pengirim ?? '-' }}</td>
                    <td class="py-4 text-on-surface-variant text-sm">{{ Str::limit($letter->subject ?? $letter->perihal ?? '-', 30) }}</td>
                    <td class="py-4 text-on-surface-variant text-sm">{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-8 text-outline font-body-sm">Belum ada surat masuk.</div>
        @endif
    </div>
</div>

@endsection
