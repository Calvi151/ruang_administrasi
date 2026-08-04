@extends('admin.layouts.app')

@section('title', 'Buat Surat Keluar - Ruang Administrasi')
@section('page-title', 'Buat Surat Keluar')

@section('content')
<div class="mb-6">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant dark:text-ds-text-primary dark:hover:text-ds-accent hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Surat Keluar
    </a>
</div>

<div class="bg-surface-container dark:bg-ds-surface rounded-xl shadow-sm border border-outline-variant/50 dark:border-ds-border/50 overflow-hidden">
    <div class="px-6 py-4 border-b border-outline-variant/30 dark:border-ds-border/30 bg-surface-container-lowest dark:bg-ds-surface">
        <h3 class="font-h3 text-h3 text-on-surface dark:text-ds-text-primary">Detail Surat Keluar Baru</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary mt-1">Buat draft surat keluar baru untuk diajukan</p>
    </div>

    <form action="{{ route('outgoing-letters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if ($errors->any())
        <div class="mx-6 mt-6 bg-error-container/30 dark:bg-error-container/10 text-error dark:text-[#ff7070] p-4 rounded-lg font-body-sm text-body-sm border border-error/20">
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
            <div>
                <label class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-2">Kategori Surat Keluar <span class="text-error">*</span></label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-lg">
                    <label class="border border-outline-variant dark:border-ds-border rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:border-primary bg-surface-container-lowest dark:bg-ds-surface">
                        <input type="radio" name="category" value="umum" {{ old('category', !empty($replyTo) ? 'balasan' : 'umum') === 'umum' ? 'checked' : '' }} class="text-primary focus:ring-primary" onchange="toggleReplySection()">
                        <div>
                            <span class="block font-bold text-xs text-on-surface dark:text-ds-text-primary">🏢 Surat Perusahaan (Umum)</span>
                            <span class="block text-[11px] text-on-surface-variant">Inisiatif baru dari kantor</span>
                        </div>
                    </label>
                    <label class="border border-outline-variant dark:border-ds-border rounded-xl p-3 flex items-center gap-3 cursor-pointer hover:border-primary bg-surface-container-lowest dark:bg-ds-surface">
                        <input type="radio" name="category" value="balasan" {{ old('category', !empty($replyTo) ? 'balasan' : 'umum') === 'balasan' ? 'checked' : '' }} class="text-primary focus:ring-primary" onchange="toggleReplySection()">
                        <div>
                            <span class="block font-bold text-xs text-on-surface dark:text-ds-text-primary">↩️ Surat Balasan</span>
                            <span class="block text-[11px] text-on-surface-variant">Jawaban atas surat lain</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Pilih Surat Masuk yang Dibalas (Muncul saat Kategori = Balasan) -->
            <div id="reply-select-container" class="p-5 rounded-2xl bg-[#0055CC]/5 dark:bg-[#1A2440]/80 border-2 border-dashed border-[#0055CC]/40 dark:border-amber-400/50 {{ old('category', !empty($replyTo) ? 'balasan' : 'umum') === 'balasan' ? '' : 'hidden' }} transition-all shadow-sm">
                <label for="incoming_letter_id" class="block font-extrabold text-sm text-[#0055CC] dark:text-amber-300 mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-amber-500">mark_email_read</span>
                    <span>Surat Masuk yang Dibalas (Referensi)</span>
                    <span class="text-red-500">*</span>
                </label>
                
                @if(!empty($replyTo))
                    <!-- TAMPILAN TERKUNCI (Jika masuk dari klik tombol balas di tabel) -->
                    <div class="bg-white dark:bg-[#0B1220] border border-emerald-500/50 rounded-xl p-4 shadow-sm flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                            <span class="material-symbols-outlined">verified_user</span>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-on-surface dark:text-ds-text-primary">Membalas Surat: {{ $replyTo->letter_number }}</p>
                            <p class="text-xs text-on-surface-variant dark:text-ds-text-secondary mt-1">Dari: <strong>{{ $replyTo->sender }}</strong></p>
                            <p class="text-xs text-on-surface-variant dark:text-ds-text-secondary line-clamp-1 mt-0.5">Perihal: {{ strip_tags($replyTo->subject) }}</p>
                            
                            <!-- Hidden input agar ID tetap terkirim saat disubmit -->
                            <input type="hidden" name="incoming_letter_id" id="incoming_letter_id" value="{{ $replyTo->id }}" data-sender="{{ $replyTo->sender }}" data-subject="{{ strip_tags($replyTo->subject) }}">
                        </div>
                    </div>
                    <p class="text-[11px] text-emerald-600 dark:text-emerald-400 mt-2.5 flex items-center gap-1.5 font-medium">
                        <span class="material-symbols-outlined text-[16px]">lock</span>
                        <span>Referensi surat telah dikunci agar tidak salah ubah. Tujuan dan Perihal otomatis terisi.</span>
                    </p>
                @else
                    <!-- TAMPILAN DROPDOWN (Jika buat surat balasan manual) -->
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-[20px]">search</span>
                        <select name="incoming_letter_id" id="incoming_letter_id" class="block w-full rounded-xl border border-outline-variant dark:border-ds-border bg-white dark:bg-[#0B1220] text-on-surface dark:text-white shadow-sm focus:border-[#0055CC] dark:focus:border-amber-400 focus:ring-2 focus:ring-[#0055CC]/20 dark:focus:ring-amber-400/20 py-3 pl-10 pr-10 text-xs font-semibold outline-none transition-all" onchange="autoFillFromIncoming(this)" {{ old('category') === 'balasan' ? 'required' : '' }}>
                            @if(isset($incomingLetters) && $incomingLetters->count() > 0)
                                <option value="">-- Cari & Pilih Nomor / Pengirim Surat Masuk yang Dibalas --</option>
                                @foreach($incomingLetters as $inLetter)
                                    <option value="{{ $inLetter->id }}" 
                                        data-sender="{{ $inLetter->sender }}" 
                                        data-subject="{{ strip_tags($inLetter->subject) }}" 
                                        {{ old('incoming_letter_id') == $inLetter->id ? 'selected' : '' }}>
                                        [#{{ $inLetter->letter_number }}] - Dari: {{ $inLetter->sender }} (Perihal: {{ Str::limit(strip_tags($inLetter->subject), 65) }})
                                    </option>
                                @endforeach
                            @else
                                <option value="">-- Semua Surat Masuk Sudah Dibalas (Tidak ada antrean balasan) --</option>
                            @endif
                        </select>
                    </div>
                    <p class="text-[11px] text-on-surface-variant dark:text-ds-text-secondary mt-2.5 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-emerald-500">auto_awesome</span>
                        <span><strong>Fitur Pintar:</strong> Memilih surat di atas akan <strong>otomatis mengisi field Tujuan (Penerima)</strong> dan <strong>Perihal</strong> di bawah tanpa perlu diketik ulang!</span>
                    </p>
                @endif
            </div>

            <h4 class="font-title-md text-title-md text-primary dark:text-ds-text-primary flex items-center gap-2 border-b border-outline-variant/30 dark:border-ds-border/30 pb-2">
                <span class="material-symbols-outlined">looks_one</span>
                Langkah 1: Informasi Dasar
            </h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tujuan -->
                <div>
                    <label for="recipient" class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Tujuan (Penerima) <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">business</span>
                        <input type="text" name="recipient" id="recipient"
                            class="block w-full rounded-lg border-outline-variant dark:border-ds-border bg-surface-container-lowest dark:bg-ds-surface text-on-surface dark:text-ds-text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                            placeholder="Nama instansi/perorangan tujuan" value="{{ old('recipient', !empty($replyTo) ? $replyTo->sender : '') }}" required>
                    </div>
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="date_sent" class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Tanggal Surat <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">calendar_today</span>
                        <input type="date" name="date_sent" id="date_sent"
                            class="block w-full rounded-lg border-outline-variant dark:border-ds-border bg-surface-container-lowest dark:bg-ds-surface text-on-surface dark:text-ds-text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                            value="{{ old('date_sent', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Jenis Surat -->
                <div>
                    <label for="letter_type_id" class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Jenis Surat <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">category</span>
                        <select name="letter_type_id" id="letter_type_id"
                            class="block w-full rounded-lg border-outline-variant dark:border-ds-border bg-surface-container-lowest dark:bg-ds-surface text-on-surface dark:text-ds-text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-10 font-body-sm text-body-sm appearance-none bg-none" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($letterTypes as $type)
                                <option value="{{ $type->id }}" data-code="{{ $type->letter_code }}" {{ old('letter_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->type_name }} ({{ $type->letter_code }})
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">expand_more</span>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-low dark:bg-ds-bg border border-outline-variant/50 dark:border-ds-border/50 p-4 rounded-lg font-body-sm text-body-sm text-on-surface-variant dark:text-ds-text-secondary flex gap-3">
                <span class="material-symbols-outlined text-primary text-[20px] shrink-0">info</span>
                <div>
                    <strong>Otomatisasi Sistem:</strong><br>
                    Format nomor surat: <code>No Urut/Kode Surat/Kode Perusahaan/Bulan/Tahun</code>.<br>
                    Nomor surat akan langsung digenerate secara otomatis di dalam editor berdasarkan urutan surat sebelumnya.
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-outline-variant/30">
                <a href="{{ route('outgoing-letters.index') }}" class="px-4 py-2 bg-surface-container-lowest dark:bg-ds-surface border border-outline-variant dark:border-ds-border text-on-surface-variant dark:text-ds-text-secondary rounded-lg font-label-md text-label-md hover:bg-surface dark:hover:bg-ds-hover transition-colors shadow-sm">
                    Batal
                </a>
                <button type="button" id="btn-next" class="px-4 py-2 bg-primary dark:bg-ds-bg text-on-primary dark:text-ds-text-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
                    Lanjut Isi Surat
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- STEP 2: Content (TinyMCE) -->
        <div id="step-2" class="p-6 space-y-6 hidden">
            <h4 class="font-title-md text-title-md text-primary dark:text-ds-text-primary flex items-center gap-2 border-b border-outline-variant/30 dark:border-ds-border/30 pb-2">
                <span class="material-symbols-outlined">looks_two</span>
                Langkah 2: Perihal dan Isi Surat
            </h4>

            <!-- Perihal -->
            <div>
                <label for="subject" class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Perihal <span class="text-error">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline dark:text-ds-text-secondary text-[20px] pointer-events-none">title</span>
                    <input type="text" name="subject" id="subject"
                        class="block w-full rounded-lg border-outline-variant dark:border-ds-border bg-surface-container-lowest dark:bg-ds-surface text-on-surface dark:text-ds-text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                        placeholder="Masukkan perihal surat" value="{{ old('subject', !empty($replyTo) ? 'Balasan: ' . strip_tags($replyTo->subject) : '') }}">
                </div>
            </div>

            <!-- Isi Surat (TinyMCE) -->
            <div class="tinymce-wrapper min-w-0 flex flex-col">
                <label for="content" class="block font-label-md text-label-md text-on-surface dark:text-ds-text-primary mb-1">Isi Surat / Keterangan <span class="text-error">*</span></label>
                <div class="flex-1 min-h-[400px]">
                    <textarea name="content" id="content" rows="15" class="tinymce-field
                        block w-full rounded-lg border-outline-variant dark:border-ds-border bg-surface-container-lowest dark:bg-ds-surface text-on-surface dark:text-ds-text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 px-3 font-body-sm text-body-sm resize-y"
                        placeholder="Ketik isi atau keterangan surat di sini...">{{ old('content') }}</textarea>
                </div>
            </div>

            <div class="flex justify-between gap-3 pt-4 border-t border-outline-variant/30">
                <button type="button" id="btn-back" class="px-4 py-2 bg-surface-container-lowest dark:bg-ds-surface border border-outline-variant dark:border-ds-border text-on-surface-variant dark:text-ds-text-secondary rounded-lg font-label-md text-label-md hover:bg-surface dark:hover:bg-ds-hover transition-colors shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Kembali
                </button>
                <button type="submit" class="px-4 py-2 bg-primary dark:bg-ds-bg text-on-primary dark:text-ds-text-primary rounded-lg font-label-md text-label-md hover:opacity-90 transition-colors shadow-sm flex items-center gap-2">
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
    // =====================================================================
    // AKAR MASALAH: TinyMCE di-init saat #step-2 masih `display:none`
    // (karena baru terlihat setelah user klik "Lanjut Isi Surat").
    // Saat elemen induk display:none, browser TIDAK BISA menghitung
    // offsetWidth (hasilnya 0), sehingga TinyMCE membangun iframe editor
    // dengan lebar yang salah/collapsed. Begitu #step-2 dimunculkan,
    // TinyMCE tidak otomatis menghitung ulang -> muncul sebagai editor
    // "melebar/menyusut" atau layoutnya tidak pas sampai ada trigger lain.
    //
    // FIX: setelah #step-2 ditampilkan, paksa TinyMCE reflow dengan
    // dispatch event 'resize' + set lebar container secara eksplisit.
    // =====================================================================
    let tinyMCEReady = false;

    tinymce.init({
        promotion: false,
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
        // FIX: kunci lebar editor ke 100% dari parent, jangan biarkan
        // TinyMCE menghitung sendiri dari viewport
        width: '100%',
        resize: false,
        setup: function(editor) {
            editor.on('change', function() { editor.save(); });
            editor.on('init', function() {
                tinyMCEReady = true;
                // Paksa container ikut lebar parent begitu editor siap
                editor.getContainer().style.width = '100%';
            });
        }
    });

    // Helper: paksa TinyMCE menghitung ulang layout setelah container
    // yang tadinya display:none dimunculkan.
    function refreshTinyMCELayout() {
        if (!tinyMCEReady) return;
        const editor = tinymce.get('content');
        if (!editor) return;

        // requestAnimationFrame memastikan browser sudah selesai
        // menerapkan class 'hidden' dihapus (layout sudah reflow)
        // sebelum kita memaksa TinyMCE membaca ulang dimensinya.
        requestAnimationFrame(function() {
            editor.getContainer().style.width = '100%';
            window.dispatchEvent(new Event('resize'));
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const letterTypeSelect = document.getElementById('letter_type_id');
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const btnNext = document.getElementById('btn-next');
        const btnBack = document.getElementById('btn-back');

        const letterTemplates = @json($letterTypes->pluck('template', 'id'));
        const nextLetterNumbers = @json($nextLetterNumbers);

        // Multi-step form logic
        if (btnNext && btnBack && step1 && step2) {
            btnNext.addEventListener('click', function() {
                const recipient = document.getElementById('recipient');
                const letterType = document.getElementById('letter_type_id');
                const dateSent = document.getElementById('date_sent');

                if (!recipient.value || !letterType.value || !dateSent.value) {
                    alert('Harap lengkapi Tujuan, Tanggal, dan Jenis Surat terlebih dahulu.');
                    return;
                }

                step1.classList.add('hidden');
                step2.classList.remove('hidden');

                // FIX UTAMA: paksa TinyMCE reflow setelah container terlihat
                refreshTinyMCELayout();
            });

            btnBack.addEventListener('click', function() {
                step2.classList.add('hidden');
                step1.classList.remove('hidden');
            });
        }

        // FIX tambahan: ResizeObserver sebagai jaring pengaman —
        // jika lebar #step-2 berubah karena alasan lain (sidebar toggle,
        // resize window, dsb), TinyMCE ikut menyesuaikan otomatis.
        if (step2 && 'ResizeObserver' in window) {
            const ro = new ResizeObserver(function() {
                if (!step2.classList.contains('hidden')) {
                    refreshTinyMCELayout();
                }
            });
            ro.observe(step2);
        }

        // Template insertion logic
        if (letterTypeSelect) {
            letterTypeSelect.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
                    const typeName = selectedOption.text.split(' (')[0].trim();
                    const typeCode = selectedOption.getAttribute('data-code');
                    const realLetterNumber = nextLetterNumbers[this.value] || '[Otomatis]';

                    const subjectInput = document.getElementById('subject');
                    if (subjectInput) {
                        subjectInput.value = typeName;
                    }

                    let customBody = letterTemplates[this.value] || '<p>[Isi surat]</p>';

                    const dateInputVal = document.getElementById('date_sent').value;
                    let formattedDate = '................';
                    if (dateInputVal) {
                        const d = new Date(dateInputVal);
                        if (!isNaN(d.getTime())) {
                            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            formattedDate = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
                        }
                    }

                    // =========================================================
                    // LOGIKA PEMBAGIAN 2 KELOMPOK LAYOUT SURAT
                    // =========================================================
                    const typeNameLower = typeName.toLowerCase();
                    // Deteksi apakah ini Surat Naskah Khusus (Group 2)
                    const isNaskahKhusus = ['keterangan', 'tugas', 'keputusan', 'sk', 'perintah', 'kuasa', 'rekomendasi', 'peringatan', 'perjanjian'].some(keyword => typeNameLower.includes(keyword));

                    let template = '';

                    if (isNaskahKhusus) {
                        // KELOMPOK 2: Surat Naskah Khusus (SK, Keterangan, Tugas, dll)
                        // Format: Judul Tengah (Underline), Nomor di bawahnya. Tanpa Perihal/Lampiran.
                        template = `
<div class="mceNonEditable" style="text-align: center; margin-bottom: 20px; font-family: 'Times New Roman', serif;">
    <h3 style="margin: 0; font-size: 14pt; text-transform: uppercase; text-decoration: underline;">${typeName}</h3>
    <p style="margin: 0; font-size: 12pt;">Nomor: ${realLetterNumber}</p>
</div>
<br>
${customBody}
<br>
                        `;
                    } else {
                        // KELOMPOK 1: Surat Biasa / Korespondensi (Undangan, Edaran, dll)
                        // Format: Tabel Nomor, Perihal, Lampiran di pojok kiri atas.
                        template = `
<table class="mceNonEditable" style="width: 100%; border-collapse: collapse; border: none; background-color: transparent;">
  <tbody>
    <tr>
      <td style="width: 12%; vertical-align: top;"><strong>Nomor</strong></td>
      <td style="width: 2%; vertical-align: top;">:</td>
      <td style="width: 46%; vertical-align: top;">${realLetterNumber}</td>
      <td style="width: 40%; vertical-align: top; text-align: right;"><span class="date-placeholder">${formattedDate}</span></td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><strong>Perihal</strong></td>
      <td style="vertical-align: top;">:</td>
      <td style="vertical-align: top;" colspan="2"><span class="subject-placeholder">${typeName}</span></td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><strong>Lampiran</strong></td>
      <td style="vertical-align: top;">:</td>
      <td style="vertical-align: top;" colspan="2">-</td>
    </tr>
  </tbody>
</table>
<br>
${customBody}
<br>
                        `;
                    }

                    if (tinymce.get('content')) {
                        tinymce.get('content').setContent(template);
                    } else {
                        const contentTextarea = document.getElementById('content');
                        if (contentTextarea) {
                            contentTextarea.value = template;
                        }
                    }

                    if (subjectInput) {
                        subjectInput.dispatchEvent(new Event('input'));
                    }
                }
            });

            const subjectInput = document.getElementById('subject');
            if (subjectInput) {
                subjectInput.addEventListener('input', function() {
                    if (tinymce.get('content')) {
                        let body = tinymce.get('content').getBody();
                        let placeholder = body.querySelector('.subject-placeholder');

                        if (placeholder) {
                            placeholder.textContent = this.value;
                        } else {
                            let html = tinymce.get('content').getContent();
                            let newHtml = html;
                            
                            // Cek apakah ada placeholder [PERIHAL...] di teks
                            if (newHtml.match(/\[PERIHAL.*?\]/i)) {
                                newHtml = newHtml.replace(/\[PERIHAL.*?\]/ig, '<span class="subject-placeholder">' + (this.value || '[PERIHAL]') + '</span>');
                            } else {
                                // Format lama
                                newHtml = newHtml.replace(/(<strong>Perihal:\s*<\/strong>\s*|<p>\s*Perihal:\s*)(.*?)(<\/p>|<br>)/ig, '$1' + this.value + '$3');
                            }

                            if(newHtml !== html) {
                                const bookmark = tinymce.get('content').selection.getBookmark(2, true);
                                tinymce.get('content').setContent(newHtml);
                                tinymce.get('content').selection.moveToBookmark(bookmark);
                            }
                        }
                    }
                });
            }

            const dateInput = document.getElementById('date_sent');
            if (dateInput) {
                dateInput.addEventListener('change', function() {
                    if (tinymce.get('content')) {
                        let body = tinymce.get('content').getBody();
                        let placeholder = body.querySelector('.date-placeholder');

                        if (placeholder) {
                            const d = new Date(this.value);
                            if (!isNaN(d.getTime())) {
                                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                placeholder.textContent = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
                            }
                        }
                    }
                });
            }

            const incSelect = document.getElementById('incoming_letter_id');
            if (incSelect && incSelect.value) {
                autoFillFromIncoming(incSelect);
            }
        }
    });

    function toggleReplySection() {
        const checkedVal = document.querySelector('input[name="category"]:checked')?.value;
        const container = document.getElementById('reply-select-container');
        const select = document.getElementById('incoming_letter_id');
        if (checkedVal === 'balasan') {
            container.classList.remove('hidden');
            if (select) {
                if (select.tagName === 'SELECT') select.required = true;
                select.disabled = false;
            }
        } else {
            container.classList.add('hidden');
            if (select) {
                if (select.tagName === 'SELECT') {
                    select.required = false;
                    select.value = "";
                }
                select.disabled = true;
            }
        }
    }

    function autoFillFromIncoming(selectElem) {
        let sender = '';
        let subject = '';
        
        if (selectElem.tagName === 'SELECT') {
            const selectedOpt = selectElem.options[selectElem.selectedIndex];
            if (selectedOpt && selectedOpt.value) {
                sender = selectedOpt.getAttribute('data-sender') || '';
                subject = selectedOpt.getAttribute('data-subject') || '';
            }
        } else if (selectElem.tagName === 'INPUT') {
            // Jika elemen adalah hidden input (Terkunci)
            sender = selectElem.getAttribute('data-sender') || '';
            subject = selectElem.getAttribute('data-subject') || '';
        }

        if (sender || subject) {
            const recipientInput = document.getElementById('recipient');
            const subjectInput = document.getElementById('subject');
            
            if (sender && recipientInput) {
                recipientInput.value = sender;
                recipientInput.style.transition = 'all 0.3s ease';
                recipientInput.style.backgroundColor = 'rgba(16, 185, 129, 0.15)';
                setTimeout(() => { recipientInput.style.backgroundColor = ''; }, 1500);
            }
            if (subject && subjectInput) {
                subjectInput.value = "Balasan: " + subject;
                subjectInput.style.transition = 'all 0.3s ease';
                subjectInput.style.backgroundColor = 'rgba(16, 185, 129, 0.15)';
                setTimeout(() => { 
                    subjectInput.style.backgroundColor = ''; 
                    subjectInput.dispatchEvent(new Event('input'));
                }, 1500);
            }
        }
    }
</script>
@endsection