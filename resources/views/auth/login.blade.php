<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — {{ config('app.name', 'HR Portal') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:        #0058be;
            --primary-dark:   #003d8a;
            --primary-light:  #d8e2ff;
            --neon:           #00D2FF;
            --navy:           #1E1B4B;
            --navy-light:     #2d2a62;
            --surface:        #f7f9fb;
            --surface-low:    #f2f4f6;
            --white:          #ffffff;
            --on-surface:     #191c1e;
            --on-surface-v:   #424754;
            --outline:        #727785;
            --outline-v:      #c2c6d6;
            --secondary:      #5b598c;
            --tertiary:       #4648d4;
            --error:          #ba1a1a;
            --shadow-color:   rgba(30,27,75,0.08);
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--surface);
            color: var(--on-surface);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Layout ── */
        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ── Left panel ── */
        .left-panel {
            position: relative;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 64px;
            overflow: hidden;
        }

        /* animated gradient orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: drift 8s ease-in-out infinite alternate;
        }
        .orb-1 { width: 420px; height: 420px; background: var(--tertiary); top: -80px; left: -80px; animation-delay: 0s; }
        .orb-2 { width: 320px; height: 320px; background: var(--primary);  bottom: 60px; right: -60px; animation-delay: -3s; }
        .orb-3 { width: 220px; height: 220px; background: var(--neon);     bottom: -40px; left: 160px; animation-delay: -6s; opacity: 0.20; }

        @keyframes drift {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(20px, 30px) scale(1.08); }
        }

        .left-content { position: relative; z-index: 1; }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 9999px;
            padding: 8px 20px;
            margin-bottom: 40px;
        }
        .brand-badge-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--neon); }
        .brand-badge span { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.85); letter-spacing: 0.04em; }

        .left-headline {
            font-size: 42px;
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin-bottom: 20px;
        }
        .left-headline .accent { color: var(--neon); }

        .left-desc {
            font-size: 16px;
            font-weight: 400;
            color: rgba(255,255,255,0.65);
            line-height: 1.7;
            max-width: 380px;
            margin-bottom: 44px;
        }

        /* stats row */
        .stats-row { display: flex; gap: 32px; }
        .stat-item { display: flex; flex-direction: column; gap: 4px; }
        .stat-num  { font-size: 28px; font-weight: 800; color: #fff; letter-spacing: -0.02em; }
        .stat-label{ font-size: 12px; font-weight: 600; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.06em; }

        /* glass feature cards */
        .feature-cards { display: flex; flex-direction: column; gap: 14px; margin-top: 48px; }
        .feature-card {
            display: flex;
            align-items: center;
            gap: 16px;
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            padding: 16px 20px;
            transition: background 0.3s;
        }
        .feature-card:hover { background: rgba(255,255,255,0.12); }
        .feature-icon {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.12);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .feature-icon svg { width: 20px; height: 20px; stroke: var(--neon); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .feature-text strong { display: block; font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 2px; }
        .feature-text span   { font-size: 12px; color: rgba(255,255,255,0.55); }

        /* ── Right panel ── */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 48px;
            background: var(--surface-low);
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: var(--white);
            border-radius: 28px;
            padding: 48px 44px;
            box-shadow: 0 20px 60px var(--shadow-color), 0 4px 16px rgba(0,0,0,0.04);
        }

        /* card header */
        .card-header { margin-bottom: 36px; }
        .card-logo {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, var(--primary), var(--tertiary));
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(0,88,190,0.35);
        }
        .card-logo svg { width: 26px; height: 26px; stroke: #fff; fill: none; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }
        .card-title { font-size: 26px; font-weight: 800; color: var(--on-surface); letter-spacing: -0.02em; margin-bottom: 8px; }
        .card-subtitle { font-size: 14px; color: var(--on-surface-v); line-height: 1.6; }

        /* session status */
        .session-status {
            background: #e8f5e9;
            border: 1px solid #a5d6a7;
            color: #2e7d32;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 24px;
        }

        /* form */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--on-surface);
            margin-bottom: 8px;
            letter-spacing: 0.01em;
        }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            width: 18px; height: 18px;
            stroke: var(--outline);
            fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
            pointer-events: none;
            transition: stroke 0.2s;
        }

        .form-input {
            width: 100%;
            height: 50px;
            padding: 0 44px 0 44px;
            border: 1.5px solid var(--outline-v);
            border-radius: 12px;
            background: var(--surface-low);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            color: var(--on-surface);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .form-input::placeholder { color: var(--outline); font-weight: 400; }
        .form-input:focus {
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(0,88,190,0.1);
        }
        .form-input:focus ~ .input-icon { stroke: var(--primary); }

        /* toggle password */
        .eye-btn {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            padding: 4px; border-radius: 6px;
            color: var(--outline);
            transition: color 0.2s;
            display: flex; align-items: center;
        }
        .eye-btn:hover { color: var(--primary); }
        .eye-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

        /* error */
        .field-error { font-size: 12px; color: var(--error); margin-top: 6px; font-weight: 500; }

        /* row */
        .form-row {
            display: flex; align-items: center;
            justify-content: space-between;
            margin: 20px 0 28px;
        }
        .remember-label {
            display: flex; align-items: center; gap: 10px;
            cursor: pointer; font-size: 13px; font-weight: 500; color: var(--on-surface-v);
        }
        .remember-label input[type="checkbox"] {
            appearance: none;
            width: 18px; height: 18px;
            border: 1.5px solid var(--outline-v);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            flex-shrink: 0;
        }
        .remember-label input[type="checkbox"]:checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        .remember-label input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            left: 4px; top: 1px;
            width: 6px; height: 10px;
            border: 2px solid #fff;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }

        .forgot-link {
            font-size: 13px; font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: var(--primary-dark); text-decoration: underline; }

        /* submit button */
        .btn-login {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, var(--primary), var(--tertiary));
            border: none;
            border-radius: 9999px;
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: 0 8px 24px rgba(0,88,190,0.35);
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            position: relative;
            overflow: hidden;
        }
        .btn-login::before {
            content: '';
            position: absolute; inset: 0;
            background: rgba(255,255,255,0);
            transition: background 0.2s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(0,88,190,0.45); }
        .btn-login:hover::before { background: rgba(255,255,255,0.07); }
        .btn-login:active { transform: translateY(0); box-shadow: 0 4px 12px rgba(0,88,190,0.3); }
        .btn-login svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round; }

        /* divider */
        .divider { display: flex; align-items: center; gap: 14px; margin: 24px 0 0; }
        .divider-line { flex: 1; height: 1px; background: var(--outline-v); }
        .divider-text { font-size: 12px; color: var(--outline); font-weight: 500; }

        /* footer */
        .card-footer { margin-top: 24px; text-align: center; font-size: 13px; color: var(--on-surface-v); }
        .card-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }
        .card-footer a:hover { text-decoration: underline; }

        /* loading spinner */
        .btn-login .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Responsive */
        @media (max-width: 900px) {
            .login-wrapper { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 24px 20px; }
            .login-card { padding: 36px 28px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- ── LEFT PANEL ── -->
    <div class="left-panel">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <div class="left-content">
            <div class="brand-badge">
                <div class="brand-badge-dot"></div>
                <span>{{ config('app.name', 'HR Portal') }}</span>
            </div>

            <h1 class="left-headline">
                Kelola Tim Anda<br>
                dengan <span class="accent">Cerdas</span><br>
                & Efisien.
            </h1>
            <p class="left-desc">
                Platform administrasi terpusat untuk kehadiran, cuti, dan data karyawan — semua dalam satu dasbor yang elegan.
            </p>

            <div class="stats-row">
                <div class="stat-item">
                    <span class="stat-num">2K+</span>
                    <span class="stat-label">Pengguna Aktif</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">98%</span>
                    <span class="stat-label">Uptime</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">50+</span>
                    <span class="stat-label">Instansi</span>
                </div>
            </div>

            <div class="feature-cards">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div class="feature-text">
                        <strong>Manajemen Karyawan</strong>
                        <span>Data lengkap, absensi, & penggajian</span>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div class="feature-text">
                        <strong>Pengelolaan Cuti</strong>
                        <span>Pengajuan & persetujuan real-time</span>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div class="feature-text">
                        <strong>Keamanan Terjamin</strong>
                        <span>Enkripsi data & kontrol akses berbasis peran</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── RIGHT PANEL ── -->
    <div class="right-panel">
        <div class="login-card">
            <div class="card-header">
                <div class="card-logo">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <h1 class="card-title">Masuk ke Akun</h1>
                <p class="card-subtitle">Silakan masukkan NIP dan kata sandi Anda untuk melanjutkan.</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                {{-- NIP --}}
                <div class="form-group">
                    <label class="form-label" for="nip">NIP</label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <input
                            id="nip"
                            class="form-input"
                            type="text"
                            name="nip"
                            value="{{ old('nip') }}"
                            placeholder="Masukkan NIP Anda"
                            required
                            autofocus
                            autocomplete="username"
                        >
                    </div>
                    @error('nip')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-wrap">
                        <svg class="input-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input
                            id="password"
                            class="form-input"
                            type="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="eye-btn" id="togglePassword" aria-label="Tampilkan kata sandi">
                            <svg id="eyeIcon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="form-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" id="submitBtn">
                    <span class="spinner" id="spinner"></span>
                    <svg id="loginIcon" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    <span id="loginText">Masuk Sekarang</span>
                </button>

                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">Portal Administrasi</span>
                    <div class="divider-line"></div>
                </div>
            </form>

            <div class="card-footer">
                Butuh bantuan? Hubungi <a href="mailto:admin@example.com">administrator</a>
            </div>
        </div>
    </div>

</div>

<script>
    // Toggle password visibility
    const toggle = document.getElementById('togglePassword');
    const pwInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOff = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    const eyeOn  = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
    let visible = false;

    toggle.addEventListener('click', () => {
        visible = !visible;
        pwInput.type = visible ? 'text' : 'password';
        eyeIcon.innerHTML = visible ? eyeOff : eyeOn;
    });

    // Loading state on submit
    document.getElementById('loginForm').addEventListener('submit', () => {
        const btn = document.getElementById('submitBtn');
        document.getElementById('spinner').style.display = 'block';
        document.getElementById('loginIcon').style.display = 'none';
        document.getElementById('loginText').textContent = 'Memproses...';
        btn.style.opacity = '0.85';
        btn.disabled = true;
    });
</script>
</body>
</html>
