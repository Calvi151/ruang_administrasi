@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('incoming-letters.index') }}" class="btn btn-sm btn-outline-secondary border-0 mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Arsip
    </a>
    <h1 class="h3 mb-0" style="font-weight: 700;">Detail Surat Masuk</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fa-solid fa-envelope-open me-2"></i>Informasi Lengkap Surat
        </h6>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-4">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Nomor Surat</small>
                    <code class="fs-5 text-dark fw-bold">{{ $incomingLetter->letter_number }}</code>
                </div>
                <div class="mb-4">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Pengirim / Instansi</small>
                    <p class="mb-0 fs-6 fw-medium">{{ $incomingLetter->sender }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Tanggal Diterima</small>
                    <span class="badge bg-primary px-3 py-2 rounded-pill" style="font-size: 0.9rem;">
                        <i class="fa-regular fa-calendar me-2"></i>
                        {{ \Carbon\Carbon::parse($incomingLetter->date_received)->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div class="mb-4">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Diarsipkan Pada</small>
                    <p class="mb-0 fs-6 text-muted">{{ $incomingLetter->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-4">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">Perihal</small>
                    <p class="mb-0 fs-6 p-3 bg-light rounded border-start border-4 border-primary">{{ $incomingLetter->subject }}</p>
                </div>
            </div>

            {{-- File Surat --}}
            <div class="col-12">
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">File Arsip Surat</small>
                @if($incomingLetter->file)
                    @php
                        $ext = pathinfo($incomingLetter->file, PATHINFO_EXTENSION);
                    @endphp
                    <div class="p-4 bg-light rounded border text-center">
                        @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                            {{-- Preview gambar langsung --}}
                            <img src="{{ asset('storage/' . $incomingLetter->file) }}"
                                 alt="File Surat"
                                 class="img-fluid rounded shadow-sm mb-3"
                                 style="max-height: 400px; object-fit: contain;">
                            <div>
                                <a href="{{ asset('storage/' . $incomingLetter->file) }}" target="_blank"
                                   class="btn btn-success">
                                    <i class="fa-solid fa-image me-2"></i>Buka Gambar Penuh
                                </a>
                            </div>
                        @else
                            {{-- Tombol untuk buka PDF --}}
                            <i class="fa-solid fa-file-pdf fa-4x text-danger mb-3 d-block"></i>
                            <p class="text-muted mb-3">File dalam format <strong>PDF</strong></p>
                            <a href="{{ asset('storage/' . $incomingLetter->file) }}" target="_blank"
                               class="btn btn-danger px-4">
                                <i class="fa-solid fa-file-arrow-down me-2"></i>Buka / Unduh File PDF
                            </a>
                        @endif
                    </div>
                @else
                    <div class="p-4 bg-light rounded border text-center text-muted">
                        <i class="fa-solid fa-file-circle-xmark fa-3x mb-2 d-block text-secondary"></i>
                        Tidak ada file arsip yang disimpan untuk surat ini.
                    </div>
                @endif
            </div>
        </div>

        <hr class="my-4 text-muted">

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('incoming-letters.edit', $incomingLetter->id) }}" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
                <i class="fa-solid fa-pen-to-square me-2"></i>Edit Data
            </a>
        </div>
    </div>
</div>
@endsection
