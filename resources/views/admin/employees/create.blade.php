@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary border-0 mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
    <h1 class="h3 mb-0 text-gray-800" style="font-weight: 700;">Tambah Karyawan Baru</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Informasi & Akun Karyawan</h6>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Kolom Kiri: Informasi Pribadi -->
                <div class="col-md-6 border-end pe-md-4">
                    <h5 class="mb-3 text-muted" style="font-size: 0.95rem; font-weight: 600; text-transform: uppercase;">
                        <i class="fa-solid fa-address-card me-2 text-primary"></i>Informasi Pribadi
                    </h5>

                    <div class="mb-3">
                        <label for="name" class="form-label" style="font-weight: 500;">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="font-weight: 500;">Email Karyawan <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@domain.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label" style="font-weight: 500;">Nomor Telepon</label>
                        <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ old('number') }}" placeholder="08xxxxxxxxxx">
                        @error('number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label" style="font-weight: 500;">Foto Profil</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                        <div class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG. Ukuran maks 2MB.</div>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan: Akses Sistem (User Auth) -->
                <div class="col-md-6 ps-md-4">
                    <h5 class="mb-3 text-muted" style="font-size: 0.95rem; font-weight: 600; text-transform: uppercase;">
                        <i class="fa-solid fa-lock me-2 text-primary"></i>Akses Login Karyawan
                    </h5>

                    <div class="mb-3">
                        <label for="nip" class="form-label" style="font-weight: 500;">NIP (Nomor Induk Pegawai) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP resmi" required>
                        <div class="form-text text-muted">Akan digunakan sebagai username saat masuk ke aplikasi.</div>
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label" style="font-weight: 500;">Peran Akses <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="" disabled selected>-- Pilih Peran --</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Staff Administrasi)</option>
                            <option value="ceo" {{ old('role') === 'ceo' ? 'selected' : '' }}>CEO (Kepala Sekolah/Pimpinan)</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label" style="font-weight: 500;">Kata Sandi (Password) <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted">

            <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-light px-4 py-2" style="border-radius: 8px;">Reset</button>
                <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Karyawan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
