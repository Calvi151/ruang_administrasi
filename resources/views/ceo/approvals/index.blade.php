@extends('ceo.layouts.app')

@section('title', 'Persetujuan Surat - Ruang Administrasi')
@section('page-title', 'Persetujuan Surat')
@section('page-subtitle', 'Kelola dan review surat keluar dari staf sebelum diterbitkan')

@section('content')
<!-- Top Action Bar -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-2.5">
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-brand-amber/20 text-brand-amber dark:bg-brand-amber/10">
            <span class="material-symbols-outlined text-xl">fact_check</span>
        </span>
        <div>
            <h3 class="font-headline-md text-lg font-bold text-on-surface dark:text-ds-text-primary">Daftar Menunggu Persetujuan</h3>
            <p class="font-body-md text-xs text-on-surface-variant dark:text-ds-text-secondary">Pilih surat untuk melakukan tinjau dan pengesahan</p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="w-full sm:w-80 relative group">
        <form action="{{ url('/ceo/letter-approvals') }}" method="GET">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-brand-navy dark:group-focus-within:text-brand-amber transition-colors text-[20px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal, atau tujuan..." class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-[#141C33] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl font-body-md text-sm text-on-surface dark:text-[#E8E6E0] focus:border-brand-navy dark:focus:border-brand-amber focus:ring-2 focus:ring-brand-navy/10 dark:focus:ring-brand-amber/20 focus:outline-none transition-all shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500">
        </form>
    </div>
</div>

<!-- Table Card (Dengan Border Tegas & Background Kontras) -->
<div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden transition-all duration-300">
    <!-- Executive Brief Bar -->
    <div class="px-6 py-3.5 bg-[#F2F6FC] dark:bg-[#1C2640] border-b border-[#E0DED8] dark:border-[#2A3654] flex items-center justify-between text-xs text-brand-navy dark:text-gray-300 font-medium">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-amber-500">lightbulb</span>
            <span><strong>Petunjuk Pimpinan:</strong> Surat di bawah ini merupakan draft konfirmasi dari Staf Admin. Klik baris surat atau tombol aksi untuk melihat dokumen utuh, meninjau, serta membubuhkan <strong>Tanda Tangan & Cap Stempel Digital</strong>.</span>
        </div>
        <span class="bg-brand-navy/10 dark:bg-amber-400/20 text-brand-navy dark:text-brand-amber font-extrabold px-2.5 py-1 rounded-full text-[11px] shrink-0">
            Total Menunggu: {{ $letters->count() }} Dokumen
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA] dark:bg-[#0C1326] text-brand-navy dark:text-brand-amber font-label-md text-[11px] uppercase tracking-wider font-extrabold">
                    <th class="py-4 px-6 font-extrabold w-3/12">1. Klasifikasi & No. Dokumen</th>
                    <th class="py-4 px-6 font-extrabold w-3/12">2. Tujuan (Kepada Yth.) & Rujukan</th>
                    <th class="py-4 px-6 font-extrabold w-3/12">3. Subjek Perihal & Isi Pokok</th>
                    <th class="py-4 px-6 font-extrabold w-2/12">4. Pengaju & Waktu</th>
                    <th class="py-4 px-6 font-extrabold w-1/12 text-right">5. Tindakan</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-sm text-on-surface dark:text-ds-text-primary divide-y divide-[#E0DED8] dark:divide-[#2A3654] bg-white dark:bg-[#141C33]">
                @forelse($letters as $letter)
                @php
                    // Membersihkan duplikasi boilerplate header dari ringkasan
                    $rawText = trim(strip_tags($letter->content));
                    $cleanSummary = preg_replace('/^(Nomor\s*[:=].*?Perihal\s*[:=].*?|Yth\..*?di\s*Tempat)/is', '', $rawText);
                    $cleanSummary = trim(preg_replace('/\s+/', ' ', $cleanSummary));
                    if(empty($cleanSummary) || strlen($cleanSummary) < 15) {
                        $cleanSummary = $rawText;
                    }
                @endphp
                <tr onclick="window.location='{{ url('ceo/letter-approvals/' . $letter->id) }}'" class="hover:bg-[#F2F6FC] dark:hover:bg-[#1D2847] transition-all duration-200 cursor-pointer group">
                    <!-- 1. KLASIFIKASI & NOMOR DOKUMEN -->
                    <td class="py-5 px-6 vertical-align-top">
                        <div class="flex flex-wrap items-center gap-1.5 mb-2">
                            @if($letter->category === 'balasan')
                                <span class="px-2.5 py-0.5 text-[10px] font-black rounded-md bg-amber-500/20 text-amber-700 dark:text-amber-300 uppercase border border-amber-500/40 tracking-wide flex items-center gap-1 shadow-2xs" title="Surat Balasan Atas Surat Masuk">
                                    <span class="material-symbols-outlined text-[13px]">reply_all</span>
                                    <span>Surat Balasan</span>
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 text-[10px] font-black rounded-md bg-blue-500/20 text-blue-700 dark:text-blue-300 uppercase border border-blue-500/40 tracking-wide flex items-center gap-1 shadow-2xs" title="Surat Keluar Perusahaan (Utama)">
                                    <span class="material-symbols-outlined text-[13px]">corporate_fare</span>
                                    <span>Surat Perusahaan</span>
                                </span>
                            @endif
                        </div>
                        <div class="font-extrabold text-on-surface dark:text-white text-sm tracking-tight group-hover:text-blue-600 dark:group-hover:text-amber-400 transition-colors">
                            {{ optional($letter->letterType)->type_name ?? 'Dokumen Umum' }}
                        </div>
                        <div class="mt-1.5 font-mono font-bold text-brand-navy dark:text-brand-amber text-xs bg-[#EBF0FA] dark:bg-[#0A1020] px-2.5 py-1 rounded-md border border-brand-navy/20 dark:border-brand-amber/30 inline-block">
                            {{ $letter->letter_number }}
                        </div>
                    </td>

                    <!-- 2. TUJUAN (INSTANSI PENERIMA) & RUJUKAN -->
                    <td class="py-5 px-6 vertical-align-top">
                        <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold block mb-1">Kepada Yth. (Instansi/Penerima):</span>
                        <div class="flex items-start gap-1.5 text-on-surface dark:text-[#F3F1EC] font-extrabold text-sm uppercase leading-snug">
                            <span class="material-symbols-outlined text-[18px] text-blue-600 dark:text-amber-400 shrink-0 mt-0.5">business_center</span>
                            <span class="underline decoration-blue-500/30 dark:decoration-amber-400/30 underline-offset-2">{{ $letter->recipient ?? '-' }}</span>
                        </div>
                        
                        @if($letter->category === 'balasan' && $letter->incomingLetter)
                            <div class="mt-3 p-2.5 rounded-xl bg-amber-50/90 dark:bg-[#1A243E] border border-amber-300 dark:border-amber-400/30 text-xs shadow-xs" onclick="event.stopPropagation();">
                                <div class="flex items-center gap-1.5 text-amber-800 dark:text-amber-300 font-extrabold mb-1 text-[11px]">
                                    <span class="material-symbols-outlined text-[14px]">link</span>
                                    <span>Rujukan Surat Masuk:</span>
                                </div>
                                <div class="text-on-surface dark:text-gray-200 font-semibold text-[11px] mb-1">
                                    Dari: <strong>{{ $letter->incomingLetter->sender }}</strong>
                                </div>
                                <a href="{{ $letter->incomingLetter->file_path ? asset('storage/' . $letter->incomingLetter->file_path) : url('/ceo/incoming-letters?search=' . urlencode($letter->incomingLetter->letter_number)) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-emerald-600 dark:text-emerald-400 hover:underline font-extrabold bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20" title="Klik untuk melompat ke Berkas Dokumen Asli (Tab Baru)">
                                    <span class="material-symbols-outlined text-[13px]">{{ $letter->incomingLetter->file_path ? 'description' : 'search' }}</span>
                                    <span>Buka Dokumen #{{ $letter->incomingLetter->letter_number }} ↗</span>
                                </a>
                            </div>
                        @endif
                    </td>

                    <!-- 3. SUBJEK PERIHAL & ISI POKOK -->
                    <td class="py-5 px-6 vertical-align-top">
                        <div class="text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-1">Perihal Utama:</div>
                        <div class="font-extrabold text-brand-navy dark:text-white text-sm mb-2 leading-tight group-hover:underline">
                            {{ $letter->subject ?? '-' }}
                        </div>
                        <div class="text-[12px] text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-[#0B1222]/80 p-2.5 rounded-lg border border-gray-200 dark:border-gray-800 line-clamp-3 font-normal leading-relaxed italic">

                            "{{ Str::limit($cleanSummary, 120, '...') }}"
                        </div>
                        <span class="inline-block mt-1.5 text-[10px] text-blue-600 dark:text-amber-400 font-bold">👉 Klik baris untuk periksa lengkap & ACC</span>
                    </td>

                    <!-- 4. PENGAJU & WAKTU -->
                    <td class="py-5 px-6 vertical-align-top">
                        <div class="flex flex-col gap-1">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-[#F0F4FA] dark:bg-[#1A233A] text-on-surface dark:text-gray-200 font-bold text-xs border border-gray-200/60 dark:border-gray-700 w-fit">
                                <span class="material-symbols-outlined text-[16px] text-blue-500">verified_user</span>
                                <span>{{ optional($letter->creator)->name ?? 'Staf Admin' }}</span>
                            </span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1 font-semibold">
                                <span class="material-symbols-outlined text-[14px] text-gray-400">event</span>
                                <span>{{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d M Y') }}</span>
                            </span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px] text-gray-400">schedule</span>
                                <span>Pukul {{ \Carbon\Carbon::parse($letter->created_at)->format('H:i') }} WIB</span>
                            </span>
                        </div>
                    </td>

                    <!-- 5. TINDAKAN -->
                    <td class="py-5 px-6 text-right vertical-align-top" onclick="event.stopPropagation();">
                        <a href="{{ url('ceo/letter-approvals/' . $letter->id) }}" class="inline-flex flex-col items-center justify-center gap-1 px-4 py-2.5 bg-brand-navy hover:bg-blue-900 dark:bg-brand-amber dark:hover:bg-amber-400 text-white dark:text-brand-navy rounded-xl font-bold transition-all duration-200 shadow-md hover:shadow-lg w-full min-w-[125px]">
                            <div class="flex items-center gap-1 text-xs">
                                <span class="material-symbols-outlined text-[18px]">draw</span>
                                <span class="uppercase font-extrabold tracking-wider">Periksa & ACC</span>
                            </div>
                            <span class="text-[9px] opacity-80 font-normal">Tinjau Dokumen Utuh</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-[#1D2847] flex items-center justify-center text-gray-400 dark:text-ds-text-secondary shadow-inner border border-gray-200 dark:border-[#2A3654]">
                                <span class="material-symbols-outlined text-4xl">verified_user</span>
                            </div>
                            <div class="max-w-sm">
                                <p class="font-label-md text-base text-brand-navy dark:text-ds-text-primary font-bold">Tidak Ada Surat Menunggu Persetujuan</p>
                                <p class="font-body-md text-xs text-gray-500 dark:text-ds-text-secondary mt-1">Semua surat keluar telah selesai diperiksa dan diproyeksikan ke langkah berikutnya.</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($letters->hasPages())
    <div class="px-6 py-4 border-t border-[#CCC7BD] dark:border-[#2A3654] bg-[#F8F9FC] dark:bg-[#0E1628]">
        {{ $letters->links() }}
    </div>
    @endif
</div>
@endsection
