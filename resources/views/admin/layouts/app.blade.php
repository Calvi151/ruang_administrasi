<!DOCTYPE html>
<html lang="id" id="html-root">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Ruang Administrasi - Dashboard')</title>
    <!-- Fonts (Inter — sesuai Stitch) -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Tailwind Config (sesuai Stitch design system) -->
    <!-- Dark Mode: apply class before render to prevent flash -->
    <script>
        (function() {
            const saved = localStorage.getItem('ruang-admin-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-secondary-fixed-variant": "#005137",
                    "secondary": "#006c4a",
                    "primary": "#004ac6",
                    "on-error": "#ffffff",
                    "surface-dim": "#d9d9e5",
                    "primary-container": "#2563eb",
                    "on-secondary": "#ffffff",
                    "outline-variant": "#c3c6d7",
                    "on-primary-container": "#eeefff",
                    "on-error-container": "#93000a",
                    "background": "#faf8ff",
                    "tertiary": "#4338d9",
                    "primary-fixed-dim": "#b4c5ff",
                    "primary-fixed": "#dbe1ff",
                    "on-tertiary-fixed": "#0f0069",
                    "secondary-fixed-dim": "#68dba9",
                    "inverse-primary": "#b4c5ff",
                    "tertiary-fixed": "#e2dfff",
                    "tertiary-container": "#5d55f3",
                    "surface-bright": "#faf8ff",
                    "on-primary": "#ffffff",
                    "on-tertiary": "#ffffff",
                    "surface": "#faf8ff",
                    "error": "#ba1a1a",
                    "on-primary-fixed-variant": "#003ea8",
                    "on-tertiary-container": "#f2eeff",
                    "tertiary-fixed-dim": "#c3c0ff",
                    "inverse-surface": "#2e3039",
                    "secondary-fixed": "#85f8c4",
                    "surface-tint": "#0053db",
                    "surface-container-lowest": "#ffffff",
                    "on-primary-fixed": "#00174b",
                    "surface-variant": "#e1e2ed",
                    "on-secondary-container": "#00714e",
                    "surface-container-highest": "#e1e2ed",
                    "on-background": "#191b23",
                    "on-surface": "#191b23",
                    "surface-container-high": "#e7e7f3",
                    "inverse-on-surface": "#f0f0fb",
                    "surface-container-low": "#f3f3fe",
                    "on-tertiary-fixed-variant": "#3323cc",
                    "outline": "#737686",
                    "on-secondary-fixed": "#002114",
                    "on-surface-variant": "#434655",
                    "error-container": "#ffdad6",
                    "secondary-container": "#82f5c1",
                    "surface-container": "#ededf9",
                    "status-mint": "#ecfdf5",
                    "status-peach": "#fff7ed",
                    "status-lilac": "#f5f3ff",
                    "heading-slate": "#0f172a",
                    "border-muted": "#f1f5f9",
                    /* Dark mode surface tokens */
                    "dark-surface": "#1e2030",
                    "dark-surface-container": "#252840",
                    "dark-surface-container-high": "#2d3050",
                    "dark-surface-container-low": "#191b2e",
                    "dark-on-surface": "#e2e4f0",
                    "dark-on-surface-variant": "#a0a4bb",
                    "dark-outline-variant": "#3a3d54",
                    "dark-primary": "#b4c5ff"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "2xl": "1rem",
                    "3xl": "1.5rem",
                    "full": "9999px"
            },
            "spacing": {
                    "container_max_width": "1280px",
                    "margin_desktop": "2rem",
                    "gutter": "1.5rem",
                    "margin_mobile": "1rem",
                    "sidebar_width": "256px",
                    "macro-padding": "32px"
            },
            "fontFamily": {
                    "label-sm": ["Inter"],
                    "display": ["Inter"],
                    "body-lg": ["Inter"],
                    "body-md": ["Inter"],
                    "body-sm": ["Inter"],
                    "h1": ["Inter"],
                    "h1-mobile": ["Inter"],
                    "h2": ["Inter"],
                    "h3": ["Inter"],
                    "label-md": ["Inter"]
            },
            "fontSize": {
                    "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "600"}],
                    "display": ["36px", {"lineHeight": "44px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                    "h1": ["30px", {"lineHeight": "38px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                    "h1-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "700"}],
                    "h2": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                    "h3": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "label-md": ["14px", {"lineHeight": "20px", "fontWeight": "500"}]
            }
          }
        }
      }
    </script>
    <style>
        /* ============================================================
           LAYOUT SHIFT FIX — root cause: scrollbar appearing/disappearing
           causes the page width to change by ~15px. Solution:
           - scrollbar-gutter: stable  → reserves scrollbar space always
           - overflow-y: scroll        → fallback for older browsers
           This prevents ANY width change when TinyMCE opens menus/dialogs
        ============================================================ */
        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Dark mode smooth transition — scoped ke elemen UI, BUKAN body/html/main agar TinyMCE tidak memicu reflow */
        html.dark a, html:not(.dark) a,
        html.dark button, html:not(.dark) button,
        html.dark .bg-surface, html:not(.dark) .bg-surface,
        html.dark [class*="bg-surface"], html:not(.dark) [class*="bg-surface"],
        html.dark [class*="bg-primary"], html:not(.dark) [class*="bg-primary"],
        html.dark [class*="bg-secondary"], html:not(.dark) [class*="bg-secondary"],
        html.dark [class*="border-"], html:not(.dark) [class*="border-"],
        html.dark [class*="text-on-"], html:not(.dark) [class*="text-on-"],
        html.dark [class*="text-primary"], html:not(.dark) [class*="text-primary"],
        html.dark [class*="text-secondary"], html:not(.dark) [class*="text-secondary"] {
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.15s ease;
        }
        /* Layout containers: NO transition — prevents reflow when TinyMCE injects styles */
        body, main, header, nav, .flex-1, aside {
            transition: none !important;
        }
        /* Scrollbar — lebar SAMA di dark & light agar scrollbar-gutter:stable
           tidak berubah ukuran saat toggle mode (yg menyebabkan layout shift) */
        ::-webkit-scrollbar              { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track        { background: #f1f1f1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb        { background: #c0c4d0; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover  { background: #a0a4bb; }

        html.dark ::-webkit-scrollbar-track { background: #12131e; }
        html.dark ::-webkit-scrollbar-thumb { background: #3a3d54; border-radius: 4px; }
        html.dark ::-webkit-scrollbar-thumb:hover { background: #4a4e6a; }

        /* ============================================================
           DARK MODE — Override semua Tailwind surface & text tokens
           Mencakup seluruh halaman tanpa perlu ubah file view
        ============================================================ */

        /* ----- BACKGROUNDS ----- */
        html.dark .bg-background,
        html.dark .bg-surface,
        html.dark .bg-surface-bright            { background-color: #1e2030 !important; }

        html.dark .bg-surface-container-lowest  { background-color: #1a1c2e !important; }
        html.dark .bg-surface-container-low     { background-color: #1e2035 !important; }
        html.dark .bg-surface-container         { background-color: #252840 !important; }
        html.dark .bg-surface-container-high    { background-color: #2d3050 !important; }
        html.dark .bg-surface-container-highest { background-color: #333560 !important; }
        html.dark .bg-surface-dim               { background-color: #13141e !important; }
        html.dark .bg-surface-variant           { background-color: #252840 !important; }

        /* Primary container (icon background) — lebih gelap agar tidak menyilaukan */
        html.dark .bg-primary-fixed             { background-color: #1e2f5a !important; }
        html.dark .bg-primary-container         { background-color: #1a2d6e !important; }
        html.dark .bg-tertiary-fixed            { background-color: #3b1215 !important; }
        html.dark .bg-tertiary-container        { background-color: #6b1215 !important; }

        /* Secondary container badge */
        html.dark .bg-secondary-container       { background-color: #0a3b28 !important; }

        /* ----- TEXT ----- */
        html.dark .text-on-surface              { color: #e2e4f0 !important; }
        html.dark .text-on-surface-variant      { color: #9ca3bf !important; }
        html.dark .text-on-background           { color: #e2e4f0 !important; }
        html.dark .text-on-secondary-container  { color: #6ee7b7 !important; }
        html.dark .text-primary                 { color: #60a5fa !important; } /* Tailwind blue-400 */
        html.dark .text-secondary               { color: #4ade80 !important; } /* Tailwind green-400 */
        html.dark .text-outline                 { color: #636885 !important; }
        html.dark .text-tertiary                { color: #ff8a80 !important; }
        html.dark .text-heading-slate           { color: #c5c8df !important; }

        /* Teks umum di dalam tabel / konten */
        html.dark p, html.dark span,
        html.dark td, html.dark th,
        html.dark li, html.dark label          { color: inherit; }

        /* ----- BORDERS ----- */
        html.dark .border-outline-variant       { border-color: #33374f !important; }
        html.dark .border-outline               { border-color: #4a4e6a !important; }
        html.dark .border-secondary-fixed       { border-color: #1a6b4a !important; }
        html.dark .border-border-muted          { border-color: #33374f !important; }

        /* ----- HOVER STATES ----- */
        html.dark .hover\:bg-surface-container:hover          { background-color: #252840 !important; }
        html.dark .hover\:bg-surface-container-high:hover     { background-color: #2d3050 !important; }
        html.dark .hover\:bg-surface-container-lowest:hover   { background-color: #252840 !important; }
        html.dark .hover\:bg-surface-container-high\/50:hover { background-color: rgba(45,48,80,0.5) !important; }

        /* ----- INPUT & FORM ----- */
        html.dark input, html.dark select, html.dark textarea {
            background-color: #252840 !important;
            border-color: #33374f !important;
            color: #e2e4f0 !important;
        }
        html.dark input::placeholder,
        html.dark textarea::placeholder         { color: #5a5e7a !important; }
        html.dark input:focus, html.dark select:focus,
        html.dark textarea:focus                { border-color: #b4c5ff !important; box-shadow: 0 0 0 3px rgba(180,197,255,0.15) !important; }

        /* ----- MODALS & DROPDOWNS (Bootstrap) ----- */
        html.dark .modal-content                { background-color: #1a1c2e !important; border-color: #33374f !important; }
        html.dark .modal-header, html.dark .modal-footer { border-color: #33374f !important; }
        html.dark .modal-title, html.dark .modal-body    { color: #e2e4f0 !important; }
        html.dark .dropdown-menu                { background-color: #1a1c2e !important; border-color: #33374f !important; }
        html.dark .dropdown-item                { color: #9ca3bf !important; }
        html.dark .dropdown-item:hover          { background-color: #252840 !important; color: #e2e4f0 !important; }

        /* ----- BADGES ----- */
        html.dark .bg-secondary-container\/30   { background-color: rgba(10, 59, 40, 0.5) !important; }
        html.dark .bg-error-container           { background-color: #3b0d0d !important; }
        html.dark .text-error                   { color: #ff7070 !important; }
        html.dark .bg-error-container\/30       { background-color: rgba(59, 13, 13, 0.5) !important; }
        html.dark .bg-status-mint               { background-color: #0a3b28 !important; }

        /* Amber / warning */
        html.dark .bg-amber-100                 { background-color: #3b2a05 !important; }
        html.dark .text-amber-800               { color: #fbbf24 !important; }
        html.dark .bg-amber-500\/10             { background-color: rgba(59, 42, 5, 0.4) !important; }
        html.dark .text-amber-600               { color: #fbbf24 !important; }

        /* ----- MISC UTILITY ----- */
        html.dark .shadow-sm                    { box-shadow: 0 1px 2px rgba(0,0,0,0.6) !important; }
        html.dark .shadow-md                    { box-shadow: 0 4px 12px rgba(0,0,0,0.5) !important; }
    

        /* Fix TinyMCE jumping — lock editor width */
        .tox-tinymce {
            width: 100% !important;
            min-width: 0 !important;
        }
        /* Block TinyMCE padding-right injection to body */
        body {
            padding-right: 0 !important;
            overflow-x: hidden !important;
        }
        .tox-tinymce-aux {
            z-index: 999999 !important;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-surface-variant/20 dark:bg-dark-surface text-on-surface dark:text-dark-on-surface antialiased min-h-screen flex selection:bg-primary-fixed selection:text-on-primary-fixed">
    
    <!-- SideNavBar (sesuai Stitch: bg-surface, border-l-4 active, rounded-lg) -->
    <nav class="w-sidebar_width h-screen fixed left-0 top-0 hidden md:flex flex-col border-r border-outline-variant dark:border-dark-outline-variant shadow-sm bg-surface dark:bg-dark-surface-container justify-between py-6 px-4 z-50">
        <div>
            <!-- Brand Header -->
            <div class="px-2 mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-on-primary font-display font-bold text-sm flex-shrink-0">RA</div>
                    <div>
                        <h1 class="font-display text-label-md font-bold text-primary dark:text-dark-primary truncate">Ruang Administrasi</h1>
                        <p class="font-label-sm text-label-sm text-on-surface-variant dark:text-dark-on-surface-variant truncate">Panel Admin</p>
                    </div>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <div class="flex flex-col gap-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-primary bg-secondary-container text-on-secondary-container font-label-md text-label-md' : 'border-transparent text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-md text-label-md' }} transition-colors duration-200">
                    <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'icon-fill' : '' }}">dashboard</span>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('incoming-letters.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 {{ request()->routeIs('incoming-letters.*') ? 'border-primary bg-secondary-container text-on-secondary-container font-label-md text-label-md' : 'border-transparent text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-md text-label-md' }} transition-colors duration-200">
                    <span class="material-symbols-outlined {{ request()->routeIs('incoming-letters.*') ? 'icon-fill' : '' }}">inbox</span>
                    <span>Surat Masuk</span>
                </a>
                
                <a href="{{ route('outgoing-letters.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 {{ request()->routeIs('outgoing-letters.*') ? 'border-primary bg-secondary-container text-on-secondary-container font-label-md text-label-md' : 'border-transparent text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-md text-label-md' }} transition-colors duration-200">
                    <span class="material-symbols-outlined {{ request()->routeIs('outgoing-letters.*') ? 'icon-fill' : '' }}">send</span>
                    <span>Surat Keluar</span>
                </a>
                
                <a href="{{ route('letter-types.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 {{ request()->routeIs('letter-types.*') ? 'border-primary bg-secondary-container text-on-secondary-container font-label-md text-label-md' : 'border-transparent text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-md text-label-md' }} transition-colors duration-200">
                    <span class="material-symbols-outlined {{ request()->routeIs('letter-types.*') ? 'icon-fill' : '' }}">description</span>
                    <span>Jenis Surat</span>
                </a>
                
                <a href="{{ route('employees.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 {{ request()->routeIs('employees.*') ? 'border-primary bg-secondary-container text-on-secondary-container font-label-md text-label-md' : 'border-transparent text-on-surface-variant hover:bg-surface-container hover:text-on-surface font-label-md text-label-md' }} transition-colors duration-200">
                    <span class="material-symbols-outlined {{ request()->routeIs('employees.*') ? 'icon-fill' : '' }}">badge</span>
                    <span>Karyawan</span>
                </a>
            </div>
        </div>
        
        <!-- Footer Nav -->
        <div class="flex flex-col gap-1 border-t border-outline-variant pt-4 mt-4">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors duration-200 font-label-md text-label-md">
                <span class="material-symbols-outlined">account_circle</span>
                <span>Profil Saya</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-error hover:bg-surface-container transition-colors duration-200 font-label-md text-label-md">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>
    
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col md:ml-sidebar_width min-w-0">
        <!-- TopAppBar (sesuai Stitch) -->
        <header class="sticky top-0 z-40 w-full bg-surface/80 dark:bg-dark-surface-container/80 backdrop-blur-md border-b border-outline-variant/30 dark:border-dark-outline-variant shadow-sm flex justify-between items-center px-margin_mobile md:px-margin_desktop h-16">
            <div class="flex items-center">
                <h1 class="font-h2 text-h2 md:font-h1 md:text-h1 text-on-surface">@yield('page-title')</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-on-surface-variant dark:text-dark-on-surface-variant font-body-sm text-body-sm bg-surface-container dark:bg-dark-surface-container px-3 py-1.5 rounded-full">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d M Y') }}</span>
                </div>
                <!-- Dark Mode Toggle -->
                <button id="dark-mode-toggle" onclick="toggleDarkMode()"
                    class="p-2 text-on-surface-variant dark:text-dark-on-surface-variant hover:bg-surface-container-high/50 dark:hover:bg-dark-surface-container-high/50 rounded-full transition-all focus:ring-2 focus:ring-primary/20"
                    title="Toggle Dark Mode">
                    <span id="dark-icon" class="material-symbols-outlined hidden">light_mode</span>
                    <span id="light-icon" class="material-symbols-outlined">dark_mode</span>
                </button>
                <div class="relative">
                    @php
                        $notifications = \App\Models\OutgoingLetter::whereIn('status', ['acc', 'ditolak'])
                            ->orderBy('updated_at', 'desc')
                            ->take(5)
                            ->get();
                        $hasNotif = $notifications->count() > 0;
                        $latestNotifTime = $hasNotif ? $notifications->first()->updated_at->timestamp : 0;
                    @endphp
                    <button id="notification-btn" class="relative p-2 text-on-surface-variant dark:text-dark-on-surface-variant hover:bg-surface-container-high/50 dark:hover:bg-dark-surface-container-high/50 rounded-full transition-all focus:ring-2 focus:ring-primary/20">
                        <span class="material-symbols-outlined">notifications</span>
                        @if($hasNotif)
                            <span id="notif-badge" data-time="{{ $latestNotifTime }}" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-error rounded-full border-2 border-surface dark:border-dark-surface-container"></span>
                        @endif
                    </button>
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-surface dark:bg-dark-surface border border-outline-variant/30 rounded-xl shadow-md py-2 z-50">
                        <div class="px-4 py-3 border-b border-outline-variant/30">
                            <h3 class="font-label-md text-label-md text-on-surface dark:text-dark-on-surface font-bold">Notifikasi Terakhir</h3>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @if($hasNotif)
                                @foreach($notifications as $notif)
                                    <a href="{{ route('outgoing-letters.show', $notif->id) }}" class="block px-4 py-3 hover:bg-surface-container-lowest dark:hover:bg-dark-surface-container-lowest border-b border-outline-variant/10 transition-colors">
                                        <div class="flex items-start gap-3">
                                            @if($notif->status == 'acc')
                                                <div class="w-8 h-8 rounded-full bg-secondary-container/50 text-secondary-fixed flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-error-container/50 text-error flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-[18px]">cancel</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-label-sm text-label-sm text-on-surface dark:text-dark-on-surface mb-0.5">Surat {{ $notif->status == 'acc' ? 'Disetujui' : 'Ditolak' }}</p>
                                                <p class="font-body-xs text-[11px] text-on-surface-variant dark:text-dark-on-surface-variant line-clamp-2">
                                                    Surat "{{ $notif->subject }}" telah {{ $notif->status == 'acc' ? 'disetujui oleh CEO' : 'ditolak' }}.
                                                </p>
                                                <span class="font-body-xs text-[10px] text-outline mt-1 block">{{ $notif->updated_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                <a href="{{ route('outgoing-letters.index') }}" class="block px-4 py-2 text-center font-label-sm text-label-sm text-primary hover:underline mt-1">Lihat Semua Surat</a>
                            @else
                                <div class="px-4 py-8 text-center text-on-surface-variant dark:text-dark-on-surface-variant font-body-sm">
                                    <span class="material-symbols-outlined text-[32px] opacity-50 mb-2">notifications_off</span>
                                    <p>Belum ada notifikasi baru.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('profile.edit') }}" title="Profil Saya">
                    @if(Auth::user()->employee && Auth::user()->employee->photo)
                        <img alt="Profil Pengguna" class="w-8 h-8 rounded-full border border-outline-variant dark:border-dark-outline-variant object-cover cursor-pointer hover:opacity-90 transition-opacity" src="{{ asset('storage/' . Auth::user()->employee->photo) }}">
                    @else
                        <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm border border-outline-variant dark:border-dark-outline-variant cursor-pointer hover:opacity-90 transition-opacity">
                            {{ strtoupper(substr(Auth::user()->employee->name ?? 'Admin', 0, 2)) }}
                        </div>
                    @endif
                </a>
            </div>
        </header>
        
        <!-- Canvas -->
        <div class="flex-1 p-margin_mobile md:p-margin_desktop overflow-y-scroll overflow-x-hidden w-full">
            @if(session('success'))
            <div class="bg-status-mint dark:bg-green-900/30 text-secondary dark:text-green-300 border border-secondary-fixed dark:border-green-700/40 px-4 py-3 rounded-xl font-label-md text-label-md mb-6 flex items-center gap-3">
                <span class="material-symbols-outlined icon-fill">check_circle</span>
                {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </div>
    </main>
    
    @yield('scripts')

    <!-- Dark Mode Script -->
    <script>
        function toggleDarkMode() {
            const html = document.getElementById('html-root');
            const isDark = html.classList.toggle('dark');
            localStorage.setItem('ruang-admin-theme', isDark ? 'dark' : 'light');
            updateDarkModeIcons(isDark);
        }

        function updateDarkModeIcons(isDark) {
            const darkIcon = document.getElementById('dark-icon');
            const lightIcon = document.getElementById('light-icon');
            if (isDark) {
                darkIcon.classList.remove('hidden');
                lightIcon.classList.add('hidden');
            } else {
                darkIcon.classList.add('hidden');
                lightIcon.classList.remove('hidden');
            }
        }

        // Init icons on load
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.getElementById('html-root').classList.contains('dark');
            updateDarkModeIcons(isDark);
            
            // Notification toggle & read status
            const notifBtn = document.getElementById('notification-btn');
            const notifDropdown = document.getElementById('notification-dropdown');
            const notifBadge = document.getElementById('notif-badge');
            
            if (notifBadge) {
                const latestTime = parseInt(notifBadge.getAttribute('data-time'));
                const savedTime = localStorage.getItem('ruang_admin_notif_time');
                if (savedTime && parseInt(savedTime) >= latestTime) {
                    notifBadge.style.display = 'none';
                }
            }
            
            if (notifBtn && notifDropdown) {
                notifBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                    if (notifBadge && notifBadge.style.display !== 'none') {
                        notifBadge.style.display = 'none';
                        localStorage.setItem('ruang_admin_notif_time', notifBadge.getAttribute('data-time'));
                    }
                });
                
                document.addEventListener('click', function(e) {
                    if (!notifDropdown.contains(e.target)) {
                        notifDropdown.classList.add('hidden');
                    }
                });
            }
            
            // Live Search for Tables
            const searchInputs = document.querySelectorAll('input[placeholder*="Cari"]');
            searchInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase();
                    const tableBody = document.querySelector('table tbody');
                    if (tableBody) {
                        const rows = tableBody.querySelectorAll('tr');
                        rows.forEach(row => {
                            // Skip empty state row (usually has colspan)
                            if (row.querySelector('td[colspan]')) return;
                            
                            const text = row.textContent.toLowerCase();
                            if (text.includes(term)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    }
                });
            });

            // =============================================
            // TinyMCE Layout-Shift Fix: MutationObserver
            // Intercept & cancel any style injection TinyMCE
            // makes to <body> (padding-right, overflow, etc.)
            // that causes the page width to jump/reflow.
            // =============================================
            (function() {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                            const el = mutation.target;
                            // Only watch body element
                            if (el === document.body) {
                                // Remove any padding-right TinyMCE injected
                                if (el.style.paddingRight) {
                                    el.style.paddingRight = '';
                                }
                                // Remove overflow:hidden TinyMCE may inject
                                if (el.style.overflow === 'hidden') {
                                    el.style.overflow = '';
                                }
                                if (el.style.overflowY === 'hidden') {
                                    el.style.overflowY = '';
                                }
                            }
                        }
                    });
                });

                observer.observe(document.body, {
                    attributes: true,
                    attributeFilter: ['style']
                });
            })();
        });
    </script>
</body>
</html>







