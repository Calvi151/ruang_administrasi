<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Masuk - Ruang Administrasi</title>
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
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .icon-fill { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .ambient-shadow { box-shadow: 0 8px 30px rgba(0, 74, 198, 0.04), 0 2px 10px rgba(0, 0, 0, 0.02); }
        .hero-pattern {
            background-color: #0b1c30;
            background-image: radial-gradient(circle at top right, rgba(0, 74, 198, 0.6), transparent 50%),
                              radial-gradient(circle at bottom left, rgba(0, 106, 97, 0.6), transparent 50%);
        }
    </style>
</head>
<body class="bg-background font-body-md text-on-background min-h-screen flex selection:bg-primary-fixed selection:text-on-primary-fixed">
    
    <div class="flex w-full min-h-screen">
        
        <!-- Left Panel: Branding -->
        <div class="hidden lg:flex w-[45%] hero-pattern flex-col justify-between p-12 text-white relative overflow-hidden">
            <!-- Decorative blur orbs -->
            <div class="absolute -top-32 -right-32 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-secondary rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>

            <div class="relative z-10 flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center">
                    <span class="material-symbols-outlined icon-fill text-white">dashboard_customize</span>
                </div>
                <div class="font-headline-md font-bold tracking-tight">Ruang Administrasi</div>
            </div>

            <div class="relative z-10 max-w-md">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 font-label-sm text-white/90 mb-6">
                    <span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
                    Sistem Manajemen Terpadu v2.0
                </div>
                <h1 class="font-headline-xl font-bold leading-tight mb-6">Kelola instansi Anda dengan <span class="text-secondary-fixed">cerdas</span> & efisien.</h1>
                <p class="font-body-lg text-white/70 leading-relaxed">
                    Platform administrasi terpusat untuk mengelola kehadiran, persuratan, dan data operasional dengan keamanan standar tinggi.
                </p>
                
                <div class="mt-12 grid grid-cols-2 gap-8">
                    <div>
                        <div class="font-headline-lg font-bold">99.9%</div>
                        <div class="font-label-sm text-white/50 uppercase tracking-wider mt-1">Uptime Server</div>
                    </div>
                    <div>
                        <div class="font-headline-lg font-bold">256-bit</div>
                        <div class="font-label-sm text-white/50 uppercase tracking-wider mt-1">Enkripsi Data</div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 font-label-sm text-white/40">
                &copy; {{ date('Y') }} Ruang Administrasi System. All rights reserved.
            </div>
        </div>

        <!-- Right Panel: Login Form -->
        <div class="w-full lg:w-[55%] flex items-center justify-center p-8 bg-surface-container-lowest">
            <div class="w-full max-w-md">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center gap-3 mb-10 justify-center">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary to-secondary-container flex items-center justify-center shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined icon-fill text-white">dashboard_customize</span>
                    </div>
                    <div class="font-headline-md font-bold text-on-background tracking-tight">Ruang Administrasi</div>
                </div>

                <div class="text-center lg:text-left mb-10">
                    <h2 class="font-headline-xl font-bold text-on-background tracking-tight mb-2">Selamat Datang</h2>
                    <p class="font-body-lg text-on-surface-variant">Silakan masuk menggunakan kredensial Anda.</p>
                </div>

                @if (session('status'))
                    <div class="bg-status-mint text-secondary border border-secondary-fixed px-4 py-3 rounded-xl font-label-md mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined icon-fill">check_circle</span>
                        {{ session('status') }}
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="bg-error-container text-on-error-container border border-error-container/50 px-4 py-3 rounded-xl font-label-md mb-6 flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5">error</span>
                        <div>
                            <strong>Login Gagal:</strong>
                            <ul class="list-disc pl-4 mt-1 font-body-md">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- NIP Input -->
                    <div class="space-y-2">
                        <label for="nip" class="font-label-md text-on-background block">Nomor Induk Pegawai (NIP)</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">badge</span>
                            <input type="text" id="nip" name="nip" value="{{ old('nip') }}" required autofocus autocomplete="username"
                                class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-surface border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-on-background placeholder:text-outline/70" 
                                placeholder="Contoh: 198001012005011001">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <label for="password" class="font-label-md text-on-background block">Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                class="w-full pl-12 pr-12 py-3.5 rounded-2xl bg-surface border border-outline-variant/50 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-on-background placeholder:text-outline/70" 
                                placeholder="Masukkan kata sandi">
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined" id="eye-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember_me" class="w-5 h-5 rounded border-outline-variant/50 text-primary focus:ring-primary/20 transition-colors">
                            <span class="font-label-md text-on-surface-variant group-hover:text-on-background transition-colors">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-label-md text-primary hover:text-on-primary-fixed-variant transition-colors">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 rounded-full bg-primary text-on-primary font-label-md text-[15px] hover:shadow-lg hover:shadow-primary/25 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2 group">
                            Masuk ke Sistem
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>

