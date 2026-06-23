@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary border-0 mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
    <h1 class="h3 mb-0 text-gray-800" style="font-weight: 700;">Edit Karyawan: {{ $employee->name }}</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Perubahan Informasi Karyawan</h6>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Kolom Kiri: Informasi Pribadi -->
                <div class="col-md-6 border-end pe-md-4">
                    <h5 class="mb-3 text-muted" style="font-size: 0.95rem; font-weight: 600; text-transform: uppercase;">
                        <i class="fa-solid fa-user-pen me-2 text-primary"></i>Informasi Karyawan
                    </h5>

                    <div class="mb-3">
                        <label for="name" class="form-label" style="font-weight: 500;">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="font-weight: 500;">Email Karyawan <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="number" class="form-label" style="font-weight: 500;">Nomor Telepon</label>
                        <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ old('number', $employee->number) }}">
                        @error('number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom Kanan: Foto Profil Saat Ini & Ganti Foto -->
                <div class="col-md-6 ps-md-4">
                    <h5 class="mb-3 text-muted" style="font-size: 0.95rem; font-weight: 600; text-transform: uppercase;">
                        <i class="fa-solid fa-image me-2 text-primary"></i>Foto Profil & NIP
                    </h5>

                    <div class="mb-3">
                        <label class="form-label d-block" style="font-weight: 500;">NIP Pegawai</label>
                        <input type="text" class="form-control bg-light" value="{{ $employee->nip }}" disabled readonly>
                        <div class="form-text text-muted">NIP tidak dapat diubah karena merupakan ID sistem utama.</div>
                    </div>

                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Foto {{ $employee->name }}" class="rounded-circle object-fit-cover" style="width: 80px; height: 80px; border: 2px solid #e2e8f0;">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 1.5rem; font-weight: 600;">
                                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <label for="photo" class="form-label" style="font-weight: 500;">Unggah Foto Baru</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            <div class="form-text text-muted">Pilih jika ingin mengganti foto yang lama (JPG, JPEG, PNG, maks 2MB).</div>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('employees.index') }}" class="btn btn-light px-4 py-2" style="border-radius: 8px;">Batal</a>
                <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
