@extends('admin.layouts.app')

@section('title','Edit Surat Masuk')
@section('page-title','Edit Surat Masuk')
@section('page-subtitle','Ubah data surat: {{ $incomingLetter->letter_number }}')

@section('styles')
<style>
    .back-link{display:inline-flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--on-surface-v);text-decoration:none;margin-bottom:20px;transition:color 0.2s}
    .back-link:hover{color:var(--primary)}
    .back-link svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
    .form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
    .field{margin-bottom:0}
    .field-hint{font-size:11px;color:var(--outline);margin-top:5px}
    .field-error{font-size:11px;color:var(--error);margin-top:4px;font-weight:600}
    .field-warn{font-size:11px;color:#b45309;margin-top:5px;font-weight:600}
    .divider{border:none;border-top:1px solid var(--outline-v);margin:24px 0}
    .form-actions{display:flex;justify-content:flex-end;gap:10px}
    .btn-cancel{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 20px;border:1.5px solid var(--outline-v);border-radius:9999px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;background:var(--white);color:var(--on-surface-v);transition:all 0.2s;text-decoration:none}
    .btn-cancel:hover{border-color:var(--outline);color:var(--on-surface)}
    .current-file-box{display:flex;align-items:center;gap:12px;padding:12px 16px;background:var(--surface-low);border:1.5px solid var(--outline-v);border-radius:10px;margin-bottom:16px}
    .current-file-box svg{width:20px;height:20px;stroke:var(--primary);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
    .file-preview{display:flex;align-items:center;gap:10px;padding:12px 16px;background:var(--primary-light);border-radius:10px;margin-top:10px}
    .file-preview svg{width:18px;height:18px;stroke:var(--primary-dark);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
    .file-preview span{font-size:13px;font-weight:600;color:var(--primary-dark)}
    .view-link{font-size:12px;font-weight:700;color:var(--primary);text-decoration:none}
    .view-link:hover{text-decoration:underline}
</style>
@endsection

@section('content')
<a href="{{ route('incoming-letters.index') }}" class="back-link">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Arsip
</a>

@if($errors->any())
<div style="background:#fff5f5;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:var(--error);font-weight:500">
    <strong>Terjadi kesalahan:</strong>
    <ul style="margin:4px 0 0 20px;padding:0">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
    </ul>
</div>
@endif

<form action="{{ route('incoming-letters.update', $incomingLetter->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="form-grid-2">
            <div class="field">
                <label class="form-label" for="letter_number">Nomor Surat <span style="color:var(--error)">*</span></label>
                <input type="text" class="form-input" id="letter_number" name="letter_number"
                    value="{{ old('letter_number', $incomingLetter->letter_number) }}" required>
                @error('letter_number')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label class="form-label" for="date_received">Tanggal Diterima <span style="color:var(--error)">*</span></label>
                <input type="date" class="form-input" id="date_received" name="date_received"
                    value="{{ old('date_received', $incomingLetter->date_received) }}" required>
                @error('date_received')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label class="form-label" for="sender">Pengirim / Instansi <span style="color:var(--error)">*</span></label>
                <input type="text" class="form-input" id="sender" name="sender"
                    value="{{ old('sender', $incomingLetter->sender) }}" required>
                @error('sender')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label class="form-label" for="subject">Perihal Surat <span style="color:var(--error)">*</span></label>
                <input type="text" class="form-input" id="subject" name="subject"
                    value="{{ old('subject', $incomingLetter->subject) }}" required>
                @error('subject')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- File section --}}
        <div class="field" style="margin-bottom:0">
            <label class="form-label">File Surat Saat Ini</label>
            @if($incomingLetter->file)
                <div class="current-file-box">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <div style="flex:1;min-width:0">
                        <div style="font-size:13px;font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ basename($incomingLetter->file) }}</div>
                    </div>
                    <a href="{{ asset('storage/' . $incomingLetter->file) }}" target="_blank" class="view-link">Lihat File →</a>
                </div>
            @else
                <div style="padding:12px 16px;background:var(--surface-low);border-radius:10px;font-size:13px;color:var(--outline);margin-bottom:16px">
                    Tidak ada file tersimpan.
                </div>
            @endif

            <label class="form-label" for="file">Ganti File Surat <span style="font-weight:400;color:var(--outline)">(Opsional)</span></label>
            <input type="file" class="form-input" id="file" name="file"
                accept=".pdf,.jpg,.jpeg,.png" style="padding:8px 14px;height:auto">
            @if($incomingLetter->file)
            <div class="field-warn">⚠ Memilih file baru akan menghapus file lama secara permanen. Biarkan kosong jika tidak ingin mengubah.</div>
            @else
            <div class="field-hint">Format: PDF, JPG, JPEG, PNG. Ukuran maks 5MB.</div>
            @endif
            @error('file')<div class="field-error">{{ $message }}</div>@enderror
            <div class="file-preview" id="file-preview" style="display:none">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span id="file-preview-name"></span>
            </div>
        </div>

        <hr class="divider">
        <div class="form-actions">
            <a href="{{ route('incoming-letters.index') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:#fff;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan Perubahan
            </button>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.getElementById('file').addEventListener('change', function () {
        const preview = document.getElementById('file-preview');
        const name = document.getElementById('file-preview-name');
        if (this.files && this.files[0]) {
            name.textContent = this.files[0].name;
            preview.style.display = 'flex';
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endsection
