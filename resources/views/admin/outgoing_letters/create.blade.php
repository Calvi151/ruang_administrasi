@extends('admin.layouts.app')

@section('title', 'Buat Surat Keluar - Ruang Administrasi')
@section('page-title', 'Buat Surat Keluar')

@section('content')
<div class="mb-6">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Surat Keluar
    </a>
</div>

<div class="bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
    <div class="px-6 py-4 border-b border-outline-variant/30 bg-surface-container-lowest">
        <h3 class="font-h3 text-h3 text-on-surface">Detail Surat Keluar Baru</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Buat draft surat keluar baru untuk diajukan</p>
    </div>

    <form action="{{ route('outgoing-letters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($errors->any())
        <div class="mx-6 mt-6 bg-error-container/30 text-error p-4 rounded-lg font-body-sm text-body-sm border border-error/20">
            <div class="flex items-center gap-2 mb-2 font-medium">
                <span class="material-symbols-outlined text-[18px]">error</span>
                Terdapat kesalahan pada input Anda:
            </div>
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-5">
                <div>
                    <label for="recipient" class="block font-label-md text-label-md text-on-surface mb-1">Tujuan (Penerima) <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">business</span>
                        <input type="text" name="recipient" id="recipient"
                            class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                            placeholder="Nama instansi/perorangan tujuan" value="{{ old('recipient') }}" required>
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Lampiran Dokumen (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-outline-variant border-dashed rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">cloud_upload</span>
                            <div class="flex text-body-sm text-on-surface-variant justify-center">
                                <label class="relative cursor-pointer font-label-md text-primary hover:underline" for="file_path">
                                    <span>Pilih berkas</span>
                                    <input type="file" name="file_path" id="file_path" accept=".pdf,.jpg,.jpeg,.png" class="sr-only">
                                </label>
                                <p class="pl-1">atau tarik dan lepas</p>
                            </div>
                            <p class="text-xs text-on-surface-variant">PDF, DOC, DOCX hingga 10MB</p>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-surface-container-low border border-outline-variant/50 p-4 rounded-lg font-body-sm text-body-sm text-on-surface-variant flex gap-3">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0">info</span>
                    <div>
                        <strong>Otomatisasi Sistem:</strong><br>
                        Jenis surat, nomor urut, kode surat, bulan, dan tahun akan diisi otomatis oleh sistem saat disimpan.
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-5">
                <div>
                    <label for="subject" class="block font-label-md text-label-md text-on-surface mb-1">Perihal <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">title</span>
                        <input type="text" name="subject" id="subject"
                            class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                            placeholder="Masukkan perihal surat" value="{{ old('subject') }}" required>
                    </div>
                </div>

                <div>
                    <label for="content" class="block font-label-md text-label-md text-on-surface mb-1">Isi Surat / Keterangan <span class="text-error">*</span></label>
                    <textarea name="content" id="content" rows="10"
                        class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 px-3 font-body-sm text-body-sm resize-y"
                        placeholder="Ketik isi atau keterangan surat di sini..." required>{{ old('content') }}</textarea>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-3">
            <a href="{{ route('outgoing-letters.index') }}"
                class="px-4 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface-variant rounded-lg font-label-md text-label-md hover:bg-surface transition-colors shadow-sm">
                Batal
            </a>
            <button type="submit"
                class="px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan & Ajukan
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
            const label = container.querySelector('label span');
            if (icon) { icon.textContent = 'check_circle'; icon.classList.add('text-primary'); }
            if (label) { label.textContent = fileName; }
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
        content_style: 'body { font-family: "Inter", sans-serif; font-size: 14px; }',
        setup: function(editor) { editor.on('change', function() { editor.save(); }); }
    });
</script>
@endsection
