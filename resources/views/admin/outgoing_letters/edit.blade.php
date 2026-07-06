@extends('admin.layouts.app')

@section('title', 'Edit Surat Keluar - Ruang Administrasi')
@section('page-title', 'Edit Surat Keluar')
@section('page-subtitle', 'Perbarui detail data surat keluar yang diajukan')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-4 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
        Kembali ke Surat Keluar
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-3xl border border-muted p-6 md:p-8 w-full">
    
    <div class="mb-5 p-4 bg-surface-container border border-border-muted rounded-3xl flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-primary-fixed text-primary flex items-center justify-center">
                <span class="material-symbols-outlined">tag</span>
            </div>
            <div>
                <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Nomor Surat</p>
                <p class="font-headline-md text-headline-md font-bold text-on-background">{{ $outgoingLetter->letter_number }}</p>
            </div>
        </div>
        <div class="text-right">
            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full bg-status-peach text-tertiary-container font-label-sm text-label-sm border border-tertiary-fixed">
                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                Status: Pending
            </span>
        </div>
    </div>

    <form action="{{ route('outgoing-letters.update', $outgoingLetter->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

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
                <!-- Recipient -->
                <div class="flex flex-col gap-4">
                    <label for="recipient" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Tujuan (Penerima) <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">business</span>
                        <input type="text" name="recipient" id="recipient" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" value="{{ old('recipient', $outgoingLetter->recipient) }}" required>
                    </div>
                </div>

                <!-- File Attachment -->
                <div class="flex flex-col gap-4">
                    <label for="file_path" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Ganti Lampiran (PDF)</label>
                    @if($outgoingLetter->file_path)
                    <div class="mb-2 p-4 bg-primary-fixed/30 rounded-3xl flex items-center justify-between border border-primary-fixed-dim/50">
                        <div class="flex items-center gap-4 text-primary text-sm font-label-md text-label-md">
                            <span class="material-symbols-outlined">attach_file</span>
                            File tersimpan
                        </div>
                        <a href="{{ asset('storage/' . $outgoingLetter->file_path) }}" target="_blank" class="text-xs bg-primary text-on-primary px-4 py-1.5 rounded-full hover:bg-primary-container transition-colors">Lihat File</a>
                    </div>
                    @endif
                    <div class="border-2 border-dashed border-outline-variant bg-slate-50/50 hover:bg-slate-50 rounded-2xl p-10 flex flex-col items-center justify-center gap-3 transition-colors cursor-pointer group relative">
                        <span class="material-symbols-outlined text-[48px] text-outline group-hover:text-primary mb-1">upload_file</span>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Klik atau drag file PDF baru ke sini</p>
                        <input type="file" name="file_path" id="file_path" accept=".pdf,.jpg,.jpeg,.png" class="w-full h-full absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>

                <!-- Info -->
                <div class="bg-surface-container-high border border-border-muted p-4 rounded-3xl font-label-sm text-label-sm text-on-surface-variant flex gap-4">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <div>
                        <strong>Info:</strong><br>
                        Tanggal, Nomor, dan Jenis Surat sudah dikelola otomatis oleh sistem dan tidak dapat diubah.
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-4">
                <!-- Subject -->
                <div class="flex flex-col gap-4">
                    <label for="subject" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Perihal <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">title</span>
                        <input type="text" name="subject" id="subject" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" value="{{ old('subject', $outgoingLetter->subject) }}" required>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex flex-col gap-4 h-full">
                    <label for="content" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Isi Surat / Keterangan <span class="text-error">*</span></label>
                    <textarea name="content" id="content" rows="6" class="w-full h-full px-2 py-1 rounded-2xl bg-background border border-border-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md text-on-background placeholder:text-outline" required>{{ old('content', $outgoingLetter->content) }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-muted flex flex-col-reverse md:flex-row justify-end items-center gap-4">
            <a href="{{ route('outgoing-letters.index') }}" class="w-full md:w-auto px-6 py-3 rounded-full font-label-md text-label-md text-slate-600 hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-full font-label-md text-label-md text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[14px]">save</span>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('file_path').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            const container = this.closest('.border-dashed');
            const icon = container.querySelector('.material-symbols-outlined');
            const title = container.querySelector('p:first-of-type');
            
            if (icon) {
                icon.textContent = 'check_circle';
                icon.classList.remove('text-outline');
                icon.classList.add('text-primary');
            }
            
            if (title) {
                title.textContent = fileName;
                title.classList.add('text-primary', 'font-bold', 'truncate', 'w-full', 'px-4', 'text-center');
            }
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
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










