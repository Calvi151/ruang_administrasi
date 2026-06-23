@extends('layouts.admin')

@slot('title', 'Daftar Karyawan')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800" style="font-weight: 700;">Data Master Karyawan</h1>
    <a href="{{ route('employees.create') }}" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-user-plus me-2"></i>Tambah Karyawan
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Akun & Informasi Karyawan</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">Foto</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Role</th>
                        <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td class="ps-4">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="Foto {{ $employee->name }}" class="rounded-circle object-fit-cover" style="width: 45px; height: 45px; border: 2px solid #e2e8f0;">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; font-weight: 600;">
                                    {{ strtoupper(substr($employee->name, 0, 2)) }}
                                </div>
                            @endif
                        </td>
                        <td><code class="text-dark" style="font-weight: 600;">{{ $employee->nip }}</code></td>
                        <td style="font-weight: 500;">{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->number ?? '-' }}</td>
                        <td>
                            @if($employee->user && $employee->user->role === 'ceo')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill" style="font-weight: 600;">CEO</span>
                            @else
                                <span class="badge bg-info text-dark px-3 py-2 rounded-pill" style="font-weight: 600;">Admin</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-secondary border-0">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini beserta akun loginnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary border-0">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-user-slash fa-2x mb-3 text-secondary"></i>
                            <p class="mb-0">Belum ada data karyawan terdaftar.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
