@extends('admin.layouts.app')

@section('title', 'Catat Surat Masuk - Ruang Administrasi')
@section('page-title', 'Catat Surat Masuk')
@section('page-subtitle', 'Masukkan detail surat masuk baru ke dalam sistem')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('incoming-letters.index') }}" class="inline-flex items-center gap-4 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
        Kembali ke Surat Masuk
    </a>
</div>

<!-- Form Card -->
<div class="bg-surface-container-lowest rounded-3xl border border-border-muted ambient-shadow p-6 md:p-8 w-full">
    <form action="{{ route('incoming-letters.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf

        @if ($errors->any())
        <div class="bg-error-container text-on-error-container p-4 rounded-3xl font-body-md text-body-md border border-error-container/50">
            <div class="flex items-center gap-4 mb-2 font-bold">
                <span class="material-symbols-outlined">error</span>
                Terdapat kesalahan pada input Anda:
            </div>
            <ul class="list-disc pl-8 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Left Column -->
            <div class="flex flex-col gap-4">
                <!-- Letter Number -->
                <div class="flex flex-col gap-4">
                    <label for="letter_number" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Nomor Surat <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">tag</span>
                        <input type="text" name="letter_number" id="letter_number" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" placeholder="Contoh: 001/SK/2023" value="{{ old('letter_number') }}" required>
                    </div>
                </div>

                <!-- Sender -->
                <div class="flex flex-col gap-4">
                    <label for="sender" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Pengirim <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">domain</span>
                        <input type="text" name="sender" id="sender" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" placeholder="Nama instansi/perorangan pengirim" value="{{ old('sender') }}" required>
                    </div>
                </div>

                <!-- Date Received -->
                <div class="flex flex-col gap-4">
                    <label for="date_received" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Tanggal Diterima <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">calendar_month</span>
                        <input type="date" name="date_received" id="date_received" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" value="{{ old('date_received', date('Y-m-d')) }}" required>
                    </div>
                </div>
                <!-- File Attachment -->
                <div class="flex flex-col gap-4">
                    <label for="file" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Lampiran File (PDF)</label>
                    <div class="border-2 border-dashed border-outline-variant bg-slate-50/50 hover:bg-slate-50 rounded-2xl p-10 flex flex-col items-center justify-center gap-3 transition-colors cursor-pointer group relative">
                        <span class="material-symbols-outlined text-[40px] text-outline group-hover:text-primary mb-2">upload_file</span>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Klik atau drag file PDF ke sini</p>
                        <p class="text-[10px] text-outline mt-1">Maks. 5MB</p>
                        <input type="file" name="file" id="file" accept=".pdf" class="w-full h-full absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-4">
                <!-- Subject -->
                <div class="flex flex-col gap-4 h-full">
                    <label for="subject" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Perihal / Ringkasan <span class="text-error">*</span></label>
                    <textarea name="subject" id="subject" rows="12" class="w-full h-full bg-slate-50 border-0 rounded-2xl p-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-y shadow-sm font-body-md text-body-md" placeholder="Tuliskan ringkasan isi surat secara singkat dan jelas..." required>{{ old('subject') }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-muted flex flex-col-reverse md:flex-row justify-end items-center gap-4">
            <a href="{{ route('incoming-letters.index') }}" class="w-full md:w-auto px-6 py-3 rounded-full font-label-md text-label-md text-slate-600 hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-full font-label-md text-label-md text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[14px]">save</span>
                Simpan Surat Masuk
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#subject',
        height: 300,
        menubar: false,
        plugins: 'lists link table',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | table',
        content_style: 'body { font-family: "Plus Jakarta Sans", sans-serif; font-size: 14px; }',
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
</script>
@endsection
