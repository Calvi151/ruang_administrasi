@extends('ceo.layouts.app')

@section('title', 'Persetujuan Surat - Ruang Administrasi')
@section('page-title', 'Persetujuan Surat')
@section('page-subtitle', 'Kelola dan review surat keluar dari staf sebelum diterbitkan')

@section('content')
<!-- Top Action Bar -->
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="flex items-center gap-2.5">
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-brand-amber/20 text-brand-amber dark:bg-brand-amber/10">
            <span class="material-symbols-outlined text-xl">fact_check</span>
        </span>
        <div>
            <h3 class="font-headline-md text-lg font-bold text-on-surface dark:text-ds-text-primary">Daftar Menunggu Persetujuan</h3>
            <p class="font-body-md text-xs text-on-surface-variant dark:text-ds-text-secondary">Pilih surat untuk melakukan tinjau dan pengesahan</p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="w-full sm:w-80 relative group">
        <form action="{{ url('/ceo/letter-approvals') }}" method="GET">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-brand-navy dark:group-focus-within:text-brand-amber transition-colors text-[20px]">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, perihal, atau tujuan..." class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-[#141C33] border border-[#CCC7BD] dark:border-[#2A3654] rounded-xl font-body-md text-sm text-on-surface dark:text-[#E8E6E0] focus:border-brand-navy dark:focus:border-brand-amber focus:ring-2 focus:ring-brand-navy/10 dark:focus:ring-brand-amber/20 focus:outline-none transition-all shadow-sm placeholder:text-gray-400 dark:placeholder:text-gray-500">
        </form>
    </div>
</div>

<!-- Table Card (Dengan Border Tegas & Background Kontras) -->
<div class="bg-white dark:bg-[#141C33] rounded-2xl shadow-[0_8px_30px_rgba(15,27,61,0.08)] border border-[#B3AEA3] dark:border-[#2A3654] overflow-hidden transition-all duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-[#B3AEA3] dark:border-[#2A3654] bg-[#EAF0FA] dark:bg-[#0C1326] text-brand-navy dark:text-brand-amber font-label-md text-xs uppercase tracking-wider font-bold">
                    <th class="py-4 px-6 font-bold w-1/5">Nomor Surat</th>
                    <th class="py-4 px-6 font-bold w-1/4">Perihal</th>
                    <th class="py-4 px-6 font-bold w-1/5">Tujuan</th>
                    <th class="py-4 px-6 font-bold w-1/6">Pembuat</th>
                    <th class="py-4 px-6 font-bold w-1/6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-sm text-on-surface dark:text-ds-text-primary divide-y divide-[#E0DED8] dark:divide-[#2A3654] bg-white dark:bg-[#141C33]">
                @forelse($letters as $letter)
                <tr class="hover:bg-[#F2F6FC] dark:hover:bg-[#1A2440]/70 transition-all duration-200 group">
                    <td class="py-4 px-6">
                        <span class="font-semibold text-brand-navy dark:text-brand-amber font-mono text-xs md:text-sm bg-[#EBF0FA] dark:bg-brand-amber/10 px-2.5 py-1 rounded-md border border-brand-navy/15 dark:border-brand-amber/20 block w-fit">
                            {{ $letter->letter_number }}
                        </span>
                    </td>
                    <td class="py-4 px-6 font-medium">
                        <div class="max-w-[220px] truncate text-on-surface dark:text-[#E8E6E0] font-semibold" title="{{ $letter->subject }}">
                            {{ $letter->subject ?? '-' }}
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600 dark:text-gray-300">
                        <div class="flex items-center gap-1.5 font-medium">
                            <span class="material-symbols-outlined text-[16px] text-gray-400">business</span>
                            <span>{{ $letter->recipient ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600 dark:text-gray-300">
                        <div class="flex flex-col">
                            <span class="font-bold text-on-surface dark:text-ds-text-primary text-xs">{{ optional($letter->creator)->name ?? optional($letter->creator)->nip ?? '-' }}</span>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-0.5 font-normal">
                                <span class="material-symbols-outlined text-[12px] text-gray-400">calendar_today</span>
                                {{ \Carbon\Carbon::parse($letter->created_at)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-right">
                        <a href="{{ url('ceo/letter-approvals/' . $letter->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-navy dark:bg-brand-amber text-white dark:text-brand-navy rounded-xl font-label-md text-xs font-bold hover:opacity-95 hover:shadow-md transition-all duration-200 group-hover:translate-x-0.5 shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">rule</span>
                            <span>Review</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-[#1D2847] flex items-center justify-center text-gray-400 dark:text-ds-text-secondary shadow-inner border border-gray-200 dark:border-[#2A3654]">
                                <span class="material-symbols-outlined text-4xl">verified_user</span>
                            </div>
                            <div class="max-w-sm">
                                <p class="font-label-md text-base text-brand-navy dark:text-ds-text-primary font-bold">Tidak Ada Surat Menunggu Persetujuan</p>
                                <p class="font-body-md text-xs text-gray-500 dark:text-ds-text-secondary mt-1">Semua surat keluar telah selesai diperiksa dan diproyeksikan ke langkah berikutnya.</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($letters->hasPages())
    <div class="px-6 py-4 border-t border-[#CCC7BD] dark:border-[#2A3654] bg-[#F8F9FC] dark:bg-[#0E1628]">
        {{ $letters->links() }}
    </div>
    @endif
</div>
@endsection
