@extends('admin.layouts.app')

@section('title', 'Edit Karyawan - Ruang Administrasi')
@section('page-title', 'Edit Karyawan')
@section('page-subtitle', 'Perbarui detail profil dan akses sistem karyawan')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-4 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
        Kembali ke Daftar Karyawan
    </a>
</div>

<!-- Form Card -->
<div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-6 md:p-8 w-full">
    
    <div class="flex items-center gap-4 mb-5 pb-8 border-b border-border-muted">
        @if($employee->photo)
            <img src="{{ asset('storage/' . $employee->photo) }}" alt="Current Profile" class="w-24 h-24 rounded-full object-cover shadow-md border-4 border-surface-container-lowest">
        @else
            <div class="w-24 h-24 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-3xl shadow-md border-4 border-surface-container-lowest">
                {{ strtoupper(substr($employee->name, 0, 2)) }}
            </div>
        @endif
        <div>
            <h3 class="font-headline-md text-headline-md text-on-background font-bold">{{ $employee->name }}</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mt-1">{{ $employee->nip }} &bull; {{ ucfirst($employee->user ? $employee->user->role : 'karyawan') }}</p>
        </div>
    </div>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-3xl font-body-md text-body-md border border-error-container/50">
            <div class="flex items-center gap-4 mb-2 font-bold">
                <span class="material-symbols-outlined">error</span>
                Terdapat kesalahan pada input Anda:
            </div>
            <ul class="list-disc pl-8 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Left Column -->
            <div class="flex flex-col gap-4">
                <!-- Name -->
                <div class="flex flex-col gap-4">
                    <label for="name" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Nama Lengkap <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">person</span>
                        <input type="text" name="name" id="name" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" value="{{ old('name', $employee->name) }}" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-4">
                    <label for="email" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Alamat Email <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">mail</span>
                        <input type="email" name="email" id="email" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" value="{{ old('email', $employee->email) }}" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-4">
                    <label for="password" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Password (Kosongkan jika tidak diubah)</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">lock</span>
                        <input type="password" name="password" id="password" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" placeholder="Ketik password baru">
                    </div>
                </div>

                <!-- NIP -->
                <div class="flex flex-col gap-4">
                    <label for="nip" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">NIP <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">badge</span>
                        <input type="text" name="nip" id="nip" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" value="{{ old('nip', $employee->nip) }}" required>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-4">
                <!-- Role -->
                <div class="flex flex-col gap-4">
                    <label for="role" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Hak Akses Sistem <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">admin_panel_settings</span>
                        <select name="role" id="role" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md appearance-none" required>
                            <option value="karyawan" {{ old('role', ($employee->user ? $employee->user->role : '')) == 'karyawan' ? 'selected' : '' }}>Karyawan (Standard)</option>
                            <option value="ceo" {{ old('role', ($employee->user ? $employee->user->role : '')) == 'ceo' ? 'selected' : '' }}>Admin / CEO (Full Access)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                    </div>
                </div>

                <!-- Contact Number -->
                <div class="flex flex-col gap-4">
                    <label for="number" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Nomor Telepon</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">phone</span>
                        <input type="text" name="number" id="number" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" value="{{ old('number', $employee->number) }}">
                    </div>
                </div>

                <!-- Photo -->
                <div class="flex flex-col gap-4">
                    <label for="photo" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Ubah Foto Profil</label>
                    <div class="border-2 border-dashed border-outline-variant bg-slate-50/50 hover:bg-slate-50 rounded-2xl p-10 flex flex-col items-center justify-center gap-3 transition-colors cursor-pointer group relative">
                        <span class="material-symbols-outlined text-[40px] text-outline group-hover:text-primary mb-2">add_photo_alternate</span>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Klik atau drag foto baru ke sini</p>
                        <p class="text-[10px] text-outline mt-1">Biarkan kosong jika tidak ingin mengubah</p>
                        <input type="file" name="photo" id="photo" class="w-full h-full absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-muted flex flex-col-reverse md:flex-row justify-end items-center gap-4">
            <a href="{{ route('employees.index') }}" class="w-full md:w-auto px-6 py-3 rounded-full font-label-md text-label-md text-slate-600 hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-full font-label-md text-label-md text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[14px]">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection











