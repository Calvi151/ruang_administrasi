@extends('admin.layouts.app')

@section('title','Absensi')
@section('page-title','Absensi Karyawan')
@section('page-subtitle','Kelola data kehadiran karyawan')

@section('content')

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div style="font-size:11px;font-weight:700;color:#15803d;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:12px;">Hadir</div>
        <div class="stat-num" style="color:#15803d;">{{ $totalHadir }}</div>
        <div class="stat-lbl">Record bulan ini</div>
    </div>
    <div class="stat-card">
        <div style="font-size:11px;font-weight:700;color:#1d4ed8;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:12px;">Izin</div>
        <div class="stat-num" style="color:#1d4ed8;">{{ $totalIzin }}</div>
        <div class="stat-lbl">Record bulan ini</div>
    </div>
    <div class="stat-card">
        <div style="font-size:11px;font-weight:700;color:#b45309;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:12px;">Sakit</div>
        <div class="stat-num" style="color:#b45309;">{{ $totalSakit }}</div>
        <div class="stat-lbl">Record bulan ini</div>
    </div>
    <div class="stat-card">
        <div style="font-size:11px;font-weight:700;color:#b91c1c;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:12px;">Alpha</div>
        <div class="stat-num" style="color:#b91c1c;">{{ $totalAlpha }}</div>
        <div class="stat-lbl">Record bulan ini</div>
    </div>
</div>

{{-- Tambah Absensi --}}
<div class="card" style="margin-bottom:20px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div>
            <div style="font-size:15px;font-weight:800;color:var(--on-surface);">Tambah Data Absensi</div>
            <div style="font-size:12px;color:var(--on-surface-v);margin-top:2px;">Input kehadiran karyawan</div>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.attendance.store') }}">
        @csrf
        <div class="form-row">
            <div>
                <label class="form-label">Karyawan (NIP)</label>
                <select name="nip" class="form-select" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($employees as $emp)
                        <option value="{{ $emp->nip }}">{{ $emp->name }} ({{ $emp->nip }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Tanggal</label>
                <input type="date" name="date" class="form-input" value="{{ date('Y-m-d') }}" required>
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div>
                <label class="form-label">Jam Masuk</label>
                <input type="time" name="check_in" class="form-input">
            </div>
            <div>
                <label class="form-label">Jam Keluar</label>
                <input type="time" name="check_out" class="form-input">
            </div>
            <div>
                <label class="form-label">Keterangan</label>
                <input type="text" name="notes" class="form-input" placeholder="Opsional...">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Simpan Absensi
        </button>
    </form>
</div>

{{-- Tabel Data --}}
<div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div>
            <div style="font-size:15px;font-weight:800;color:var(--on-surface);">Riwayat Absensi</div>
            <div style="font-size:12px;color:var(--on-surface-v);margin-top:2px;">Total {{ $totalRecord }} record bulan {{ \Carbon\Carbon::parse($month.'-01')->locale('id')->isoFormat('MMMM Y') }}</div>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.attendance.index') }}" class="filter-row">
        <input type="month" name="month" class="form-input" value="{{ $month }}" style="height:40px;width:180px;">
        <input type="text" name="search" class="form-input" placeholder="Cari NIP / Nama..." value="{{ $search }}" style="height:40px;width:220px;">
        <button type="submit" class="btn btn-primary" style="height:40px;">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Filter
        </button>
        <a href="{{ route('admin.attendance.index') }}" class="btn" style="background:var(--surface-low);color:var(--on-surface-v);border:1.5px solid var(--outline-v);height:40px;">Reset</a>
    </form>

    <table class="data-table">
        <thead>
            <tr>
                <th>Karyawan</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $row)
            <tr>
                <td>
                    <div style="font-weight:600;">{{ $row->employee->name ?? '-' }}</div>
                    <div class="sub">{{ $row->nip }}</div>
                </td>
                <td>{{ \Carbon\Carbon::parse($row->date)->locale('id')->isoFormat('D MMM Y') }}</td>
                <td>{{ $row->check_in ?? '-' }}</td>
                <td>{{ $row->check_out ?? '-' }}</td>
                <td>
                    <span class="badge badge-{{ $row->status }}">
                        {{ ucfirst($row->status) }}
                    </span>
                </td>
                <td style="color:var(--on-surface-v);font-size:12px;">{{ $row->notes ?? '-' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.attendance.destroy', $row) }}" onsubmit="return confirm('Hapus data ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="height:34px;padding:0 14px;font-size:12px;">
                            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:var(--outline);font-size:13px;font-weight:500;">
                    Belum ada data absensi untuk periode ini
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">{{ $attendances->links() }}</div>
</div>

@endsection
