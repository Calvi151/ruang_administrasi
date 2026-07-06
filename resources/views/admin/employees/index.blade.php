@extends('admin.layouts.app')

@section('title', 'Karyawan - Ruang Administrasi')
@section('page-title', 'Data Karyawan')
@section('page-subtitle', 'Manajemen akses dan profil karyawan sistem')

@section('content')
<!-- Action Bar -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-5">
    <div class="flex items-center gap-4">
        <!-- Search Input -->
        <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input class="w-64 pl-10 pr-4 py-1 rounded-full bg-surface-container-lowest border border-border-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md text-on-background placeholder:text-outline shadow-sm" placeholder="Cari karyawan..." type="text">
        </div>
    </div>
    <!-- Primary Action Button -->
    <a href="{{ route('employees.create') }}" class="flex items-center gap-2 px-6 py-2.5 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:opacity-90 transition-all shadow-lg shadow-primary/30 transform hover:-translate-y-0.5">
        <span class="material-symbols-outlined text-[18px]">person_add</span>
        Tambah Karyawan
    </a>
</div>

<!-- Table Card -->
<div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow overflow-hidden p-4">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="border-b border-border-muted">
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold w-12">#</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold w-[30%]">Profil</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold w-[25%]">NIP / Akses</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold w-[25%]">Kontak</th>
                    <th class="py-3 px-4 font-label-sm text-label-sm text-outline uppercase tracking-wider font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-muted/50">
                @forelse($employees as $index => $employee)
                <tr class="hover:bg-surface-container-low transition-colors group">
                    <td class="py-3 px-4 font-label-md text-label-md text-outline font-bold">
                        {{ $index + 1 }}
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-4">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->name }}" class="w-8 h-8 rounded-full object-cover shadow-sm">
                            @else
                                <div class="w-8 h-8 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-sm shadow-sm">
                                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-label-md text-label-md text-on-background font-bold">{{ $employee->name }}</p>
                                <p class="font-body-md text-body-md text-outline text-sm">{{ $employee->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <p class="font-label-md text-label-md text-on-background font-mono">{{ $employee->nip }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ ($employee->user && $employee->user->role == 'ceo') ? 'bg-primary-fixed text-primary border-primary/20' : 'bg-surface-variant text-on-surface-variant border-outline-variant/50' }}">
                            {{ $employee->user ? $employee->user->role : 'karyawan' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 font-body-md text-body-md text-on-surface-variant">
                        {{ $employee->number ?? '-' }}
                    </td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex items-center justify-end gap-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('employees.edit', $employee->id) }}" class="w-7 h-7 flex items-center justify-center rounded-full text-primary hover:bg-primary-fixed transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[14px]">edit</span>
                            </a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
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
                                    <span class="material-symbols-outlined text-[48px] font-light">group</span>
                                </div>
                            </div>
                            <h4 class="font-headline-md text-headline-md text-on-background mb-2">Belum ada karyawan</h4>
                            <p class="font-body-md text-body-md text-on-surface-variant max-w-sm mx-auto">
                                Sistem belum memiliki data karyawan yang terdaftar.
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









