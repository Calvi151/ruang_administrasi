@extends('admin.layouts.app')

@section('title', 'Jenis Surat - Ruang Administrasi')
@section('page-title', 'Jenis Surat')

@section('content')
<!-- Action Bar -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
            <input class="w-72 pl-10 pr-4 py-2 rounded-lg bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-sm text-body-sm text-on-surface placeholder:text-outline" placeholder="Cari jenis surat..." type="text">
        </div>
    </div>
    <a href="{{ route('letter-types.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:opacity-90 transition-all shadow-sm">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Tambah Jenis Surat
    </a>
</div>

<!-- Table Card -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[600px]">
            <thead>
                <tr class="bg-surface-container-highest border-b border-outline-variant/40 font-label-sm text-label-sm text-on-surface">
                    <th class="px-6 py-3 font-medium w-12">#</th>
                    <th class="px-6 py-3 font-medium w-[30%]">Kode Surat</th>
                    <th class="px-6 py-3 font-medium w-[40%]">Nama Jenis Surat</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm">
                @forelse($types as $index => $type)
                <tr class="border-b border-outline-variant/20 hover:bg-black/5 dark:hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-3 text-on-surface font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed-variant font-mono text-[13px] font-bold">
                            {{ $type->letter_code }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-on-surface font-medium">{{ $type->type_name }}</td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('letter-types.edit', $type->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-amber-400 hover:bg-amber-400/15 hover:text-amber-300 transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <form action="{{ route('letter-types.destroy', $type->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis surat ini?');">
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
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[48px] text-outline/30">description</span>
                            <h4 class="font-h3 text-h3 text-on-surface">Belum ada jenis surat</h4>
                            <p class="font-body-sm text-body-sm max-w-sm">Daftar referensi jenis surat kosong.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection



