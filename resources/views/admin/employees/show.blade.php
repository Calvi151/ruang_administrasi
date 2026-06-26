@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary border-0 mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
    <h1 class="h3 mb-0 text-gray-800" style="font-weight: 700;">Detail Karyawan</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-1">
        <h6 class="m-0 font-weight-bold text-primary">Detail Informasi Akun</h6>
    </div>
    <div class="card-body p-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-3 text-center mb-3 mb-md-0">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" alt="Foto {{ $employee->name }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 150px; height: 150px; border: 3px solid #e2e8f0;">
                @else
                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 150px; height: 150px; font-size: 3rem; font-weight: 600;">
                        {{ strtoupper(substr($employee->name, 0, 2)) }}
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <h3 class="mb-1" style="font-weight: 700;">{{ $employee->name }}</h3>
                <p class="text-muted mb-3"><code class="text-dark" style="font-size: 1rem; font-weight: 600;">NIP: {{ $employee->nip }}</code></p>
                
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-4 bg-light rounded" style="border-left: 4px solid #3b82f6;">
                            <small class="text-muted d-block uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Email Resmi</small>
                            <strong>{{ $employee->email }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-4 bg-light rounded" style="border-left: 4px solid #3b82f6;">
                            <small class="text-muted d-block uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Nomor Handphone</small>
                            <strong>{{ $employee->number ?? 'Tidak tersedia' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-4 bg-light rounded" style="border-left: 4px solid #f59e0b;">
                            <small class="text-muted d-block uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Hak Akses Sistem</small>
                            <span class="badge bg-dark px-2 py-1 rounded-pill mt-1">
                                {{ strtoupper($employee->user->role ?? 'N/A') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-4 bg-light rounded" style="border-left: 4px solid #10b981;">
                            <small class="text-muted d-block uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Tanggal Registrasi</small>
                            <strong>{{ $employee->created_at ? $employee->created_at->format('d M Y H:i') : '-' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-4">
            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary px-2 py-1" style="border-radius: 8px;">
                <i class="fa-solid fa-pen-to-square me-2"></i>Edit Data
            </a>
        </div>
    </div>
</div>
@endsection








