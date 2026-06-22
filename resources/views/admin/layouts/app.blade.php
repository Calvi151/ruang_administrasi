<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--primary:#0058be;--primary-dark:#003d8a;--primary-light:#d8e2ff;--neon:#00D2FF;--navy:#1E1B4B;--surface:#f7f9fb;--surface-low:#f2f4f6;--surface-cnt:#eceef0;--white:#ffffff;--on-surface:#191c1e;--on-surface-v:#424754;--outline:#727785;--outline-v:#c2c6d6;--tertiary:#4648d4;--error:#ba1a1a;--shadow:rgba(30,27,75,0.08)}
        html,body{height:100%;font-family:'Plus Jakarta Sans',sans-serif;background:var(--surface);color:var(--on-surface);-webkit-font-smoothing:antialiased}
        .app-layout{display:flex;min-height:100vh}
        /* Sidebar */
        .sidebar{width:260px;flex-shrink:0;background:var(--navy);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:100}
        .sidebar-brand{padding:28px 24px 20px;border-bottom:1px solid rgba(255,255,255,0.08)}
        .brand-logo{display:flex;align-items:center;gap:12px}
        .brand-icon{width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,var(--primary),var(--tertiary));display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .brand-icon svg{width:20px;height:20px;stroke:#fff;fill:none;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}
        .brand-name{font-size:15px;font-weight:800;color:#fff;line-height:1.2}
        .brand-sub{font-size:11px;color:rgba(255,255,255,0.45);font-weight:500;letter-spacing:0.04em}
        .sidebar-nav{flex:1;padding:16px 12px;overflow-y:auto}
        .nav-label{font-size:10px;font-weight:700;color:rgba(255,255,255,0.35);letter-spacing:0.1em;text-transform:uppercase;padding:12px 12px 6px}
        .nav-item{display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:10px;color:rgba(255,255,255,0.65);font-size:14px;font-weight:500;text-decoration:none;cursor:pointer;transition:background 0.2s,color 0.2s;margin-bottom:2px;border:none;background:none;width:100%;text-align:left}
        .nav-item:hover{background:rgba(255,255,255,0.07);color:#fff}
        .nav-item.active{background:rgba(255,255,255,0.12);color:#fff;font-weight:700;position:relative}
        .nav-item.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:60%;background:var(--neon);border-radius:0 3px 3px 0}
        .nav-item svg{width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
        .sidebar-footer{padding:16px 12px;border-top:1px solid rgba(255,255,255,0.08)}
        .user-card{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:10px;background:rgba(255,255,255,0.07)}
        .user-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--tertiary));display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#fff;flex-shrink:0}
        .user-info{flex:1;min-width:0}
        .user-name{font-size:13px;font-weight:700;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .user-role{font-size:11px;color:rgba(255,255,255,0.45);text-transform:capitalize}
        /* Main */
        .main-content{margin-left:260px;flex:1;display:flex;flex-direction:column;min-height:100vh}
        .topbar{height:68px;background:var(--white);border-bottom:1px solid var(--outline-v);display:flex;align-items:center;justify-content:space-between;padding:0 32px;position:sticky;top:0;z-index:50}
        .topbar-left h1{font-size:20px;font-weight:800;color:var(--on-surface);letter-spacing:-0.01em}
        .topbar-left p{font-size:13px;color:var(--on-surface-v);margin-top:1px}
        .topbar-date{display:flex;align-items:center;gap:8px;background:var(--surface-low);border:1px solid var(--outline-v);border-radius:9999px;padding:7px 16px;font-size:13px;font-weight:600;color:var(--on-surface-v)}
        .topbar-date svg{width:15px;height:15px;stroke:var(--primary);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        .page-body{padding:32px;flex:1}
        /* Cards */
        .card{background:var(--white);border-radius:20px;padding:24px;box-shadow:0 4px 20px var(--shadow)}
        .card+.card{margin-top:20px}
        .badge{display:inline-block;padding:3px 10px;border-radius:9999px;font-size:11px;font-weight:700;letter-spacing:0.03em}
        .badge-hadir{background:#dcfce7;color:#15803d}
        .badge-izin{background:#dbeafe;color:#1d4ed8}
        .badge-sakit{background:#fef3c7;color:#b45309}
        .badge-alpha{background:#fee2e2;color:#b91c1c}
        .data-table{width:100%;border-collapse:collapse}
        .data-table th{font-size:11px;font-weight:700;color:var(--outline);text-transform:uppercase;letter-spacing:0.06em;padding:0 12px 12px;text-align:left;border-bottom:1px solid var(--outline-v)}
        .data-table td{padding:13px 12px;border-bottom:1px solid var(--surface-cnt);font-size:13px;color:var(--on-surface);vertical-align:middle}
        .data-table tr:last-child td{border-bottom:none}
        .data-table tr:hover td{background:var(--surface-low)}
        .sub{font-size:11px;color:var(--on-surface-v);margin-top:2px}
        /* Form */
        .form-label{display:block;font-size:12px;font-weight:700;color:var(--on-surface);margin-bottom:6px;letter-spacing:0.01em}
        .form-input,.form-select{width:100%;height:42px;padding:0 14px;border:1.5px solid var(--outline-v);border-radius:10px;background:var(--surface-low);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:var(--on-surface);outline:none;transition:border-color 0.2s,box-shadow 0.2s}
        .form-input:focus,.form-select:focus{border-color:var(--primary);background:var(--white);box-shadow:0 0 0 4px rgba(0,88,190,0.1)}
        .form-row{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:16px}
        .form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
        .btn{display:inline-flex;align-items:center;gap:8px;height:42px;padding:0 20px;border:none;border-radius:9999px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:all 0.2s;text-decoration:none}
        .btn-primary{background:linear-gradient(135deg,var(--primary),var(--tertiary));color:#fff;box-shadow:0 4px 16px rgba(0,88,190,0.3)}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 8px 24px rgba(0,88,190,0.4)}
        .btn-danger{background:#fee2e2;color:var(--error);border:1.5px solid #fecaca}
        .btn-danger:hover{background:#fecaca}
        .btn svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
        /* Stats */
        .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
        .stat-card{background:var(--white);border-radius:16px;padding:20px;box-shadow:0 4px 20px var(--shadow)}
        .stat-num{font-size:32px;font-weight:800;letter-spacing:-0.03em;line-height:1;margin-bottom:4px}
        .stat-lbl{font-size:12px;font-weight:600;color:var(--on-surface-v)}
        /* Alert */
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;border-radius:12px;padding:12px 16px;font-size:13px;font-weight:500;margin-bottom:20px}
        /* Filter row */
        .filter-row{display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap}
        .filter-row .form-input,.filter-row .form-select{height:40px;width:auto}
        /* Pagination */
        .pagination-wrap{display:flex;justify-content:flex-end;margin-top:20px}
        .pagination-wrap nav .flex{gap:4px}
    </style>
    @yield('styles')
</head>
<body>
<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <div>
                    <div class="brand-name">{{ config('app.name','HR Portal') }}</div>
                    <div class="brand-sub">Admin Console</div>
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard
            </a>

            <a href="{{ url('/admin/incoming-letters') }}" class="nav-item {{ request()->is('admin/incoming*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>Surat Masuk
            </a>
            <a href="{{ url('/admin/outgoing-letters') }}" class="nav-item {{ request()->is('admin/outgoing*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>Surat Keluar
            </a>
            <a href="{{ url('/admin/employees') }}" class="nav-item {{ request()->is('admin/employees*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Karyawan
            </a>
            <a href="{{ url('/admin/letter-types') }}" class="nav-item {{ request()->is('admin/letter-types*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>Jenis Surat
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->nip,0,2)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->nip }}</div>
                    <div class="user-role">{{ auth()->user()->role }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:10px">
                @csrf
                <button type="submit" class="nav-item" style="color:rgba(255,100,100,0.8)">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <h1>@yield('page-title','Dashboard')</h1>
                <p>@yield('page-subtitle','HR Portal Admin')</p>
            </div>
            <div>
                <div class="topbar-date">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </div>
            </div>
        </header>
        <div class="page-body">
            @yield('content')
        </div>
    </div>
</div>
@yield('scripts')
</body>
</html>
