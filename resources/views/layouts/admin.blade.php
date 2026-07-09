<!DOCTYPE html>
<html lang="id" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ruang Administrasi - Admin Panel</title>
    
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
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS via Vite -->
    @vite('resources/css/bootstrap.css')
    
    <!-- FontAwesome Icons CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: 260px;
            background-color: #1e293b;
            color: #fff;
            transition: all 0.3s;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background-color: #0f172a;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 0.95rem;
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        #sidebar ul li a:hover {
            color: #fff;
            background: #334155;
            border-left-color: #3b82f6;
        }

        #sidebar ul li.active a {
            color: #fff;
            background: #334155;
            border-left-color: #3b82f6;
            font-weight: 600;
        }

        #content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .navbar {
            padding: 15px 30px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 20px;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom-width: 1px;
        }

        .table td {
            font-size: 0.9rem;
            vertical-align: middle;
            color: #334155;
        }

        /* ===== DARK MODE ===== */
        html.dark body {
            background-color: #12131e;
            color: #e2e4f0;
        }
        html.dark #content {
            background-color: #12131e;
        }
        html.dark #sidebar {
            background-color: #0e0f1a;
        }
        html.dark #sidebar .sidebar-header {
            background-color: #080910;
        }
        html.dark #sidebar ul li a {
            color: #9ca3bf;
        }
        html.dark #sidebar ul li a:hover {
            color: #e2e4f0;
            background: #1e2035;
            border-left-color: #b4c5ff;
        }
        html.dark #sidebar ul li.active a {
            color: #e2e4f0;
            background: #1e2035;
            border-left-color: #b4c5ff;
        }
        html.dark .navbar {
            background: #161726 !important;
            border-bottom-color: #2d3050;
        }
        /* Card & card-body */
        html.dark .card {
            background-color: #1a1c2e;
            border-color: #2d3050;
            color: #e2e4f0;
        }
        html.dark .card-body {
            background-color: #1a1c2e;
        }
        html.dark .card-header {
            background-color: #161726;
            border-bottom-color: #2d3050;
            color: #e2e4f0;
        }
        html.dark .card-footer {
            background-color: #161726;
            border-top-color: #2d3050;
        }
        /* Tables */
        html.dark .table {
            color: #c5c8df;
            border-color: #2d3050;
        }
        html.dark .table th {
            color: #9ca3bf;
            background-color: #161726;
            border-bottom-color: #2d3050;
        }
        html.dark .table td {
            color: #c5c8df;
            border-color: #252840;
        }
        html.dark .table thead th {
            border-bottom-color: #2d3050;
        }
        html.dark .table-bordered td,
        html.dark .table-bordered th {
            border-color: #2d3050;
        }
        html.dark .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: #1e2035;
            color: #c5c8df;
        }
        html.dark .table-hover > tbody > tr:hover > * {
            background-color: #252840;
            color: #e2e4f0;
        }
        /* Forms */
        html.dark .form-control,
        html.dark .form-select {
            background-color: #1e2035;
            border-color: #2d3050;
            color: #e2e4f0;
        }
        html.dark .form-control:focus,
        html.dark .form-select:focus {
            background-color: #252840;
            border-color: #b4c5ff;
            color: #e2e4f0;
            box-shadow: 0 0 0 0.2rem rgba(180, 197, 255, 0.15);
        }
        html.dark .form-control::placeholder { color: #5a5e7a; }
        html.dark .form-label { color: #9ca3bf; }
        html.dark .input-group-text {
            background-color: #1e2035;
            border-color: #2d3050;
            color: #9ca3bf;
        }
        /* Modals */
        html.dark .modal-content {
            background-color: #1a1c2e;
            border-color: #2d3050;
        }
        html.dark .modal-header,
        html.dark .modal-footer { border-color: #2d3050; }
        html.dark .modal-title  { color: #e2e4f0; }
        html.dark .modal-body   { color: #c5c8df; }
        html.dark .btn-close    { filter: invert(1) grayscale(1) opacity(0.6); }
        /* Alerts */
        html.dark .alert-success {
            background-color: #0a3b28;
            border-color: #1a6b4a;
            color: #6ee7b7;
        }
        html.dark .alert-danger {
            background-color: #3b0d0d;
            border-color: #6b1a1a;
            color: #fca5a5;
        }
        html.dark .alert-warning {
            background-color: #3b2a05;
            border-color: #856404;
            color: #fbbf24;
        }
        html.dark .alert-info {
            background-color: #0c2340;
            border-color: #1a4580;
            color: #93c5fd;
        }
        /* Badges */
        html.dark .badge.bg-success   { background-color: #0a3b28 !important; color: #6ee7b7 !important; }
        html.dark .badge.bg-danger    { background-color: #3b0d0d !important; color: #fca5a5 !important; }
        html.dark .badge.bg-warning   { background-color: #3b2a05 !important; color: #fbbf24 !important; }
        html.dark .badge.bg-primary   { background-color: #1e2f5a !important; color: #b4c5ff !important; }
        html.dark .badge.bg-secondary { background-color: #1e2035 !important; color: #9ca3bf !important; }
        /* Pagination */
        html.dark .page-link {
            background-color: #1a1c2e;
            border-color: #2d3050;
            color: #9ca3bf;
        }
        html.dark .page-link:hover {
            background-color: #252840;
            color: #e2e4f0;
        }
        html.dark .page-item.active .page-link {
            background-color: #1e2f5a;
            border-color: #b4c5ff;
            color: #b4c5ff;
        }
        html.dark .page-item.disabled .page-link {
            background-color: #161726;
            color: #5a5e7a;
        }
        /* Text utilities */
        html.dark .text-muted    { color: #9ca3bf !important; }
        html.dark .text-dark     { color: #c5c8df !important; }
        html.dark .text-secondary{ color: #9ca3bf !important; }
        /* Border utilities */
        html.dark .border        { border-color: #2d3050 !important; }
        html.dark .border-top    { border-top-color: #2d3050 !important; }
        html.dark .border-bottom { border-bottom-color: #2d3050 !important; }
        /* Dropdown */
        html.dark .dropdown-menu {
            background-color: #1a1c2e;
            border-color: #2d3050;
        }
        html.dark .dropdown-item { color: #9ca3bf; }
        html.dark .dropdown-item:hover { background-color: #252840; color: #e2e4f0; }
        html.dark .dropdown-divider { border-color: #2d3050; }
        /* List groups */
        html.dark .list-group-item {
            background-color: #1a1c2e;
            border-color: #2d3050;
            color: #c5c8df;
        }
        html.dark .list-group-item:hover { background-color: #252840; }
        /* Smooth transitions */
        body, #sidebar, .navbar, .card, .card-header, .table, .form-control, .form-select, .modal-content {
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.15s ease;
        }
        /* Dark mode toggle button */
        #dark-mode-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: #64748b;
            padding: 6px 8px;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
            font-size: 1.1rem;
            line-height: 1;
            display: flex;
            align-items: center;
        }
        #dark-mode-toggle:hover {
            background: #f1f5f9;
            color: #3b82f6;
        }
        html.dark #dark-mode-toggle {
            color: #a0a4bb;
        }
        html.dark #dark-mode-toggle:hover {
            background: #2d3050;
            color: #b4c5ff;
        }
    </style>
</head>
<body>

    <div id="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <i class="fa-solid fa-folder-open me-2"></i>Ruang Admin
            </div>

            <ul class="list-unstyled components">
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie me-3"></i>Dashboard</a>
                </li>
                <li class="{{ Request::is('admin/employees*') ? 'active' : '' }}">
                    <a href="{{ route('employees.index') }}"><i class="fa-solid fa-users me-3"></i>Karyawan</a>
                </li>
                <li class="{{ Request::is('admin/letter-types*') ? 'active' : '' }}">
                    <a href="{{ route('letter-types.index') }}"><i class="fa-solid fa-tags me-3"></i>Jenis Surat</a>
                </li>
                <li class="{{ Request::is('admin/incoming-letters*') ? 'active' : '' }}">
                    <a href="{{ route('incoming-letters.index') }}"><i class="fa-solid fa-envelope-open-text me-3"></i>Surat Masuk</a>
                </li>
                <li class="{{ Request::is('admin/outgoing-letters*') ? 'active' : '' }}">
                    <a href="{{ route('outgoing-letters.index') }}"><i class="fa-solid fa-paper-plane me-3"></i>Surat Keluar</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                        <i class="fa-solid fa-right-from-bracket me-3"></i>Keluar
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Topbar / Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1 text-muted" style="font-size: 1rem;">
                        Selamat Datang, <strong>{{ auth()->user()->nip }}</strong> (Admin)
                    </span>
                    <!-- Dark Mode Toggle -->
                    <button id="dark-mode-toggle" onclick="toggleDarkMode()" title="Toggle Dark Mode">
                        <span id="dark-icon" style="display:none;">&#9728;</span>
                        <span id="light-icon">&#9790;</span>
                    </button>
                </div>
            </nav>

            <!-- Alerts for Success/Error -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>Terdapat kesalahan pada input Anda. Silakan cek form kembali.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Main Yield -->
            @yield('admin_content')
        </div>
    </div>

    <!-- Bootstrap JS Bundle via Vite -->
    @vite('resources/js/bootstrap-bundle.js')

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
                darkIcon.style.display = 'inline';
                lightIcon.style.display = 'none';
            } else {
                darkIcon.style.display = 'none';
                lightIcon.style.display = 'inline';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.getElementById('html-root').classList.contains('dark');
            updateDarkModeIcons(isDark);
        });
    </script>
</body>
</html>

