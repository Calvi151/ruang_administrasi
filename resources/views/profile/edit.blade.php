@php
    $layout = auth()->user()->role === 'admin' ? 'admin.layouts.app' : 'ceo.layouts.app';
    $employee = auth()->user()->employee;
@endphp

@extends($layout)

@section('title', 'Profil Saya - Ruang Administrasi')
@section('page-title', 'Profil Saya')

@section('content')
<style>
    /* Noise texture for premium feel */
    .bg-noise {
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.08'/%3E%3C/svg%3E");
    }
    
    /* Dramatic shadow for floating card */
    .shadow-dramatic {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 40px rgba(0,0,0,0.05);
    }
    html.dark .shadow-dramatic {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), 0 0 40px rgba(0,0,0,0.4);
    }
</style>

<div class="mb-6 relative z-20">
    <nav aria-label="Breadcrumb" class="flex text-sm text-on-surface-variant dark:text-ds-text-secondary mb-2">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 font-body-sm text-body-sm">
            <li class="inline-flex items-center">
                <a class="hover:text-[#D9A441] transition-colors" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : url('/ceo/dashboard') }}">Beranda</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-sm mx-1">chevron_right</span>
                    <span class="text-on-surface dark:text-ds-text-primary font-medium">Profil Saya</span>
                </div>
            </li>
        </ol>
    </nav>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h1 class="font-h1-mobile text-h1-mobile md:font-h1 md:text-h1 text-on-surface dark:text-ds-text-primary tracking-tight">Profil Saya</h1>
    </div>
</div>

{{-- Notifications --}}
@if (session('status') === 'profile-updated')
<div class="mb-8 bg-[#D9A441]/10 dark:bg-ds-accent/10 border border-[#D9A441]/30 dark:border-[#D9A441]/20 text-[#0F1B3D] dark:text-[#D9A441] px-6 py-4 rounded-2xl flex items-center gap-3 animate-fade-in shadow-sm relative z-20" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
    <span class="material-symbols-outlined text-[#D9A441] icon-fill text-[24px]">check_circle</span>
    <span class="font-semibold text-sm">Data profil Anda berhasil disimpan!</span>
</div>
@endif

@if (session('status') === 'password-updated')
<div class="mb-8 bg-[#D9A441]/10 dark:bg-ds-accent/10 border border-[#D9A441]/30 dark:border-[#D9A441]/20 text-[#0F1B3D] dark:text-[#D9A441] px-6 py-4 rounded-2xl flex items-center gap-3 animate-fade-in shadow-sm relative z-20" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
    <span class="material-symbols-outlined text-[#D9A441] icon-fill text-[24px]">check_circle</span>
    <span class="font-semibold text-sm">Kata sandi berhasil diperbarui!</span>
</div>
@endif

@if ($errors->any())
<div class="mb-8 bg-error-container/30 dark:bg-error-container/20 border border-error/20 dark:border-error/30 text-error dark:text-error-container px-6 py-4 rounded-2xl shadow-sm relative z-20">
    <div class="flex items-center gap-2 mb-2 font-semibold text-sm">
        <span class="material-symbols-outlined text-[20px]">error</span>
        Terdapat kesalahan dalam pengisian formulir:
    </div>
    <ul class="list-disc pl-6 space-y-1 font-body-sm text-body-sm">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Main Form Container --}}
