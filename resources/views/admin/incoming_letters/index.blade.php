@extends('admin.layouts.app')

@section('title', 'Surat Masuk - Ruang Administrasi')
@section('page-title', 'Surat Masuk')

@section('content')
<!-- Action Bar -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div class="flex items-center gap-3">
        <!-- Search Input -->
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
            <input class="w-72 pl-10 pr-4 py-2 rounded-lg bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border focus:border-primary dark:focus:border-ds-accent focus:ring-2 focus:ring-primary/20 dark:focus:ring-ds-accent/20 outline-none transition-all font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary placeholder:text-outline dark:placeholder:text-ds-text-secondary" placeholder="Cari nomor surat, perihal..." type="text">
        </div>
    </div>
    <!-- Primary Action Button -->
    <a href="{{ route('incoming-letters.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary dark:bg-ds-bg text-on-primary dark:text-ds-text-primary dark:border dark:border-ds-border font-label-md text-label-md hover:opacity-90 dark:hover:bg-ds-hover transition-all shadow-sm">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Catat Surat Masuk
    </a>
</div>

<!-- Table Card -->
<div class="bg-surface-container-lowest dark:bg-ds-surface rounded-xl shadow-sm border border-outline-variant/50 dark:border-ds-border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-surface-container dark:bg-ds-bg border-y border-outline-variant/40 dark:border-ds-border font-label-sm text-label-sm text-on-surface-variant dark:text-ds-text-secondary">
                    <th class="px-6 py-3 font-medium">Nomor Surat</th>
                    <th class="px-6 py-3 font-medium">Tanggal</th>
                    <th class="px-6 py-3 font-medium">Pengirim</th>
                    <th class="px-6 py-3 font-medium">Perihal</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm">
                @forelse($letters as $letter)
                <tr class="border-b border-outline-variant/20 dark:border-ds-border hover:bg-black/5 dark:hover:bg-ds-hover transition-colors group">
                    <td class="px-6 py-3 text-primary dark:text-ds-accent font-semibold">
                        {{ $letter->letter_number }}
                    </td>
                    <td class="px-6 py-3 text-on-surface-variant dark:text-ds-text-secondary">
                        {{ \Carbon\Carbon::parse($letter->date_received)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-3 text-on-surface dark:text-ds-text-primary font-semibold uppercase">
                        {{ $letter->sender }}
                    </td>
                    <td class="px-6 py-3 text-on-surface-variant dark:text-ds-text-secondary max-w-xs truncate">
                        {{ strip_tags($letter->subject) }}
                    </td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($letter->file_path)
                            <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg text-violet-400 hover:bg-violet-400/15 hover:text-violet-300 transition-colors" title="Lihat Lampiran">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                  <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                  <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2.5a1 1 0 0 0 1 1H13v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                </svg>
                            </a>
                            @endif
                            <a href="{{ route('incoming-letters.show', $letter->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-sky-400 hover:bg-sky-400/15 hover:text-sky-300 transition-colors" title="Detail">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </a>
                            <a href="{{ route('incoming-letters.edit', $letter->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-amber-400 hover:bg-amber-400/15 hover:text-amber-300 transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <form action="{{ route('incoming-letters.destroy', $letter->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-400 hover:bg-red-400/15 hover:text-red-300 transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3 text-on-surface-variant dark:text-ds-text-secondary">
                            <span class="material-symbols-outlined text-[48px] opacity-30">drafts</span>
                            <h4 class="font-h3 text-h3 text-on-surface dark:text-ds-text-primary">Belum ada surat masuk</h4>
                            <p class="font-body-sm text-body-sm max-w-sm">Kotak masuk Anda saat ini bersih. Surat yang baru tiba akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection



