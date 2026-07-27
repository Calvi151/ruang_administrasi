@extends('ceo.layouts.app')

@section('title', 'Dashboard Pimpinan - Ruang Administrasi')
@section('page-title', 'Dashboard Pimpinan')
@section('page-subtitle', 'Selamat Datang, ' . (auth()->user()->employee->name ?? 'Bapak/Ibu Pimpinan'))

@section('content')
<!-- Stats & Hero Section (Bento Grid Style) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- HERO CARD: Menunggu Persetujuan -->
    <div class="lg:col-span-2 bg-brand-amber rounded-2xl p-6 md:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between shadow-[0_8px_30px_rgba(217,164,65,0.25)] text-brand-navy relative overflow-hidden transition-all duration-300 border border-brand-amber/80">
        <!-- Decorative background element -->
        <div class="absolute right-0 top-0 w-64 h-64 bg-white opacity-20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
        <div class="absolute left-10 bottom-0 w-48 h-48 bg-brand-navy opacity-10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>

        <div class="z-10 flex-1 pr-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-navy/15 font-label-md text-xs text-brand-navy font-bold tracking-wider uppercase mb-3 border border-brand-navy/10">
                <span class="w-2 h-2 rounded-full bg-brand-navy animate-ping"></span>
                Tindakan Diperlukan
            </div>
            <h3 class="font-headline-md text-2xl md:text-3xl font-bold mb-2 leading-tight">Menunggu Persetujuan</h3>
            <p class="font-body-md text-brand-navy/90 mb-6 max-w-md text-sm md:text-base leading-relaxed font-medium">
                Dokumen dan surat keluar yang memerlukan perhatian serta persetujuan Anda segera untuk menjaga kelancaran operasional.
            </p>
            <div class="flex flex-wrap gap-3">
                <div class="bg-white/40 backdrop-blur-sm rounded-xl px-3.5 py-1.5 flex items-center gap-2 font-label-md text-xs border border-white/60 shadow-sm text-brand-navy font-bold">
                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                    Respon Cepat Diperlukan
                </div>
                <div class="bg-white/40 backdrop-blur-sm rounded-xl px-3.5 py-1.5 flex items-center gap-2 font-label-md text-xs border border-white/60 shadow-sm text-brand-navy font-bold">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    Prioritas Pimpinan
                </div>
            </div>
        </div>

        <div class="z-10 mt-6 sm:mt-0 flex flex-col items-center shrink-0 w-full sm:w-48 bg-white/20 sm:bg-transparent p-4 sm:p-0 rounded-xl sm:rounded-none border border-white/30 sm:border-none">
            <!-- Radial Progress Ring Visual -->
            <div class="relative w-32 h-32 flex items-center justify-center">
                <svg class="w-full h-full transform -rotate-90 drop-shadow-sm" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" fill="none" r="42" stroke="rgba(255,255,255,0.4)" stroke-width="8"></circle>
                    <circle class="transition-all duration-1000 ease-out" cx="50" cy="50" fill="none" r="42" stroke="#0F1B3D" stroke-dasharray="263.89" stroke-dashoffset="{{ 263.89 - ($outgoingPending > 0 ? min(263.89, ($outgoingPending / 50) * 263.89) : 0) }}" stroke-width="8" stroke-linecap="round"></circle>
                </svg>
                <div class="absolute flex flex-col items-center justify-center text-center">
                    <span class="font-stat-number text-3xl font-extrabold text-brand-navy leading-none">{{ $outgoingPending }}</span>
                    <span class="font-label-md text-[11px] uppercase font-extrabold tracking-wider text-brand-navy/90 mt-1">Surat</span>
                </div>
            </div>
            <a href="{{ url('ceo/letter-approvals') }}" class="mt-5 bg-brand-navy text-white font-label-md text-sm px-5 py-2.5 rounded-xl hover:bg-brand-navy/95 hover:shadow-xl transition-all w-full flex justify-between items-center group shadow-md font-bold">
                <span>Proses Sekarang</span>
                <span class="material-symbols-outlined text-[18px] transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Stat Card: Total Surat Masuk -->
    <div class="bg-white dark:bg-[#141C33] rounded-2xl p-6 md:p-8 shadow-[0_4px_20px_rgba(15,27,61,0.07)] hover:shadow-lg flex flex-col justify-between border border-[#CCC7BD] dark:border-[#2A3654] transition-all duration-300 cursor-pointer group" onclick="window.location.href='{{ url('ceo/incoming-letters') }}'">
        <div class="flex justify-between items-start">
            <div>
                <span class="font-label-md text-xs text-brand-navy/70 dark:text-ds-text-secondary uppercase tracking-wider font-bold">Total Surat Masuk</span>
                <div class="mt-3 flex items-baseline gap-3">
                    <span class="font-stat-number text-4xl font-extrabold text-brand-navy dark:text-ds-text-primary group-hover:text-brand-amber transition-colors">{{ $totalIncoming }}</span>
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold {{ $growthPct >= 0 ? 'text-emerald-700 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-950/50 border-emerald-300 dark:border-emerald-800' : 'text-red-700 dark:text-red-400 bg-red-100 dark:bg-red-950/50 border-red-300 dark:border-red-800' }} px-2 py-0.5 rounded-full border shadow-xs">
                        <span class="material-symbols-outlined text-[14px]">{{ $growthPct >= 0 ? 'trending_up' : 'trending_down' }}</span>
                        {{ $growthPct >= 0 ? '+' : '' }}{{ $growthPct }}%
                    </span>
                </div>
            </div>
            <div class="w-12 h-12 bg-brand-navy/10 dark:bg-[#1D2847] rounded-xl flex items-center justify-center text-brand-navy dark:text-brand-amber group-hover:scale-110 transition-transform duration-300 shadow-inner">
                <span class="material-symbols-outlined text-2xl">inbox</span>
            </div>
        </div>

        <!-- Realtime Sparkline Bar Chart -->
        <div class="mt-8 pt-4 border-t border-[#E0DED8] dark:border-[#2A3654]">
            <div class="h-12 flex items-end justify-between gap-2 w-full opacity-85 group-hover:opacity-100 transition-opacity">
                @if(isset($sparklineHeights))
                    @foreach($sparklineHeights as $h)
                        <div class="w-full bg-brand-navy/30 dark:bg-brand-amber/40 rounded-t-sm group-hover:bg-brand-navy/70 dark:group-hover:bg-brand-amber/80 transition-all shadow-xs" style="height: {{ $h }}%;"></div>
                    @endforeach
                @else
                    <div class="w-full bg-brand-navy/20 h-1/3 rounded-t-sm"></div>
                    <div class="w-full bg-brand-navy/40 h-2/3 rounded-t-sm"></div>
                    <div class="w-full bg-brand-navy/30 h-1/2 rounded-t-sm"></div>
                    <div class="w-full bg-brand-navy/60 h-3/4 rounded-t-sm"></div>
                    <div class="w-full bg-brand-navy/50 h-2/3 rounded-t-sm"></div>
                    <div class="w-full bg-brand-navy h-full rounded-t-sm"></div>
                @endif
            </div>
            <div class="flex justify-between items-center mt-3 text-[11px] font-label-md text-gray-500 dark:text-ds-text-secondary">
                <span>Aktivitas Realtime 6 Hari Terakhir</span>
                <span class="text-brand-navy dark:text-brand-amber font-bold group-hover:underline">Lihat Arsip →</span>
            </div>
        </div>
    </div>
</div>

<!-- Tables Section (Dengan Border Tegas & Background Kontras) -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-8">
    <!-- Table 1: Surat Menunggu Persetujuan -->
    <div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden flex flex-col transition-all duration-300">
        <div class="px-6 py-5 border-b border-[#D4D1C7] dark:border-[#2A3654] flex justify-between items-center bg-white dark:bg-[#1A2440]">
            <div class="flex items-center gap-2.5">
                <div class="w-3 h-3 rounded-full bg-brand-amber animate-pulse border border-brand-amber/50"></div>
                <h3 class="font-headline-md text-lg font-bold text-on-surface dark:text-ds-text-primary">Surat Menunggu Persetujuan</h3>
            </div>
            <a href="{{ url('ceo/letter-approvals') }}" class="text-brand-navy dark:text-brand-amber hover:underline font-label-md text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            </a>
        </div>
        
        <div class="flex-1 overflow-x-auto">
            @if($recentOutgoing->count())
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA] dark:bg-[#0C1326] text-brand-navy dark:text-brand-amber font-label-md text-xs uppercase tracking-wider font-bold">
                        <th class="py-3.5 px-6 font-bold w-1/3">No Surat</th>
                        <th class="py-3.5 px-4 font-bold w-1/3">Pengirim / Perihal</th>
                        <th class="py-3.5 px-4 font-bold">Tanggal</th>
                        <th class="py-3.5 px-6 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-sm divide-y divide-[#E0DED8] dark:divide-[#2A3654] bg-white dark:bg-[#141C33]">
                    @foreach($recentOutgoing as $letter)
                    <tr onclick="window.location='{{ url('ceo/letter-approvals/' . $letter->id) }}'" class="hover:bg-[#F2F6FC] dark:hover:bg-[#1A2440]/70 transition-colors cursor-pointer group" title="Klik untuk meninjau dan ACC surat ini">
                        <td class="py-4 px-6 font-semibold text-brand-navy dark:text-ds-text-primary">
                            <span class="bg-[#EBF0FA] dark:bg-brand-amber/10 px-2.5 py-1 rounded-md border border-brand-navy/15 dark:border-brand-amber/20 font-mono text-xs group-hover:underline">{{ $letter->letter_number ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-4">
                            <div class="font-bold text-on-surface dark:text-[#E8E6E0] text-xs group-hover:text-blue-600 dark:group-hover:text-amber-400">{{ optional($letter->creator)->name ?? optional($letter->creator)->nip ?? '-' }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[180px] font-medium">{{ $letter->subject ?? '-' }}</div>
                        </td>
                        <td class="py-4 px-4 text-gray-600 dark:text-gray-300 text-xs font-medium">
                            {{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <a href="{{ url('ceo/letter-approvals/' . $letter->id) }}" class="inline-flex items-center justify-center p-2 rounded-xl bg-[#EBF0FA] text-brand-navy dark:bg-brand-amber/20 dark:text-brand-amber hover:bg-brand-navy hover:text-white dark:hover:bg-brand-amber dark:hover:text-brand-navy transition-all shadow-xs border border-brand-navy/15 dark:border-brand-amber/30 group-hover:border-brand-navy" title="Review Surat">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward_ios</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-12 px-4 flex flex-col items-center justify-center">
                <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-[#1D2847] flex items-center justify-center text-gray-400 dark:text-ds-text-secondary mb-3 border border-gray-200 dark:border-[#2A3654]">
                    <span class="material-symbols-outlined text-3xl">task_alt</span>
                </div>
                <p class="font-label-md text-sm text-brand-navy dark:text-ds-text-primary font-bold">Semua Bersih!</p>
                <p class="font-body-md text-xs text-gray-500 dark:text-ds-text-secondary mt-1">Tidak ada surat yang menunggu persetujuan saat ini.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Table 2: Surat Masuk Terbaru -->
    <div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden flex flex-col transition-all duration-300">
        <div class="px-6 py-5 border-b border-[#D4D1C7] dark:border-[#2A3654] flex justify-between items-center bg-white dark:bg-[#1A2440]">
            <div class="flex items-center gap-2.5">
                <div class="w-3 h-3 rounded-full bg-brand-navy dark:bg-brand-amber border border-brand-navy/30 dark:border-brand-amber/50"></div>
                <h3 class="font-headline-md text-lg font-bold text-on-surface dark:text-ds-text-primary">Surat Masuk Terbaru</h3>
            </div>
            <a href="{{ url('/ceo/incoming-letters') }}" class="text-brand-navy dark:text-brand-amber hover:underline font-label-md text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                <span>Lihat Semua</span>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            </a>
        </div>
        
        <div class="flex-1 overflow-x-auto">
            @if($recentIncoming->count())
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b-2 border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA] dark:bg-[#0C1326] text-brand-navy dark:text-brand-amber font-label-md text-xs uppercase tracking-wider font-bold">
                        <th class="py-3.5 px-6 font-bold w-1/3">No Surat</th>
                        <th class="py-3.5 px-4 font-bold w-1/3">Pengirim</th>
                        <th class="py-3.5 px-4 font-bold">Perihal</th>
                        <th class="py-3.5 px-6 font-bold text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="font-body-md text-sm divide-y divide-[#E0DED8] dark:divide-[#2A3654] bg-white dark:bg-[#141C33]">
                    @foreach($recentIncoming as $letter)
                    <tr onclick="window.open('{{ $letter->file_path ? asset('storage/' . $letter->file_path) : url('/ceo/incoming-letters?search=' . urlencode($letter->letter_number)) }}', '_blank')" class="hover:bg-[#F2F6FC] dark:hover:bg-[#1A2440]/70 transition-colors cursor-pointer group" title="Klik untuk membuka arsip dokumen surat masuk ini">
                        <td class="py-4 px-6 font-semibold text-brand-navy dark:text-ds-text-primary">
                            <span class="bg-[#EBF0FA] dark:bg-brand-amber/10 px-2.5 py-1 rounded-md border border-brand-navy/15 dark:border-brand-amber/20 font-mono text-xs group-hover:underline">{{ $letter->letter_number ?? $letter->nomor_surat ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-4 text-gray-700 dark:text-[#E8E6E0] font-bold text-xs group-hover:text-blue-600 dark:group-hover:text-amber-400">{{ $letter->sender ?? $letter->pengirim ?? '-' }}</td>
                        <td class="py-4 px-4 text-gray-600 dark:text-gray-300 text-xs truncate max-w-[150px] font-medium" title="{{ $letter->subject ?? $letter->perihal ?? '-' }}">
                            {{ Str::limit($letter->subject ?? $letter->perihal ?? '-', 28) }}
                        </td>
                        <td class="py-4 px-6 text-right text-gray-600 dark:text-gray-300 text-xs font-medium">
                            {{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="text-center py-12 px-4 flex flex-col items-center justify-center">
                <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-[#1D2847] flex items-center justify-center text-gray-400 dark:text-ds-text-secondary mb-3 border border-gray-200 dark:border-[#2A3654]">
                    <span class="material-symbols-outlined text-3xl">inbox_customize</span>
                </div>
                <p class="font-label-md text-sm text-brand-navy dark:text-ds-text-primary font-bold">Arsip Kosong</p>
                <p class="font-body-md text-xs text-gray-500 dark:text-ds-text-secondary mt-1">Belum ada surat masuk yang dicatat dalam sistem.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
