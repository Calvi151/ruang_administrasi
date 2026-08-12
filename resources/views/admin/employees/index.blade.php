@extends('admin.layouts.app')

@section('title', 'Karyawan - Ruang Administrasi')
@section('page-title', 'Data Karyawan')

@section('content')
<!-- Action Bar -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <form action="{{ route('employees.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
            <input name="search" value="{{ request('search') }}" class="w-64 pl-10 pr-4 py-2 rounded-lg bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border focus:border-primary dark:focus:border-ds-accent focus:ring-2 focus:ring-primary/20 dark:focus:ring-ds-accent/20 outline-none transition-all font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary placeholder:text-outline dark:placeholder:text-ds-text-secondary" placeholder="Cari nama, NIP, email..." type="text">
        </div>

        <div class="relative">
            <select name="position_id" onchange="this.form.submit()" class="pl-3 pr-8 py-2 rounded-lg bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border focus:border-primary dark:focus:border-ds-accent outline-none font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary appearance-none cursor-pointer">
                <option value="">Semua Jabatan</option>
                @foreach($positions as $pos)
                    <option value="{{ $pos->id }}" {{ request('position_id') == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                @endforeach
            </select>
            <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">expand_more</span>
        </div>

        @if(request('search') || request('position_id'))
            <a href="{{ route('employees.index') }}" class="px-3 py-2 rounded-lg bg-surface-variant dark:bg-ds-bg border border-outline-variant dark:border-ds-border text-on-surface-variant dark:text-ds-text-secondary hover:text-error text-body-sm transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">close</span>
                Reset
            </a>
        @endif
    </form>
    <a href="{{ route('employees.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-primary/30 active:scale-95 shadow-sm dark:bg-primary dark:text-on-primary dark:border-none group">
        <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:rotate-90">person_add</span>
        Tambah Karyawan
    </a>
</div>

<!-- Table Card -->
<div class="bg-surface-container-lowest dark:bg-ds-surface rounded-xl shadow-sm border border-outline-variant/50 dark:border-ds-border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-surface-container-highest dark:bg-ds-bg border-b border-outline-variant/40 dark:border-ds-border font-label-sm text-label-sm text-on-surface dark:text-ds-text-secondary">
                    <th class="px-6 py-3 font-medium w-12">#</th>
                    <th class="px-6 py-3 font-medium w-[25%]">Profil</th>
                    <th class="px-6 py-3 font-medium w-[20%]">Jabatan</th>
                    <th class="px-6 py-3 font-medium w-[20%]">NIP / Akses</th>
                    <th class="px-6 py-3 font-medium w-[20%]">Kontak</th>
                    <th class="px-6 py-3 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm">
                @forelse($employees as $index => $employee)
                <tr class="border-b border-outline-variant/20 dark:border-ds-border hover:bg-black/5 dark:hover:bg-ds-hover transition-colors group">
                    <td class="px-6 py-3 text-on-surface dark:text-ds-text-secondary font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->name }}" class="w-8 h-8 rounded-full object-cover border border-outline-variant dark:border-ds-border">
                            @else
                                <div class="w-8 h-8 rounded-full bg-primary-fixed dark:bg-ds-bg text-primary dark:text-ds-text-primary flex items-center justify-center font-bold text-xs dark:border dark:border-ds-border">
                                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-on-surface dark:text-ds-text-primary font-medium">{{ $employee->name }}</p>
                                <p class="text-on-surface-variant dark:text-ds-text-secondary text-[12px]">{{ $employee->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3">
                        @if($employee->position)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-semibold text-xs border border-blue-200 dark:border-blue-800">
                                <span class="material-symbols-outlined text-[14px]">work</span>
                                {{ $employee->position->name }}
                            </span>
                        @else
                            <span class="text-on-surface-variant dark:text-ds-text-secondary text-xs italic">- Belum Set -</span>
                        @endif
                    </td>
                    <td class="px-6 py-3">
                        <p class="text-on-surface dark:text-ds-text-primary font-mono text-[13px]">{{ $employee->nip }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ ($employee->user && $employee->user->role == 'ceo') ? 'bg-primary-fixed dark:bg-ds-accent/20 text-primary dark:text-ds-accent' : 'bg-surface-variant dark:bg-ds-bg dark:border dark:border-ds-border text-on-surface-variant dark:text-ds-text-secondary' }}">
                            {{ $employee->user ? $employee->user->role : 'karyawan' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-on-surface dark:text-ds-text-secondary">{{ $employee->number ?? '-' }}</td>
                    <td class="px-6 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('employees.edit', $employee->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-amber-400 hover:bg-amber-400/15 hover:text-amber-300 transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            <button type="button" onclick="openModal('deleteModal-{{ $employee->id }}')" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-400 hover:bg-red-400/15 hover:text-red-300 transition-colors" title="Hapus">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-3 text-on-surface-variant dark:text-ds-text-secondary">
                            <span class="material-symbols-outlined text-[48px] opacity-30">group</span>
                            <h4 class="font-h3 text-h3 text-on-surface dark:text-ds-text-primary">Belum ada karyawan</h4>
                            <p class="font-body-sm text-body-sm max-w-sm">Sistem belum memiliki data karyawan yang sesuai filter.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modals Container (Rendered OUTSIDE the table to prevent HTML layout break and black screen bug) --}}
@foreach($employees as $employee)
    {{-- Delete Modal --}}
    <div id="deleteModal-{{ $employee->id }}" class="modal-overlay fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="modal-content-box bg-white dark:bg-[#141C33] w-full max-w-md rounded-2xl shadow-2xl overflow-hidden border border-outline-variant/20 dark:border-[#2A3654]">
            <div class="flex justify-between items-center p-5 border-b border-outline-variant/20 dark:border-[#2A3654] bg-red-50/50 dark:bg-red-900/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                        <span class="material-symbols-outlined">delete_forever</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-on-surface dark:text-white text-lg">Hapus Karyawan</h3>
                        <p class="text-xs text-on-surface-variant dark:text-[#8B93A8]">{{ $employee->name }}</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('deleteModal-{{ $employee->id }}')" class="text-outline hover:text-error transition-colors rounded-full p-1 hover:bg-surface-container-low dark:hover:bg-[#0F172E]">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
            </div>
            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="p-6">
                @csrf
                @method('DELETE')
                <div class="mb-6">
                    <p class="text-sm text-on-surface dark:text-[#E8E6E0]">Apakah Anda yakin ingin menghapus data karyawan ini secara permanen? Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('deleteModal-{{ $employee->id }}')" class="px-5 py-2.5 rounded-xl font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold shadow-lg shadow-red-500/30 transition-all active:scale-95">Ya, Hapus Data</button>
                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection



