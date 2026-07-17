<!DOCTYPE html>
<html lang="id" id="html-root">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Ruang Administrasi - Dashboard Pimpinan')</title>
    
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
    
    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Bootstrap (if needed for old components) via Vite -->
    @vite('resources/css/bootstrap.css')
    
    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
        .icon-fill {
            font-variation-settings: 'FILL' 1;
        }
        /* Dark mode smooth transition */
        html.dark *, html:not(.dark) * {
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.15s ease;
        }
        /* Custom scrollbar for dark mode */
        html.dark ::-webkit-scrollbar-track { background: #12131e; }
        html.dark ::-webkit-scrollbar-thumb { background: #3a3d54; border-radius: 4px; }
        html.dark ::-webkit-scrollbar { width: 6px; }

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
        html.dark .text-outline                 { color: #636885 !important; }
        html.dark .text-primary                 { color: #b4c5ff !important; }
        html.dark .text-secondary               { color: #68dba9 !important; }
        html.dark .text-tertiary                { color: #ff8a80 !important; }

        /* Teks umum di dalam tabel / konten */
        html.dark p, html.dark span,
        html.dark td, html.dark th,
        html.dark li, html.dark label          { color: inherit; }

        /* ----- BORDERS ----- */
        html.dark .border-outline-variant       { border-color: #33374f !important; }
        html.dark .border-outline               { border-color: #4a4e6a !important; }
        html.dark .border-secondary-fixed       { border-color: #1a6b4a !important; }

        /* ----- HOVER STATES ----- */
        html.dark .hover\:bg-surface-container-high:hover { background-color: #2d3050 !important; }
        html.dark .hover\:bg-surface-container-lowest:hover { background-color: #252840 !important; }

        /* ----- INPUT & FORM ----- */
        html.dark input, html.dark select, html.dark textarea {
            background-color: #252840 !important;
            border-color: #33374f !important;
            color: #e2e4f0 !important;
        }
        html.dark input::placeholder,
        html.dark textarea::placeholder         { color: #5a5e7a !important; }
        html.dark input:focus, html.dark select:focus,
        html.dark textarea:focus                { border-color: #b4c5ff !important; }

        /* ----- MODALS & DROPDOWNS ----- */
        html.dark [class*="modal"],
        html.dark [class*="dropdown-menu"]      { background-color: #1a1c2e !important; border-color: #33374f !important; }

        /* ----- BADGES ----- */
        /* Success badge */
        html.dark .bg-secondary-container\/30  { background-color: rgba(10, 59, 40, 0.5) !important; }
        /* Error/red badge */
        html.dark .bg-error-container           { background-color: #3b0d0d !important; }
        html.dark .text-error                   { color: #ff7070 !important; }
        html.dark .bg-error-container\/30       { background-color: rgba(59, 13, 13, 0.5) !important; }

        /* Amber / warning */
        html.dark .bg-amber-100                 { background-color: #3b2a05 !important; }
        html.dark .text-amber-800               { color: #fbbf24 !important; }
        html.dark .bg-amber-500\/10             { background-color: rgba(59, 42, 5, 0.5) !important; }
        html.dark .text-amber-600               { color: #fbbf24 !important; }

        /* ----- MISC UTILITY ----- */
        html.dark .shadow-sm                    { box-shadow: 0 1px 2px rgba(0,0,0,0.6) !important; }
        html.dark .shadow-md                    { box-shadow: 0 4px 12px rgba(0,0,0,0.5) !important; }
    </style>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary": "#ffffff",
                        "on-surface-variant": "#434655",
                        "on-primary-fixed-variant": "#003ea8",
                        "inverse-on-surface": "#edf1f5",
                        "primary-fixed": "#dbe1ff",
                        "surface-dim": "#d6dade",
                        "surface-container-highest": "#dfe3e7",
                        "outline": "#737686",
                        "outline-variant": "#c3c6d7",
                        "on-error-container": "#93000a",
                        "surface-variant": "#dfe3e7",
                        "on-primary-container": "#eeefff",
                        "background": "#f6fafe",
                        "on-primary": "#ffffff",
                        "on-secondary-container": "#00714e",
                        "on-tertiary-container": "#ffecea",
                        "primary-fixed-dim": "#b4c5ff",
                        "primary": "#004ac6",
                        "on-background": "#171c1f",
                        "tertiary-fixed-dim": "#ffb4ab",
                        "tertiary-fixed": "#ffdad6",
                        "surface-container-low": "#f0f4f8",
                        "on-secondary-fixed": "#002114",
                        "secondary-fixed": "#85f8c4",
                        "surface-tint": "#0053db",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#171c1f",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "on-secondary-fixed-variant": "#005137",
                        "inverse-surface": "#2c3134",
                        "error-container": "#ffdad6",
                        "on-primary-fixed": "#00174b",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-fixed": "#410002",
                        "surface-bright": "#f6fafe",
                        "surface-container": "#eaeef2",
                        "secondary": "#006c4a",
                        "surface-container-high": "#e4e9ed",
                        "primary-container": "#2563eb",
                        "secondary-fixed-dim": "#68dba9",
                        "inverse-primary": "#b4c5ff",
                        "surface": "#f6fafe",
                        "secondary-container": "#82f5c1",
                        "tertiary-container": "#d52022",
                        "on-tertiary-fixed-variant": "#93000b",
                        "tertiary": "#ae0010",
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
                        "full": "9999px",
                        "2xl": "1rem"
                    },
                    "spacing": {
                        "sidebar-width": "16rem",
                        "topbar-height": "4rem",
                        "container-padding": "1.25rem",
                        "stack-gap": "0.75rem",
                        "gutter": "1rem"
                    },
                    "fontFamily": {
                        "label-sm": ["Inter"],
                        "label-xs": ["Inter"],
                        "body-base": ["Inter"],
                        "label-md": ["Inter"],
                        "display": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-sm": ["Inter"],
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"]
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background dark:bg-dark-surface text-on-background dark:text-dark-on-surface font-body-base antialiased flex min-h-screen">
    <!-- SideNavBar -->
    <aside class="w-sidebar-width h-screen sticky top-0 left-0 bg-surface-container-lowest dark:bg-dark-surface-container shadow-sm flex flex-col py-6 px-4 gap-stack-gap z-50">
        <!-- Brand -->
        <div class="flex items-center gap-3 mb-4 px-2">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-on-primary font-display font-bold">RA</div>
            <div>
                <h1 class="font-display text-label-md font-bold text-primary">Ruang Administrasi</h1>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Panel Pimpinan</p>
            </div>
        </div>
        
        <!-- Navigation Tabs -->
        <nav class="flex-1 flex flex-col gap-1">
            <!-- Active Tab: Dashboard -->
            <a href="{{ route('ceo.dashboard') }}" class="{{ request()->routeIs('ceo.dashboard') ? 'flex items-center gap-3 px-3 py-2 bg-primary-container text-on-primary-container rounded-xl font-semibold active:scale-95 transition-transform' : 'flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-xl active:scale-95 transition-transform' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('ceo.dashboard') ? 'icon-fill' : '' }}">dashboard</span>
                <span class="font-label-md text-label-md">Dasbor</span>
            </a>
            <a href="{{ url('ceo/letter-approvals') }}" class="{{ request()->is('ceo/letter-approvals*') ? 'flex items-center gap-3 px-3 py-2 bg-primary-container text-on-primary-container rounded-xl font-semibold active:scale-95 transition-transform' : 'flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-xl active:scale-95 transition-transform' }}">
                <span class="material-symbols-outlined {{ request()->is('ceo/letter-approvals*') ? 'icon-fill' : '' }}">fact_check</span>
                <span class="font-label-md text-label-md">Persetujuan Surat</span>
            </a>
            <a href="{{ url('ceo/incoming-letters') }}" class="{{ request()->is('ceo/incoming-letters*') ? 'flex items-center gap-3 px-3 py-2 bg-primary-container text-on-primary-container rounded-xl font-semibold active:scale-95 transition-transform' : 'flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-xl active:scale-95 transition-transform' }}">
                <span class="material-symbols-outlined {{ request()->is('ceo/incoming-letters*') ? 'icon-fill' : '' }}">inbox</span>
                <span class="font-label-md text-label-md">Surat Masuk</span>
            </a>
            <a href="{{ url('ceo/outgoing-letters') }}" class="{{ request()->is('ceo/outgoing-letters*') ? 'flex items-center gap-3 px-3 py-2 bg-primary-container text-on-primary-container rounded-xl font-semibold active:scale-95 transition-transform' : 'flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-xl active:scale-95 transition-transform' }}">
                <span class="material-symbols-outlined {{ request()->is('ceo/outgoing-letters*') ? 'icon-fill' : '' }}">send</span>
                <span class="font-label-md text-label-md">Surat Keluar</span>
            </a>
            <a href="{{ url('ceo/employees') }}" class="{{ request()->is('ceo/employees*') ? 'flex items-center gap-3 px-3 py-2 bg-primary-container text-on-primary-container rounded-xl font-semibold active:scale-95 transition-transform' : 'flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high transition-colors rounded-xl active:scale-95 transition-transform' }}">
                <span class="material-symbols-outlined {{ request()->is('ceo/employees*') ? 'icon-fill' : '' }}">group</span>
                <span class="font-label-md text-label-md">Karyawan</span>
            </a>
        </nav>
        
        <!-- Footer / Profile -->
        <div class="mt-auto flex flex-col gap-2 pt-4 border-t border-outline-variant dark:border-dark-outline-variant">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-colors cursor-pointer">
                @if(Auth::user()->employee && Auth::user()->employee->photo)
                    <img alt="Profil Pengguna" class="w-8 h-8 rounded-full border border-outline-variant dark:border-dark-outline-variant object-cover" src="{{ asset('storage/' . Auth::user()->employee->photo) }}">
                @else
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-xs uppercase">
                        {{ substr(auth()->user()->employee->name ?? 'CEO', 0, 2) }}
                    </div>
                @endif
                <div class="flex flex-col">
                    <span class="font-label-md text-label-md text-on-surface">{{ auth()->user()->employee->name ?? auth()->user()->nip }}</span>
                    <span class="font-label-xs text-label-xs capitalize">{{ auth()->user()->role ?? 'Pimpinan' }}</span>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2 text-error hover:bg-error-container hover:text-on-error-container rounded-xl transition-colors text-left w-full">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-label-md text-label-md">Keluar</span>
                </button>
            </form>
        </div>
    </aside>
    
    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- TopNavBar -->
        <header class="sticky top-0 w-full h-topbar-height z-40 bg-surface/80 dark:bg-dark-surface-container/80 backdrop-blur-md border-b border-outline-variant dark:border-dark-outline-variant flex justify-between items-center px-container-padding">
            <div class="flex items-center">
                <div class="relative w-64 hidden md:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-sm text-body-sm focus:border-primary focus:ring-4 focus:ring-primary-fixed-dim focus:outline-none transition-all placeholder:text-outline" placeholder="Cari surat atau dokumen..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-4 text-on-surface-variant dark:text-dark-on-surface-variant">
                <div class="relative">
                    <button id="notification-btn" class="p-2 hover:bg-surface-container-high dark:hover:bg-dark-surface-container-high rounded-full transition-colors active:opacity-80 hover:text-primary relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-error rounded-full"></span>
                    </button>
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-surface dark:bg-dark-surface border border-outline-variant/30 rounded-xl shadow-md py-2 z-50">
                        <div class="px-4 py-3 border-b border-outline-variant/30">
                            <h3 class="font-label-md text-label-md text-on-surface font-bold">Notifikasi</h3>
                        </div>
                        <div class="px-4 py-8 text-center text-on-surface-variant font-body-sm">
                            <span class="material-symbols-outlined text-[32px] opacity-50 mb-2">notifications_off</span>
                            <p>Belum ada notifikasi baru.</p>
                        </div>
                    </div>
                </div>
                <!-- Dark Mode Toggle -->
                <button id="dark-mode-toggle" onclick="toggleDarkMode()"
                    class="p-2 hover:bg-surface-container-high dark:hover:bg-dark-surface-container-high rounded-full transition-colors active:opacity-80"
                    title="Toggle Dark Mode">
                    <span id="dark-icon" class="material-symbols-outlined hidden">light_mode</span>
                    <span id="light-icon" class="material-symbols-outlined">dark_mode</span>
                </button>
                <a href="{{ route('profile.edit') }}" class="ml-2 hover:opacity-90 transition-opacity" title="Profil Saya">
                    @if(Auth::user()->employee && Auth::user()->employee->photo)
                        <img alt="Profil Pengguna" class="w-9 h-9 rounded-full border border-outline-variant dark:border-dark-outline-variant object-cover" src="{{ asset('storage/' . Auth::user()->employee->photo) }}">
                    @else
                        <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold uppercase">
                            {{ substr(auth()->user()->employee->name ?? 'C', 0, 1) }}
                        </div>
                    @endif
                </a>
            </div>
        </header>
        
        <!-- Main Canvas -->
        <main class="flex-1 p-container-padding flex flex-col gap-6">
            @if(session('success'))
                <div class="bg-secondary-container text-on-secondary-container p-4 rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined icon-fill">check_circle</span>
                    <p class="font-body-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-error-container text-on-error-container p-4 rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined icon-fill">error</span>
                    <p class="font-body-sm">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Content Area -->
            @yield('content')
        </main>
    </div>
    
    @vite('resources/js/bootstrap-bundle.js')
    
    <!-- Alpine.js (if used) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
            
            // Notification toggle
            const notifBtn = document.getElementById('notification-btn');
            const notifDropdown = document.getElementById('notification-dropdown');
            
            if (notifBtn && notifDropdown) {
                notifBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                });
                
                document.addEventListener('click', function(e) {
                    if (!notifDropdown.contains(e.target)) {
                        notifDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>

