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

        /* === Stat Cards Interactive Animations (Light & Dark Theme) === */
        .stat-card {
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s ease, border-color 0.3s ease, background-color 0.3s ease !important;
            will-change: transform, box-shadow;
            position: relative;
            overflow: hidden;
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 70%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(217, 164, 65, 0.15), transparent);
            transform: skewX(-25deg);
            transition: left 0.75s ease-in-out;
            pointer-events: none;
        }
        html.dark .stat-card::after {
            background: linear-gradient(90deg, transparent, rgba(229, 176, 77, 0.12), transparent);
        }
        .stat-card:hover::after {
            left: 150%;
        }
        .stat-card:hover {
            transform: translateY(-6px) scale(1.02);
            border-color: #D9A441 !important;
            box-shadow: 0 14px 28px -6px rgba(15, 27, 61, 0.12), 0 4px 14px -2px rgba(217, 164, 65, 0.2) !important;
        }
        html.dark .stat-card:hover {
            border-color: #E5B04D !important;
            box-shadow: 0 16px 32px -6px rgba(0, 0, 0, 0.65), 0 0 24px rgba(229, 176, 77, 0.22) !important;
        }
        .stat-card .stat-icon {
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), color 0.3s ease;
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.28) rotate(8deg);
            color: #D9A441 !important;
        }
        html.dark .stat-card:hover .stat-icon {
            color: #E5B04D !important;
        }
        .stat-card .stat-number {
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), color 0.3s ease;
            display: inline-block;
        }
        .stat-card:hover .stat-number {
            transform: scale(1.08);
            color: #D9A441 !important;
        }
        html.dark .stat-card:hover .stat-number {
            color: #E5B04D !important;
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

        /* Dark mode surface & card background overrides */
        html.dark .bg-surface,
        html.dark .bg-white { background-color: #141C33 !important; }
        html.dark .bg-surface-bright,
        html.dark .bg-surface-container-lowest { background-color: #1A2440 !important; }
        html.dark .bg-surface-container,
        html.dark .bg-surface-container-low { background-color: #0F172E !important; }
        html.dark .text-on-surface,
        html.dark .text-on-background,
        html.dark .text-gray-800,
        html.dark .prose { color: #E8E6E0 !important; }
        html.dark .text-on-surface-variant { color: #9CA3AF !important; }
        html.dark .text-primary { color: #E5B04D !important; }
        html.dark .border-outline-variant,
        html.dark .border-outline-variant\/50,
        html.dark .border-outline-variant\/30,
        html.dark .border-outline-variant\/20,
        html.dark .border-border-muted,
        html.dark .border-border-muted\/50 { border-color: #2A3654 !important; }
        html.dark .bg-primary-container\/10 { background-color: rgba(229, 176, 77, 0.15) !important; }
        html.dark .bg-primary-fixed,
        html.dark .bg-primary-fixed\/20 { background-color: rgba(229, 176, 77, 0.15) !important; color: #E5B04D !important; }
        html.dark .border-primary-fixed-dim\/30 { border-color: rgba(229, 176, 77, 0.3) !important; }
        html.dark .border-dashed { border-color: #2A3654 !important; }
        html.dark .text-outline { color: #8B93A8 !important; }
        html.dark .text-outline\/30 { color: #5D6A85 !important; }

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
    
    <!-- Global Auto-Animation System -->
    <style>
        /* Native UI Modals Base Styles */
        .modal-overlay {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-out;
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .modal-content-box {
            transform: scale(0.95) translateY(10px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-overlay.active .modal-content-box {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slide-in {
            animation: slideInRight 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animasi untuk stat cards / glass-card / editorial-card
            const cards = document.querySelectorAll('.glass-card, .editorial-card, .bg-white.rounded-xl, .dark\\:bg-\\[\\#141C33\\].rounded-xl');
            let cardIndex = 1;
            cards.forEach(el => {
                if(!el.classList.contains('animate-fade-in')) {
                    el.classList.add('animate-fade-in');
                    if(!el.style.animationDelay) {
                        el.style.animationDelay = `${cardIndex * 100}ms`;
                        cardIndex++;
                    }
                }
            });
            
            // Animasi untuk baris tabel
            const rows = document.querySelectorAll('tbody tr, .interactive-row');
            let rowIndex = 0;
            rows.forEach(el => {
                if(!el.classList.contains('animate-slide-in')) {
                    el.classList.add('animate-slide-in');
                    if(!el.style.animationDelay) {
                        el.style.animationDelay = `${400 + (rowIndex * 50)}ms`;
                        rowIndex++;
                    }
                }
            });
        });
    </script>
</head>
<body class="bg-background dark:bg-ds-bg text-on-surface dark:text-ds-text-primary font-body-md min-h-screen flex antialiased items-stretch selection:bg-primary-fixed selection:text-on-primary-fixed">
    
    <!-- SideNavBar (Administrative Authority: dark navy, amber active, border-l-4) -->
    <nav class="w-sidebar_width h-screen fixed left-0 top-0 hidden md:flex flex-col bg-primary-container dark:bg-ds-sidebar border-r border-outline/10 dark:border-ds-border py-8 z-50">
        <div class="px-6 mb-12 flex items-center gap-3">
            <!-- Tempat Logo -->
            <div class="w-12 h-12 rounded-lg bg-[#ffffff] shrink-0 flex items-center justify-center p-1 border border-outline-variant/20 shadow-sm overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" alt="The Prime Logo" class="w-full h-full object-contain" onerror="this.src='https://ui-avatars.com/api/?name=PRIME&background=0D8ABC&color=fff&rounded=true&bold=true'">
            </div>
            <div>
                <h1 class="font-headline-md text-[20px] font-bold text-secondary-fixed-dim dark:text-ds-accent leading-tight">Ruang Administrasi</h1>
                <p class="font-body-sm text-xs text-on-primary-container dark:text-ds-text-secondary mt-0.5">Sistem Kelola Surat</p>
            </div>
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
            
            <a href="{{ route('attendances.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('attendances.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('attendances.*') ? 'fill-icon' : '' }}">assignment_ind</span>
                <span class="font-label-md text-label-md">Laporan Absensi</span>
            </a>
            
            <a href="{{ route('leave-requests.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('leave-requests.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('leave-requests.*') ? 'fill-icon' : '' }}">event_busy</span>
                <span class="font-label-md text-label-md">Pengajuan Cuti</span>
            </a>
            
            <a href="{{ route('overtime-requests.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('overtime-requests.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('overtime-requests.*') ? 'fill-icon' : '' }}">more_time</span>
                <span class="font-label-md text-label-md">Data Lembur</span>
            </a>
            
            <a href="{{ route('employees.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('employees.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('employees.*') ? 'fill-icon' : '' }}">group</span>
                <span class="font-label-md text-label-md">Karyawan</span>
            </a>
            
            <a href="{{ route('positions.index') }}" class="flex items-center gap-3 py-3 px-6 border-l-4 transition-colors duration-200 {{ request()->routeIs('positions.*') ? 'border-secondary dark:border-ds-accent text-secondary-fixed-dim dark:text-ds-accent font-semibold bg-primary/10 dark:bg-ds-sidebar-active' : 'border-transparent text-on-primary-container dark:text-[#94a3b8] hover:bg-primary/5 dark:hover:bg-ds-sidebar-active hover:text-on-primary dark:hover:text-ds-text-primary' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('positions.*') ? 'fill-icon' : '' }}">work</span>
                <span class="font-label-md text-label-md">Jabatan</span>
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
        <header class="w-full h-20 sticky top-0 z-50 bg-surface dark:bg-ds-bg border-b border-on-primary-container/10 dark:border-ds-border flex justify-between items-center px-margin-edge">
            <div class="flex items-center gap-6">
                <div class="hidden md:block">
                    <h1 class="font-headline-sm text-headline-sm font-bold text-primary dark:text-ds-text-primary">@yield('page-title', 'Ruang Administrasi')</h1>
                    <p class="font-body-sm text-xs text-on-surface-variant dark:text-ds-text-secondary mt-0.5">@yield('page-subtitle', 'Halo, ' . (auth()->user()->employee->name ?? 'Admin'))</p>
                </div>
                <!-- Search bar di Header -->
                <div class="hidden lg:block relative w-80 transition-all duration-300 focus-within:w-96">
                    <form action="{{ route('incoming-letters.index') }}" method="GET">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant dark:text-ds-text-secondary text-[18px]">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari surat atau dokumen..." class="w-full pl-10 pr-4 py-2 bg-surface-container-low dark:bg-ds-surface border border-outline-variant dark:border-ds-border rounded-full text-sm font-body-md text-on-surface dark:text-ds-text-primary focus:border-secondary dark:focus:border-ds-accent focus:outline-none transition-all placeholder:text-on-surface-variant/70 dark:placeholder:text-ds-text-secondary">
                    </form>
                </div>
            </div>
            <div class="flex items-center gap-3 lg:gap-4">
                <!-- Calendar Chip -->
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-surface-container-low dark:bg-[#0F172E] border border-outline-variant/60 dark:border-[#2A3654] rounded-xl text-sm font-medium text-on-surface-variant dark:text-[#8B93A8]">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d M Y') }}</span>
                </div>
                
                <!-- Dark Mode Toggle -->
                <button id="dark-mode-toggle" onclick="toggleDarkMode()"
                    class="p-2 flex items-center justify-center text-on-surface-variant dark:text-[#8B93A8] hover:text-primary dark:hover:text-white transition-colors"
                    title="Toggle Dark Mode">
                    <span id="dark-icon" class="material-symbols-outlined hidden">light_mode</span>
                    <span id="light-icon" class="material-symbols-outlined">dark_mode</span>
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
                    <button id="notification-btn" class="p-2 flex items-center justify-center text-on-surface-variant dark:text-[#8B93A8] hover:text-primary dark:hover:text-white transition-colors relative">
                        <span class="material-symbols-outlined">notifications</span>
                        @if($hasNotif)
                            <span id="notif-badge" data-time="{{ $latestNotifTime }}" class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                        @endif
                    </button>
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-[#141C33] border border-outline-variant/50 dark:border-[#2A3654] rounded-xl shadow-2xl py-2 z-[100]">
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
                
                <!-- Separator -->
                <div class="h-6 w-px bg-outline-variant/50 dark:bg-[#2A3654] mx-1"></div>
                
                <!-- Profile Squircle Avatar -->
                <a href="{{ route('profile.edit') }}" title="Profil Saya" class="hover:scale-105 transition-transform ml-1 shrink-0">
                    @if(Auth::user()->employee && Auth::user()->employee->photo)
                        <img alt="Profil Pengguna" class="w-10 h-10 shrink-0 rounded-2xl border border-outline-variant/30 dark:border-[#2A3654] object-cover shadow-sm" src="{{ asset('storage/' . Auth::user()->employee->photo) }}">
                    @else
                        <div class="w-10 h-10 shrink-0 rounded-2xl bg-[#000210] dark:bg-[#141C33] text-[#dbe1ff] dark:text-[#E5B04D] flex items-center justify-center font-bold text-sm border border-outline-variant/20 dark:border-[#2A3654] shadow-sm">
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
            
            // ADVANCED REAL-TIME LIVE SEARCH (AJAX + Instant DOM Filter, No Enter Required)
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

        // Global Modal Controller
        window.openModal = function(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeModal = function(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        };

        // Close modal on overlay click globally
        document.addEventListener('click', function(e) {
            if(e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Close modals and dropdowns on Escape key globally
        document.addEventListener('keydown', function(e) {
            if(e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(modal => {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                });
                document.querySelectorAll('.action-dropdown').forEach(d => d.classList.add('hidden'));
            }
        });
    </script>
</body>
</html>
