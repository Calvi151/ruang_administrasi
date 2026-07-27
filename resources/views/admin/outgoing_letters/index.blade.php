@extends('admin.layouts.app')

@section('title', 'Surat Keluar (Mailroom) - Ruang Administrasi')
@section('page-title', 'Surat Keluar & Balasan')

@section('content')
<!-- Action & Search Bar -->
<div class="flex flex-col mb-6 gap-4">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <form action="{{ route('outgoing-letters.index') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
            @if(request('letter_type_id'))
                <input type="hidden" name="letter_type_id" value="{{ request('letter_type_id') }}">
            @endif
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1 md:w-80">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 rounded-lg bg-surface-container-lowest dark:bg-ds-bg border border-outline-variant dark:border-ds-border focus:border-primary dark:focus:border-ds-accent focus:ring-2 focus:ring-primary/20 dark:focus:ring-ds-accent/20 outline-none transition-all font-body-sm text-body-sm text-on-surface dark:text-ds-text-primary placeholder:text-outline dark:placeholder:text-ds-text-secondary" placeholder="Cari nomor surat, perihal, atau ref nomor..." type="text">
            </div>
            <button type="submit" class="px-4 py-2 rounded-lg bg-primary/10 text-primary dark:bg-ds-surface dark:text-ds-accent border border-primary/20 text-xs font-semibold hover:bg-primary hover:text-white transition-colors">Cari</button>
            @if(request()->hasAny(['search', 'category', 'status', 'letter_type_id']))
                <a href="{{ route('outgoing-letters.index') }}" class="text-xs text-on-surface-variant hover:underline whitespace-nowrap">Reset Filter</a>
            @endif
        </form>
        <a href="{{ route('outgoing-letters.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-primary/30 active:scale-95 shadow-sm dark:bg-primary dark:text-on-primary group shrink-0">
            <span class="material-symbols-outlined text-[18px] transition-transform duration-300 group-hover:rotate-90">add</span>
            Buat Surat Keluar
        </a>
    </div>

    <!-- Sub-filters: Status Chips -->
    <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-outline-variant/20">
        <span class="text-xs font-bold text-on-surface-variant dark:text-ds-text-secondary uppercase mr-2 flex items-center gap-1">
            <span class="material-symbols-outlined text-[15px]">filter_list</span> Status:
        </span>
        <a href="{{ route('outgoing-letters.index', array_merge(request()->except(['status', 'page']), ['status' => null])) }}" 
           class="px-3 py-1 rounded-full text-xs font-semibold transition-all {{ !request('status') ? 'bg-[#0055CC] text-white dark:bg-amber-400 dark:text-[#0B1220] shadow-sm' : 'bg-surface-container dark:bg-ds-surface text-on-surface-variant dark:text-ds-text-secondary hover:bg-surface-container-high' }}">
            Semua Status
        </a>
        <a href="{{ route('outgoing-letters.index', array_merge(request()->except(['status', 'page']), ['status' => 'pending'])) }}" 
           class="px-3 py-1 rounded-full text-xs font-semibold transition-all {{ request('status') == 'pending' ? 'bg-amber-500 text-white dark:bg-amber-500 dark:text-[#0B1220] shadow-sm' : 'bg-surface-container dark:bg-ds-surface text-on-surface-variant hover:bg-surface-container-high' }}">
            🟡 Menunggu ACC
        </a>
        <a href="{{ route('outgoing-letters.index', array_merge(request()->except(['status', 'page']), ['status' => 'acc'])) }}" 
           class="px-3 py-1 rounded-full text-xs font-semibold transition-all {{ request('status') == 'acc' ? 'bg-emerald-600 text-white dark:bg-emerald-500 dark:text-[#0B1220] shadow-sm' : 'bg-surface-container dark:bg-ds-surface text-on-surface-variant hover:bg-surface-container-high' }}">
            🟢 Disetujui (Siap Kirim)
        </a>
        <a href="{{ route('outgoing-letters.index', array_merge(request()->except(['status', 'page']), ['status' => 'delivered'])) }}" 
           class="px-3 py-1 rounded-full text-xs font-semibold transition-all {{ request('status') == 'delivered' ? 'bg-blue-600 text-white dark:bg-blue-500 dark:text-white shadow-sm' : 'bg-surface-container dark:bg-ds-surface text-on-surface-variant hover:bg-surface-container-high' }}">
            🚚 Terkirim (Delivered)
        </a>
        <a href="{{ route('outgoing-letters.index', array_merge(request()->except(['status', 'page']), ['status' => 'reject'])) }}" 
           class="px-3 py-1 rounded-full text-xs font-semibold transition-all {{ request('status') == 'reject' ? 'bg-red-600 text-white dark:bg-red-500 dark:text-white shadow-sm' : 'bg-surface-container dark:bg-ds-surface text-on-surface-variant hover:bg-surface-container-high' }}">
            🔴 Ditolak
        </a>
    </div>
