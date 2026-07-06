@extends('admin.layouts.app')

@section('title', 'Ruang Administrasi - Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . Auth::user()->name . '.')

@section('content')
<!-- Stats Grid -->
<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
    <!-- Card 1: Surat Masuk -->
    <div class="bg-surface-container-lowest rounded-3xl p-4 border border-border-muted ambient-shadow hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,74,198,0.08)] transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-4 text-primary-fixed-dim/20 group-hover:scale-110 transition-transform duration-500">
            <span class="material-symbols-outlined text-[48px] icon-fill">mark_email_unread</span>
        </div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary">
                <span class="material-symbols-outlined icon-fill">inbox</span>
            </div>
            <span class="bg-primary/5 text-primary border border-primary/10 px-2 py-1 rounded-full font-label-sm text-label-sm tracking-wider">TOTAL</span>
        </div>
        <div class="relative z-10">
            <p class="font-body-md text-body-md text-on-surface-variant mb-1">Surat Masuk</p>
            <h3 class="font-headline-xl text-headline-xl text-on-background tracking-tighter">{{ $totalIncoming }}</h3>
            <p class="font-label-sm text-label-sm text-secondary mt-3 flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">history</span>
                Semua data
            </p>
        </div>
    </div>
    
    <!-- Card 2: Surat Keluar -->
    <div class="bg-surface-container-lowest rounded-3xl p-4 border border-border-muted ambient-shadow hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(147,0,10,0.04)] transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-4 text-status-lilac group-hover:scale-110 transition-transform duration-500">
            <span class="material-symbols-outlined text-[48px] icon-fill">send</span>
        </div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div class="w-12 h-12 rounded-full bg-status-lilac flex items-center justify-center text-primary-container">
                <span class="material-symbols-outlined icon-fill">outbox</span>
            </div>
        </div>
        <div class="relative z-10">
            <p class="font-body-md text-body-md text-on-surface-variant mb-1">Surat Keluar</p>
            <h3 class="font-headline-xl text-headline-xl text-on-background tracking-tighter">{{ $totalOutgoing }}</h3>
            <p class="font-label-sm text-label-sm text-outline mt-3 flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">history</span>
                Semua data
            </p>
        </div>
    </div>
    
    <!-- Card 3: Menunggu Approval -->
    <div class="bg-surface-container-lowest rounded-3xl p-4 border border-border-muted ambient-shadow hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(188,72,0,0.06)] transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-4 text-status-peach group-hover:scale-110 transition-transform duration-500">
            <span class="material-symbols-outlined text-[48px] icon-fill">pending_actions</span>
        </div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div class="w-12 h-12 rounded-full bg-status-peach flex items-center justify-center text-tertiary-container">
                <span class="material-symbols-outlined icon-fill">hourglass_empty</span>
            </div>
            @if($outgoingPending > 0)
                <span class="w-3 h-3 rounded-full bg-tertiary-container animate-pulse"></span>
            @endif
        </div>
        <div class="relative z-10">
            <p class="font-body-md text-body-md text-on-surface-variant mb-1">Menunggu Approval</p>
            <h3 class="font-headline-xl text-headline-xl text-on-background tracking-tighter">{{ $outgoingPending }}</h3>
            <p class="font-label-sm text-label-sm text-tertiary-container mt-3 flex items-center gap-1">
                @if($outgoingPending > 0)
                    <span class="material-symbols-outlined text-[14px]">error</span>
                    Membutuhkan perhatian
                @else
                    <span class="material-symbols-outlined text-[14px]">check_circle</span>
                    Semua sudah diproses
                @endif
            </p>
        </div>
    </div>
    
    <!-- Card 4: Total Karyawan -->
    <div class="bg-surface-container-lowest rounded-3xl p-4 border border-border-muted ambient-shadow hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,106,97,0.06)] transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-4 text-status-mint group-hover:scale-110 transition-transform duration-500">
            <span class="material-symbols-outlined text-[48px] icon-fill">groups</span>
        </div>
        <div class="flex justify-between items-start mb-4 relative z-10">
            <div class="w-12 h-12 rounded-full bg-status-mint flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined icon-fill">badge</span>
            </div>
        </div>
        <div class="relative z-10">
            <p class="font-body-md text-body-md text-on-surface-variant mb-1">Total Karyawan</p>
            <h3 class="font-headline-xl text-headline-xl text-on-background tracking-tighter">{{ $totalEmployees }}</h3>
            <p class="font-label-sm text-label-sm text-secondary mt-3 flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">group</span>
                Data karyawan aktif
            </p>
        </div>
    </div>
</section>

<!-- Recent Sections -->
<section class="grid grid-cols-1 lg:grid-cols-2 gap-gutter pb-margin-desktop mt-4">
    <!-- Left: Surat Keluar Terbaru -->
    <div class="bg-surface-container-lowest rounded-3xl p-4 border border-border-muted ambient-shadow flex flex-col h-[500px]">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-headline-md text-headline-md font-bold text-on-background">Surat Keluar Terbaru</h3>
            <a href="{{ route('outgoing-letters.index') }}" class="bg-inverse-surface text-inverse-on-surface px-5 py-1 rounded-full font-label-sm text-label-sm hover:bg-heading-slate transition-colors flex items-center gap-4">
                Lihat Semua
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
        </div>
        <div class="flex-1 overflow-y-auto pr-2 flex flex-col gap-4">
            @forelse($recentOutgoing as $letter)
            <div class="group flex items-center justify-between p-4 rounded-3xl border border-border-muted hover:border-primary-fixed-dim hover:bg-surface-container-lowest transition-all cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-full @if($letter->status == 'pending') bg-status-peach text-tertiary-container @elseif($letter->status == 'acc') bg-status-mint text-secondary @else bg-error-container/30 text-error @endif flex items-center justify-center">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <div>
                        <p class="font-label-md text-label-md text-on-background">{{ $letter->letter_number }}</p>
                        <p class="font-body-md text-body-md text-on-surface-variant text-sm mt-0.5">{{ Str::limit($letter->subject, 35) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if($letter->status == 'pending')
                        <span class="bg-status-peach text-tertiary border border-tertiary-fixed px-2 py-1 rounded-full font-label-sm text-label-sm">Pending</span>
                    @elseif($letter->status == 'acc')
                        <span class="bg-status-mint text-secondary border border-secondary-fixed px-2 py-1 rounded-full font-label-sm text-label-sm">Disetujui</span>
                    @else
                        <span class="bg-error-container text-on-error-container border border-error-container px-2 py-1 rounded-full font-label-sm text-label-sm">Ditolak</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="flex-1 flex flex-col items-center justify-center text-center p-4">
                <div class="w-16 h-16 mb-4 relative">
                    <div class="absolute inset-0 bg-surface-container rounded-full opacity-50 scale-110"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-primary-fixed-dim">
                        <span class="material-symbols-outlined text-[48px] font-light">drafts</span>
                    </div>
                </div>
                <h4 class="font-headline-md text-headline-md text-on-background mb-2">Belum ada surat keluar</h4>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-sm mx-auto">
                    Data surat keluar akan muncul di sini.
                </p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Right: Surat Masuk Terbaru -->
    <div class="bg-surface-container-lowest rounded-3xl p-4 border border-border-muted ambient-shadow flex flex-col h-[500px]">
        <div class="flex justify-between items-center mb-5">
            <h3 class="font-headline-md text-headline-md font-bold text-on-background">Surat Masuk Terbaru</h3>
            <a href="{{ route('incoming-letters.index') }}" class="bg-inverse-surface text-inverse-on-surface px-5 py-1 rounded-full font-label-sm text-label-sm hover:bg-heading-slate transition-colors flex items-center gap-4">
                Lihat Semua
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
        </div>
        <div class="flex-1 overflow-y-auto pr-2 flex flex-col gap-4">
            @forelse($recentIncoming as $letter)
            <div class="group flex items-center justify-between p-4 rounded-3xl border border-border-muted hover:border-primary-fixed-dim hover:bg-surface-container-lowest transition-all cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-full bg-primary-fixed/50 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">inbox</span>
                    </div>
                    <div>
                        <p class="font-label-md text-label-md text-on-background">{{ $letter->letter_number }}</p>
                        <p class="font-body-md text-body-md text-on-surface-variant text-sm mt-0.5">{{ Str::limit($letter->subject, 35) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="bg-surface-variant text-on-surface-variant border border-outline-variant px-2 py-1 rounded-full font-label-sm text-label-sm">{{ \Carbon\Carbon::parse($letter->date_received)->format('d M') }}</span>
                </div>
            </div>
            @empty
            <div class="flex-1 flex flex-col items-center justify-center text-center p-4">
                <div class="w-16 h-16 mb-4 relative">
                    <div class="absolute inset-0 bg-surface-container rounded-full opacity-50 scale-110"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-primary-fixed-dim">
                        <span class="material-symbols-outlined text-[48px] font-light">mark_email_unread</span>
                    </div>
                </div>
                <h4 class="font-headline-md text-headline-md text-on-background mb-2">Belum ada surat masuk</h4>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-sm mx-auto">
                    Kotak masuk Anda saat ini bersih. Surat yang baru tiba akan langsung muncul di panel ini.
                </p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection







