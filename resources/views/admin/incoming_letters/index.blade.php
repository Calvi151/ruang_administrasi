@extends('admin.layouts.app')

@section('title','Surat Masuk')
@section('page-title','Surat Masuk')
@section('page-subtitle','Kelola arsip surat masuk')

@section('styles')
<style>
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
    .search-row{display:flex;align-items:center;gap:10px;margin-bottom:20px}
    .search-wrap{position:relative;flex:1;max-width:400px}
    .search-wrap svg{position:absolute;left:14px;top:50%;transform:translateY(-50%);width:15px;height:15px;stroke:var(--outline);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;pointer-events:none}
    .search-wrap input{padding-left:40px;height:40px}
    .btn-search{height:40px;padding:0 18px;font-size:13px}
    .btn-reset-filter{height:40px;padding:0 16px;font-size:13px;background:var(--surface-low);border:1.5px solid var(--outline-v);border-radius:9999px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--on-surface-v);cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset-filter:hover{background:var(--surface-cnt)}
    .count-chip{display:inline-flex;align-items:center;padding:4px 12px;background:var(--primary-light);color:var(--primary-dark);border-radius:9999px;font-size:12px;font-weight:700;margin-left:10px}
    .file-chip{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:8px;font-size:11px;font-weight:700}
    .file-chip-yes{background:#dcfce7;color:#15803d}
    .file-chip-no{background:var(--surface-cnt);color:var(--outline)}
    .file-chip svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
    .action-btn{width:32px;height:32px;border-radius:8px;border:none;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;transition:background 0.15s;text-decoration:none}
    .action-btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .btn-view{background:#ede9fe;color:#5b21b6}
    .btn-view:hover{background:#ddd6fe}
    .btn-edit{background:var(--primary-light);color:var(--primary-dark)}
    .btn-edit:hover{background:#c0d0f5}
    .btn-del{background:#fee2e2;color:var(--error)}
    .btn-del:hover{background:#fecaca}
    .empty-state{text-align:center;padding:60px 0;color:var(--outline)}
    .empty-state svg{width:48px;height:48px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;opacity:0.35;display:block;margin:0 auto 12px}
    .letter-number{font-family:monospace;font-size:12px;font-weight:700;background:var(--surface-low);padding:2px 8px;border-radius:6px;color:var(--on-surface)}
    .date-chip{display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:var(--on-surface-v)}
    .date-chip svg{width:13px;height:13px;stroke:var(--primary);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .subject-text{max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:13px;color:var(--on-surface)}
</style>
@endsection

@section('content')

<div class="page-header">
    <div style="display:flex;align-items:center">
        <h2 style="font-size:22px;font-weight:800;color:var(--on-surface);letter-spacing:-0.01em">Arsip Surat Masuk</h2>
        @if(isset($letters))
        <span class="count-chip">{{ $letters->total() }} Surat</span>
        @endif
    </div>
    <a href="{{ route('incoming-letters.create') }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#fff;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Arsipkan Surat Baru
    </a>
</div>

@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

{{-- Search --}}
<form action="{{ route('incoming-letters.index') }}" method="GET">
    <div class="search-row">
        <div class="search-wrap">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" class="form-input" name="search" placeholder="Cari nomor, pengirim, atau perihal..." value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn btn-primary btn-search">Cari</button>
        @if(request('search'))
        <a href="{{ route('incoming-letters.index') }}" class="btn-reset-filter">Reset</a>
        @endif
    </div>
</form>

<div class="card" style="padding:0">
    <div style="padding:20px 24px 0;display:flex;align-items:center;gap:8px">
        <svg viewBox="0 0 24 24" style="width:18px;height:18px;stroke:var(--primary);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        <span style="font-size:14px;font-weight:800;color:var(--on-surface)">Daftar Surat Masuk</span>
    </div>
    <div style="padding:16px 0 0">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="padding-left:24px;width:50px">#</th>
                    <th>Nomor Surat</th>
                    <th>Pengirim</th>
                    <th>Perihal</th>
                    <th>Tgl Diterima</th>
                    <th style="text-align:center">File</th>
                    <th style="text-align:right;padding-right:24px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($letters as $index => $letter)
                <tr>
                    <td style="padding-left:24px;font-size:12px;color:var(--outline)">{{ $letters->firstItem() + $index }}</td>
                    <td><span class="letter-number">{{ $letter->letter_number }}</span></td>
                    <td style="font-weight:600;font-size:13px">{{ $letter->sender }}</td>
                    <td><span class="subject-text" title="{{ $letter->subject }}">{{ $letter->subject }}</span></td>
                    <td>
                        <div class="date-chip">
                            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ \Carbon\Carbon::parse($letter->date_received)->format('d M Y') }}
                        </div>
                    </td>
                    <td style="text-align:center">
                        @if($letter->file)
                            <a href="{{ asset('storage/' . $letter->file) }}" target="_blank" class="file-chip file-chip-yes">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                Ada
                            </a>
                        @else
                            <span class="file-chip file-chip-no">
                                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Kosong
                            </span>
                        @endif
                    </td>
                    <td style="text-align:right;padding-right:24px">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px">
                            <a href="{{ route('incoming-letters.show', $letter->id) }}" class="action-btn btn-view" title="Lihat Detail">
                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ route('incoming-letters.edit', $letter->id) }}" class="action-btn btn-edit" title="Edit">
                                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('incoming-letters.destroy', $letter->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus surat ini beserta filenya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-del" title="Hapus">
                                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="border:none">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <p style="font-size:14px;font-weight:500">Belum ada surat masuk yang diarsipkan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($letters->hasPages())
    <div class="pagination-wrap" style="padding:16px 24px">
        {{ $letters->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
