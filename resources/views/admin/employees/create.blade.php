@extends('admin.layouts.app')

@section('title','Tambah Karyawan')
@section('page-title','Tambah Karyawan Baru')
@section('page-subtitle','Isi informasi pribadi dan akses login karyawan')

@section('styles')
<style>
    .back-link{display:inline-flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--on-surface-v);text-decoration:none;margin-bottom:20px;transition:color 0.2s}
    .back-link:hover{color:var(--primary)}
    .back-link svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
    .section-label{font-size:11px;font-weight:700;color:var(--outline);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;display:flex;align-items:center;gap:8px}
    .section-label svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px}
    .field{margin-bottom:18px}
    .field-hint{font-size:11px;color:var(--outline);margin-top:4px}
    .field-error{font-size:11px;color:var(--error);margin-top:4px;font-weight:600}
    .divider{border:none;border-top:1px solid var(--outline-v);margin:24px 0}
    .form-actions{display:flex;justify-content:flex-end;gap:10px}
    .btn-reset{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 20px;border:1.5px solid var(--outline-v);border-radius:9999px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;background:var(--white);color:var(--on-surface-v);transition:all 0.2s;text-decoration:none}
    .btn-reset:hover{border-color:var(--outline);color:var(--on-surface)}
</style>
@endsection

@section('content')
<a href="{{ route('employees.index') }}" class="back-link">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Daftar Karyawan
</a>

@if($errors->any())
<div style="background:#fff5f5;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:var(--error);font-weight:500">
    <strong>Terjadi kesalahan:</strong>
    <ul style="margin:4px 0 0 20px;padding:0">
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="form-grid">
            {{-- Kolom Kiri: Informasi Pribadi --}}
            <div>
                <div class="section-label">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Informasi Pribadi
                </div>

                <div class="field">
                    <label class="form-label" for="name">Nama Lengkap <span style="color:var(--error)">*</span></label>
                    <input type="text" class="form-input" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="form-label" for="email">Email <span style="color:var(--error)">*</span></label>
                    <input type="email" class="form-input" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@domain.com" required>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="form-label" for="number">Nomor Telepon</label>
                    <input type="text" class="form-input" id="number" name="number" value="{{ old('number') }}" placeholder="08xxxxxxxxxx">
                    @error('number')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="form-label" for="photo">Foto Profil</label>
                    <input type="file" class="form-input" id="photo" name="photo" accept="image/*" style="padding:8px 14px;height:auto">
                    <div class="field-hint">Format: JPG, JPEG, PNG. Maks 2MB.</div>
                    @error('photo')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Kolom Kanan: Akses Login --}}
            <div>
                <div class="section-label">
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Akses Login Karyawan
                </div>

                <div class="field">
                    <label class="form-label" for="nip">NIP (Nomor Induk Pegawai) <span style="color:var(--error)">*</span></label>
                    <input type="text" class="form-input" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP resmi" required>
                    <div class="field-hint">Digunakan sebagai username saat login.</div>
                    @error('nip')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="form-label" for="role">Peran Akses <span style="color:var(--error)">*</span></label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" disabled selected>-- Pilih Peran --</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Staff Administrasi)</option>
                        <option value="ceo" {{ old('role') === 'ceo' ? 'selected' : '' }}>CEO (Kepala Sekolah / Pimpinan)</option>
                    </select>
                    @error('role')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="form-label" for="password">Password <span style="color:var(--error)">*</span></label>
                    <input type="password" class="form-input" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    @error('password')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <hr class="divider">
        <div class="form-actions">
            <a href="{{ route('employees.index') }}" class="btn-reset">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Karyawan
            </button>
        </div>
    </div>
</form>
@endsection