<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-form">
    @csrf
    @method('patch')

    {{-- Hidden File Input & Delete Flag for Photo --}}
    <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png" class="hidden" onchange="previewImage(this)">
    <input type="hidden" name="delete_photo" id="delete_photo" value="0">

    {{-- 1. COVER BANNER (Mesh Gradient, Blur, Noise, Decorative Lines) --}}
    <div class="relative w-full h-64 sm:h-72 md:h-80 rounded-[32px] overflow-hidden shadow-lg border border-outline-variant/20 dark:border-ds-border/40 bg-[#070B14]">
        
        {{-- Mesh Gradient Orbs --}}
        <div class="absolute -top-[20%] -left-[10%] w-[60%] h-[70%] rounded-full bg-[#0F1B3D] blur-[80px] mix-blend-screen pointer-events-none"></div>
        <div class="absolute top-[30%] left-[20%] w-[50%] h-[60%] rounded-full bg-[#2A1B54] blur-[90px] mix-blend-screen pointer-events-none opacity-80"></div>
        <div class="absolute -bottom-[20%] right-[10%] w-[50%] h-[80%] rounded-full bg-[#D9A441] blur-[100px] mix-blend-screen pointer-events-none opacity-60"></div>
        <div class="absolute top-0 right-[20%] w-[40%] h-[50%] rounded-full bg-[#4A154B] blur-[80px] mix-blend-screen pointer-events-none opacity-70"></div>
        
        {{-- Decorative Geometrics (Fine Lines) --}}
        <svg class="absolute top-0 right-0 w-1/2 h-full opacity-[0.07] pointer-events-none" xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(50, -50) rotate(30)">
                @for ($i = 0; $i < 20; $i++)
                    <line x1="{{ $i * 20 }}" y1="0" x2="{{ $i * 20 }}" y2="800" stroke="#FFFFFF" stroke-width="0.5"/>
                @endfor
            </g>
        </svg>

        {{-- Noise Texture Overlay --}}
        <div class="absolute inset-0 bg-noise mix-blend-overlay pointer-events-none"></div>

        {{-- Dark Vignette for contrast --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/40 pointer-events-none"></div>

        {{-- Ubah Cover Button --}}
        <button type="button" onclick="alert('Fitur ubah cover banner kustom akan segera hadir!')" class="absolute top-6 right-6 md:top-8 md:right-8 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-xl text-white border border-white/20 text-xs font-semibold flex items-center gap-2 transition-all shadow-lg cursor-pointer group z-10">
            <span class="material-symbols-outlined text-[18px] group-hover:scale-110 transition-transform">photo_camera</span>
            <span class="tracking-wide uppercase text-[10px] letter-spacing-1">Ubah Cover</span>
        </button>
    </div>

    {{-- 2. FLOATING PROFILE CARD (Dramatic Shadow, Spacious) --}}
    <div class="relative -mt-20 md:-mt-28 mx-4 sm:mx-8 md:mx-12 bg-white dark:bg-ds-surface rounded-[32px] shadow-dramatic border border-outline-variant/30 dark:border-ds-border/60 p-8 sm:p-10 md:p-12 z-20 transition-all duration-300">
        
        {{-- Top Header Row: Floating Avatar + Action Buttons --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 -mt-20 md:-mt-28 pb-4">
            
            {{-- Circular Avatar (Overlap 50%, Huge, 6px Border) --}}
            <div class="relative group cursor-pointer shrink-0 self-center md:self-auto" onclick="document.getElementById('photo').click()" title="Klik untuk ubah foto profil">
                <div class="w-36 h-36 md:w-40 md:h-40 rounded-full border-[6px] border-white dark:border-ds-surface shadow-2xl bg-[#0F1B3D] text-white flex items-center justify-center relative overflow-hidden aspect-square z-30" style="border-radius: 9999px;">
                    <img id="image_preview" 
                         src="{{ ($employee && $employee->photo) ? asset('storage/' . $employee->photo) : '' }}" 
                         alt="Foto Profil" 
                         class="w-full h-full object-cover rounded-full {{ ($employee && $employee->photo) ? '' : 'hidden' }}"
                         style="border-radius: 9999px;">
                    
                    <div id="avatar_initials" class="text-5xl font-extrabold tracking-wider text-[#FAF8F3] {{ ($employee && $employee->photo) ? 'hidden' : 'flex items-center justify-center' }}">
                        {{ strtoupper(substr($employee->name ?? 'A', 0, 2)) }}
                    </div>

                    {{-- Hover Camera Overlay --}}
                    <div class="absolute inset-0 bg-[#0F1B3D]/70 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white backdrop-blur-sm" style="border-radius: 9999px;">
                        <span class="material-symbols-outlined text-[32px] mb-1">photo_camera</span>
                        <span class="text-xs font-bold uppercase tracking-widest">Ubah</span>
                    </div>
                </div>
            </div>

            {{-- Action Buttons (Aligned to the right, below banner visually) --}}
            <div class="flex items-center justify-center md:justify-end gap-3 shrink-0 pt-4 md:pt-0 pb-2">
                <button type="button" onclick="document.getElementById('photo').click()" class="px-6 py-2.5 rounded-full border border-[#D9A441] text-[#D9A441] hover:bg-[#D9A441] hover:text-[#0F1B3D] transition-all font-bold text-xs flex items-center gap-2 shadow-sm cursor-pointer active:scale-95 uppercase tracking-wide">
                    <span class="material-symbols-outlined text-[18px]">add_a_photo</span>
                    <span>Ubah Foto</span>
                </button>

                <button type="button" id="btn_delete_photo" onclick="removePhoto()" class="{{ ($employee && $employee->photo) ? '' : 'hidden' }} px-5 py-2.5 text-xs text-error/80 hover:bg-error/10 dark:hover:bg-error/20 rounded-full transition-colors font-bold flex items-center gap-1.5 cursor-pointer uppercase tracking-wide">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    <span>Hapus</span>
                </button>
            </div>

        </div>

        {{-- Baris 1: Nama Besar & Typography Tegas --}}
        <div class="pt-2 text-center md:text-left">
            <div class="flex flex-col md:flex-row md:items-center justify-center md:justify-start gap-4 mb-2">
                <h2 class="text-3xl md:text-4xl lg:text-[42px] font-black text-on-surface dark:text-white tracking-tight leading-none" id="display_name" style="letter-spacing: -0.02em;">
                    {{ $employee->name ?? 'Administrator' }}
                </h2>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] uppercase font-black tracking-widest bg-[#D9A441]/10 text-[#D9A441] border border-[#D9A441]/20 shadow-sm mt-1 md:mt-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#D9A441] animate-pulse"></span>
                    {{ auth()->user()->role === 'admin' ? 'Admin' : 'Pimpinan' }}
                </span>
            </div>
        </div>

        {{-- Baris 2: Info Meta dalam Grid Luas --}}
        <div class="flex flex-wrap justify-center md:justify-start gap-y-5 gap-x-12 mt-8 pt-6 border-t border-outline-variant/10 dark:border-white/5">
            {{-- Item 1: NIP --}}
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[20px] text-[#D9A441] mt-0.5 opacity-80">badge</span>
                <div class="text-left">
                    <p class="text-[10px] font-bold text-outline dark:text-ds-text-secondary uppercase tracking-widest mb-0.5">NIP</p>
                    <p class="text-sm font-semibold text-on-surface dark:text-white/90">{{ auth()->user()->nip }}</p>
                </div>
            </div>

            {{-- Item 2: Alamat Email --}}
            <div class="flex items-start gap-3 truncate max-w-full">
                <span class="material-symbols-outlined text-[20px] text-[#D9A441] mt-0.5 opacity-80">mail</span>
                <div class="text-left truncate">
                    <p class="text-[10px] font-bold text-outline dark:text-ds-text-secondary uppercase tracking-widest mb-0.5">Email Akses</p>
                    <p id="display_email" class="text-sm font-semibold text-on-surface dark:text-white/90 truncate">{{ $employee->email ?? auth()->user()->email }}</p>
                </div>
            </div>

            {{-- Item 3: Nomor Telepon --}}
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[20px] text-[#D9A441] mt-0.5 opacity-80">call</span>
                <div class="text-left">
                    <p class="text-[10px] font-bold text-outline dark:text-ds-text-secondary uppercase tracking-widest mb-0.5">Kontak</p>
                    <p id="display_number" class="text-sm font-semibold text-on-surface dark:text-white/90">{{ $employee->number ?? '-' }}</p>
                </div>
            </div>

            {{-- Item 4: Tanggal Bergabung --}}
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-[20px] text-[#D9A441] mt-0.5 opacity-80">calendar_month</span>
                <div class="text-left">
                    <p class="text-[10px] font-bold text-outline dark:text-ds-text-secondary uppercase tracking-widest mb-0.5">Bergabung</p>
                    <p class="text-sm font-semibold text-on-surface dark:text-white/90">{{ auth()->user()->created_at ? auth()->user()->created_at->translatedFormat('F Y') : 'Agustus 2024' }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- 3. FORM SECTIONS --}}
    <div class="space-y-10 mt-14">

        {{-- Card 1: Informasi Pribadi (Netral) --}}
        <div class="bg-white dark:bg-[#111827] rounded-3xl border border-outline-variant/30 dark:border-white/5 p-8 md:p-12 shadow-lg shadow-black/[0.03] dark:shadow-black/20">
            <div class="flex items-end gap-4 pb-6 mb-8 border-b border-outline-variant/20 dark:border-white/10">
                <span class="text-3xl font-light text-[#D9A441]/50 leading-none">01</span>
                <div>
                    <h3 class="text-xl md:text-2xl font-extrabold text-on-surface dark:text-white tracking-wide uppercase">Informasi Pribadi</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                {{-- Nama Lengkap --}}
                <div class="space-y-2 group">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant dark:text-gray-400 group-focus-within:text-[#D9A441] transition-colors">
                        Nama Lengkap <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <input name="name" id="input_name" type="text" value="{{ old('name', $employee->name ?? '') }}" 
                               class="w-full bg-transparent border-0 border-b border-outline-variant/60 dark:border-gray-700 focus:border-[#D9A441] dark:focus:border-[#D9A441] focus:ring-0 px-1 py-2 text-base text-on-surface dark:text-white transition-colors placeholder:text-gray-400/50 font-medium" 
                               placeholder="Masukkan nama lengkap" required oninput="document.getElementById('display_name').innerText = this.value || 'Administrator'"/>
                    </div>
                </div>

                {{-- Alamat Email --}}
                <div class="space-y-2 group">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant dark:text-gray-400 group-focus-within:text-[#D9A441] transition-colors">
                        Alamat Email Akses <span class="text-error">*</span>
                    </label>
                    <div class="relative">
                        <input name="email" id="input_email" type="email" value="{{ old('email', $employee->email ?? '') }}" 
                               class="w-full bg-transparent border-0 border-b border-outline-variant/60 dark:border-gray-700 focus:border-[#D9A441] dark:focus:border-[#D9A441] focus:ring-0 px-1 py-2 text-base text-on-surface dark:text-white transition-colors placeholder:text-gray-400/50 font-medium" 
                               placeholder="email@contoh.com" required oninput="document.getElementById('display_email').innerText = this.value || 'email@contoh.com'"/>
                    </div>
                </div>

                {{-- Nomor Telepon --}}
                <div class="space-y-2 group">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant dark:text-gray-400 group-focus-within:text-[#D9A441] transition-colors">
                        Nomor Kontak
                    </label>
                    <div class="relative">
                        <input name="number" id="input_number" type="text" value="{{ old('number', $employee->number ?? '') }}" 
                               class="w-full bg-transparent border-0 border-b border-outline-variant/60 dark:border-gray-700 focus:border-[#D9A441] dark:focus:border-[#D9A441] focus:ring-0 px-1 py-2 text-base text-on-surface dark:text-white transition-colors placeholder:text-gray-400/50 font-medium" 
                               placeholder="Contoh: 08123456789" oninput="document.getElementById('display_number').innerText = this.value || '-'"/>
                    </div>
                </div>

                {{-- NIP --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant dark:text-gray-500 flex items-center justify-between">
                        <span>Nomor Induk Pegawai <span class="text-error">*</span></span>
                    </label>
                    <div class="relative opacity-70">
                        <input type="text" value="{{ auth()->user()->nip }}" readonly 
                               class="w-full bg-transparent border-0 border-b border-dashed border-outline-variant/50 dark:border-gray-700 px-1 py-2 text-base text-on-surface-variant dark:text-gray-400 font-medium cursor-not-allowed select-all"/>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Keamanan & Akses (Border Kiri Amber) --}}
        <div class="bg-white dark:bg-[#111827] rounded-3xl border border-outline-variant/30 dark:border-white/5 border-l-[6px] border-l-[#D9A441] p-8 md:p-12 shadow-lg shadow-black/[0.03] dark:shadow-black/20">
            <div class="flex items-end gap-4 pb-6 mb-8 border-b border-outline-variant/20 dark:border-white/10">
                <span class="text-3xl font-light text-[#D9A441]/50 leading-none">02</span>
                <div>
                    <h3 class="text-xl md:text-2xl font-extrabold text-on-surface dark:text-white tracking-wide uppercase">Keamanan & Akses</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                {{-- Password --}}
                <div class="space-y-2 group">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant dark:text-gray-400 group-focus-within:text-[#D9A441] transition-colors">
                        Kata Sandi Baru
                    </label>
                    <div class="relative">
                        <input name="password" type="password" 
                               class="w-full bg-transparent border-0 border-b border-outline-variant/60 dark:border-gray-700 focus:border-[#D9A441] dark:focus:border-[#D9A441] focus:ring-0 px-1 py-2 text-base text-on-surface dark:text-white transition-colors placeholder:text-gray-400/50 font-medium" 
                               placeholder="Minimal 8 karakter"/>
                    </div>
                    <p class="text-[11px] text-outline dark:text-gray-500 mt-1 italic">Kosongkan jika tidak ingin mengubah kata sandi.</p>
                </div>

                {{-- Hak Akses Sistem --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant dark:text-gray-500 flex items-center justify-between">
                        <span>Hak Akses Sistem</span>
                        <span class="text-[9px] lowercase italic font-normal">(readonly)</span>
                    </label>
                    <div class="relative opacity-70">
                        <input type="text" value="{{ auth()->user()->role === 'admin' ? 'Admin (Administrator)' : 'CEO / Pimpinan' }}" readonly 
                               class="w-full bg-transparent border-0 border-b border-dashed border-outline-variant/50 dark:border-gray-700 px-1 py-2 text-base text-on-surface-variant dark:text-gray-400 font-medium cursor-not-allowed"/>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Actions Bar --}}
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : url('/ceo/dashboard') }}" 
               class="w-full sm:w-auto px-8 py-3.5 rounded-full border border-outline-variant dark:border-gray-700 text-on-surface-variant dark:text-gray-300 hover:bg-surface-container-low dark:hover:bg-white/5 transition-colors font-bold text-sm text-center uppercase tracking-wider">
                Batal
            </a>
            <button type="submit" 
                    class="w-full sm:w-auto px-10 py-3.5 rounded-full bg-[#D9A441] hover:bg-[#c69335] text-[#0F1B3D] font-black transition-all shadow-lg shadow-[#D9A441]/30 hover:shadow-xl hover:shadow-[#D9A441]/40 flex justify-center items-center gap-2.5 text-sm cursor-pointer active:scale-95 uppercase tracking-wider">
                <span>Simpan Perubahan</span>
            </button>
        </div>

    </div>
</form>

{{-- 4. ZONA BAHAYA (Deep Dark Red to Navy Gradient) --}}
<div class="rounded-3xl p-8 md:p-12 mt-16 shadow-2xl relative overflow-hidden bg-gradient-to-br from-[#450a0a] via-[#1a0505] to-[#070b14] border border-red-900/30">
    {{-- Subtle texture overlay for Danger Zone --}}
    <div class="absolute inset-0 bg-noise mix-blend-overlay opacity-50 pointer-events-none"></div>
    <div class="absolute right-0 top-0 w-64 h-64 bg-red-600/10 blur-3xl rounded-full pointer-events-none"></div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
        <div class="flex flex-col sm:flex-row items-start gap-6">
            <div class="w-16 h-16 rounded-2xl bg-red-500/10 text-red-500 border border-red-500/20 flex items-center justify-center shrink-0 shadow-inner">
                <span class="material-symbols-outlined icon-fill text-[36px]">warning</span>
            </div>
            <div>
                <h3 class="text-xl md:text-2xl font-black text-red-400 tracking-wide uppercase mb-2">Zona Berbahaya</h3>
                <p class="text-sm text-red-200/60 max-w-2xl leading-relaxed">
                    Tindakan menghapus akun bersifat permanen dan tidak dapat dibatalkan. Semua data riwayat tugas, dokumen, dan berkas terkait akan dihapus secara permanen dari basis data sistem.
                </p>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('deleteModal').classList.remove('hidden')" 
                class="w-full md:w-auto px-8 py-3.5 bg-red-600 hover:bg-red-700 text-white font-black rounded-full shadow-lg shadow-red-900/50 hover:shadow-xl transition-all flex items-center justify-center gap-2 text-sm shrink-0 uppercase tracking-widest cursor-pointer active:scale-95">
            <span>Hapus Akun</span>
        </button>
    </div>
</div>

{{-- Delete Account Modal --}}
<div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-md p-4 animate-fade-in">
    <div class="bg-white dark:bg-[#111827] rounded-3xl shadow-2xl max-w-md w-full overflow-hidden border border-outline-variant dark:border-gray-800">
        <div class="p-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-14 h-14 rounded-2xl bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[30px]">warning</span>
                </div>
                <div>
                    <h3 class="text-xl font-black text-on-surface dark:text-white uppercase tracking-wide">Konfirmasi Hapus</h3>
                    <p class="text-xs font-bold text-red-500 uppercase tracking-widest mt-1">Tindakan Permanen</p>
                </div>
            </div>
            
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <p class="text-sm text-on-surface-variant dark:text-gray-400 mb-8 leading-relaxed">
                    Seluruh data akun Anda akan dihapus dan tidak dapat dipulihkan. Masukkan kata sandi saat ini untuk memverifikasi otoritas Anda.
                </p>

                <div class="mb-8 relative group">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-on-surface-variant dark:text-gray-500 mb-2 group-focus-within:text-red-500 transition-colors">Kata Sandi Akses</label>
                    <div class="relative">
                        <input type="password" name="password" id="delete_password"
                            class="w-full bg-surface-container-lowest dark:bg-black/50 border-0 border-b-2 border-outline-variant dark:border-gray-700 focus:border-red-500 dark:focus:border-red-500 focus:ring-0 px-2 py-3 text-sm text-on-surface dark:text-white transition-shadow placeholder:text-gray-500"
                            placeholder="••••••••" required>
                    </div>
                    @if($errors->userDeletion->has('password'))
                        <p class="mt-2 text-xs text-red-500 font-bold">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')"
                        class="px-6 py-3 bg-surface-container-lowest dark:bg-transparent border border-outline-variant dark:border-gray-700 text-on-surface-variant dark:text-gray-300 rounded-full text-xs font-bold hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors uppercase tracking-widest cursor-pointer w-full sm:w-auto">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-3 bg-red-600 text-white rounded-full text-xs font-black hover:bg-red-700 transition-colors shadow-lg shadow-red-900/30 cursor-pointer uppercase tracking-widest w-full sm:w-auto">
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
            const file = input.files[0];
            
            // Check file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal adalah 2MB');
                input.value = '';
                return;
            }

            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image_preview');
                const initials = document.getElementById('avatar_initials');
                const btnDelete = document.getElementById('btn_delete_photo');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                
                if (initials) initials.classList.add('hidden');
                if (btnDelete) btnDelete.classList.remove('hidden');
                
                document.getElementById('delete_photo').value = '0';
            }
            reader.readAsDataURL(file);
        }
    }

    function removePhoto() {
        document.getElementById('delete_photo').value = '1';
        document.getElementById('photo').value = '';
        
        const preview = document.getElementById('image_preview');
        const initials = document.getElementById('avatar_initials');
        const btnDelete = document.getElementById('btn_delete_photo');
        
        preview.src = '';
        preview.classList.add('hidden');
        
        if (initials) initials.classList.remove('hidden');
        if (btnDelete) btnDelete.classList.add('hidden');
    }

    // Auto-show delete modal on validation error
    @if($errors->userDeletion->isNotEmpty())
        document.getElementById('deleteModal').classList.remove('hidden');
    @endif
</script>
@endsection
