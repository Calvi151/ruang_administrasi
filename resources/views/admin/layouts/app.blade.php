<!DOCTYPE html>
<html lang="id" id="html-root">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Ruang Administrasi - Dashboard')</title>
    <!-- Fonts (Montserrat + Plus Jakarta Sans — Administrative Authority) -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
    <!-- Tailwind Config (Administrative Authority Design System) -->
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    /* ===== LIGHT MODE TOKENS ===== */
                    "primary": "#000210",
                    "on-primary": "#ffffff",
                    "primary-container": "#0f1b3d",
                    "on-primary-container": "#7984ab",
                    "inverse-primary": "#bac5f0",
                    "primary-fixed": "#dbe1ff",
                    "primary-fixed-dim": "#bac5f0",
                    "on-primary-fixed": "#0d1a3c",
                    "on-primary-fixed-variant": "#3a4569",
                    "secondary": "#7d5700",
                    "on-secondary": "#ffffff",
                    "secondary-container": "#ffc55f",
                    "on-secondary-container": "#755100",
                    "secondary-fixed": "#ffdeaa",
                    "secondary-fixed-dim": "#f5bd58",
                    "on-secondary-fixed": "#271900",
                    "on-secondary-fixed-variant": "#5f4100",
                    "tertiary": "#00030a",
                    "on-tertiary": "#ffffff",
                    "tertiary-container": "#0d1e31",
                    "on-tertiary-container": "#76869e",
                    "tertiary-fixed": "#d3e4fe",
                    "tertiary-fixed-dim": "#b7c8e1",
                    "on-tertiary-fixed": "#0b1c30",
                    "on-tertiary-fixed-variant": "#38485d",
                    "error": "#ba1a1a",
                    "on-error": "#ffffff",
                    "error-container": "#ffdad6",
                    "on-error-container": "#93000a",
                    "surface": "#fbf9f4",
                    "surface-bright": "#fbf9f4",
                    "surface-dim": "#dbdad5",
                    "surface-container": "#f0eee9",
                    "surface-container-lowest": "#ffffff",
                    "surface-container-low": "#f5f3ee",
                    "surface-container-high": "#eae8e3",
                    "surface-container-highest": "#e4e2dd",
                    "surface-variant": "#e4e2dd",
                    "surface-tint": "#525d83",
                    "on-surface": "#1b1c19",
                    "on-surface-variant": "#45464e",
                    "on-background": "#1b1c19",
                    "background": "#fbf9f4",
                    "outline": "#76767f",
                    "outline-variant": "#c6c6cf",
                    "inverse-surface": "#30312e",
                    "inverse-on-surface": "#f2f1ec",
                    /* ===== DARK MODE TOKENS ===== */
                    "ds-bg": "#0B1220",
                    "ds-surface": "#141C33",
                    "ds-sidebar": "#0F172E",
                    "ds-sidebar-active": "#1A2440",
                    "ds-text-primary": "#E8E6E0",
                    "ds-text-secondary": "#8B93A8",
                    "ds-accent": "#E5B04D",
                    "ds-border": "#2A3654",
                    "ds-hover": "#1D2847",
                    "ds-chart-gray": "#5D6A85"
            },
            "borderRadius": {
                    "DEFAULT": "0.125rem",
                    "lg": "0.25rem",
                    "xl": "0.5rem",
                    "full": "0.75rem"
            },
            "spacing": {
                    "margin-edge": "40px",
                    "gutter": "32px",
                    "stack-tight": "8px",
                    "stack-loose": "16px",
                    "section-gap": "64px",
                    "container-max": "1440px",
                    "component-gap": "24px",
                    "sidebar_width": "280px"
            },
            "fontFamily": {
                    "display-lg": ["Montserrat", "sans-serif"],
                    "headline-lg": ["Montserrat", "sans-serif"],
                    "headline-lg-mobile": ["Montserrat", "sans-serif"],
                    "headline-md": ["Montserrat", "sans-serif"],
                    "headline-sm": ["Montserrat", "sans-serif"],
                    "numeric-data": ["Montserrat", "sans-serif"],
                    "body-lg": ["Plus Jakarta Sans", "sans-serif"],
                    "body-md": ["Plus Jakarta Sans", "sans-serif"],
                    "body-sm": ["Plus Jakarta Sans", "sans-serif"],
                    "label-md": ["Plus Jakarta Sans", "sans-serif"],
                    "label-sm": ["Plus Jakarta Sans", "sans-serif"]
            },
            "fontSize": {
                    "display-lg": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-lg": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "headline-lg-mobile": ["24px", {"lineHeight": "1.2", "fontWeight": "600"}],
                    "headline-md": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}],
                    "headline-sm": ["20px", {"lineHeight": "1.4", "fontWeight": "600"}],
                    "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "body-sm": ["14px", {"lineHeight": "1.5", "fontWeight": "400"}],
                    "label-md": ["12px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "label-sm": ["11px", {"lineHeight": "1", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "numeric-data": ["16px", {"lineHeight": "1", "letterSpacing": "0.02em", "fontWeight": "500"}]
            }
          }
        }
      }
    </script>
    <style>
        /* ============================================================
           LAYOUT SHIFT FIX — root cause: scrollbar appearing/disappearing
        ============================================================ */
        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-fill, .fill-icon {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* === Editorial Card (Stitch design) === */
        .editorial-card {
            background-color: #ffffff;
            border: 1px solid rgba(15, 27, 61, 0.1);
        }
        html.dark .editorial-card {
            background-color: #141C33;
            border-color: #2A3654;
        }

        /* === Table row hover === */
        .table-row-hover:hover {
            background-color: rgba(0, 2, 16, 0.02);
        }
        html.dark .table-row-hover:hover {
            background-color: rgba(229, 176, 77, 0.04);
        }

        /* === Focus ring === */
        .focus-ring:focus-within {
            border-color: #D9A441;
            box-shadow: 0 0 0 1px #D9A441;
            outline: none;
        }

        /* Dark mode smooth transition — scoped to UI elements, not body/html/main */
        html.dark a, html:not(.dark) a,
        html.dark button, html:not(.dark) button,
        html.dark [class*="editorial-card"], html:not(.dark) [class*="editorial-card"],
        html.dark [class*="border-"], html:not(.dark) [class*="border-"] {
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.15s ease;
        }
        /* Layout containers: NO transition — prevents reflow */
        body, main, header, nav, .flex-1, aside {
            transition: none !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar              { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track        { background: #f5f3ee; border-radius: 4px; }
        ::-webkit-scrollbar-thumb        { background: #c6c6cf; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover  { background: #76767f; }

        html.dark ::-webkit-scrollbar-track { background: #0B1220; }
        html.dark ::-webkit-scrollbar-thumb { background: #2A3654; border-radius: 4px; }
        html.dark ::-webkit-scrollbar-thumb:hover { background: #3D4E72; }

        /* ============================================================
           DARK MODE — Global overrides for surface/text tokens
        ============================================================ */

        /* Dark mode input/form overrides */
        html.dark input, html.dark select, html.dark textarea {
            background-color: #141C33 !important;
            border-color: #2A3654 !important;
            color: #E8E6E0 !important;
        }
        html.dark input::placeholder,
        html.dark textarea::placeholder { color: #5D6A85 !important; }
        html.dark input:focus, html.dark select:focus,
        html.dark textarea:focus { border-color: #E5B04D !important; box-shadow: 0 0 0 3px rgba(229,176,77,0.12) !important; }

        /* Webkit Autofill fix for Dark Mode */
        html.dark input:-webkit-autofill,
        html.dark input:-webkit-autofill:hover, 
        html.dark input:-webkit-autofill:focus, 
        html.dark input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #141C33 inset !important;
            -webkit-text-fill-color: #E8E6E0 !important;
            caret-color: #E8E6E0 !important;
        }

        /* Dark mode modals */
        html.dark .modal-content { background-color: #0F172E !important; border-color: #2A3654 !important; }
        html.dark .modal-header, html.dark .modal-footer { border-color: #2A3654 !important; }
        html.dark .modal-title, html.dark .modal-body { color: #E8E6E0 !important; }
        html.dark .dropdown-menu { background-color: #0F172E !important; border-color: #2A3654 !important; }
        html.dark .dropdown-item { color: #8B93A8 !important; }
        html.dark .dropdown-item:hover { background-color: #1D2847 !important; color: #E8E6E0 !important; }

        /* Fix TinyMCE jumping — lock editor width */
        .tox-tinymce {
            width: 100% !important;
            min-width: 0 !important;
        }
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
<body class="bg-background dark:bg-ds-bg text-on-surface dark:text-ds-text-primary font-body-md min-h-screen flex antialiased items-stretch selection:bg-primary-fixed selection:text-on-primary-fixed">
    
    <!-- SideNavBar (Administrative Authority: dark navy, amber active, border-l-4) -->
    <nav class="w-sidebar_width h-screen fixed left-0 top-0 hidden md:flex flex-col bg-primary-container dark:bg-ds-sidebar border-r border-outline/10 dark:border-ds-border py-8 z-50">
        <div class="px-6 mb-12">
            <h1 class="font-headline-md text-headline-md font-bold text-on-primary dark:text-ds-text-primary">Ruang Administrasi</h1>
            <p class="font-body-sm text-body-sm text-on-primary-container dark:text-ds-text-secondary mt-1">Sistem Kelola Surat</p>
        </div>
        
        <!-- Main Navigation -->
        <div class="flex flex-col gap-1 flex-grow">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'fill-icon' : '' }}">dashboard</span>
                <span class="font-label-md text-label-md">Dashboard</span>
            </a>
            
            <a href="{{ route('incoming-letters.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('incoming-letters.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('incoming-letters.*') ? 'fill-icon' : '' }}">drafts</span>
                <span class="font-label-md text-label-md">Surat Masuk</span>
            </a>
            
            <a href="{{ route('outgoing-letters.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('outgoing-letters.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('outgoing-letters.*') ? 'fill-icon' : '' }}">send</span>
                <span class="font-label-md text-label-md">Surat Keluar</span>
            </a>
            
            <a href="{{ route('letter-types.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('letter-types.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('letter-types.*') ? 'fill-icon' : '' }}">topic</span>
                <span class="font-label-md text-label-md">Jenis Surat</span>
            </a>
            
            <a href="{{ route('employees.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('employees.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('employees.*') ? 'fill-icon' : '' }}">group</span>
                <span class="font-label-md text-label-md">Karyawan</span>
            </a>
        </div>
        
        <!-- Footer Nav -->
        <div class="mt-auto px-6 flex flex-col gap-1 border-t border-outline/10 dark:border-ds-border pt-4">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 py-3 text-on-primary-container dark:text-[#94a3b8] transition-colors hover:text-on-primary dark:hover:text-ds-text-primary">
                <span class="material-symbols-outlined">account_circle</span>
                <span class="font-label-md text-label-md">Profil Saya</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 py-3 text-error dark:text-[#ff7070] transition-colors hover:text-on-primary dark:hover:text-ds-text-primary">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-label-md text-label-md">Keluar</span>
                </button>
            </form>
        </div>
    </nav>
    
    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col md:ml-sidebar_width min-w-0">
        <!-- TopNavBar (Administrative Authority) -->
        <header class="w-full h-20 sticky top-0 z-40 bg-surface dark:bg-ds-bg border-b border-on-primary-container/10 dark:border-ds-border flex justify-between items-center px-margin-edge">
            <div class="flex items-center gap-4">
                <h1 class="font-headline-sm text-headline-sm font-bold text-primary dark:text-ds-text-primary hidden md:block">@yield('page-title', 'Ruang Administrasi')</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-surface-container-low dark:bg-ds-surface border border-outline-variant dark:border-ds-border rounded-full">
                    <span class="material-symbols-outlined text-on-surface-variant dark:text-ds-text-secondary text-sm">calendar_today</span>
                    <span class="font-label-md text-label-md text-on-surface-variant dark:text-ds-text-secondary">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d M Y') }}</span>
                </div>
                <!-- Dark Mode Toggle -->
                <button id="dark-mode-toggle" onclick="toggleDarkMode()"
                    class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant dark:text-ds-accent hover:bg-surface-container-high dark:hover:bg-ds-hover transition-colors scale-95 active:scale-90"
                    title="Toggle Dark Mode">
                    <span id="dark-icon" class="material-symbols-outlined fill-icon hidden">dark_mode</span>
                    <span id="light-icon" class="material-symbols-outlined">light_mode</span>
                </button>
                <!-- Notifications -->
                <div class="relative">
                    @php
                        $notifications = \App\Models\OutgoingLetter::whereIn('status', ['acc', 'ditolak'])
                            ->orderBy('updated_at', 'desc')
                            ->take(5)
                            ->get();
                        $hasNotif = $notifications->count() > 0;
                        $latestNotifTime = $hasNotif ? $notifications->first()->updated_at->timestamp : 0;
                    @endphp
                    <button id="notification-btn" class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant dark:text-ds-text-secondary hover:bg-surface-container-high dark:hover:bg-ds-hover transition-colors scale-95 active:scale-90 relative">
                        <span class="material-symbols-outlined">notifications</span>
                        @if($hasNotif)
                            <span id="notif-badge" data-time="{{ $latestNotifTime }}" class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                        @endif
                    </button>
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-surface dark:bg-ds-sidebar border border-outline-variant/30 dark:border-ds-border rounded-xl shadow-md py-2 z-50">
                        <div class="px-4 py-3 border-b border-outline-variant/30 dark:border-ds-border">
                            <h3 class="font-label-md text-label-md text-on-surface dark:text-ds-text-primary font-bold">Notifikasi Terakhir</h3>
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @if($hasNotif)
                                @foreach($notifications as $notif)
                                    <a href="{{ route('outgoing-letters.show', $notif->id) }}" class="block px-4 py-3 hover:bg-surface-container-low dark:hover:bg-ds-hover border-b border-outline-variant/10 dark:border-ds-border/50 transition-colors">
                                        <div class="flex items-start gap-3">
                                            @if($notif->status == 'acc')
                                                <div class="w-8 h-8 rounded-full bg-secondary-container/50 dark:bg-ds-accent/20 text-secondary dark:text-ds-accent flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-error-container/50 dark:bg-error/20 text-error flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-[18px]">cancel</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-label-sm text-label-sm text-on-surface dark:text-ds-text-primary mb-0.5">Surat {{ $notif->status == 'acc' ? 'Disetujui' : 'Ditolak' }}</p>
                                                <p class="text-[11px] text-on-surface-variant dark:text-ds-text-secondary line-clamp-2">
                                                    Surat "{{ $notif->subject }}" telah {{ $notif->status == 'acc' ? 'disetujui oleh CEO' : 'ditolak' }}.
                                                </p>
                                                <span class="text-[10px] text-outline dark:text-ds-chart-gray mt-1 block">{{ $notif->updated_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                <a href="{{ route('outgoing-letters.index') }}" class="block px-4 py-2 text-center font-label-md text-label-md text-primary dark:text-ds-accent hover:underline mt-1">Lihat Semua Surat</a>
                            @else
                                <div class="px-4 py-8 text-center text-on-surface-variant dark:text-ds-text-secondary font-body-sm">
                                    <span class="material-symbols-outlined text-[32px] opacity-50 mb-2">notifications_off</span>
                                    <p>Belum ada notifikasi baru.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="h-8 w-px bg-outline-variant dark:bg-ds-border mx-2"></div>
                <a href="{{ route('profile.edit') }}" title="Profil Saya" class="hover:opacity-80 transition-opacity">
                    @if(Auth::user()->employee && Auth::user()->employee->photo)
                        <img alt="Profil Pengguna" class="w-9 h-9 rounded-full border border-outline-variant dark:border-ds-border object-cover" src="{{ asset('storage/' . Auth::user()->employee->photo) }}">
                    @else
                        <div class="w-9 h-9 rounded-full bg-primary dark:bg-ds-surface text-on-primary dark:text-ds-text-primary flex items-center justify-center font-bold text-sm border border-outline-variant dark:border-ds-border">
                            {{ strtoupper(substr(Auth::user()->employee->name ?? 'Admin', 0, 2)) }}
                        </div>
                    @endif
                </a>
            </div>
        </header>
        
        <!-- Canvas -->
        <div class="flex-1 p-margin-edge overflow-y-scroll overflow-x-hidden w-full max-w-container-max mx-auto flex flex-col gap-gutter">
            @if(session('success'))
            <div class="bg-[#ecfdf5] dark:bg-[#0a3020] text-[#2e7d32] dark:text-[#4caf50] border border-[#a7f3d0] dark:border-[#2e7d32]/40 px-4 py-3 rounded-xl font-label-md text-label-md mb-2 flex items-center gap-3">
                <span class="material-symbols-outlined fill-icon">check_circle</span>
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
                            if (row.querySelector('td[colspan]')) return;
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(term) ? '' : 'none';
                        });
                    }
                });
            });

            // TinyMCE Layout-Shift Fix: MutationObserver
            (function() {
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                            const el = mutation.target;
                            if (el === document.body) {
                                if (el.style.paddingRight) el.style.paddingRight = '';
                                if (el.style.overflow === 'hidden') el.style.overflow = '';
                                if (el.style.overflowY === 'hidden') el.style.overflowY = '';
                            }
                        }
                    });
                });
                observer.observe(document.body, { attributes: true, attributeFilter: ['style'] });
            })();
        });
    </script>
</body>
</html>
