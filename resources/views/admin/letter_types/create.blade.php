@extends('admin.layouts.app')

@section('title', 'Tambah Jenis Surat - Ruang Administrasi')
@section('page-title', 'Tambah Jenis Surat')
@section('page-subtitle', 'Tambahkan referensi jenis surat baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('letter-types.index') }}" class="inline-flex items-center gap-4 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
        Kembali ke Daftar Jenis Surat
    </a>
</div>

<div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-6 md:p-8 w-full">
    <form action="{{ route('letter-types.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf

        @if ($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-3xl font-body-md text-body-md border border-error-container/50">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-status-peach text-tertiary border border-tertiary-fixed p-4 rounded-3xl font-body-md text-body-md flex gap-4 items-start">
            <span class="material-symbols-outlined shrink-0">info</span>
            <div>
                <strong>Informasi Penting:</strong> Pastikan <em>Kode Surat</em> bersifat unik dan belum digunakan sebelumnya.
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <label for="letter_code" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Kode Surat <span class="text-error">*</span></label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">tag</span>
                <input type="text" name="letter_code" id="letter_code" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" placeholder="Contoh: SK, SP, BA" value="{{ old('letter_code') }}" required>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <label for="type_name" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Nama Jenis Surat <span class="text-error">*</span></label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">description</span>
                <input type="text" name="type_name" id="type_name" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" placeholder="Contoh: Surat Keputusan" value="{{ old('type_name') }}" required>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-muted flex flex-col-reverse md:flex-row justify-end items-center gap-4">
            <a href="{{ route('letter-types.index') }}" class="w-full md:w-auto px-6 py-3 rounded-full font-label-md text-label-md text-slate-600 hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-full font-label-md text-label-md text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[14px]">save</span>
                Simpan Jenis Surat
            </button>
        </div>
    </form>
</div>
@endsection