</div>

<!-- Gmail-Style Inbox Table Card -->
<div class="bg-surface-container-lowest dark:bg-ds-surface rounded-xl shadow-sm border border-outline-variant/50 dark:border-ds-border overflow-hidden">
    <!-- Gmail Category Tabs -->
    <div class="flex border-b border-outline-variant/40 dark:border-ds-border bg-surface-container-low/60 dark:bg-[#111A2E] overflow-x-auto">
        <a href="{{ route('outgoing-letters.index', array_merge(request()->except(['category', 'page']), ['category' => null])) }}"
           class="flex items-center gap-2.5 px-6 py-3.5 border-b-2 font-bold text-xs md:text-sm whitespace-nowrap transition-all {{ !request('category') ? 'border-[#0055CC] text-[#0055CC] dark:border-amber-400 dark:text-amber-300 bg-white dark:bg-ds-surface shadow-sm' : 'border-transparent text-on-surface-variant dark:text-ds-text-secondary hover:text-on-surface hover:bg-black/5 dark:hover:bg-white/5' }}">
            <span class="material-symbols-outlined text-[18px]">inbox</span>
            <span>Semua Surat</span>
            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-black/10 dark:bg-white/10 text-on-surface dark:text-ds-text-primary">{{ $totalAll ?? 0 }}</span>
        </a>
        <a href="{{ route('outgoing-letters.index', array_merge(request()->except(['category', 'page']), ['category' => 'umum'])) }}"
           class="flex items-center gap-2.5 px-6 py-3.5 border-b-2 font-bold text-xs md:text-sm whitespace-nowrap transition-all {{ request('category') == 'umum' ? 'border-[#0055CC] text-[#0055CC] dark:border-amber-400 dark:text-amber-300 bg-white dark:bg-ds-surface shadow-sm' : 'border-transparent text-on-surface-variant dark:text-ds-text-secondary hover:text-on-surface hover:bg-black/5 dark:hover:bg-white/5' }}">
            <span class="material-symbols-outlined text-[18px] text-brand-blue">domain</span>
            <span>Surat Perusahaan (Umum)</span>
            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-blue-500/10 text-blue-600 dark:text-blue-400">{{ $countUmum ?? 0 }}</span>
        </a>
        <a href="{{ route('outgoing-letters.index', array_merge(request()->except(['category', 'page']), ['category' => 'balasan'])) }}"
           class="flex items-center gap-2.5 px-6 py-3.5 border-b-2 font-bold text-xs md:text-sm whitespace-nowrap transition-all {{ request('category') == 'balasan' ? 'border-[#0055CC] text-[#0055CC] dark:border-amber-400 dark:text-amber-300 bg-white dark:bg-ds-surface shadow-sm' : 'border-transparent text-on-surface-variant dark:text-ds-text-secondary hover:text-on-surface hover:bg-black/5 dark:hover:bg-white/5' }}">
            <span class="material-symbols-outlined text-[18px] text-amber-500">reply</span>
            <span>Surat Balasan (Reply)</span>
            <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-500/10 text-amber-600 dark:text-amber-400">{{ $countBalasan ?? 0 }}</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[950px]">
            <thead>
                <tr class="bg-surface-container dark:bg-ds-bg border-b border-outline-variant/30 dark:border-ds-border font-label-sm text-label-sm text-on-surface-variant dark:text-ds-text-secondary">
                    <th class="px-6 py-3.5 font-medium">Jenis & Nomor Surat</th>
                    <th class="px-6 py-3.5 font-medium">Tanggal</th>
                    <th class="px-6 py-3.5 font-medium">Tujuan & Ref Balasan</th>
                    <th class="px-6 py-3.5 font-medium">Perihal / Subject</th>
                    <th class="px-6 py-3.5 font-medium">Status & Delivery</th>
                    <th class="px-6 py-3.5 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-sm text-body-sm divide-y divide-outline-variant/20 dark:divide-ds-border">
                @forelse($letters as $letter)
                <tr class="hover:bg-blue-50/30 dark:hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            @if($letter->category === 'balasan')
                                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded bg-amber-500/15 text-amber-600 dark:text-amber-300 uppercase border border-amber-500/30 shrink-0" title="Surat Balasan">↩️ Balasan</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded bg-blue-500/15 text-blue-600 dark:text-blue-300 uppercase border border-blue-500/30 shrink-0" title="Surat Perusahaan">🏢 Umum</span>
                            @endif
                            <a href="{{ route('outgoing-letters.show', $letter->id) }}" class="text-[#0055CC] dark:text-ds-accent font-bold font-mono text-xs hover:underline cursor-pointer" title="Klik untuk lihat detail surat">{{ $letter->letter_number }}</a>
                        </div>
                        <span class="text-[11px] text-on-surface-variant mt-1 block">{{ $letter->letterType->type_name ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-on-surface-variant dark:text-ds-text-secondary whitespace-nowrap text-xs">
                        {{ \Carbon\Carbon::parse($letter->date_sent)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-on-surface dark:text-ds-text-primary uppercase text-xs">{{ $letter->recipient }}</div>
                        @if($letter->incoming_letter_id && $letter->incomingLetter)
                            <a href="{{ route('incoming-letters.show', $letter->incoming_letter_id) }}" class="inline-flex items-center gap-1 text-[11px] text-emerald-600 dark:text-emerald-400 hover:underline mt-0.5 font-medium" title="Buka Surat Masuk Referensi">
                                <span class="material-symbols-outlined text-[13px]">link</span>
                                <span>Ref: #{{ $letter->incomingLetter->letter_number }}</span>
                            </a>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('outgoing-letters.show', $letter->id) }}" class="text-on-surface dark:text-ds-text-primary font-semibold text-xs truncate max-w-xs block hover:text-blue-600 dark:hover:text-blue-400 hover:underline cursor-pointer" title="Klik untuk lihat detail surat">{{ $letter->subject }}</a>
                        <div class="text-on-surface-variant dark:text-ds-text-secondary text-[11px] truncate max-w-xs mt-0.5 opacity-80">{{ strip_tags($letter->content) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($letter->status == 'pending')
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-500 border border-amber-500/30 font-label-sm text-[11px] font-bold tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> MENUNGGU ACC
                            </div>
                        @elseif($letter->status == 'acc')
                            <div class="flex flex-col items-start gap-1">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 font-label-sm text-[11px] font-bold tracking-wider">
                                    <span class="material-symbols-outlined text-[13px]">check_circle</span> DISETUJUI (SIAP KIRIM)
                                </div>
                                <span class="text-[10px] text-on-surface-variant">Belum di-deliver</span>
                            </div>
                        @elseif($letter->status == 'delivered')
                            <div class="flex flex-col items-start gap-1">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/30 font-label-sm text-[11px] font-bold tracking-wider">
                                    <span class="material-symbols-outlined text-[13px]">local_shipping</span> TERKIRIM
                                </div>
                                @if($letter->delivery_method)
                                    <span class="text-[10px] text-on-surface-variant flex items-center gap-1 font-semibold" title="{{ $letter->delivery_note }}">
                                        Via: {{ $letter->delivery_method }} ({{ \Carbon\Carbon::parse($letter->delivered_at)->format('d/m/Y') }})
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/30 font-label-sm text-[11px] font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> DITOLAK
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1.5">
                            @if($letter->status == 'acc')
                            <button type="button" onclick="openDeliveryModal({{ $letter->id }}, '{{ $letter->letter_number }}')" class="px-2.5 py-1.5 rounded-lg text-xs font-bold bg-blue-600 text-white hover:bg-blue-700 transition-all flex items-center gap-1 shadow-sm shrink-0" title="Proses Pengiriman / Delivery">
                                <span class="material-symbols-outlined text-[15px]">send_and_archive</span>
                                <span>Kirim</span>
                            </button>
                            @endif

                            @if($letter->file_path)
                            <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="w-8 h-8 flex items-center justify-center rounded-lg text-emerald-500 hover:bg-emerald-500/15 transition-colors" title="Lihat Lampiran">
                                <span class="material-symbols-outlined text-[18px]">attachment</span>
                            </a>
                            @endif
                            <a href="{{ route('outgoing-letters.show', $letter->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-sky-500 hover:bg-sky-500/15 transition-colors" title="Detail Surat">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </a>
                            @if($letter->status == 'pending')
                            <a href="{{ route('outgoing-letters.edit', $letter->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-amber-500 hover:bg-amber-500/15 transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            @endif
                            @if(!in_array($letter->status, ['acc', 'delivered']))
                            <form action="{{ route('outgoing-letters.destroy', $letter->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-500/15 transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-14 text-center">
                        <div class="flex flex-col items-center gap-3 text-on-surface-variant dark:text-ds-text-secondary">
                            <span class="material-symbols-outlined text-[52px] opacity-30">inbox_customize</span>
                            <h4 class="font-h3 text-h3 text-on-surface dark:text-ds-text-primary font-bold">Kotak Surat Kosong</h4>
                            <p class="font-body-sm text-body-sm max-w-sm">Belum ada surat keluar pada kategori atau filter ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($letters->hasPages())
    <div class="p-4 border-t border-outline-variant/30 dark:border-ds-border">
        {{ $letters->links() }}
    </div>
    @endif
</div>

<!-- Modal Delivery Workflow -->
<div id="delivery-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm hidden">
    <div class="bg-white dark:bg-[#151D2A] rounded-2xl shadow-xl border border-outline-variant/50 dark:border-ds-border w-full max-w-md p-6 relative transform transition-all">
        <div class="flex items-center justify-between border-b border-outline-variant/30 dark:border-ds-border pb-3 mb-4">
            <h3 class="font-headline-sm text-base font-bold text-on-surface dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-500">local_shipping</span>
                <span>Konfirmasi Delivery Surat</span>
            </h3>
            <button type="button" onclick="closeDeliveryModal()" class="text-on-surface-variant hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <p class="text-xs text-on-surface-variant dark:text-ds-text-secondary mb-4">
            Surat <strong id="modal-letter-number" class="text-[#0055CC] dark:text-amber-400"></strong> telah mendapatkan ACC dari Pimpinan (TTD digital telah tercantum). Pilih metode pengiriman ke penerima.
        </p>
        <form id="delivery-form" method="POST" action="">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-on-surface dark:text-white mb-1">Metode Pengiriman / Ekspedisi <span class="text-red-500">*</span></label>
                    <select name="delivery_method" class="w-full rounded-lg bg-surface-container-low dark:bg-[#0B1220] border border-outline-variant dark:border-ds-border py-2 px-3 text-xs text-on-surface dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" required>
                        <option value="Kurir Kantor / Eksternal">Kurir Kantor / Eksternal</option>
                        <option value="Email / Digital Distribution">Email / Digital Distribution</option>
                        <option value="Pos Indonesia / JNE / J&T">Pos Indonesia / JNE / J&T</option>
                        <option value="Diambil Langsung">Diambil Langsung oleh Penerima</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface dark:text-white mb-1">Catatan Pengiriman / No. Resi (Opsional)</label>
                    <textarea name="delivery_note" rows="2" placeholder="Contoh: Diterima oleh staf resepsionis atas nama Bpk. Agus / Resi #JNE123..." class="w-full rounded-lg bg-surface-container-low dark:bg-[#0B1220] border border-outline-variant dark:border-ds-border py-2 px-3 text-xs text-on-surface dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6 pt-3 border-t border-outline-variant/30 dark:border-ds-border">
                <button type="button" onclick="closeDeliveryModal()" class="px-4 py-2 rounded-lg border border-outline-variant text-on-surface-variant text-xs font-semibold hover:bg-gray-100 dark:hover:bg-white/5">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold flex items-center gap-1 shadow-md">
                    <span class="material-symbols-outlined text-[16px]">task_alt</span>
                    <span>Tandai Terkirim (Delivered)</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeliveryModal(id, letterNum) {
    document.getElementById('modal-letter-number').textContent = letterNum;
    document.getElementById('delivery-form').action = "/admin/outgoing-letters/" + id + "/deliver";
    document.getElementById('delivery-modal').classList.remove('hidden');
}
function closeDeliveryModal() {
    document.getElementById('delivery-modal').classList.add('hidden');
}
</script>
@endsection
