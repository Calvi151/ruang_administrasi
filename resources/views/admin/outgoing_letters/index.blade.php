@extends('admin.layouts.app')

@section('title', 'Surat Keluar - Ruang Administrasi')
@section('page-title', 'Surat Keluar')

@section('content')
<!-- Action Bar -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
            <input class="w-72 pl-10 pr-4 py-2 rounded-lg bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-sm text-body-sm text-on-surface placeholder:text-outline" placeholder="Cari nomor surat, perihal..." type="text">
        </div>
    </div>
    <a href="{{ route('outgoing-letters.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:opacity-90 transition-all shadow-sm">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Buat Surat Keluar
    </a>
</div>

<!-- Table Card -->
<div class="bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-surface-container-lowest border-b border-outline-variant/30 font-label-sm text-label-sm text-on-surface-variant">
                    <th class="px-6 py-3 font-medium">Nomor Surat</th>
                    <th class="px-6 py-3 font-medium">Tanggal</th>
                    <th class="px-6 py-3 font-medium">Tujuan</th>
                    <th class="px-6 py-3 font-medium">Perihal</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm">
                @forelse($letters as $letter)
                <tr class="border-b border-outline-variant/20 hover:bg-surface-container-lowest transition-colors group">
                    <td class="px-6 py-3 text-on-surface font-medium">{{ $letter->letter_number }}</td>
                    <td class="px-6 py-3 text-on-surface-variant">{{ \Carbon\Carbon::parse($letter->date_sent)->format('d M Y') }}</td>
                    <td class="px-6 py-3 text-on-surface-variant">{{ $letter->recipient }}</td>
                    <td class="px-6 py-3 text-on-surface-variant max-w-xs truncate">{{ $letter->subject }}</td>
                    <td class="px-6 py-3">
                        @if($letter->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-label-sm text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> PENDING
                            </span>
                        @elseif($letter->status == 'acc')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-container/40 text-on-secondary-container font-label-sm text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> ACC
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-error-container/40 text-error font-label-sm text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span> DITOLAK
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($letter->file_path)
                            <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg text-primary hover:bg-primary-fixed transition-colors" title="Lihat Lampiran">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                  <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                  <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2.5a1 1 0 0 0 1 1H13v9a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                </svg>
                            </a>
                            @endif
                            <a href="{{ route('outgoing-letters.show', $letter->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-primary hover:bg-primary-fixed transition-colors" title="Detail">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </a>
                            @if($letter->status == 'pending')
                            <a href="{{ route('outgoing-letters.edit', $letter->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-primary hover:bg-primary-fixed transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            @endif
                            <form action="{{ route('outgoing-letters.destroy', $letter->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-error hover:bg-error-container transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[48px] text-outline/30">send</span>
                            <h4 class="font-h3 text-h3 text-on-surface">Belum ada surat keluar</h4>
                            <p class="font-body-sm text-body-sm max-w-sm">Daftar surat keluar masih kosong.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
