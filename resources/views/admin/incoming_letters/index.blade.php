@extends('admin.layouts.app')

@section('title', 'Surat Masuk - Ruang Administrasi')
@section('page-title', 'Surat Masuk')
@section('page-subtitle', 'Manajemen data surat masuk dari pihak eksternal')

@section('content')
<!-- Action Bar -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-5">
    <div class="flex items-center gap-4">
        <!-- Search Input -->
        <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input class="w-64 pl-10 pr-4 py-1 rounded-full bg-surface-container-lowest border border-border-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md text-on-background placeholder:text-outline shadow-sm" placeholder="Cari nomor surat, perihal..." type="text">
        </div>
    </div>
    <!-- Primary Action Button -->
    <a href="{{ route('incoming-letters.create') }}" class="flex items-center gap-4 px-2 py-1 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:opacity-90 transition-all shadow-lg shadow-primary/30 transform hover:-translate-y-0.5">
        <span class="material-symbols-outlined text-[14px]">add</span>
        Catat Surat Masuk
    </a>
</div>

<!-- Table Card -->
<div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow overflow-hidden p-4">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="border-b border-border-muted">
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold">Nomor Surat</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold">Tanggal</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold">Pengirim</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold">Perihal</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-muted/50">
                @forelse($letters as $letter)
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="py-3 px-4 font-label-md text-label-md text-on-background font-bold">
                        {{ $letter->letter_number }}
                    </td>
                    <td class="py-3 px-4 font-body-md text-body-md text-outline">
                        {{ \Carbon\Carbon::parse($letter->date_received)->format('d M Y') }}
                    </td>
                    <td class="py-3 px-4 font-body-md text-body-md text-on-surface-variant">
                        {{ $letter->sender }}
                    </td>
                    <td class="py-3 px-4 font-body-md text-body-md text-on-surface-variant max-w-xs truncate">
                        {{ $letter->subject }}
                    </td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex items-center justify-end gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('incoming-letters.show', $letter->id) }}" class="w-7 h-7 flex items-center justify-center rounded-full text-primary hover:bg-primary-fixed transition-colors" title="Detail">
                                <span class="material-symbols-outlined text-[14px]">visibility</span>
                            </a>
                            <a href="{{ route('incoming-letters.edit', $letter->id) }}" class="w-7 h-7 flex items-center justify-center rounded-full text-primary hover:bg-primary-fixed transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[14px]">edit</span>
                            </a>
                            <form action="{{ route('incoming-letters.destroy', $letter->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-full text-error hover:bg-error-container hover:text-on-error-container transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[14px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-1">
                        <div class="flex-1 flex flex-col items-center justify-center text-center p-4">
                            <div class="w-16 h-16 mb-4 relative">
                                <div class="absolute inset-0 bg-surface-container rounded-full opacity-50 scale-110"></div>
                                <div class="absolute inset-0 flex items-center justify-center text-primary-fixed-dim">
                                    <span class="material-symbols-outlined text-[48px] font-light">drafts</span>
                                </div>
                            </div>
                            <h4 class="font-headline-md text-headline-md text-on-background mb-2">Belum ada surat masuk</h4>
                            <p class="font-body-md text-body-md text-on-surface-variant max-w-sm mx-auto">
                                Kotak masuk Anda saat ini bersih. Surat yang baru tiba akan muncul di sini.
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection







