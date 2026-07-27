@extends('ceo.layouts.app')

@section('title', 'Data Karyawan - Ruang Administrasi')
@section('page-title', 'Data Karyawan')
@section('page-subtitle', 'Informasi dan direktori seluruh staf perusahaan (Read-only)')

@section('content')
<!-- Action & Search Bar -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div class="flex items-center gap-2.5">
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-brand-navy/10 text-brand-navy dark:bg-brand-amber/10 dark:text-brand-amber">
            <span class="material-symbols-outlined text-xl">badge</span>
        </span>
        <div>
            <h3 class="font-headline-md text-lg font-bold text-on-surface dark:text-ds-text-primary">Direktori Staf</h3>
            <p class="font-body-md text-xs text-on-surface-variant dark:text-ds-text-secondary">Daftar lengkap anggota organisasi dan kontak operasional</p>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ url('/ceo/employees') }}" class="w-full md:w-auto">
        <div class="flex items-center gap-2 max-w-md w-full">
            <div class="relative flex-1 sm:w-72">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-[20px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, atau jabatan..." class="w-full pl-11 pr-4 py-2 bg-white dark:bg-[#141C33] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl font-body-md text-sm text-on-surface dark:text-[#E8E6E0] focus:border-brand-navy dark:focus:border-brand-amber focus:ring-2 focus:ring-brand-navy/10 dark:focus:ring-brand-amber/20 focus:outline-none transition-all shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500">
            </div>
            <button type="submit" class="bg-brand-navy dark:bg-brand-amber text-white dark:text-brand-navy px-5 py-2 rounded-xl font-label-md font-bold text-xs uppercase tracking-wider hover:opacity-90 hover:shadow-md transition-all shadow-sm shrink-0 flex items-center gap-1.5">
                <span>Cari</span>
            </button>
            @if(request('search'))
            <a href="{{ url('/ceo/employees') }}" class="p-2 bg-white dark:bg-[#1D2847] hover:bg-gray-100 dark:hover:bg-[#2A3654] rounded-xl text-on-surface dark:text-ds-text-primary border border-[#CCC7BD] dark:border-[#2A3654] transition-colors shadow-sm" title="Reset Pencarian">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </a>
            @endif
        </div>
    </form>
</div>

<!-- Table Card (Dengan Border Tegas & Background Kontras) -->
<div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden transition-all duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA] dark:bg-[#0C1326] text-brand-navy dark:text-brand-amber font-label-md text-xs uppercase tracking-wider font-bold">
                    <th class="py-4 px-6 font-bold w-1/4">Nama Lengkap</th>
                    <th class="py-4 px-6 font-bold w-1/6">NIP</th>
                    <th class="py-4 px-6 font-bold w-1/5">Jabatan</th>
                    <th class="py-4 px-6 font-bold w-1/5">Email</th>
                    <th class="py-4 px-6 font-bold w-1/6">No HP</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-sm text-on-surface dark:text-ds-text-primary divide-y divide-[#E0DED8] dark:divide-[#2A3654] bg-white dark:bg-[#141C33]">
                @forelse($employees as $employee)
                <tr class="hover:bg-[#F2F6FC] dark:hover:bg-[#1A2440]/70 transition-all duration-200 group">
                    <td class="py-4 px-6 font-semibold text-on-surface dark:text-[#E8E6E0]">
                        <div class="flex items-center gap-3">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->name }}" class="w-9 h-9 rounded-full object-cover border border-[#CCC7BD] dark:border-ds-border shadow-xs shrink-0">
                            @else
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-navy to-[#2A3654] dark:from-brand-amber dark:to-[#B8862D] text-white dark:text-brand-navy flex items-center justify-center font-bold text-xs uppercase shadow-xs shrink-0 border border-white/10">
                                    {{ substr($employee->name ?? 'K', 0, 2) }}
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-bold text-brand-navy dark:text-ds-text-primary group-hover:text-brand-amber transition-colors">{{ $employee->name }}</div>
                                <div class="text-[11px] text-gray-500 dark:text-gray-400 font-normal md:hidden">{{ $employee->position ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600 dark:text-ds-text-secondary font-mono text-xs font-semibold">
                        <span class="bg-gray-100 dark:bg-[#1A2440] px-2.5 py-1 rounded-md border border-gray-300/80 dark:border-[#2A3654]">
                            {{ optional($employee->user)->nip ?? '-' }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-on-surface dark:text-[#E8E6E0] font-medium">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EBF0FA] dark:bg-brand-amber/10 text-brand-navy dark:text-brand-amber font-label-md text-xs font-bold border border-brand-navy/15 dark:border-brand-amber/20">
                            {{ $employee->position ?? '-' }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-gray-600 dark:text-gray-300 text-xs font-medium">
                        @if(optional($employee->user)->email)
                            <a href="mailto:{{ optional($employee->user)->email }}" class="hover:text-brand-amber hover:underline flex items-center gap-1.5 transition-colors">
                                <span class="material-symbols-outlined text-[16px] text-gray-400">mail</span>
                                <span>{{ optional($employee->user)->email }}</span>
                            </a>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-gray-600 dark:text-gray-300 font-mono text-xs font-medium">
                        @if($employee->phone)
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-gray-400">call</span>
                                <span>{{ $employee->phone }}</span>
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center text-gray-400 dark:text-ds-text-secondary">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-[#1D2847] flex items-center justify-center text-gray-400 dark:text-ds-text-secondary shadow-inner border border-gray-200 dark:border-[#2A3654]">
                                <span class="material-symbols-outlined text-4xl">person_off</span>
                            </div>
                            <div class="max-w-sm">
                                <p class="font-label-md text-base text-brand-navy dark:text-ds-text-primary font-bold">Data Karyawan Tidak Ditemukan</p>
                                <p class="font-body-md text-xs text-gray-500 dark:text-ds-text-secondary mt-1">Tidak ada staf yang sesuai dengan parameter pencarian Anda.</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
