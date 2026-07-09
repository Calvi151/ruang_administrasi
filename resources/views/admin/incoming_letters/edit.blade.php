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

<div class="bg-surface rounded-xl shadow-sm border border-outline-variant/50 overflow-hidden">
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

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
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
                    <label class="block font-label-md text-label-md text-on-surface mb-1">Ganti Lampiran (PDF)</label>
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
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-outline-variant border-dashed rounded-lg bg-surface-container-low hover:bg-surface-container transition-colors cursor-pointer group relative">
                        <div class="space-y-1 text-center">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant group-hover:text-primary transition-colors">cloud_upload</span>
                            <div class="flex text-body-sm text-on-surface-variant justify-center">
                                <label class="relative cursor-pointer font-label-md text-primary hover:underline" for="file">
                                    <span>Pilih berkas baru</span>
                                    <input type="file" name="file" id="file" accept=".pdf" class="sr-only">
                                </label>
                                <p class="pl-1">atau tarik dan lepas</p>
                            </div>
                            <p class="text-xs text-on-surface-variant">Biarkan kosong jika tidak ingin mengubah</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-1">
                <label for="subject" class="block font-label-md text-label-md text-on-surface mb-1">Perihal / Ringkasan <span class="text-error">*</span></label>
                <textarea name="subject" id="subject" rows="14"
                    class="block w-full flex-1 rounded-lg border-outline-variant bg-surface-container-lowest text-on-surface shadow-sm focus:border-primary focus:ring focus:ring-primary/20 py-2.5 px-3 font-body-sm text-body-sm resize-y"
                    required>{{ old('subject', $incomingLetter->subject) }}</textarea>
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
