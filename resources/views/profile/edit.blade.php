@php
    $layout = auth()->user()->role === 'admin' ? 'admin.layouts.app' : 'ceo.layouts.app';
    $employee = auth()->user()->employee;
@endphp

@extends($layout)

@section('title', 'Profil Saya - Ruang Administrasi')
@section('page-title', 'Profil Saya')

@section('content')
<div class="mb-8">
    <nav aria-label="Breadcrumb" class="flex text-sm text-on-surface-variant dark:text-ds-text-secondary mb-2">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 font-body-sm text-body-sm">
            <li class="inline-flex items-center">
                <a class="hover:text-primary dark:hover:text-primary-fixed transition-colors" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : url('/ceo/dashboard') }}">Beranda</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-sm mx-1">chevron_right</span>
                    <span class="text-on-surface dark:text-ds-text-primary font-medium">Profil Saya</span>
                </div>
            </li>
        </ol>
    </nav>
    <h1 class="font-h1-mobile text-h1-mobile md:font-h1 md:text-h1 text-on-surface dark:text-ds-text-primary">Profil Saya</h1>
</div>

@if (session('status') === 'profile-updated')
<div class="mb-6 bg-secondary-container/30 dark:bg-ds-accent/20 border border-secondary/20 dark:border-ds-border text-on-secondary-container dark:text-ds-accent px-5 py-4 rounded-xl flex items-center gap-3 animate-fade-in" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
    <span class="material-symbols-outlined text-secondary dark:text-ds-accent icon-fill text-[22px]">check_circle</span>
    <span class="font-label-md text-label-md">Data profil Anda berhasil disimpan!</span>
</div>
@endif

@if (session('status') === 'password-updated')
<div class="mb-6 bg-secondary-container/30 dark:bg-ds-accent/20 border border-secondary/20 dark:border-ds-border text-on-secondary-container dark:text-ds-accent px-5 py-4 rounded-xl flex items-center gap-3 animate-fade-in" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
    <span class="material-symbols-outlined text-secondary dark:text-ds-accent icon-fill text-[22px]">check_circle</span>
    <span class="font-label-md text-label-md">Kata sandi berhasil diperbarui!</span>
</div>
@endif

@if ($errors->any())
<div class="mb-6 bg-error-container/30 dark:bg-error-container/20 border border-error/20 dark:border-error/30 text-error dark:text-error-container px-5 py-4 rounded-xl">
    <div class="flex items-center gap-2 mb-2 font-medium">
        <span class="material-symbols-outlined text-[18px]">error</span>
        Terdapat kesalahan:
    </div>
    <ul class="list-disc pl-6 space-y-1 font-body-sm text-body-sm">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Profile Header Card -->
<div class="bg-surface-container-lowest dark:bg-ds-surface rounded-2xl shadow-sm border border-outline-variant dark:border-ds-border p-5 md:p-6 flex flex-col md:flex-row items-center md:items-start gap-5 relative mb-3">
    <div class="w-28 h-28 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-surface dark:border-ds-bg shadow-md bg-primary-container dark:bg-ds-bg-container flex items-center justify-center shrink-0">
        @if($employee && $employee->photo)
            <img alt="Profile Picture" class="object-cover w-full h-full" src="{{ asset('storage/' . $employee->photo) }}"/>
        @else
            <div class="text-3xl font-bold text-on-primary-container dark:text-ds-text-primary-container">{{ strtoupper(substr($employee->name ?? 'A', 0, 2)) }}</div>
        @endif
    </div>
    
    <div class="text-center md:text-left flex-grow">
        <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
            <h2 class="font-h2 text-h2 text-on-surface dark:text-ds-text-primary">{{ $employee->name ?? '-' }}</h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-secondary-container/30 dark:bg-ds-accent/20 text-secondary-fixed-variant dark:text-ds-accent font-label-sm text-label-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary dark:bg-secondary-fixed mr-2"></span>
                {{ auth()->user()->role === 'admin' ? 'Admin' : 'CEO / Pimpinan' }}
            </span>
        </div>
        <p class="font-body-md text-body-md text-on-surface-variant dark:text-ds-text-secondary flex items-center justify-center md:justify-start gap-2">
            <span class="material-symbols-outlined text-lg">badge</span>
            NIP: {{ auth()->user()->nip }}
        </p>
        <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-2 max-w-lg">
            Kelola informasi pribadi, foto, dan pengaturan keamanan akun Anda melalui form di bawah.
        </p>
    </div>
</div>

