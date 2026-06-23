@extends('layouts.admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0" style="font-weight: 700;">Arsip Surat Masuk</h1>
    <a href="{{ route('incoming-letters.create') }}" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-envelope-circle-check me-2"></i>Arsipkan Surat Baru
    </a>
</div>

{{-- Search Form --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body py-3">
        <form action="{{ route('incoming-letters.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor surat, pengirim, atau perihal..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fa-solid fa-magnifying-glass me-2"></i>Cari
            </button>
            @if(request('search'))
                <a href="{{ route('incoming-letters.index') }}" class="btn btn-outline-secondary px-4">Reset</a>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fa-solid fa-inbox me-2"></i>Daftar Surat Masuk
        </h6>
        <span class="badge bg-primary rounded-pill">{{ $letters->total() }} Surat</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 60px;">#</th>
                        <th>Nomor Surat</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Tanggal Terima</th>
                        <th class="text-center" style="width: 100px;">File</th>
                        <th class="text-end pe-4" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $index => $letter)
                    <tr>
                        <td class="ps-4 text-muted" style="font-size: 0.85rem;">{{ $letters->firstItem() + $index }}</td>
                        <td>
                            <code class="text-dark" style="font-weight: 600; font-size: 0.9rem;">{{ $letter->letter_number }}</code>
                        </td>
                        <td style="font-weight: 500;">{{ $letter->sender }}</td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $letter->subject }}">
                                {{ $letter->subject }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 0.85rem;">
                                <i class="fa-regular fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($letter->date_received)->format('d M Y') }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($letter->file)
                                <a href="{{ asset('storage/' . $letter->file) }}" target="_blank" class="btn btn-sm btn-outline-success border-0" title="Lihat File Surat">
                                    <i class="fa-solid fa-file-arrow-down fa-lg"></i>
                                </a>
                            @else
                                <span class="text-muted" title="Tidak ada file"><i class="fa-solid fa-file-circle-xmark fa-lg"></i></span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('incoming-letters.show', $letter->id) }}" class="btn btn-sm btn-outline-secondary border-0" title="Detail">
                                    <i class="fa-solid fa-eye text-info"></i>
                                </a>
                                <a href="{{ route('incoming-letters.edit', $letter->id) }}" class="btn btn-sm btn-outline-secondary border-0" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </a>
                                <form action="{{ route('incoming-letters.destroy', $letter->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus surat ini beserta filenya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary border-0" title="Hapus">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-inbox fa-2x mb-3 text-secondary d-block"></i>
                            Belum ada surat masuk yang diarsipkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($letters->hasPages())
    <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
        {{ $letters->links() }}
    </div>
    @endif
</div>
@endsection
