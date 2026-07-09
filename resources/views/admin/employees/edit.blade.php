@extends('admin.layouts.app')

@section('title', 'Edit Karyawan - Ruang Administrasi')
@section('page-title', 'Edit Karyawan')

@section('content')
<div class="mb-6">
    <a href="{{ route('employees.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Daftar Karyawan
    </a>
</div>

<div class="bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
    <!-- Employee Header -->
    <div class="px-6 py-4 border-b border-outline-variant/30 bg-surface-container-lowest flex items-center gap-4">
        @if($employee->photo)
            <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->name }}" class="w-12 h-12 rounded-full object-cover border border-outline-variant">
        @else
            <div class="w-12 h-12 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold text-lg">
                {{ strtoupper(substr($employee->name, 0, 2)) }}
            </div>
        @endif
        <div>
            <h3 class="font-h3 text-h3 text-on-surface">{{ $employee->name }}</h3>
            <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $employee->nip }} &bull; {{ ucfirst($employee->user ? $employee->user->role : 'karyawan') }}</p>
        </div>
    </div>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="mx-6 mt-6 bg-error-container/30 text-error p-4 rounded-lg font-body-sm text-body-sm border border-error/20">
            <div class="flex items-center gap-2 mb-2 font-medium">
                <span class="material-symbols-outlined text-[18px]">error</span>
                Terdapat kesalahan:
            </div>
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-5">
                <div>
                    <label for="name" class="block font-label-md text-label-md text-on-surface mb-1">Nama Lengkap <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">person</span>
                        <input type="text" name="name" id="name" class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm" value="{{ old('name', $employee->name) }}" required>
                    </div>
                </div>
                <div>
                    <label for="email" class="block font-label-md text-label-md text-on-surface mb-1">Email <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">mail</span>
                        <input type="email" name="email" id="email" class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm" value="{{ old('email', $employee->email) }}" required>
                    </div>
                </div>
                <div>
                    <label for="password" class="block font-label-md text-label-md text-on-surface mb-1">Password Baru <span class="font-body-sm text-body-sm text-on-surface-variant">(kosongkan jika tidak diubah)</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">lock</span>
                        <input type="password" name="password" id="password" class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm" placeholder="Minimal 8 karakter">
                    </div>
                </div>
                <div>
                    <label for="nip" class="block font-label-md text-label-md text-on-surface mb-1">NIP <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">badge</span>
                        <input type="text" name="nip" id="nip" class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm" value="{{ old('nip', $employee->nip) }}" required>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label for="role" class="block font-label-md text-label-md text-on-surface mb-1">Hak Akses <span class="text-error">*</span></label>
                    <div class="relative">
                        <select name="role" id="role" class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-3 pr-10 font-body-sm text-body-sm appearance-none" required>
                            <option value="admin" {{ old('role', $employee->user ? $employee->user->role : 'admin') == 'admin' ? 'selected' : '' }}>Admin (Standard)</option>
                            <option value="ceo" {{ old('role', $employee->user ? $employee->user->role : 'admin') == 'ceo' ? 'selected' : '' }}>Admin / CEO (Full Access)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-on-surface-variant">
                            <span class="material-symbols-outlined">expand_more</span>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="number" class="block font-label-md text-label-md text-on-surface mb-1">Nomor Telepon</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">phone</span>
                        <input type="text" name="number" id="number" class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm" value="{{ old('number', $employee->number) }}">
                    </div>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Ganti Foto Profil</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-outline-variant border-dashed rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">add_photo_alternate</span>
                            <div class="flex text-body-sm text-on-surface-variant justify-center">
                                <label class="relative cursor-pointer font-label-md text-primary hover:underline" for="photo">
                                    <span id="file_name_display">Pilih foto baru</span>
                                    <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png" class="sr-only">
                                </label>
                                <p class="pl-1" id="file_drag_text">atau tarik dan lepas</p>
                            </div>
                            <p class="text-xs text-on-surface-variant" id="file_help_text">Biarkan kosong jika tidak diubah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-3">
            <a href="{{ route('employees.index') }}" class="px-4 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface-variant rounded-lg font-label-md text-label-md hover:bg-surface transition-colors shadow-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    const fileInput = document.getElementById('photo');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('file_name_display').textContent = fileName;
                const dragText = document.getElementById('file_drag_text');
                if(dragText) dragText.style.display = 'none';
                
                const icon = this.closest('.border-dashed').querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.textContent = 'check_circle';
                    icon.classList.add('text-primary');
                }
            }
        });
    }
</script>
@endsection