<!-- Main Form -->
<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-surface-container-lowest dark:bg-ds-surface rounded-xl shadow-sm border border-outline-variant dark:border-ds-border overflow-hidden mb-3">
    @csrf
    @method('patch')

    <div class="p-4 md:p-5">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-6 gap-y-3">
            
            <!-- LEFT COLUMN -->
            <div class="space-y-3">
                <!-- Nama Lengkap -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Nama Lengkap <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">person</span>
                        <input name="name" class="w-full bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border rounded-lg pl-10 pr-4 py-2.5 font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary focus:border-primary dark:focus:border-primary-fixed focus:ring-1 focus:ring-primary dark:focus:ring-primary-fixed outline-none transition-shadow placeholder:text-outline-variant dark:placeholder:text-ds-text-secondary" type="text" value="{{ old('name', $employee->name ?? '') }}" placeholder="Masukkan nama lengkap" required/>
                    </div>
                </div>

                <!-- Alamat Email -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Alamat Email <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">mail</span>
                        <input name="email" class="w-full bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border rounded-lg pl-10 pr-4 py-2.5 font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary focus:border-primary dark:focus:border-primary-fixed focus:ring-1 focus:ring-primary dark:focus:ring-primary-fixed outline-none transition-shadow placeholder:text-outline-variant dark:placeholder:text-ds-text-secondary" type="email" value="{{ old('email', $employee->email ?? '') }}" placeholder="email@contoh.com" required/>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Password <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">lock</span>
                        <input name="password" class="w-full bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border rounded-lg pl-10 pr-4 py-2.5 font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary focus:border-primary dark:focus:border-primary-fixed focus:ring-1 focus:ring-primary dark:focus:ring-primary-fixed outline-none transition-shadow placeholder:text-outline-variant dark:placeholder:text-ds-text-secondary" type="password" placeholder="Minimal 8 karakter"/>
                    </div>
                    <p class="text-xs text-outline dark:text-ds-text-secondary mt-1.5 ml-1">Kosongkan jika tidak ingin mengubah password.</p>
                </div>

                <!-- NIP -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">NIP <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">badge</span>
                        <input class="w-full bg-surface-container-low dark:bg-ds-surface border border-outline-variant dark:border-ds-border rounded-lg pl-10 pr-4 py-2.5 font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary cursor-not-allowed" type="text" value="{{ auth()->user()->nip }}" readonly/>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="flex flex-col space-y-3">
                <!-- Hak Akses Sistem -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Hak Akses Sistem <span class="text-error">*</span></label>
                    <div class="relative">
                        <input class="w-full bg-surface-container-low dark:bg-ds-surface border border-outline-variant dark:border-ds-border rounded-lg px-4 py-2.5 font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary cursor-not-allowed" type="text" value="{{ auth()->user()->role === 'admin' ? 'Admin (Standard)' : 'CEO / Pimpinan' }}" readonly/>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">keyboard_arrow_down</span>
                    </div>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Nomor Telepon</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">call</span>
                        <input name="number" class="w-full bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border rounded-lg pl-10 pr-4 py-2.5 font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary focus:border-primary dark:focus:border-primary-fixed focus:ring-1 focus:ring-primary dark:focus:ring-primary-fixed outline-none transition-shadow placeholder:text-outline-variant dark:placeholder:text-ds-text-secondary" type="text" value="{{ old('number', $employee->number ?? '') }}" placeholder="08123456789"/>
                    </div>
                </div>

                <!-- Foto Profil (Spans remaining height) -->
                <div class="flex-grow flex flex-col">
                    <label class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Foto Profil</label>
                    <div class="flex-grow w-full border-2 border-dashed border-outline dark:border-ds-border rounded-xl bg-surface-container-low/50 dark:bg-ds-bg/50 hover:bg-surface-container-low dark:hover:bg-ds-hover transition-colors flex flex-col items-center justify-center p-4 cursor-pointer group relative overflow-hidden min-h-[140px]" onclick="document.getElementById('photo').click()" id="dropzone">
                        
                        <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                        
                        @if($employee && $employee->photo)
                            <!-- Existing Image Preview -->
                            <img id="image_preview" src="{{ asset('storage/' . $employee->photo) }}" class="absolute inset-0 w-full h-full object-cover z-0">
                            
                            <div class="text-center z-20 bg-black/50 absolute inset-0 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" id="upload_content">
                                <span class="material-symbols-outlined text-white text-[32px] mb-2">add_photo_alternate</span>
                                <p class="text-sm text-white font-medium">Ubah Foto</p>
                            </div>
                        @else
                            <img id="image_preview" src="" class="absolute inset-0 w-full h-full object-cover z-0 hidden">
                            
                            <div class="text-center z-20" id="upload_content">
                                <div class="w-12 h-12 mb-3 bg-surface-container-lowest dark:bg-ds-bg shadow-sm border border-outline-variant dark:border-ds-border rounded-lg mx-auto flex items-center justify-center text-outline dark:text-ds-text-secondary group-hover:text-primary dark:group-hover:text-primary-fixed transition-colors">
                                    <span class="material-symbols-outlined text-[24px]">add_photo_alternate</span>
                                </div>
                                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mb-1"><span class="text-primary dark:text-primary-fixed font-medium">Pilih foto</span> atau tarik dan lepas</p>
                                <p class="text-xs text-outline dark:text-ds-text-secondary">JPG, PNG maks. 2MB</p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Action Footer -->
    <div class="px-6 py-4 bg-surface-container-low dark:bg-ds-surface border-t border-outline-variant/30 dark:border-ds-border/30 flex justify-end gap-3">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : url('/ceo/dashboard') }}" class="px-5 py-2.5 bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border text-on-surface-variant dark:text-ds-text-secondary rounded-lg font-label-md text-label-md hover:bg-surface-container-low dark:hover:bg-ds-hover transition-colors focus:ring-2 focus:ring-outline-variant dark:focus:ring-dark-outline-variant focus:outline-none">
            Batal
        </a>
        <button type="submit" class="px-5 py-2.5 bg-primary dark:bg-ds-bg text-on-primary dark:text-ds-text-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:outline-none flex items-center gap-2 shadow-sm">
            <span class="material-symbols-outlined text-[18px]">save</span>
            Simpan Perubahan
        </button>
    </div>
</form>

<!-- Danger Zone -->
<div class="bg-surface-container-lowest dark:bg-ds-surface rounded-xl shadow-sm border border-error/30 dark:border-error/20 overflow-hidden mt-0">
    <div class="px-6 py-5 border-b border-error/10 bg-error-container/10 dark:bg-error-container/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="p-2.5 bg-surface-container-lowest dark:bg-ds-bg shadow-sm border border-error/20 rounded-lg text-error dark:text-error shrink-0">
                <span class="material-symbols-outlined icon-fill">warning</span>
            </div>
            <div>
                <h3 class="font-h3 text-h3 text-error dark:text-error">Zona Berbahaya</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-0.5">Tindakan menghapus akun bersifat permanen dan tidak dapat dibatalkan. Semua data riwayat dan dokumen akan dihapus.</p>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" class="px-5 py-2.5 bg-error dark:bg-error text-on-error dark:text-on-error rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors focus:ring-2 focus:ring-error focus:outline-none flex items-center justify-center gap-2 shadow-sm shrink-0 whitespace-nowrap">
            <span class="material-symbols-outlined text-[18px]">delete_forever</span>
            Hapus Akun
        </button>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-surface-container-lowest dark:bg-ds-surface rounded-2xl shadow-xl max-w-md w-full overflow-hidden border border-outline-variant dark:border-ds-border">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-error-container text-on-error-container dark:bg-error-container dark:text-on-error-container flex items-center justify-center">
                    <span class="material-symbols-outlined">warning</span>
                </div>
                <h3 class="font-h3 text-h3 text-on-surface dark:text-ds-text-primary">Hapus Akun</h3>
            </div>
            
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mb-5">
                    Apakah Anda yakin ingin menghapus akun ini? Semua data akan dihapus permanen. Masukkan kata sandi Anda untuk konfirmasi.
                </p>

                <div class="mb-6 relative">
                    <label class="sr-only" for="delete_password">Kata Sandi</label>
                    <input type="password" name="password" id="delete_password"
                        class="w-full bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border rounded-lg pl-10 pr-4 py-2.5 font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary focus:border-error dark:focus:border-error focus:ring-1 focus:ring-error outline-none transition-shadow placeholder:text-outline-variant dark:placeholder:text-ds-text-secondary"
                        placeholder="Masukkan Kata Sandi" required>
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">lock</span>
                    @if($errors->userDeletion->has('password'))
                        <p class="mt-2 text-sm text-error font-medium">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                        class="px-5 py-2.5 bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border text-on-surface-variant dark:text-ds-text-secondary rounded-lg font-label-md text-label-md hover:bg-surface-container-low dark:hover:bg-ds-hover transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-error text-on-error rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById('image_preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                preview.classList.remove('opacity-30');
                preview.classList.add('opacity-100');
                
                // Set hover overlay styling
                const uploadContent = document.getElementById('upload_content');
                uploadContent.className = 'text-center z-20 bg-black/50 absolute inset-0 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity';
                uploadContent.innerHTML = '<span class="material-symbols-outlined text-white text-[32px] mb-2">add_photo_alternate</span><p class="text-sm text-white font-medium">Ubah Foto</p>';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Drag and drop logic
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('photo');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropzone.classList.add('border-primary', 'dark:border-primary-fixed', 'bg-primary/5', 'dark:bg-ds-bg-fixed/10');
        dropzone.classList.remove('border-outline', 'dark:border-ds-border', 'bg-surface-container-low/50', 'dark:bg-ds-bg/50');
    }

    function unhighlight(e) {
        dropzone.classList.remove('border-primary', 'dark:border-primary-fixed', 'bg-primary/5', 'dark:bg-ds-bg-fixed/10');
        dropzone.classList.add('border-outline', 'dark:border-ds-border', 'bg-surface-container-low/50', 'dark:bg-ds-bg/50');
    }

    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        previewImage(fileInput);
    }

    // Auto-show delete modal on validation error
    @if($errors->userDeletion->isNotEmpty())
        document.getElementById('deleteModal').classList.remove('hidden');
    @endif
</script>
@endsection
