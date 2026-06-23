@extends('admin.layouts.app')

@section('title','Karyawan')
@section('page-title','Data Karyawan')
@section('page-subtitle','Manajemen akun dan informasi karyawan')

@section('styles')
<style>
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
    .page-header h2{font-size:22px;font-weight:800;color:var(--on-surface);letter-spacing:-0.01em}
    .avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--tertiary));display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff;flex-shrink:0;overflow:hidden}
    .avatar img{width:100%;height:100%;object-fit:cover}
    .badge-ceo{background:#fef3c7;color:#b45309;display:inline-block;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700}
    .badge-admin{background:#dbeafe;color:#1d4ed8;display:inline-block;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700}
    .action-btn{width:32px;height:32px;border-radius:8px;border:none;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.15s}
    .action-btn svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .action-btn-edit{background:var(--primary-light);color:var(--primary-dark)}
    .action-btn-edit:hover{background:#c0d0f5}
    .action-btn-del{background:#fee2e2;color:var(--error)}
    .action-btn-del:hover{background:#fecaca}
    .empty-state{text-align:center;padding:60px 20px;color:var(--outline)}
    .empty-state svg{width:48px;height:48px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;margin-bottom:12px;opacity:0.4}
    .empty-state p{font-size:14px;font-weight:500}
</style>
@endsection

@section('content')
<div class="page-header">
    <h2>Daftar Karyawan</h2>
    <a href="{{ route('employees.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
        Tambah Karyawan
    </a>
</div>

@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th style="padding-left:0">Karyawan</th>
                <th>NIP</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Peran</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
            <tr>
                <td style="padding-left:0">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="avatar">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" alt="{{ $employee->name }}">
                            @else
                                {{ strtoupper(substr($employee->name, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:13px">{{ $employee->name }}</div>
                        </div>
                    </div>
                </td>
                <td><code style="font-size:12px;font-weight:700;background:var(--surface-low);padding:2px 8px;border-radius:6px">{{ $employee->nip }}</code></td>
                <td style="font-size:13px;color:var(--on-surface-v)">{{ $employee->email }}</td>
                <td style="font-size:13px;color:var(--on-surface-v)">{{ $employee->number ?? '-' }}</td>
                <td>
                    @if($employee->user && $employee->user->role === 'ceo')
                        <span class="badge-ceo">CEO</span>
                    @else
                        <span class="badge-admin">Admin</span>
                    @endif
                </td>
                <td style="text-align:right">
                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px">
                        <a href="{{ route('employees.edit', $employee->id) }}" class="action-btn action-btn-edit" title="Edit">
                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus karyawan ini beserta akun loginnya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn action-btn-del" title="Hapus">
                                <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="border:none">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                        <p>Belum ada data karyawan terdaftar.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
