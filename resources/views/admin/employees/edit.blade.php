@extends('admin.layouts.app')

@section('title','Edit Karyawan')
@section('page-title','Edit Karyawan')
@section('page-subtitle','Ubah informasi karyawan: {{ $employee->name }}')

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
    .btn-cancel{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 20px;border:1.5px solid var(--outline-v);border-radius:9999px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;background:var(--white);color:var(--on-surface-v);transition:all 0.2s;text-decoration:none}
    .btn-cancel:hover{border-color:var(--outline);color:var(--on-surface)}
    .avatar-lg{width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--tertiary));display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:#fff;flex-shrink:0;overflow:hidden}
    .avatar-lg img{width:100%;height:100%;object-fit:cover}
    .field-disabled{width:100%;height:42px;padding:0 14px;border:1.5px solid var(--outline-v);border-radius:10px;background:var(--surface-cnt);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:var(--outline);display:flex;align-items:center}
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

<form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="form-grid">
            {{-- Kolom Kiri: Informasi Pribadi --}}
            <div>
                <div class="section-label">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Informasi Karyawan
                </div>

                <div class="field">
                    <label class="form-label" for="name">Nama Lengkap <span style="color:var(--error)">*</span></label>
                    <input type="text" class="form-input" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                    @error('name')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="form-label" for="email">Email <span style="color:var(--error)">*</span></label>
                    <input type="email" class="form-input" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                    @error('email')<div class="field-error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label class="form-label" for="number">Nomor Telepon</label>
                    <input type="text" class="form-input" id="number" name="number" value="{{ old('number', $employee->number) }}" placeholder="08xxxxxxxxxx">
                    @error('number')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Kolom Kanan: Foto & NIP --}}
            <div>
                <div class="section-label">
                    <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="12" cy="10" r="3"/><path d="M6 21v-1a6 6 0 0 1 12 0v1"/></svg>
                    Foto Profil & NIP
                </div>

                <div class="field">
                    <label class="form-label">NIP Pegawai</label>
                    <div class="field-disabled">{{ $employee->nip }}</div>
                    <div class="field-hint">NIP tidak dapat diubah (ID sistem utama).</div>
                </div>

                <div class="field">
                    <div style="display:flex;align-items:center;gap:16px;margin-bottom:10px">
                        <div class="avatar-lg">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->name }}">
                            @else
                                {{ strtoupper(substr($employee->name, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:14px">{{ $employee->name }}</div>
                            <div style="font-size:12px;color:var(--on-surface-v)">Foto profil saat ini</div>
                        </div>
                    </div>
                    <label class="form-label" for="photo">Unggah Foto Baru</label>
                    <input type="file" class="form-input" id="photo" name="photo" accept="image/*" style="padding:8px 14px;height:auto">
                    <div class="field-hint">Biarkan kosong jika tidak ingin mengubah foto (JPG, PNG, maks 2MB).</div>
                    @error('photo')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <hr class="divider">
        <div class="form-actions">
            <a href="{{ route('employees.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>
@endsection
