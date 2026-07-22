@extends('admin.layouts.app')

@section('title', 'Edit Surat Keluar - Ruang Administrasi')
@section('page-title', 'Edit Surat Keluar')

@section('content')
<div class="mb-6">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Surat Keluar
    </a>
</div>

<div class="bg-surface-container rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
    <!-- Letter Number Header -->
    <div class="px-6 py-4 border-b border-outline-variant/30 bg-surface-container-lowest flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-primary-container/10 rounded-lg text-primary">
                <span class="material-symbols-outlined icon-fill">outbox</span>
            </div>
            <div>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nomor Surat</p>
                <h3 class="font-h3 text-h3 text-on-surface">{{ $outgoingLetter->letter_number }}</h3>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-label-sm text-[11px] font-bold tracking-wider">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> MENUNGGU
        </span>
    </div>

    <form action="{{ route('outgoing-letters.update', $outgoingLetter->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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

        <!-- FIX: grid-cols-1 md:grid-cols-2 di sini membuat kolom kanan (tempat
             TinyMCE) baru punya lebar pasti SETELAH Tailwind CDN selesai compile
             class grid. Ditambah id="edit-grid" supaya bisa dikunci lebar
             minimumnya lewat CSS di bawah -->
        <div id="edit-grid" class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 min-w-0">
            <!-- Left Column -->
            <div class="space-y-5 min-w-0">
                <div>
                    <label for="recipient" class="block font-label-md text-label-md text-on-surface mb-1">Tujuan (Penerima) <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">business</span>
                        <input type="text" name="recipient" id="recipient"
                            class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                            value="{{ old('recipient', $outgoingLetter->recipient) }}" required>
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Ganti Lampiran</label>
                    @if($outgoingLetter->file_path)
                    <div class="mb-3 p-3 bg-primary-fixed/30 rounded-lg flex items-center justify-between border border-primary-fixed-dim/50">
                        <div class="flex items-center gap-2 text-primary font-label-md text-label-md">
                            <span class="material-symbols-outlined text-[18px]">attach_file</span>
                            File tersimpan
                        </div>
                        <a href="{{ asset('storage/' . $outgoingLetter->file_path) }}" target="_blank"
                            class="text-xs bg-primary text-on-primary px-3 py-1.5 rounded-lg hover:opacity-90 transition-colors">Lihat</a>
                    </div>
                    @endif
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-outline-variant border-dashed rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">cloud_upload</span>
                            <div class="flex text-body-sm text-on-surface-variant justify-center">
                                <label class="relative cursor-pointer font-label-md text-primary hover:underline" for="file_path">
                                    <span id="file_name_display">Pilih berkas baru</span>
                                    <input type="file" name="file_path" id="file_path" accept=".pdf,.jpg,.jpeg,.png" class="sr-only">
                                </label>
                                <p class="pl-1" id="file_drag_text">atau tarik dan lepas</p>
                            </div>
                            <p class="text-xs text-on-surface-variant" id="file_help_text">Biarkan kosong jika tidak ingin mengubah</p>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-low border border-outline-variant/50 p-4 rounded-lg font-body-sm text-body-sm text-on-surface-variant flex gap-3">
                    <span class="material-symbols-outlined text-primary text-[20px] shrink-0">info</span>
                    <div><strong>Info:</strong> Tanggal, Nomor, dan Jenis Surat sudah dikelola otomatis oleh sistem.</div>
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
                            value="{{ old('subject', $outgoingLetter->subject) }}" required>
                    </div>
                </div>

                <!-- FIX: dibungkus .tinymce-wrapper + class tinymce-field,
                     dikunci lebar lewat CSS global di layout.blade.php -->
                <div class="tinymce-wrapper min-w-0 flex flex-col">
                    <label for="content" class="block font-label-md text-label-md text-on-surface mb-1">Isi Surat <span class="text-error">*</span></label>
                    <div class="flex-1 min-h-[400px]">
                        <textarea name="content" id="content" rows="10" class="tinymce-field
                            block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 px-3 font-body-sm text-body-sm resize-y"
                            required>{{ old('content', $outgoingLetter->content) }}</textarea>
                    </div>
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
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    // FIX: di halaman ini TinyMCE ada di dalam grid 2 kolom yang lebarnya
    // baru pasti SETELAH Tailwind CDN compile class grid-cols-2.
    // width:'100%' + resize:false + reflow di event 'init' mencegah
    // TinyMCE "mengunci" lebar yang salah dari awal render.
    tinymce.init({
        selector: '#content',
        height: 600,
        menubar: 'file edit view insert format tools table help',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'noneditable'
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
        width: '100%',
        resize: false,
        setup: function(editor) {
            editor.on('change', function() { editor.save(); });
            editor.on('init', function() {
                editor.getContainer().style.width = '100%';
                // Jaga-jaga: paksa reflow sekali lagi setelah font & grid settle
                setTimeout(function() {
                    window.dispatchEvent(new Event('resize'));
                }, 200);
            });
        }
    });

    // Jaring pengaman tambahan: kalau lebar kolom grid berubah
    // (mis. sidebar toggle, resize window), TinyMCE ikut menyesuaikan.
    document.addEventListener('DOMContentLoaded', function() {
        const editGrid = document.getElementById('edit-grid');
        if (editGrid && 'ResizeObserver' in window) {
            const ro = new ResizeObserver(function() {
                const editor = tinymce.get('content');
                if (editor) {
                    editor.getContainer().style.width = '100%';
                }
            });
            ro.observe(editGrid);
        }
    });

    const fileInput = document.getElementById('file_path');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('file_name_display').textContent = fileName;
                const dragText = document.getElementById('file_drag_text');
                if(dragText) dragText.style.display = 'none';

                const icon = this.closest('.border-dashed').querySelector('.material-symbols-outlined');
                if (icon) {
                    icon.textContent = 'check_circle';
                    icon.classList.add('text-primary');
                }
            }
        });
    }
</script>
@endsection