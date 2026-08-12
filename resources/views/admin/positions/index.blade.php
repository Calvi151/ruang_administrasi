@extends('admin.layouts.app')

@section('content')
<div class="px-6 py-8 mx-auto w-full animate-fade-in">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div>
            <h1 class="font-display-lg text-[32px] md:text-[40px] font-bold text-on-surface dark:text-[#E8E6E0] mb-2 leading-tight">Manajemen Jabatan</h1>
            <p class="text-body-md text-on-surface-variant dark:text-[#8B93A8]">Kelola daftar posisi/jabatan yang tersedia untuk karyawan.</p>
        </div>
        <a href="{{ route('positions.create') }}" class="inline-flex items-center gap-2 bg-[#D9A441] hover:bg-[#c49237] text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-[#D9A441]/30 hover:shadow-[#D9A441]/50 transition-all active:scale-95 group">
            <span class="material-symbols-outlined text-xl group-hover:rotate-90 transition-transform">add</span>
            Tambah Jabatan
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 font-medium flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 font-medium flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            {{ session('error') }}
        </div>
    @endif

    {{-- Data Table --}}
    <div class="bg-white dark:bg-[#141C33] rounded-2xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-[#0F172E]/50 border-b border-outline-variant/30 dark:border-[#2A3654]">
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider">Nama Jabatan</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider text-center">Jumlah Pegawai</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant dark:text-[#8B93A8] uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 dark:divide-[#2A3654]">
                    @forelse($positions as $position)
                        <tr class="hover:bg-slate-50 dark:hover:bg-[#1D2847] transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-on-surface-variant dark:text-[#8B93A8]">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-on-surface dark:text-[#E8E6E0]">{{ $position->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-on-surface-variant dark:text-[#8B93A8] line-clamp-1 max-w-md">{{ $position->description ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($position->employees_count > 0)
                                    <a href="{{ route('employees.index', ['position_id' => $position->id]) }}" title="Klik untuk lihat daftar pegawai" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 text-xs font-bold border border-blue-200 dark:border-blue-800 transition-all hover:scale-105 group">
                                        <span>{{ $position->employees_count }} Orang</span>
                                        <span class="material-symbols-outlined text-[14px] opacity-70 group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
                                    </a>
                                @else
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 text-xs font-bold border border-slate-200 dark:border-slate-700">
                                        0 Orang
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('positions.edit', $position->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 dark:bg-amber-900/20 dark:hover:bg-amber-900/40 dark:text-amber-400 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                @if($position->employees_count == 0)
                                    <button type="button" onclick="openModal('deleteModal-{{ $position->id }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                @else
                                    <button type="button" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-400 dark:bg-slate-800 cursor-not-allowed" title="Tidak dapat dihapus karena sedang dipakai pegawai">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-[#1D2847] flex items-center justify-center mx-auto mb-4 text-slate-400">
                                    <span class="material-symbols-outlined text-3xl">work_off</span>
                                </div>
                                <h3 class="text-lg font-bold text-on-surface dark:text-[#E8E6E0] mb-1">Belum Ada Jabatan</h3>
                                <p class="text-sm text-on-surface-variant dark:text-[#8B93A8]">Silakan tambah jabatan baru untuk karyawan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modals Container (Rendered OUTSIDE the table to prevent HTML layout break and black screen bug) --}}
@foreach($positions as $position)
    {{-- Delete Modal --}}
    <div id="deleteModal-{{ $position->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-red-50/50 dark:bg-red-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined">delete_forever</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-lg">Hapus Jabatan</h3>
                        <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $position->name }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('deleteModal-{{ $position->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-surface-container-low dark:hover:bg-[#0F172E]">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <form action="{{ route('positions.destroy', $position->id) }}" method="POST" class="p-6">
                @csrf
                @method('DELETE')
                <div class="mb-6">
                    <p class="text-sm text-on-surface dark:text-[#E8E6E0]">Apakah Anda yakin ingin menghapus jabatan ini secara permanen? Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('deleteModal-{{ $position->id }}')" class="px-5 py-2.5 rounded-xl font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold shadow-lg shadow-red-500/30 transition-all active:scale-95">Ya, Hapus Data</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection
