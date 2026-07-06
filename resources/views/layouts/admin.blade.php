<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ruang Administrasi - Admin Panel</title>
    
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
</body>
</html>

