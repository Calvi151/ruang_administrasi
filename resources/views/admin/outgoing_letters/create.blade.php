@extends('admin.layouts.app')

@section('title', 'Buat Surat Keluar - Ruang Administrasi')
@section('page-title', 'Buat Surat Keluar')
@section('page-subtitle', 'Buat draft surat keluar baru untuk diajukan')

@section('content')
<!-- Back Button -->
<div class="mb-4">
    <a href="{{ route('outgoing-letters.index') }}" class="inline-flex items-center gap-4 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md">
        <span class="material-symbols-outlined text-[14px]">arrow_back</span>
        Kembali ke Surat Keluar
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-3xl border border-muted p-6 md:p-8 max-w-4xl mx-auto">
    <form action="{{ route('outgoing-letters.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
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
                <!-- Letter Type -->
                <div class="flex flex-col gap-4">
                    <label for="letter_type_id" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Jenis Surat <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">category</span>
                        <select name="letter_type_id" id="letter_type_id" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md appearance-none" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($letterTypes as $type)
                                <option value="{{ $type->id }}" {{ old('letter_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->letter_code }} - {{ $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                    </div>
                </div>

                <!-- Recipient -->
                <div class="flex flex-col gap-4">
                    <label for="recipient" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Tujuan (Penerima) <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">business</span>
                        <input type="text" name="recipient" id="recipient" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" placeholder="Nama instansi/perorangan tujuan" value="{{ old('recipient') }}" required>
                    </div>
                </div>

                <!-- Date Sent -->
                <div class="flex flex-col gap-4">
                    <label for="date_sent" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Tanggal Surat <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">calendar_month</span>
                        <input type="date" name="date_sent" id="date_sent" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" value="{{ old('date_sent', date('Y-m-d')) }}" required>
                    </div>
                </div>
                
                <!-- Format Info -->
                <div class="bg-surface-container-high border border-border-muted p-4 rounded-3xl font-label-sm text-label-sm text-on-surface-variant flex gap-4">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <div>
                        <strong>Format Penomoran Otomatis:</strong><br>
                        Nomor surat akan di-generate secara otomatis setelah disimpan dengan format:<br>
                        <code class="text-primary font-mono bg-primary-fixed/50 px-1 py-0.5 rounded mt-1 inline-block">[Nomor Urut]/[Kode Jenis Surat]/[Bulan Romawi]/[Tahun]</code>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-4">
                <!-- Subject -->
                <div class="flex flex-col gap-4">
                    <label for="subject" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Perihal <span class="text-error">*</span></label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-5 text-outline">title</span>
                        <input type="text" name="subject" id="subject" class="w-full bg-slate-50 border-0 rounded-xl py-3 pl-10 pr-4 text-sm text-heading-slate focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-body-md text-body-md" placeholder="Masukkan perihal surat" value="{{ old('subject') }}" required>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex flex-col gap-4 h-full">
                    <label for="content" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Isi Surat / Keterangan <span class="text-error">*</span></label>
                    <textarea name="content" id="content" rows="6" class="w-full h-full px-2 py-1 rounded-2xl bg-background border border-border-muted focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md text-on-background placeholder:text-outline" placeholder="Ketik isi atau keterangan surat di sini..." required>{{ old('content') }}</textarea>
                </div>
                
                <!-- File Attachment (Optional initially) -->
                <div class="flex flex-col gap-4">
                    <label for="file" class="font-label-md text-label-md text-slate-700 flex items-center gap-1">Lampiran File (Opsional)</label>
                    <div class="border-2 border-dashed border-outline-variant bg-slate-50/50 hover:bg-slate-50 rounded-2xl p-10 flex flex-col items-center justify-center gap-3 transition-colors cursor-pointer group relative">
                        <span class="material-symbols-outlined text-[48px] text-outline group-hover:text-primary mb-1">upload_file</span>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Klik atau drag file PDF ke sini</p>
                        <input type="file" name="file" id="file" accept=".pdf" class="w-full h-full absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-muted flex flex-col-reverse md:flex-row justify-end items-center gap-4">
            <a href="{{ route('outgoing-letters.index') }}" class="w-full md:w-auto px-6 py-3 rounded-full font-label-md text-label-md text-slate-600 hover:bg-slate-100 transition-colors">
                Batal
            </a>
            <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-full font-label-md text-label-md text-white bg-gradient-to-r from-primary to-primary-container shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[14px]">save</span>
                Simpan & Ajukan
            </button>
        </div>
    </form>
</div>
@endsection










