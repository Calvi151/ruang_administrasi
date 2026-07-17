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

        <!-- STEP 1: Basic Info -->
        <div id="step-1" class="p-6 space-y-6">
            <h4 class="font-title-md text-title-md text-primary flex items-center gap-2 border-b border-outline-variant/30 pb-2">
                <span class="material-symbols-outlined">looks_one</span>
                Langkah 1: Informasi Dasar
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tujuan -->
                <div>
                    <label for="recipient" class="block font-label-md text-label-md text-on-surface mb-1">Tujuan (Penerima) <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">business</span>
                        <input type="text" name="recipient" id="recipient"
                            class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                            placeholder="Nama instansi/perorangan tujuan" value="{{ old('recipient') }}" required>
                    </div>
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="date_sent" class="block font-label-md text-label-md text-on-surface mb-1">Tanggal Surat <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">calendar_today</span>
                        <input type="date" name="date_sent" id="date_sent"
                            class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                            value="{{ old('date_sent', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Jenis Surat -->
                <div>
                    <label for="letter_type_id" class="block font-label-md text-label-md text-on-surface mb-1">Jenis Surat <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">category</span>
                        <select name="letter_type_id" id="letter_type_id"
                            class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-10 font-body-sm text-body-sm appearance-none bg-none" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($letterTypes as $type)
                                <option value="{{ $type->id }}" data-code="{{ $type->letter_code }}" {{ old('letter_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->type_name }} ({{ $type->letter_code }})
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">expand_more</span>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-low border border-outline-variant/50 p-4 rounded-lg font-body-sm text-body-sm text-on-surface-variant flex gap-3">
                <span class="material-symbols-outlined text-primary text-[20px] shrink-0">info</span>
                <div>
                    <strong>Otomatisasi Sistem:</strong><br>
                    Nomor urut, kode surat, bulan, dan tahun akan diisi otomatis oleh sistem saat disimpan.
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/30">
                <a href="{{ route('outgoing-letters.index') }}" class="px-4 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface-variant rounded-lg font-label-md text-label-md hover:bg-surface transition-colors shadow-sm">
                    Batal
                </a>
                <button type="button" id="btn-next" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
                    Lanjut Isi Surat
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- STEP 2: Content (TinyMCE) -->
        <div id="step-2" class="p-6 space-y-6 hidden">
            <h4 class="font-title-md text-title-md text-primary flex items-center gap-2 border-b border-outline-variant/30 pb-2">
                <span class="material-symbols-outlined">looks_two</span>
                Langkah 2: Perihal dan Isi Surat
            </h4>

            <!-- Perihal -->
            <div>
                <label for="subject" class="block font-label-md text-label-md text-on-surface mb-1">Perihal <span class="text-error">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">title</span>
                    <input type="text" name="subject" id="subject"
                        class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                        placeholder="Masukkan perihal surat" value="{{ old('subject') }}">
                </div>
            </div>

            <!-- Isi Surat (TinyMCE) -->
            <div>
                <label for="content" class="block font-label-md text-label-md text-on-surface mb-1">Isi Surat / Keterangan <span class="text-error">*</span></label>
                <textarea name="content" id="content" rows="15"
                    class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 px-3 font-body-sm text-body-sm resize-y"
                    placeholder="Ketik isi atau keterangan surat di sini...">{{ old('content') }}</textarea>
            </div>

            <div class="flex justify-between gap-3 pt-4 border-t border-outline-variant/30">
                <button type="button" id="btn-back" class="px-4 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface-variant rounded-lg font-label-md text-label-md hover:bg-surface transition-colors shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </button>
                <button type="submit" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    Simpan & Ajukan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        height: 500,
        menubar: false,
        plugins: 'lists link table',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | table',
        content_style: 'body { font-family: "Inter", sans-serif; font-size: 14px; }',
        setup: function(editor) { 
            editor.on('change', function() { editor.save(); }); 
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const letterTypeSelect = document.getElementById('letter_type_id');
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const btnNext = document.getElementById('btn-next');
        const btnBack = document.getElementById('btn-back');
        
        const letterTemplates = @json($letterTypes->pluck('template', 'id'));
        
        // Multi-step form logic
        if (btnNext && btnBack && step1 && step2) {
            btnNext.addEventListener('click', function() {
                // Basic HTML5 validation check for Step 1
                const recipient = document.getElementById('recipient');
                const letterType = document.getElementById('letter_type_id');
                const dateSent = document.getElementById('date_sent');
                
                if (!recipient.value || !letterType.value || !dateSent.value) {
                    alert('Harap lengkapi Tujuan, Tanggal, dan Jenis Surat terlebih dahulu.');
                    return;
                }
                
                step1.classList.add('hidden');
                step2.classList.remove('hidden');
            });
            
            btnBack.addEventListener('click', function() {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
            });
        }
        
        // Template insertion logic
        if (letterTypeSelect) {
            letterTypeSelect.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const typeName = selectedOption.text.split(' (')[0].trim();
                    const typeCode = selectedOption.getAttribute('data-code');
                    
                    // Set default subject input
                    const subjectInput = document.getElementById('subject');
                    if (subjectInput) {
                        subjectInput.value = typeName;
                    }
                    
                    // Ambil isi template dari master Jenis Surat
                    let customBody = letterTemplates[this.value] || '<p>[Isi surat]</p>';
                    
                    // Gabungkan header standar, isi custom di tengah, dan footer standar
                    let template = `
<p><strong>Kode Surat:</strong> ${typeCode}</p>
<p><strong>Perihal:</strong> <span class="subject-placeholder">${typeName}</span></p>
<p><strong>Lampiran:</strong> - </p>
<br>
<p>Dengan hormat,</p>
<p>&nbsp;</p>
${customBody}
<p>&nbsp;</p>
<p>Demikian ${typeName} ini dibuat. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
                    `;
                    
                    if (tinymce.get('content')) {
                        // Selalu timpa (overwrite) isi editor dengan template yang sudah digabung
                        tinymce.get('content').setContent(template);
                    } else {
                        const contentTextarea = document.getElementById('content');
                        if (contentTextarea) {
                            contentTextarea.value = template;
                        }
                    }

                    // Trigger input event to sync with TinyMCE (if it's the default template or has Perihal)
                    if (subjectInput) {
                        subjectInput.dispatchEvent(new Event('input'));
                    }
                }
            });

            // Sync subject input with TinyMCE
            const subjectInput = document.getElementById('subject');
            if (subjectInput) {
                subjectInput.addEventListener('input', function() {
                    if (tinymce.get('content')) {
                        let body = tinymce.get('content').getBody();
                        let placeholder = body.querySelector('.subject-placeholder');
                        
                        if (placeholder) {
                            placeholder.textContent = this.value;
                        } else {
                            // Regex fallback to find Perihal: and replace text after it until the end of the tag
                            let html = tinymce.get('content').getContent();
                            let newHtml = html.replace(/(<strong>Perihal:\s*<\/strong>\s*|<p>\s*Perihal:\s*)(.*?)(<\/p>|<br>)/ig, '$1' + this.value + '$3');
                            
                            // To avoid unnecessary resets that ruin cursor position, only setContent if it actually changed
                            if(newHtml !== html) {
                                // Save cursor position
                                const bookmark = tinymce.get('content').selection.getBookmark(2, true);
                                tinymce.get('content').setContent(newHtml);
                                tinymce.get('content').selection.moveToBookmark(bookmark);
                            }
                        }
                    }
                });
            }
        }
    });
</script>
@endsection
