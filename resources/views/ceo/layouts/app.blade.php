<!DOCTYPE html>
<html lang="id" id="html-root">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Ruang Administrasi - Panel Pimpinan')</title>
    
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
    
    <!-- Google Fonts: Source Serif 4 & Hanken Grotesk & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <style>
        body { background-color: #FAF8F3; }
        html.dark body { background-color: #0B1220 !important; }
        .shadow-ambient { box-shadow: 0px 4px 20px rgba(15, 27, 61, 0.05); }
        html.dark .shadow-ambient { box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.4); }
        .shadow-ambient-hover:hover { box-shadow: 0px 8px 30px rgba(15, 27, 61, 0.1); transform: translateY(-2px); transition: all 0.2s ease; }
        html.dark .shadow-ambient-hover:hover { box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.6); }
        
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
        .icon-fill { font-variation-settings: 'FILL' 1; }

        /* Dark Mode overrides for main view content */
        html.dark .bg-surface, html.dark .bg-white { background-color: #141C33 !important; }
        html.dark .bg-surface-bright, html.dark .bg-surface-container-lowest { background-color: #1A2440 !important; }
        html.dark .bg-surface-container, html.dark .bg-surface-container-low { background-color: #0F172E !important; }
        html.dark .text-on-surface { color: #E8E6E0 !important; }
        html.dark .text-on-surface-variant { color: #9CA3AF !important; }
        html.dark .border-outline-variant\/30, html.dark .border-outline-variant, html.dark .border-outline-variant\/50, html.dark .border-outline-variant\/20 { border-color: #2A3654 !important; }
        
        /* Form inputs in dark mode */
        html.dark input[type="text"], html.dark select {
            background-color: #0F172E !important;
            border-color: #2A3654 !important;
            color: #E8E6E0 !important;
        }
        html.dark input[type="text"]::placeholder {
            color: #64748B !important;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f5f3ee; }
        ::-webkit-scrollbar-thumb { background: #c6c6cf; border-radius: 4px; }
        html.dark ::-webkit-scrollbar-track { background: #0B1220; }
        html.dark ::-webkit-scrollbar-thumb { background: #2A3654; }
    </style>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary": "#040200",
                        "surface-container-low": "#f5f3ee",
                        "on-tertiary-container": "#ab7d1c",
                        "primary-fixed-dim": "#bac5f0",
                        "inverse-primary": "#bac5f0",
                        "inverse-surface": "#30312e",
                        "outline-variant": "#c6c6cf",
                        "on-secondary-container": "#755100",
                        "surface-container-high": "#eae8e3",
                        "tertiary-container": "#291a00",
                        "error-container": "#ffdad6",
                        "on-background": "#1b1c19",
                        "inverse-on-surface": "#f2f1ec",
                        "secondary-container": "#ffc55f",
                        "on-error-container": "#93000a",
                        "surface-bright": "#fbf9f4",
                        "on-secondary-fixed-variant": "#5f4100",
                        "tertiary-fixed": "#ffdea9",
                        "surface": "#fbf9f4",
                        "on-tertiary-fixed": "#271900",
                        "on-surface-variant": "#45464e",
                        "primary": "#000210",
                        "secondary": "#7d5700",
                        "surface-tint": "#525d83",
                        "on-primary-fixed": "#0d1a3c",
                        "on-primary-container": "#7984ab",
                        "outline": "#76767f",
                        "on-primary-fixed-variant": "#3a4569",
                        "surface-container": "#f0eee9",
                        "primary-fixed": "#dbe1ff",
                        "on-error": "#ffffff",
                        "on-secondary-fixed": "#271900",
                        "surface-container-highest": "#e4e2dd",
                        "secondary-fixed": "#ffdeaa",
                        "on-surface": "#1b1c19",
                        "surface-variant": "#e4e2dd",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed-dim": "#f5bd58",
                        "on-secondary": "#ffffff",
                        "on-primary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "primary-container": "#0f1b3d",
                        "surface-dim": "#dbdad5",
                        "error": "#ba1a1a",
                        "on-tertiary-fixed-variant": "#5f4100",
                        "tertiary-fixed-dim": "#f4be59",
                        "background": "#fbf9f4",
                        "brand-amber": "#D9A441",
                        "brand-navy": "#0F1B3D",
                        "ds-bg": "#0B1220",
                        "ds-surface": "#141C33",
                        "ds-sidebar": "#0F172E",
                        "ds-sidebar-active": "#1A2440",
                        "ds-text-primary": "#E8E6E0",
                        "ds-text-secondary": "#8B93A8",
                        "ds-accent": "#E5B04D",
                        "ds-border": "#2A3654",
                        "ds-hover": "#1D2847"
                    },
                    "spacing": {
                        "container-max": "1440px",
                        "stack-md": "16px",
                        "gutter": "24px",
                        "margin-desktop": "32px",
                        "stack-lg": "32px",
                        "margin-mobile": "16px",
                        "stack-sm": "8px"
                    },
                    "fontFamily": {
                        "headline-lg": ["\"Source Serif 4\"", "serif"],
                        "body-md": ["Hanken Grotesk", "sans-serif"],
                        "stat-number": ["\"Source Serif 4\"", "serif"],
                        "label-md": ["Hanken Grotesk", "sans-serif"],
                        "headline-lg-mobile": ["\"Source Serif 4\"", "serif"],
                        "headline-md": ["\"Source Serif 4\"", "serif"],
                        "display-lg": ["\"Source Serif 4\"", "serif"],
                        "body-lg": ["Hanken Grotesk", "sans-serif"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", { "lineHeight": "40px", "fontWeight": "600" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "stat-number": ["36px", { "lineHeight": "44px", "fontWeight": "700" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "600" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    @yield('styles')
</head>
<body class="font-body-md text-body-md text-on-surface antialiased flex h-screen overflow-hidden selection:bg-brand-amber/30">
    <!-- SideNavBar (Source of Truth untuk 5 halaman CEO) -->
    <nav class="hidden md:flex flex-col bg-brand-navy fixed left-0 top-0 h-screen w-[280px] py-stack-lg z-20 border-r border-white/5">
        <div class="px-6 mb-8">
            <h1 class="font-headline-md text-headline-md text-brand-amber font-bold leading-tight">Ruang Administrasi</h1>
            <p class="font-body-md text-xs text-white/70 mt-1">Panel Pimpinan</p>
        </div>
        
        <div class="flex-1 overflow-y-auto">
            <ul class="space-y-2">
                <!-- 1. Dashboard -->
                <li>
                    <a class="flex items-center gap-stack-md py-3 px-6 font-label-md text-label-md transition-all duration-200 border-l-4 {{ request()->routeIs('ceo.dashboard') ? 'text-white bg-white/10 border-brand-amber scale-[0.99]' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}" href="{{ route('ceo.dashboard') }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('ceo.dashboard') ? 'icon-fill' : '' }}">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <!-- 2. Persetujuan Surat -->
                <li>
                    <a class="flex items-center gap-stack-md py-3 px-6 font-label-md text-label-md transition-all duration-200 border-l-4 {{ request()->is('ceo/letter-approvals*') ? 'text-white bg-white/10 border-brand-amber scale-[0.99]' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}" href="{{ url('ceo/letter-approvals') }}">
                        <span class="material-symbols-outlined {{ request()->is('ceo/letter-approvals*') ? 'icon-fill' : '' }}">fact_check</span>
                        Persetujuan Surat
                    </a>
                </li>
                <!-- 3. Surat Masuk -->
                <li>
                    <a class="flex items-center gap-stack-md py-3 px-6 font-label-md text-label-md transition-all duration-200 border-l-4 {{ request()->is('ceo/incoming-letters*') ? 'text-white bg-white/10 border-brand-amber scale-[0.99]' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}" href="{{ url('ceo/incoming-letters') }}">
                        <span class="material-symbols-outlined {{ request()->is('ceo/incoming-letters*') ? 'icon-fill' : '' }}">move_to_inbox</span>
                        Surat Masuk
                    </a>
                </li>
                <!-- 4. Surat Keluar -->
                <li>
                    <a class="flex items-center gap-stack-md py-3 px-6 font-label-md text-label-md transition-all duration-200 border-l-4 {{ request()->is('ceo/outgoing-letters*') ? 'text-white bg-white/10 border-brand-amber scale-[0.99]' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}" href="{{ url('ceo/outgoing-letters') }}">
                        <span class="material-symbols-outlined {{ request()->is('ceo/outgoing-letters*') ? 'icon-fill' : '' }}">outbox</span>
                        Surat Keluar
                    </a>
                </li>
                <!-- 5. Karyawan -->
                <li>
                    <a class="flex items-center gap-stack-md py-3 px-6 font-label-md text-label-md transition-all duration-200 border-l-4 {{ request()->is('ceo/employees*') ? 'text-white bg-white/10 border-brand-amber scale-[0.99]' : 'text-white/70 hover:text-white hover:bg-white/5 border-transparent' }}" href="{{ url('ceo/employees') }}">
                        <span class="material-symbols-outlined {{ request()->is('ceo/employees*') ? 'icon-fill' : '' }}">group</span>
                        Karyawan
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Bagian bawah: Logout saja -->
        <div class="px-6 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-white/70 hover:text-white flex items-center gap-stack-md py-3 font-label-md text-label-md hover:bg-white/5 transition-all duration-200 rounded mt-2 border-t border-white/10 text-left">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </nav>
    
    <!-- Main Content Area -->
    <div class="flex-1 ml-0 md:ml-[280px] flex flex-col h-screen overflow-hidden">
        <!-- Header (Source of Truth untuk 5 halaman CEO) -->
        <header class="flex justify-between items-center w-full px-margin-desktop py-4 bg-surface dark:bg-[#141C33] shadow-sm z-10 sticky top-0 border-b border-outline-variant/30 dark:border-[#2A3654]">
            <div class="flex items-center gap-4 md:hidden">
                <button class="text-primary dark:text-ds-text-primary hover:text-secondary transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <h1 class="font-headline-md text-headline-md font-bold text-brand-amber">Ruang Administrasi</h1>
            </div>
            <div class="hidden md:block">
                <h2 class="font-headline-lg text-headline-lg text-on-surface dark:text-ds-text-primary">@yield('page-title', 'Dashboard Pimpinan')</h2>
                <p class="font-body-md text-body-md text-on-surface-variant dark:text-ds-text-secondary mt-1">@yield('page-subtitle', 'Selamat Datang, ' . (auth()->user()->employee->name ?? 'Bapak/Ibu Pimpinan'))</p>
            </div>
            <div class="flex items-center gap-6">
                <!-- Search bar di Header -->
                <div class="hidden xl:block relative w-72">
                    <form action="{{ url('/ceo/incoming-letters') }}" method="GET">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-ds-text-secondary text-[20px]">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari surat atau dokumen..." class="w-full pl-10 pr-4 py-2 bg-surface-container-low dark:bg-[#0F172E] border border-outline-variant/50 dark:border-[#2A3654] rounded-full text-xs font-body-md text-on-surface dark:text-[#E8E6E0] focus:border-brand-amber focus:ring-2 focus:ring-brand-amber/20 focus:outline-none transition-all placeholder:text-outline/70 dark:placeholder:text-[#8B93A8]">
                    </form>
                </div>
                <div class="hidden lg:flex items-center gap-2 text-on-surface-variant dark:text-ds-text-secondary font-body-md text-sm">
                    <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </div>
                <div class="flex items-center gap-3">
                    <!-- Theme Toggle -->
                    <button id="dark-mode-toggle" onclick="toggleDarkMode()" class="p-2 text-on-surface dark:text-ds-accent hover:text-brand-amber transition-colors opacity-80 hover:opacity-100 rounded-full hover:bg-surface-container" title="Toggle Theme">
                        <span id="dark-icon" class="material-symbols-outlined hidden">light_mode</span>
                        <span id="light-icon" class="material-symbols-outlined">dark_mode</span>
                    </button>
                    <!-- Notification Bell Icon -->
                    <div class="relative">
                        <button id="notification-btn" class="p-2 text-on-surface dark:text-ds-text-primary hover:text-brand-amber transition-colors opacity-80 hover:opacity-100 rounded-full hover:bg-surface-container relative">
                            <span class="material-symbols-outlined">notifications</span>
                            @php
                                $pendingCount = \App\Models\OutgoingLetter::where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-600 rounded-full animate-pulse"></span>
                            @endif
                        </button>
                        <!-- Notification Dropdown -->
                        <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-surface dark:bg-[#141C33] border border-outline-variant/30 dark:border-[#2A3654] rounded-xl shadow-lg py-2 z-50">
                            <div class="px-4 py-3 border-b border-outline-variant/30 dark:border-[#2A3654] flex justify-between items-center">
                                <h3 class="font-label-md text-sm font-bold text-on-surface dark:text-ds-text-primary">Notifikasi Surat</h3>
                                @if($pendingCount > 0)
                                    <span class="bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 text-[11px] font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }} Baru</span>
                                @endif
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                @if($pendingCount > 0)
                                    <a href="{{ url('ceo/letter-approvals') }}" class="block px-4 py-3 hover:bg-surface-container-low dark:hover:bg-[#1D2847] transition-colors border-b border-outline-variant/10">
                                        <div class="flex items-start gap-3">
                                            <div class="p-2 bg-brand-amber/20 text-brand-amber rounded-lg shrink-0">
                                                <span class="material-symbols-outlined text-[20px]">fact_check</span>
                                            </div>
                                            <div>
                                                <p class="font-label-md text-xs font-bold text-on-surface dark:text-ds-text-primary">Menunggu Persetujuan</p>
                                                <p class="font-body-md text-xs text-on-surface-variant dark:text-ds-text-secondary mt-0.5">Terdapat {{ $pendingCount }} surat keluar baru yang memerlukan tindakan Anda.</p>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <div class="px-4 py-6 text-center text-on-surface-variant dark:text-ds-text-secondary text-sm">
                                        <span class="material-symbols-outlined text-3xl opacity-50 block mx-auto mb-1">notifications_off</span>
                                        Belum ada surat menunggu persetujuan.
                                    </div>
                                @endif
                            </div>
                            <a href="{{ url('ceo/letter-approvals') }}" class="block text-center py-2 text-xs font-label-md text-brand-navy dark:text-brand-amber hover:underline">Lihat Semua Persetujuan</a>
                        </div>
                    </div>
                    <!-- Profile Avatar + Nama di Kanan Atas -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 hover:bg-surface-container dark:hover:bg-[#1D2847] p-1 rounded-full transition-colors pl-2">
                        @if(Auth::user()->employee && Auth::user()->employee->photo)
                            <img alt="Profile" class="w-8 h-8 rounded-full object-cover border border-outline-variant dark:border-[#2A3654]" src="{{ asset('storage/' . Auth::user()->employee->photo) }}">
                        @else
                            <div class="w-8 h-8 rounded-full bg-brand-navy dark:bg-brand-amber text-white dark:text-brand-navy font-bold text-xs flex items-center justify-center border border-outline-variant/30 uppercase">
                                {{ substr(auth()->user()->employee->name ?? 'C', 0, 1) }}
                            </div>
                        @endif
                        <div class="hidden xl:block text-left pr-2">
                            <div class="font-label-md text-xs text-on-surface dark:text-ds-text-primary leading-none font-semibold">{{ auth()->user()->employee->name ?? auth()->user()->nip ?? 'Bapak Direktur' }}</div>
                            <div class="font-body-md text-[10px] text-on-surface-variant dark:text-ds-text-secondary capitalize mt-0.5">{{ auth()->user()->role ?? 'Executive CEO' }}</div>
                        </div>
                    </a>
                </div>
            </div>
        </header>
        
        <!-- Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-margin-desktop bg-[#FAF8F3] dark:bg-[#0B1220]">
            <div class="max-w-container-max mx-auto space-y-stack-lg">
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900/40 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-300 p-4 rounded-xl flex items-center gap-3 shadow-sm">
                        <span class="material-symbols-outlined icon-fill">check_circle</span>
                        <p class="font-body-md text-sm font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-900/40 border border-red-300 dark:border-red-700 text-red-800 dark:text-red-300 p-4 rounded-xl flex items-center gap-3 shadow-sm">
                        <span class="material-symbols-outlined icon-fill">error</span>
                        <p class="font-body-md text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Dynamic Content Area -->
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Dark Mode & Notifications Script -->
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
                if (darkIcon) darkIcon.classList.remove('hidden');
                if (lightIcon) lightIcon.classList.add('hidden');
            } else {
                if (darkIcon) darkIcon.classList.add('hidden');
                if (lightIcon) lightIcon.classList.remove('hidden');
            }
        }

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

            // ADVANCED REAL-TIME LIVE SEARCH FOR CEO (AJAX + Instant DOM Filter, No Enter Required)
            const searchInputs = document.querySelectorAll('input[name="search"], input[placeholder*="Cari"], input[placeholder*="cari"]');
            searchInputs.forEach(input => {
                let debounceTimer;
                const form = input.closest('form');
                
                // Add status indicator inside input container
                const wrapper = input.parentElement;
                let statusBadge = document.createElement('span');
                statusBadge.className = 'absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-extrabold text-blue-600 dark:text-amber-400 bg-blue-500/10 dark:bg-amber-400/15 border border-blue-500/20 dark:border-amber-400/30 px-2 py-0.5 rounded-md hidden animate-pulse shadow-2xs z-10 pointer-events-none';
                statusBadge.innerHTML = '⚡ Mencari...';
                if (wrapper) {
                    wrapper.style.position = 'relative';
                    wrapper.appendChild(statusBadge);
                }

                input.addEventListener('input', function(e) {
                    const term = e.target.value.trim();
                    const table = document.querySelector('table');
                    const tbody = table ? table.querySelector('tbody') : null;
                    
                    // 1. Instant client-side visual filtering (0ms latency feedback)
                    if (tbody && term !== '') {
                        const termLow = term.toLowerCase();
                        tbody.querySelectorAll('tr:not(.no-results-placeholder)').forEach(row => {
                            if (row.querySelector('td[colspan]')) return;
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(termLow) ? '' : 'none';
                        });
                    } else if (tbody && term === '') {
                        tbody.querySelectorAll('tr').forEach(row => {
                            row.style.display = '';
                        });
                    }

                    // 2. Debounced background server search (Fetches exact relevant database records without page reload or Enter!)
                    if (form && (form.getAttribute('method') || 'GET').toUpperCase() === 'GET') {
                        clearTimeout(debounceTimer);
                        if (statusBadge) statusBadge.classList.remove('hidden');
                        
                        debounceTimer = setTimeout(() => {
                            const formData = new FormData(form);
                            const params = new URLSearchParams(formData);
                            const actionUrl = form.getAttribute('action') || window.location.pathname;
                            const fetchUrl = `${actionUrl}?${params.toString()}`;

                            fetch(fetchUrl, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'text/html'
                                }
                            })
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const newDoc = parser.parseFromString(html, 'text/html');
                                
                                // Swap table content smoothly with fresh database results
                                const currentTableContainer = document.querySelector('table')?.closest('.overflow-x-auto') || document.querySelector('table')?.parentElement;
                                const newTableContainer = newDoc.querySelector('table')?.closest('.overflow-x-auto') || newDoc.querySelector('table')?.parentElement;
                                
                                if (currentTableContainer && newTableContainer) {
                                    currentTableContainer.innerHTML = newTableContainer.innerHTML;
                                }
                                
                                // Update pagination & count totals if present
                                const currentPagination = document.querySelector('.pagination, nav[role="navigation"]')?.parentElement;
                                const newPagination = newDoc.querySelector('.pagination, nav[role="navigation"]')?.parentElement;
                                if (currentPagination && newPagination) {
                                    currentPagination.innerHTML = newPagination.innerHTML;
                                }
                                
                                // Seamlessly update URL without refreshing browser
                                window.history.replaceState(null, '', fetchUrl);
                            })
                            .catch(err => console.error('Live Search Error:', err))
                            .finally(() => {
                                if (statusBadge) statusBadge.classList.add('hidden');
                            });
                        }, 380); // 380ms debounce for ultra-smooth typing feeling
                    }
                });
                
                // Prevent double submissions or page reload if Enter is accidentally pressed
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(debounceTimer);
                        input.dispatchEvent(new Event('input'));
                    }
                });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
