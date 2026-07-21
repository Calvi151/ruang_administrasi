@extends('admin.layouts.app')

@section('title', 'Edit Surat Masuk - Ruang Administrasi')
@section('page-title', 'Edit Surat Masuk')

@section('content')
<div class="mb-6">
    <a href="{{ route('incoming-letters.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
        Kembali ke Surat Masuk
    </a>
</div>

<div class="bg-surface-container rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
    <div class="px-6 py-4 border-b border-outline-variant/30 bg-surface-container-lowest">
        <h3 class="font-h3 text-h3 text-on-surface">Edit Surat Masuk</h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Perbarui detail data surat masuk</p>
    </div>

    <form action="{{ route('incoming-letters.update', $incomingLetter->id) }}" method="POST" enctype="multipart/form-data">
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

        <div class="p-6 space-y-6">
            <!-- File Attachment (Full Width, Big) -->
            <div>
                <label class="block font-label-md text-label-md text-on-surface mb-2">Ganti Lampiran File (PDF)</label>
                
                @if($incomingLetter->file_path)
                <div class="mb-3 p-3 bg-primary-fixed/30 rounded-lg flex items-center justify-between border border-primary-fixed-dim/50">
                    <div class="flex items-center gap-2 text-primary font-label-md text-label-md">
                        <span class="material-symbols-outlined text-[18px]">attach_file</span>
                        File tersimpan saat ini
                    </div>
                    <a href="{{ asset('storage/' . $incomingLetter->file_path) }}" target="_blank"
                        class="text-xs bg-primary text-on-primary px-3 py-1.5 rounded-lg hover:opacity-90 transition-colors">Lihat File</a>
                </div>
                @endif
                
                <label for="file" id="dropzone" class="flex flex-col items-center justify-center w-full h-64 border-2 border-outline-variant border-dashed rounded-xl bg-surface-container-low hover:bg-surface-container hover:border-primary/50 transition-all cursor-pointer group relative overflow-hidden">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6 space-y-3 pointer-events-none">
                        <span id="upload_icon" class="material-symbols-outlined text-6xl text-on-surface-variant group-hover:text-primary transition-colors">cloud_upload</span>
                        <div class="flex flex-col items-center text-body-lg text-on-surface-variant justify-center text-center">
                            <span class="font-label-lg text-primary font-semibold mb-1" id="file_name_display">Klik di sini atau tarik berkas untuk mengganti</span>
                            <p class="text-sm" id="file_drag_text">Biarkan kosong jika tidak ingin mengubah (PDF Maks 5MB)</p>
                        </div>
                    </div>
                    <input type="file" name="file" id="file" accept=".pdf" class="hidden">
                </label>
            </div>

            <hr class="border-outline-variant/30">

            <!-- Other Fields Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column for smaller inputs -->
                <div class="space-y-5">
                    <div>
                        <label for="letter_number" class="block font-label-md text-label-md text-on-surface mb-1">Nomor Surat <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">tag</span>
                            <input type="text" name="letter_number" id="letter_number"
                                class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                                value="{{ old('letter_number', $incomingLetter->letter_number) }}" required>
                        </div>
                    </div>

                    <div>
                        <label for="sender" class="block font-label-md text-label-md text-on-surface mb-1">Pengirim <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">domain</span>
                            <input type="text" name="sender" id="sender"
                                class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                                value="{{ old('sender', $incomingLetter->sender) }}" required>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-5">
                    <div>
                        <label for="date_received" class="block font-label-md text-label-md text-on-surface mb-1">Tanggal Diterima <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">calendar_month</span>
                            <input type="date" name="date_received" id="date_received"
                                class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                                value="{{ old('date_received', $incomingLetter->date_received) }}" required>
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block font-label-md text-label-md text-on-surface mb-1">Perihal / Ringkasan <span class="text-error">*</span></label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">subject</span>
                            <input type="text" name="subject" id="subject"
                                class="block w-full rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 pl-10 pr-3 font-body-sm text-body-sm"
                                value="{{ old('subject', $incomingLetter->subject) }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/30 flex justify-end gap-3">
            <a href="{{ route('incoming-letters.index') }}"
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropzone = document.getElementById('dropzone');
        const fileInput = document.getElementById('file');
        const fileNameDisplay = document.getElementById('file_name_display');
        const fileDragText = document.getElementById('file_drag_text');
        const uploadIcon = document.getElementById('upload_icon');

        const inputLetterNumber = document.getElementById('letter_number');
        const inputSender = document.getElementById('sender');
        const inputSubject = document.getElementById('subject');

        function updateFileInfo(file) {
            if (file) {
                fileNameDisplay.textContent = file.name;
                if (fileDragText) fileDragText.style.display = 'none';
                
                if (uploadIcon) {
                    uploadIcon.textContent = 'hourglass_empty';
                    uploadIcon.classList.add('text-primary', 'animate-spin');
                    uploadIcon.classList.remove('text-on-surface-variant');
                }
                if (dropzone) {
                    dropzone.classList.add('bg-primary-container/10', 'border-primary');
                    dropzone.classList.remove('bg-surface-container-low', 'border-outline-variant');
                }

                // Call OCR Endpoint
                extractOcrData(file);
            }
        }

        function extractOcrData(file) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('incoming-letters.ocr') }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                uploadIcon.classList.remove('animate-spin');
                if (data.error) {
                    uploadIcon.textContent = 'error';
                    uploadIcon.classList.replace('text-primary', 'text-error');
                    console.error(data.error);
                } else {
                    uploadIcon.textContent = 'check_circle';
                    
                    // Auto-fill fields
                    if (data.letter_number) {
                        inputLetterNumber.value = data.letter_number;
                    }
                    if (data.sender) {
                        inputSender.value = data.sender;
                    }
                    if (data.subject) {
                        inputSubject.value = data.subject;
                    }
                }
            })
            .catch(error => {
                uploadIcon.classList.remove('animate-spin');
                uploadIcon.textContent = 'error';
                uploadIcon.classList.replace('text-primary', 'text-error');
                console.error('Error extracting OCR:', error);
            });
        }

        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                updateFileInfo(e.target.files[0]);
            });
        }

        if (dropzone) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropzone.classList.add('bg-surface-container', 'border-primary', 'border-solid');
                dropzone.classList.remove('border-dashed');
            }

            function unhighlight(e) {
                dropzone.classList.remove('bg-surface-container', 'border-primary', 'border-solid');
                dropzone.classList.add('border-dashed');
            }

            dropzone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;
                
                if (files.length > 0) {
                    fileInput.files = files; // Assign files to the input
                    updateFileInfo(files[0]);
                }
            }
        }
    });
</script>
@endsection
