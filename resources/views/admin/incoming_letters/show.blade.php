@extends('admin.layouts.app')

@section('title','Detail Surat Masuk')
@section('page-title','Detail Surat Masuk')
@section('page-subtitle','{{ $incomingLetter->letter_number }}')

@section('styles')
<style>
    .back-link{display:inline-flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--on-surface-v);text-decoration:none;margin-bottom:20px;transition:color 0.2s}
    .back-link:hover{color:var(--primary)}
    .back-link svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px}
    .detail-item{}
    .detail-label{font-size:10px;font-weight:700;color:var(--outline);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px}
    .detail-value{font-size:14px;font-weight:600;color:var(--on-surface)}
    .detail-value.mono{font-family:monospace;background:var(--surface-low);display:inline-block;padding:4px 10px;border-radius:8px}
    .subject-box{background:var(--surface-low);border-left:3px solid var(--primary);border-radius:0 10px 10px 0;padding:14px 18px;font-size:14px;font-weight:500;color:var(--on-surface)}
    .file-box{border-radius:16px;border:1.5px solid var(--outline-v);padding:24px;text-align:center}
    .file-box-empty{background:var(--surface-low);color:var(--outline)}
    .file-box-has{background:#f0fdf4;border-color:#bbf7d0}
    .file-img{max-height:360px;border-radius:12px;object-fit:contain;margin-bottom:16px;box-shadow:0 4px 20px rgba(30,27,75,0.08)}
    .btn-file{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 20px;border-radius:9999px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none;transition:all 0.2s}
    .btn-file-pdf{background:#fef2f2;color:#dc2626;border:1.5px solid #fecaca}
    .btn-file-pdf:hover{background:#fee2e2}
    .btn-file-img{background:#f0fdf4;color:#15803d;border:1.5px solid #bbf7d0}
    .btn-file-img:hover{background:#dcfce7}
    .btn-file svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .divider{border:none;border-top:1px solid var(--outline-v);margin:24px 0}
    .form-actions{display:flex;justify-content:flex-end;gap:10px}
    .btn-cancel{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 20px;border:1.5px solid var(--outline-v);border-radius:9999px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;background:var(--white);color:var(--on-surface-v);transition:all 0.2s;text-decoration:none}
    .btn-cancel:hover{border-color:var(--outline);color:var(--on-surface)}
</style>
@endsection

@section('content')
<a href="{{ route('incoming-letters.index') }}" class="back-link">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Arsip
</a>

<div class="card">
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">Nomor Surat</div>
            <div class="detail-value mono">{{ $incomingLetter->letter_number }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Tanggal Diterima</div>
            <div class="detail-value">{{ \Carbon\Carbon::parse($incomingLetter->date_received)->translatedFormat('d F Y') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Pengirim / Instansi</div>
            <div class="detail-value">{{ $incomingLetter->sender }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Diarsipkan Pada</div>
            <div class="detail-value" style="font-weight:400;color:var(--on-surface-v)">{{ $incomingLetter->created_at->format('d M Y, H:i') }} WIB</div>
        </div>
    </div>

    <div style="margin-bottom:24px">
        <div class="detail-label" style="margin-bottom:8px">Perihal Surat</div>
        <div class="subject-box">{{ $incomingLetter->subject }}</div>
    </div>

    <div>
        <div class="detail-label" style="margin-bottom:10px">File Arsip Surat</div>
        @if($incomingLetter->file)
            @php $ext = strtolower(pathinfo($incomingLetter->file, PATHINFO_EXTENSION)); @endphp
            @if(in_array($ext, ['jpg','jpeg','png']))
                <div class="file-box file-box-has">
                    <img src="{{ asset('storage/' . $incomingLetter->file) }}" alt="File Surat" class="file-img">
                    <div>
                        <a href="{{ asset('storage/' . $incomingLetter->file) }}" target="_blank" class="btn-file btn-file-img">
                            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            Buka Gambar Penuh
                        </a>
                    </div>
                </div>
            @else
                <div class="file-box file-box-has">
                    <svg viewBox="0 0 24 24" style="width:48px;height:48px;stroke:#dc2626;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;margin-bottom:12px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    <p style="font-size:13px;color:var(--on-surface-v);margin-bottom:16px">File dalam format <strong>PDF</strong></p>
                    <a href="{{ asset('storage/' . $incomingLetter->file) }}" target="_blank" class="btn-file btn-file-pdf">
                        <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Buka / Unduh File PDF
                    </a>
                </div>
            @endif
        @else
            <div class="file-box file-box-empty">
                <svg viewBox="0 0 24 24" style="width:40px;height:40px;stroke:currentColor;fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round;opacity:0.4;display:block;margin:0 auto 10px"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                <p style="font-size:13px;font-weight:500">Tidak ada file arsip untuk surat ini.</p>
            </div>
        @endif
    </div>

    <hr class="divider">
    <div class="form-actions">
        <a href="{{ route('incoming-letters.index') }}" class="btn-cancel">Kembali</a>
        <a href="{{ route('incoming-letters.edit', $incomingLetter->id) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#fff;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Data Surat
        </a>
    </div>
</div>
@endsection
