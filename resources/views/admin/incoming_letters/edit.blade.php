@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('incoming-letters.index') }}" class="btn btn-sm btn-outline-secondary border-0 mb-3">
        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Arsip
    </a>
    <h1 class="h3 mb-0" style="font-weight: 700;">Edit Surat Masuk</h1>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fa-solid fa-pen-to-square me-2"></i>Form Perubahan Data Surat
        </h6>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('incoming-letters.update', $incomingLetter->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="letter_number" class="form-label" style="font-weight: 500;">
                        Nomor Surat <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('letter_number') is-invalid @enderror"
                           id="letter_number" name="letter_number"
                           value="{{ old('letter_number', $incomingLetter->letter_number) }}"
                           required>
                    @error('letter_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="date_received" class="form-label" style="font-weight: 500;">
                        Tanggal Diterima <span class="text-danger">*</span>
                    </label>
                    <input type="date"
                           class="form-control @error('date_received') is-invalid @enderror"
                           id="date_received" name="date_received"
                           value="{{ old('date_received', $incomingLetter->date_received) }}"
                           required>
                    @error('date_received')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="sender" class="form-label" style="font-weight: 500;">
                        Nama Pengirim / Instansi <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('sender') is-invalid @enderror"
                           id="sender" name="sender"
                           value="{{ old('sender', $incomingLetter->sender) }}"
                           required>
                    @error('sender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="subject" class="form-label" style="font-weight: 500;">
                        Perihal Surat <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('subject') is-invalid @enderror"
                           id="subject" name="subject"
                           value="{{ old('subject', $incomingLetter->subject) }}"
                           required>
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- File Saat Ini --}}
                <div class="col-12">
                    <label class="form-label" style="font-weight: 500;">File Surat Saat Ini</label>
                    @if($incomingLetter->file)
                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border">
                            <i class="fa-solid fa-file-pdf fa-2x text-danger"></i>
                            <div>
                                <div style="font-weight: 500;">{{ basename($incomingLetter->file) }}</div>
                                <a href="{{ asset('storage/' . $incomingLetter->file) }}" target="_blank"
                                   class="btn btn-sm btn-outline-primary mt-1">
                                    <i class="fa-solid fa-eye me-1"></i>Lihat File Saat Ini
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="p-3 bg-light rounded border text-muted">
                            <i class="fa-solid fa-file-circle-xmark me-2"></i>Tidak ada file yang tersimpan.
                        </div>
                    @endif
                </div>

                {{-- Upload File Baru --}}
                <div class="col-12">
                    <label for="file" class="form-label" style="font-weight: 500;">
                        Ganti File Surat <span class="text-muted fw-normal">(Opsional)</span>
                    </label>
                    <input type="file"
                           class="form-control @error('file') is-invalid @enderror"
                           id="file" name="file"
                           accept=".pdf,.jpg,.jpeg,.png">
                    <div class="form-text text-muted mt-1">
                        <i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i>
                        Jika Anda memilih file baru, <strong>file lama akan terhapus secara permanen</strong>. Biarkan kosong jika tidak ingin mengubah file.
                    </div>
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-none" id="file-preview-container">
                    <div class="p-3 bg-light rounded border" style="border-style: dashed !important; border-color: #3b82f6 !important;">
                        <i class="fa-solid fa-paperclip me-2 text-primary"></i>
                        File baru yang akan di-upload: <strong id="file-preview-name"></strong>
                    </div>
                </div>
            </div>

            <hr class="my-4 text-muted">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('incoming-letters.index') }}" class="btn btn-light px-4 py-2" style="border-radius: 8px;">Batal</a>
                <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('file').addEventListener('change', function () {
        const preview = document.getElementById('file-preview-container');
        const name = document.getElementById('file-preview-name');
        if (this.files && this.files[0]) {
            name.textContent = this.files[0].name;
            preview.classList.remove('d-none');
        } else {
            preview.classList.add('d-none');
        }
    });
</script>
@endsection
