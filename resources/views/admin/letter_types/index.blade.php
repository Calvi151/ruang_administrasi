@extends('admin.layouts.app')

@section('title', 'Jenis Surat - Ruang Administrasi')
@section('page-title', 'Jenis Surat')

@section('content')
<!-- Action Bar -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
            <input class="w-72 pl-10 pr-4 py-2 rounded-lg bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border focus:border-primary dark:focus:border-ds-accent focus:ring-2 focus:ring-primary/20 dark:focus:ring-ds-accent/20 outline-none transition-all font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary placeholder:text-outline dark:placeholder:text-ds-text-secondary" placeholder="Cari jenis surat..." type="text">
        </div>
    </div>
    <a href="{{ route('letter-types.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-primary/30 active:scale-95 shadow-sm dark:bg-primary dark:text-on-primary dark:border-none group">
        <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:rotate-90">add</span>
        Tambah Jenis Surat
    </a>
</div>

<!-- Table Card -->
<div class="bg-surface-container-lowest dark:bg-ds-surface rounded-2xl shadow-md border border-outline-variant/50 dark:border-ds-border overflow-hidden">
    <!-- Explanatory Banner -->
    <div class="px-6 py-3.5 bg-blue-50 dark:bg-[#111A30] border-b border-outline-variant/30 dark:border-ds-border flex flex-wrap items-center justify-between gap-3 text-xs text-gray-600 dark:text-gray-300">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-blue-600 dark:text-amber-400">shield_lock</span>
            <span><strong>Proteksi Kode Unik:</strong> Kode baru wajib unik. Jika terdapat kode kembar pada data dummy/lama, akan ditandai badge peringatan duplikat.</span>
        </div>
        <div class="flex items-center gap-2 font-semibold">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <span>Data yang terpakai di surat keluar dikunci dari penghapusan (namun tetap bisa diedit untuk koreksi dummy).</span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[850px]">
            <thead>
                <tr class="bg-surface-container-highest dark:bg-[#0E1528] border-b border-outline-variant/40 dark:border-ds-border font-label-md text-xs text-on-surface dark:text-ds-text-secondary uppercase tracking-wider font-extrabold">
                    <th class="px-6 py-4 font-extrabold w-12 text-center">#</th>
                    <th class="px-6 py-4 font-extrabold w-3/12">Kode Surat & Duplikasi</th>
                    <th class="px-6 py-4 font-extrabold w-4/12">Nama Jenis & Kegunaan</th>
                    <th class="px-6 py-4 font-extrabold w-2/12">Statistik Terpakai</th>
                    <th class="px-6 py-4 font-extrabold w-2/12 text-center">Status Audit</th>
                    <th class="px-6 py-4 font-extrabold w-1/12 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm divide-y divide-outline-variant/20 dark:divide-[#2A3654]">
                @php
                    $codeCounts = $types->groupBy(function($item) {
                        return strtoupper(trim($item->letter_code));
                    })->map->count();
                @endphp

                @forelse($types as $index => $type)
                @php
                    $isDuplicate = ($codeCounts[strtoupper(trim($type->letter_code))] ?? 0) > 1;
                @endphp
                <tr class="hover:bg-blue-50/50 dark:hover:bg-[#1D2847]/60 transition-colors group">
                    <td class="px-6 py-4 text-center text-on-surface dark:text-ds-text-secondary font-bold">{{ $index + 1 }}</td>
                    
                    <!-- KODE SURAT -->
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-start gap-1.5">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg bg-tertiary-fixed dark:bg-[#0A1020] text-on-tertiary-fixed-variant dark:text-amber-400 font-mono text-sm font-extrabold border border-blue-500/20 dark:border-amber-400/30 shadow-2xs">
                                {{ $type->letter_code }}
                            </span>
                            @if($isDuplicate)
                                <div class="flex items-center gap-1 text-[11px] font-black text-red-600 dark:text-red-400 bg-red-500/15 px-2 py-0.5 rounded border border-red-500/30 animate-pulse" title="Ada jenis surat lain dengan kode sama persis. Harap ubah salah satunya agar nomor surat tidak rancu.">
                                    <span class="material-symbols-outlined text-[14px]">warning</span>
                                    <span>⚠️ Kode Duplikat!</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    
                    <!-- NAMA JENIS SURAT -->
                    <td class="px-6 py-4">
                        <div class="font-extrabold text-on-surface dark:text-white text-sm md:text-base tracking-tight">{{ $type->type_name }}</div>
                        @if($type->template)
                            <div class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">description</span>
                                <span>Ada template standar tersimpan ({{ strlen($type->template) }} karakter)</span>
                            </div>
                        @else
                            <div class="text-xs text-gray-400 dark:text-gray-500 italic mt-1 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">short_text</span>
                                <span>Template kosong (Ketik bebas di form)</span>
                            </div>
                        @endif
                    </td>
                    
                    <!-- STATISTIK PENGGUNAAN -->
                    <td class="px-6 py-4 font-medium">
                        @if($type->outgoing_letters_count > 0)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 dark:bg-[#16213A] dark:text-blue-300 border border-blue-200 dark:border-blue-800 text-xs font-extrabold shadow-2xs">
                                <span class="material-symbols-outlined text-[16px] text-blue-500 dark:text-blue-400">folder_shared</span>
                                <span>{{ $type->outgoing_letters_count }} Surat Terbit</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-gray-100 dark:bg-[#1A2440]/50 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700 text-xs font-bold">
                                <span class="material-symbols-outlined text-[16px] text-gray-400">inventory_2</span>
                                <span>0 (Belum Dipakai)</span>
                            </span>
                        @endif
                    </td>

                    <!-- STATUS AUDIT / PROTEKSI -->
                    <td class="px-6 py-4 text-center">
                        @if($type->outgoing_letters_count > 0)
                            <span class="inline-flex items-center justify-center gap-1 text-[11px] font-extrabold text-amber-800 dark:text-amber-300 bg-amber-500/15 border border-amber-500/40 px-3 py-1 rounded-full shadow-2xs" title="Sudah ada surat resmi/dummy yang terkait. Penghapusan dikunci, tetapi Anda boleh mengedit namanya jika ingin merevisi.">
                                <span class="material-symbols-outlined text-[14px] text-amber-600 dark:text-amber-400">lock_outline</span>
                                <span>Terikat (Hapus Dikunci)</span>
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center gap-1 text-[11px] font-extrabold text-emerald-800 dark:text-emerald-300 bg-emerald-500/15 border border-emerald-500/40 px-3 py-1 rounded-full shadow-2xs" title="Belum terhubung dengan dokumen apapun. Bisa diedit maupun dihapus bebas.">
                                <span class="material-symbols-outlined text-[14px] text-emerald-600 dark:text-emerald-400">check_circle</span>
                                <span>Bebas Edit & Hapus</span>
                            </span>
                        @endif
                    </td>

                    <!-- AKSI -->
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('letter-types.edit', $type->id) }}" class="p-2 flex items-center justify-center rounded-xl text-amber-600 dark:text-amber-400 bg-amber-500/15 hover:bg-amber-600 hover:text-white dark:hover:bg-amber-400 dark:hover:text-brand-navy transition-all border border-amber-500/30 shadow-2xs hover:shadow-sm" title="Edit Kode / Nama Jenis Surat">
                                <span class="material-symbols-outlined text-[19px]">edit_note</span>
                            </a>
                            @if($type->outgoing_letters_count == 0)
                                <form action="{{ route('letter-types.destroy', $type->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen jenis surat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 flex items-center justify-center rounded-xl text-red-600 dark:text-red-400 bg-red-500/15 hover:bg-red-600 hover:text-white dark:hover:bg-red-500 dark:hover:text-white transition-all border border-red-500/30 shadow-2xs hover:shadow-sm" title="Hapus Jenis Surat">
                                        <span class="material-symbols-outlined text-[19px]">delete</span>
                                    </button>
                                </form>
                            @else
                                <button type="button" onclick="alert('🔒 MENOLAK PENGHAPUSAN: Jenis Surat \'{{ $type->type_name }}\' tidak dapat dihapus karena terlanjur terhubung ke {{ $type->outgoing_letters_count }} dokumen surat keluar (Dummy/Resmi).\n\n💡 SOLUSI: Karena saat ini masih berupa data Dummy, silakan gunakan tombol EDIT (ikon pensil kuning) untuk mengganti Kode atau Nama surat ke referensi yang benar agar tidak perlu menghapus database relasionalnya.');" class="p-2 flex items-center justify-center rounded-xl text-gray-400 bg-gray-100 dark:bg-[#1A2440]/30 border border-gray-300 dark:border-gray-700 cursor-not-allowed opacity-70" title="Dikunci dari Penghapusan (Klik untuk Info)">
                                    <span class="material-symbols-outlined text-[19px]">lock</span>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-3 text-on-surface-variant dark:text-ds-text-secondary">
                            <span class="material-symbols-outlined text-[48px] opacity-30">description</span>
                            <h4 class="font-h3 text-h3 text-on-surface dark:text-ds-text-primary font-bold">Belum Ada Jenis Surat</h4>
                            <p class="font-body-sm text-body-sm max-w-sm text-gray-500">Daftar referensi jenis surat kosong. Silakan tambah referensi baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection



