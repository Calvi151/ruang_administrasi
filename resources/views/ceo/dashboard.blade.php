@extends('ceo.layouts.app')

@section('title','Dashboard')
@section('page-title','Dashboard CEO')
@section('page-subtitle','Selamat datang kembali, {{ auth()->user()->nip }}')

@section('styles')
<style>
    .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:28px}
    .stat-card{background:var(--white);border-radius:20px;padding:24px;position:relative;overflow:hidden;box-shadow:0 4px 20px var(--shadow);transition:transform 0.2s,box-shadow 0.2s}
    .stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 30px var(--shadow)}
    .stat-card-icon{width:48px;height:48px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:20px}
    .stat-card-icon svg{width:24px;height:24px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .stat-num{font-size:36px;font-weight:800;color:var(--on-surface);letter-spacing:-0.03em;line-height:1;margin-bottom:6px}
    .stat-label{font-size:13px;font-weight:600;color:var(--on-surface-v)}
    .stat-badge{position:absolute;top:20px;right:20px;font-size:11px;font-weight:700;letter-spacing:0.04em;padding:4px 10px;border-radius:9999px}
    .stat-badge.blue{background:var(--primary-light);color:var(--primary-dark)}
    .stat-badge.green{background:#dcfce7;color:#15803d}
    .stat-badge.amber{background:#fef3c7;color:#b45309}
    .content-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
    .view-all{font-size:12px;font-weight:700;color:var(--primary);text-decoration:none;padding:5px 12px;border-radius:9999px;background:var(--primary-light);transition:opacity 0.2s}
    .view-all:hover{opacity:0.8}
    .card-title{font-size:15px;font-weight:800;color:var(--on-surface)}
    .card-subtitle{font-size:12px;color:var(--on-surface-v);margin-top:2px}
    .empty-state{text-align:center;padding:40px 0;color:var(--outline);font-size:13px;font-weight:500}
</style>
@endsection

@section('content')

{{-- Stat Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-badge blue">TOTAL</span>
        <div class="stat-card-icon" style="background:linear-gradient(135deg,var(--primary),var(--tertiary))">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div class="stat-num">{{ $totalIncoming }}</div>
        <div class="stat-label">Surat Masuk</div>
    </div>
    <div class="stat-card">
        <span class="stat-badge blue">TOTAL</span>
        <div class="stat-card-icon" style="background:linear-gradient(135deg,#4648d4,#7c3aed)">
            <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </div>
        <div class="stat-num">{{ $totalOutgoing }}</div>
        <div class="stat-label">Surat Keluar</div>
    </div>
    <div class="stat-card">
        <span class="stat-badge amber">PENDING</span>
        <div class="stat-card-icon" style="background:linear-gradient(135deg,#b45309,#d97706)">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M9 15l2 2 4-4"/></svg>
        </div>
        <div class="stat-num">{{ $outgoingPending }}</div>
        <div class="stat-label">Perlu Approval</div>
    </div>
    <div class="stat-card">
        <span class="stat-badge green">AKTIF</span>
        <div class="stat-card-icon" style="background:linear-gradient(135deg,#15803d,#16a34a)">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="stat-num">{{ $totalEmployees }}</div>
        <div class="stat-label">Total Karyawan</div>
    </div>
</div>

{{-- Content Grid --}}
<div class="content-grid">
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
            <div>
                <div class="card-title">Surat Butuh Approval</div>
                <div class="card-subtitle">5 surat keluar terakhir</div>
            </div>
            <a href="{{ url('/ceo/letter-approvals') }}" class="view-all">Lihat Semua</a>
        </div>
        @if($recentOutgoing->count())
        <table class="data-table">
            <thead><tr><th>Nomor / Perihal</th><th>Status</th><th>Tanggal</th></tr></thead>
            <tbody>
                @foreach($recentOutgoing as $letter)
                <tr>
                    <td>
                        <div style="font-weight:600">{{ $letter->letter_number ?? '-' }}</div>
                        <div class="sub">{{ Str::limit($letter->subject ?? $letter->perihal ?? '-', 30) }}</div>
                    </td>
                    <td><span class="badge badge-{{ $letter->status }}">{{ $letter->status === 'acc' ? 'Disetujui' : ($letter->status === 'reject' ? 'Ditolak' : 'Pending') }}</span></td>
                    <td style="color:var(--on-surface-v);font-size:12px">{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">Tidak ada surat keluar</div>
        @endif
    </div>

    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
            <div>
                <div class="card-title">Surat Masuk Terbaru</div>
                <div class="card-subtitle">5 surat masuk terakhir</div>
            </div>
            <a href="{{ url('/ceo/incoming-letters') }}" class="view-all">Lihat Semua</a>
        </div>
        @if($recentIncoming->count())
        <table class="data-table">
            <thead><tr><th>Nomor / Pengirim</th><th>Perihal</th><th>Tanggal</th></tr></thead>
            <tbody>
                @foreach($recentIncoming as $letter)
                <tr>
                    <td>
                        <div style="font-weight:600">{{ $letter->letter_number ?? $letter->nomor_surat ?? '-' }}</div>
                        <div class="sub">{{ $letter->sender ?? $letter->pengirim ?? '-' }}</div>
                    </td>
                    <td style="font-size:12px">{{ Str::limit($letter->subject ?? $letter->perihal ?? '-', 28) }}</td>
                    <td style="color:var(--on-surface-v);font-size:12px">{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">Belum ada surat masuk</div>
        @endif
    </div>
</div>

@endsection

