<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Ruang Administrasi - Dashboard Pimpinan')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
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
                        "tertiary": "#ae0010"
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
<body class="bg-background text-on-background font-body-base antialiased flex min-h-screen">
    <!-- SideNavBar -->
    <aside class="w-sidebar-width h-screen sticky top-0 left-0 bg-surface-container-lowest shadow-sm flex flex-col py-6 px-4 gap-stack-gap z-50">
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
        <div class="mt-auto flex flex-col gap-2 pt-4 border-t border-outline-variant">
            <div class="flex items-center gap-3 px-3 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-colors cursor-pointer">
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-xs uppercase">
                    {{ substr(auth()->user()->nip ?? 'CEO', 0, 2) }}
                </div>
                <div class="flex flex-col">
                    <span class="font-label-md text-label-md text-on-surface">{{ auth()->user()->nip ?? 'CEO' }}</span>
                    <span class="font-label-xs text-label-xs capitalize">{{ auth()->user()->role ?? 'Pimpinan' }}</span>
                </div>
            </div>
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
        <header class="sticky top-0 w-full h-topbar-height z-40 bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center px-container-padding">
            <div class="flex items-center">
                <div class="relative w-64 hidden md:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-xl font-body-sm text-body-sm focus:border-primary focus:ring-4 focus:ring-primary-fixed-dim focus:outline-none transition-all placeholder:text-outline" placeholder="Cari surat atau dokumen..." type="text"/>
                </div>
            </div>
            <div class="flex items-center gap-4 text-on-surface-variant">
                <button class="p-2 hover:bg-surface-container-high rounded-full transition-colors active:opacity-80 hover:text-primary relative">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-error rounded-full"></span>
                </button>
                <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-white text-xs font-bold uppercase ml-2 block md:hidden">
                    {{ substr(auth()->user()->nip ?? 'C', 0, 1) }}
                </div>
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
</body>
</html>

