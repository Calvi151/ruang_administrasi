@extends('ceo.layouts.app')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')
@section('page-subtitle', 'Daftar semua karyawan (Read-only)')

@section('content')
<div class="flex flex-col gap-1 mb-2">
    <h2 class="font-display text-display text-on-surface">Data Karyawan</h2>
    <p class="font-body-sm text-body-sm text-on-surface-variant">Informasi staf dan karyawan perusahaan</p>
</div>

<!-- Search Form -->
<form method="GET" action="{{ url('/ceo/employees') }}" class="mb-4">
    <div class="flex items-center gap-2 max-w-md">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, atau jabatan..." class="w-full px-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-sm focus:border-primary focus:ring-2 focus:ring-primary-fixed-dim focus:outline-none transition-all">
        <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-xl font-label-md font-semibold hover:opacity-90 transition-opacity">Cari</button>
    </div>
</form>

<div class="bg-surface-container-lowest border border-outline-variant rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm uppercase tracking-wide">
                    <th class="py-4 px-6 font-semibold">Nama</th>
                    <th class="py-4 px-6 font-semibold">NIP</th>
                    <th class="py-4 px-6 font-semibold">Jabatan</th>
                    <th class="py-4 px-6 font-semibold">Email</th>
                    <th class="py-4 px-6 font-semibold">No HP</th>
                </tr>
            </thead>
            <tbody class="font-body-base text-body-base">
                @forelse($employees as $employee)
                <tr class="border-b border-outline-variant/50 hover:bg-surface-container-low transition-colors">
                    <td class="py-4 px-6 font-semibold text-on-surface">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-xs uppercase">
                                {{ substr($employee->name, 0, 2) }}
                            </div>
                            {{ $employee->name }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ optional($employee->user)->nip ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ $employee->position ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ optional($employee->user)->email ?? '-' }}</td>
                    <td class="py-4 px-6 text-on-surface-variant">{{ $employee->phone ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-outline">Data karyawan tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
