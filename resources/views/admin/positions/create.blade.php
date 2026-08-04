@extends('admin.layouts.app')

@section('content')
<div class="px-6 py-8 mx-auto w-full animate-fade-in">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('positions.index') }}" class="w-10 h-10 rounded-full flex items-center justify-center bg-white dark:bg-[#141C33] border border-outline-variant/40 dark:border-[#2A3654] text-on-surface-variant hover:text-on-surface dark:hover:text-white hover:bg-slate-50 dark:hover:bg-[#1D2847] transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="font-display-lg text-[28px] font-bold text-on-surface dark:text-[#E8E6E0] leading-tight">Tambah Jabatan</h1>
            <p class="text-sm text-on-surface-variant dark:text-[#8B93A8]">Buat jabatan baru untuk ditugaskan ke karyawan.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-[#141C33] rounded-2xl border border-outline-variant/40 dark:border-[#2A3654] shadow-sm p-6 md:p-8">
        <form action="{{ route('positions.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-on-surface dark:text-[#E8E6E0] mb-2">Nama Jabatan <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="Contoh: HR Manager" class="w-full px-4 py-3 bg-slate-50 dark:bg-[#0F172E] border @error('name') border-red-500 @else border-outline-variant/60 dark:border-[#2A3654] @enderror rounded-xl focus:ring-2 focus:ring-[#D9A441] focus:border-[#D9A441] transition-all text-on-surface dark:text-white">
                    @error('name')
                        <p class="mt-2 text-xs text-red-500 font-medium flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-on-surface dark:text-[#E8E6E0] mb-2">Deskripsi <span class="text-on-surface-variant font-normal">(Opsional)</span></label>
                    <textarea name="description" id="description" rows="4" placeholder="Jelaskan secara singkat tugas dan tanggung jawab jabatan ini..." class="w-full px-4 py-3 bg-slate-50 dark:bg-[#0F172E] border @error('description') border-red-500 @else border-outline-variant/60 dark:border-[#2A3654] @enderror rounded-xl focus:ring-2 focus:ring-[#D9A441] focus:border-[#D9A441] transition-all text-on-surface dark:text-white resize-none">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-xs text-red-500 font-medium flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-outline-variant/30 dark:border-[#2A3654] flex justify-end gap-3">
                <a href="{{ route('positions.index') }}" class="px-6 py-2.5 rounded-xl font-semibold text-on-surface-variant dark:text-[#8B93A8] hover:bg-slate-100 dark:hover:bg-[#0F172E] transition-colors">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#D9A441] hover:bg-[#c49237] text-white font-bold shadow-lg shadow-[#D9A441]/30 transition-all active:scale-95 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan Jabatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
