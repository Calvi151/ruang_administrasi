@extends('admin.layouts.app')

@section('title', 'Tambah Jenis Surat - Ruang Administrasi')
@section('page-title', 'Tambah Jenis Surat')

@section('content')
<div class="mb-6">
    <a href="{{ route('letter-types.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant dark:text-ds-text-primary dark:hover:text-ds-accent hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Jenis Surat
    </a>
</div>

<div class="bg-surface dark:bg-ds-surface rounded-xl shadow-sm border border-outline-variant/50 dark:border-ds-border/50 overflow-hidden">
    <div class="px-6 py-4 border-b border-outline-variant/30 dark:border-ds-border/30 bg-surface-container-lowest dark:bg-ds-surface">
        <h3 class="font-h3 text-h3 text-on-surface dark:text-ds-text-primary">Jenis Surat Baru</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-1">Tambahkan referensi jenis surat baru beserta templatenya</p>
    </div>

    <form action="{{ route('letter-types.store') }}" method="POST">
        @csrf

        @if ($errors->any())
        <div class="mx-6 mt-6 bg-error-container/30 dark:bg-error-container/10 text-error dark:text-[#ff7070] p-4 rounded-lg font-body-sm text-body-sm border border-error/20">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="letter_code" class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Kode Surat <span class="text-error">*</span></label>
                    <input type="text" name="letter_code" id="letter_code" class="block w-full rounded-lg border-outline-variant dark:border-ds-border bg-surface-container-lowest dark:bg-ds-surface text-on-surface dark:text-ds-text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 px-3 font-body-sm text-body-sm" placeholder="Contoh: SK, SP, SE" value="{{ old('letter_code') }}" required>
                </div>
                <div>
                    <label for="type_name" class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Nama Jenis Surat <span class="text-error">*</span></label>
                    <input type="text" name="type_name" id="type_name" class="block w-full rounded-lg border-outline-variant dark:border-ds-border bg-surface-container-lowest dark:bg-ds-surface text-on-surface dark:text-ds-text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 px-3 font-body-sm text-body-sm" placeholder="Contoh: Surat Keputusan" value="{{ old('type_name') }}" required>
                </div>
            </div>
            
            <div>
                <label for="template" class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Template Surat</label>
                <textarea name="template" id="template" rows="15" class="block w-full rounded-lg border-outline-variant dark:border-ds-border bg-surface-container-lowest dark:bg-ds-surface text-on-surface dark:text-ds-text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 px-3 font-body-sm text-body-sm resize-y" placeholder="Ketik isi/deskripsi khusus untuk jenis surat ini...">{{ old('template') }}</textarea>
                <p class="mt-2 font-body-sm text-xs text-on-surface-variant">Isi dengan isi/deskripsi khusus untuk jenis surat ini. (Header standar seperti Kode, Perihal, Lampiran, dan Footer standar akan otomatis ditambahkan oleh sistem saat surat keluar dibuat).</p>
            </div>
        </div>

        <div class="px-6 py-4 bg-surface-container-low dark:bg-ds-bg border-t border-outline-variant/30 dark:border-ds-border/30 flex justify-end gap-3">
            <a href="{{ route('letter-types.index') }}" class="px-4 py-2 bg-surface-container-lowest dark:bg-ds-surface border border-outline-variant dark:border-ds-border text-on-surface-variant dark:text-ds-text-secondary rounded-lg font-label-md text-label-md hover:bg-surface dark:hover:bg-ds-hover transition-colors shadow-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary dark:bg-ds-bg text-on-primary dark:text-ds-text-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        promotion: false,
        selector: '#template',
        height: 600,
        menubar: 'file edit view insert format tools table help',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | ' +
            'bold italic underline strikethrough | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'forecolor backcolor removeformat | table image link | ' +
            'fullscreen preview',
        font_size_formats: '8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt',
        font_family_formats: 'Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats; Inter=Inter,sans-serif',
        content_style: 'body { font-family: "Inter", "Times New Roman", sans-serif; font-size: 12pt; line-height: 1.5; padding: 20px; }',
        visual: false,
        toolbar_sticky: false,
        toolbar_mode: 'wrap',
        setup: function(editor) { 
            editor.on('change', function() { editor.save(); }); 
        }
    });
</script>
@endsection

