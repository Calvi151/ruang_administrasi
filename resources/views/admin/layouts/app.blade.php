<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title', 'Ruang Administrasi - Dashboard')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Tailwind Config -->
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "on-primary-fixed-variant": "#003ea8",
                    "surface-bright": "#f8f9ff",
                    "on-tertiary-fixed": "#360f00",
                    "status-lilac": "#f5f3ff",
                    "on-background": "#0b1c30",
                    "background": "#f8f9ff",
                    "on-error": "#ffffff",
                    "primary-fixed": "#dbe1ff",
                    "inverse-surface": "#213145",
                    "primary-fixed-dim": "#b4c5ff",
                    "background-pristine": "#ffffff",
                    "secondary": "#006a61",
                    "primary-container": "#2563eb",
                    "tertiary-fixed": "#ffdbcd",
                    "surface-container": "#e5eeff",
                    "heading-slate": "#0f172a",
                    "on-primary": "#ffffff",
                    "tertiary-container": "#bc4800",
                    "inverse-primary": "#b4c5ff",
                    "status-peach": "#fff7ed",
                    "on-primary-container": "#eeefff",
                    "on-secondary-fixed": "#00201d",
                    "surface-variant": "#d3e4fe",
                    "on-tertiary": "#ffffff",
                    "surface-dim": "#cbdbf5",
                    "secondary-container": "#86f2e4",
                    "on-tertiary-container": "#ffede6",
                    "on-primary-fixed": "#00174b",
                    "error-container": "#ffdad6",
                    "error": "#ba1a1a",
                    "on-surface-variant": "#434655",
                    "surface-container-lowest": "#ffffff",
                    "tertiary-fixed-dim": "#ffb596",
                    "outline-variant": "#c3c6d7",
                    "on-secondary": "#ffffff",
                    "surface-tint": "#0053db",
                    "outline": "#737686",
                    "status-mint": "#ecfdf5",
                    "secondary-fixed-dim": "#6bd8cb",
                    "inverse-on-surface": "#eaf1ff",
                    "on-error-container": "#93000a",
                    "on-surface": "#0b1c30",
                    "on-secondary-fixed-variant": "#005049",
                    "on-tertiary-fixed-variant": "#7d2d00",
                    "border-muted": "#f1f5f9",
                    "surface-container-high": "#dce9ff",
                    "secondary-fixed": "#89f5e7",
                    "tertiary": "#943700",
                    "surface-container-low": "#eff4ff",
                    "surface-container-highest": "#d3e4fe",
                    "surface": "#f8f9ff",
                    "primary": "#004ac6",
                    "on-secondary-container": "#006f66"
            },
            "borderRadius": {
                    "DEFAULT": "0.75rem",
                    "lg": "1rem",
                    "xl": "1.5rem",
                    "full": "9999px"
            },
            "spacing": {
                    "gutter": "24px",
                    "unit": "8px",
                    "margin-mobile": "16px",
                    "margin-desktop": "40px",
                    "container-max": "1440px",
                    "macro-padding": "32px"
            },
            "fontFamily": {
                    "body-md": ["Plus Jakarta Sans"],
                    "label-sm": ["Plus Jakarta Sans"],
                    "headline-xl": ["Plus Jakarta Sans"],
                    "body-lg": ["Plus Jakarta Sans"],
                    "label-md": ["Plus Jakarta Sans"],
                    "headline-md": ["Plus Jakarta Sans"],
                    "headline-xl-mobile": ["Plus Jakarta Sans"],
                    "headline-lg": ["Plus Jakarta Sans"]
            },
            "fontSize": {
                    "body-md": ["14px", {"lineHeight": "22px", "fontWeight": "400"}],
                    "label-sm": ["11px", {"lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "500"}],
                    "headline-xl": ["36px", {"lineHeight": "44px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-lg": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "label-md": ["13px", {"lineHeight": "18px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                    "headline-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
                    "headline-xl-mobile": ["28px", {"lineHeight": "36px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-lg": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "700"}]
            }
          }
        }
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Custom Ambient Shadow for ultra-premium feel */
        .ambient-shadow {
            box-shadow: 0 8px 30px rgba(0, 74, 198, 0.04), 0 2px 10px rgba(0, 0, 0, 0.02);
        }
    </style>
    @yield('styles')
</head>
<body class="bg-background font-body-md text-body-md text-on-background min-h-screen flex selection:bg-primary-fixed selection:text-on-primary-fixed">
    
    <!-- SideNavBar -->
    <nav class="w-64 h-full fixed left-0 top-0 border-r border-border-muted bg-background-pristine flex flex-col py-macro-padding z-50">
        <!-- Brand Header -->
        <div class="px-2 mb-10 flex items-center gap-4">
            <div class="w-8 h-8 rounded-2xl bg-gradient-to-br from-primary to-secondary-container flex items-center justify-center shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-on-primary icon-fill text-[14px]">dashboard_customize</span>
            </div>
            <div>
                <h1 class="font-headline-md text-headline-md font-bold text-on-background tracking-tight">Ruang Administrasi</h1>
                <p class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest mt-0.5" style="font-size: 9px;">Management Suite</p>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <div class="flex-1 overflow-y-auto flex flex-col gap-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-secondary-container text-on-secondary-container rounded-full px-2 py-1 mx-2 flex items-center gap-4 transition-transform scale-95 active:scale-90 group relative font-label-md text-label-md' : 'text-on-surface-variant font-label-md text-label-md px-2 py-1 mx-2 rounded-full hover:bg-surface-variant transition-colors flex items-center gap-4 group' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'icon-fill' : 'group-hover:text-primary transition-colors' }}">dashboard</span>
                Dashboard
                @if(request()->routeIs('admin.dashboard'))
                    <div class="absolute right-4 w-2 h-2 rounded-full bg-primary-container shadow-[0_0_8px_rgba(37,99,235,0.6)]"></div>
                @endif
            </a>
            
            <a href="{{ route('incoming-letters.index') }}" class="{{ request()->routeIs('incoming-letters.*') ? 'bg-secondary-container text-on-secondary-container rounded-full px-2 py-1 mx-2 flex items-center gap-4 transition-transform scale-95 active:scale-90 group relative font-label-md text-label-md' : 'text-on-surface-variant font-label-md text-label-md px-2 py-1 mx-2 rounded-full hover:bg-surface-variant transition-colors flex items-center gap-4 group' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('incoming-letters.*') ? 'icon-fill' : 'group-hover:text-primary transition-colors' }}">inbox</span>
                Surat Masuk
                @if(request()->routeIs('incoming-letters.*'))
                    <div class="absolute right-4 w-2 h-2 rounded-full bg-primary-container shadow-[0_0_8px_rgba(37,99,235,0.6)]"></div>
                @endif
            </a>
            
            <a href="{{ route('outgoing-letters.index') }}" class="{{ request()->routeIs('outgoing-letters.*') ? 'bg-secondary-container text-on-secondary-container rounded-full px-2 py-1 mx-2 flex items-center gap-4 transition-transform scale-95 active:scale-90 group relative font-label-md text-label-md' : 'text-on-surface-variant font-label-md text-label-md px-2 py-1 mx-2 rounded-full hover:bg-surface-variant transition-colors flex items-center gap-4 group' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('outgoing-letters.*') ? 'icon-fill' : 'group-hover:text-primary transition-colors' }}">send</span>
                Surat Keluar
                @if(request()->routeIs('outgoing-letters.*'))
                    <div class="absolute right-4 w-2 h-2 rounded-full bg-primary-container shadow-[0_0_8px_rgba(37,99,235,0.6)]"></div>
                @endif
            </a>
            
            <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'bg-secondary-container text-on-secondary-container rounded-full px-2 py-1 mx-2 flex items-center gap-4 transition-transform scale-95 active:scale-90 group relative font-label-md text-label-md' : 'text-on-surface-variant font-label-md text-label-md px-2 py-1 mx-2 rounded-full hover:bg-surface-variant transition-colors flex items-center gap-4 group' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('employees.*') ? 'icon-fill' : 'group-hover:text-primary transition-colors' }}">badge</span>
                Karyawan
                @if(request()->routeIs('employees.*'))
                    <div class="absolute right-4 w-2 h-2 rounded-full bg-primary-container shadow-[0_0_8px_rgba(37,99,235,0.6)]"></div>
                @endif
            </a>
            
            <a href="{{ route('letter-types.index') }}" class="{{ request()->routeIs('letter-types.*') ? 'bg-secondary-container text-on-secondary-container rounded-full px-2 py-1 mx-2 flex items-center gap-4 transition-transform scale-95 active:scale-90 group relative font-label-md text-label-md' : 'text-on-surface-variant font-label-md text-label-md px-2 py-1 mx-2 rounded-full hover:bg-surface-variant transition-colors flex items-center gap-4 group' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('letter-types.*') ? 'icon-fill' : 'group-hover:text-primary transition-colors' }}">description</span>
                Jenis Surat
                @if(request()->routeIs('letter-types.*'))
                    <div class="absolute right-4 w-2 h-2 rounded-full bg-primary-container shadow-[0_0_8px_rgba(37,99,235,0.6)]"></div>
                @endif
            </a>
        </div>
        
        <!-- CTA & Footer -->
        <div class="px-2 mt-4 flex flex-col gap-4">
            <a href="{{ route('incoming-letters.create') }}" class="w-full bg-primary text-on-primary font-label-md text-label-md py-1 rounded-full hover:shadow-lg hover:shadow-primary/20 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-4">
                <span class="material-symbols-outlined text-sm">add</span>
                Entri Surat
            </a>
            <div class="h-px bg-border-muted w-full my-2"></div>
            
            <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                @csrf
                <button type="submit" class="w-full text-on-surface-variant font-label-md text-label-md px-2 py-1 rounded-2xl hover:bg-error-container hover:text-error transition-colors flex items-center gap-4">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </nav>
    
    <!-- Main Content Canvas -->
    <main class="flex-1 pl-64 flex flex-col min-h-screen">
        <!-- TopAppBar -->
        <header class="docked full-width top-0 sticky z-40 bg-background/80 backdrop-blur-md flex justify-between items-center px-margin-desktop py-unit border-b border-transparent transition-all duration-300 mt-2">
            <!-- Left: Page Context -->
            <div class="flex flex-col">
                <h2 class="font-headline-lg text-headline-lg font-bold text-on-background tracking-tight">@yield('page-title')</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">@yield('page-subtitle')</p>
            </div>
            <!-- Right: Actions & Profile -->
            <div class="flex items-center gap-4">
                <!-- Data Pills -->
                <div class="hidden lg:flex items-center gap-4">
                    <button class="bg-surface-container-lowest border border-border-muted px-2 py-1 rounded-full font-label-sm text-label-sm text-on-surface hover:bg-surface-variant/50 transition-all flex items-center gap-4">
                        <span class="material-symbols-outlined text-[14px]">calendar_month</span>
                        {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}
                    </button>
                    <div class="bg-primary-fixed text-on-primary-fixed-variant px-2 py-1 rounded-full font-label-sm text-label-sm flex items-center gap-4 font-bold">
                        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </div>
                </div>
                <div class="w-px h-8 bg-border-muted hidden md:block"></div>
                <!-- Profile -->
                <button class="focus-within:ring-2 focus-within:ring-primary/20 rounded-full transition-all flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <div class="font-label-md text-label-md text-on-background">{{ Auth::user()->name }}</div>
                        <div class="font-label-sm text-label-sm text-on-surface-variant uppercase">{{ Auth::user()->role }}</div>
                    </div>
                    @if(Auth::user()->photo)
                        <img alt="User profile" class="w-7 h-7 rounded-full object-cover border-2 border-surface-container-lowest shadow-sm" src="{{ asset('storage/' . Auth::user()->photo) }}">
                    @else
                        <div class="w-7 h-7 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold text-sm border-2 border-surface-container-lowest shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                </button>
            </div>
        </header>
        
        <!-- Page Content -->
        <div class="p-margin-desktop pt-4 max-w-container-max w-full flex flex-col gap-macro-padding">
            @if(session('success'))
            <div class="bg-status-mint text-secondary border border-secondary-fixed px-2 py-1 rounded-3xl font-label-md text-label-md mb-4 flex items-center gap-4">
                <span class="material-symbols-outlined icon-fill">check_circle</span>
                {{ session('success') }}
            </div>
            @endif

            @yield('content')
        </div>
    </main>
    
    @yield('scripts')
</body>
</html>







