<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Ruang Administrasi</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=block" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        try {
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        "colors": {
                            "tertiary": "#020302",
                            "outline-variant": "#c6c6cf",
                            "on-primary-fixed": "#0d1a3c",
                            "on-surface-variant": "#45464e",
                            "primary-container": "#0f1b3d",
                            "secondary-fixed-dim": "#f5bd58",
                            "surface-variant": "#e4e2e2",
                            "surface-dim": "#dbd9d9",
                            "error-container": "#ffdad6",
                            "inverse-on-surface": "#f2f0f0",
                            "on-secondary-fixed": "#271900",
                            "error": "#ba1a1a",
                            "on-surface": "#1b1c1c",
                            "on-primary": "#ffffff",
                            "on-background": "#1b1c1c",
                            "surface-tint": "#525d83",
                            "surface-container-high": "#eae8e7",
                            "secondary-container": "#ffc55f",
                            "surface-container": "#efeded",
                            "on-error": "#ffffff",
                            "tertiary-fixed-dim": "#c8c6c2",
                            "secondary-fixed": "#ffdeaa",
                            "on-primary-container": "#7984ab",
                            "tertiary-fixed": "#e4e2dd",
                            "outline": "#76767f",
                            "tertiary-container": "#1d1d1a",
                            "primary-fixed": "#dbe1ff",
                            "on-error-container": "#93000a",
                            "surface": "#fbf9f8",
                            "surface-container-lowest": "#ffffff",
                            "on-secondary-container": "#755100",
                            "primary": "#000210",
                            "on-tertiary-container": "#858581",
                            "surface-container-highest": "#e4e2e2",
                            "surface-container-low": "#f5f3f3",
                            "on-secondary-fixed-variant": "#5f4100",
                            "on-tertiary-fixed": "#1b1c19",
                            "on-tertiary": "#ffffff",
                            "on-primary-fixed-variant": "#3a4569",
                            "on-secondary": "#ffffff",
                            "inverse-surface": "#303030",
                            "primary-fixed-dim": "#bac5f0",
                            "surface-bright": "#fbf9f8",
                            "on-tertiary-fixed-variant": "#474744",
                            "background": "#fbf9f8",
                            "inverse-primary": "#bac5f0",
                            "secondary": "#7d5700"
                        },
                        "borderRadius": {
                            "DEFAULT": "0.25rem",
                            "lg": "0.5rem",
                            "xl": "0.75rem",
                            "full": "9999px"
                        },
                        "spacing": {
                            "margin-desktop": "64px",
                            "base": "8px",
                            "margin-mobile": "20px",
                            "container-max": "1280px",
                            "gutter": "24px"
                        },
                        "fontFamily": {
                            "headline-lg": ["Playfair Display"],
                            "body-md": ["Work Sans"],
                            "display-lg": ["Playfair Display"],
                            "body-lg": ["Work Sans"],
                            "headline-lg-mobile": ["Playfair Display"],
                            "label-sm": ["Work Sans"],
                            "label-md": ["Work Sans"],
                            "headline-md": ["Playfair Display"]
                        },
                        "fontSize": {
                            "headline-lg": ["32px", { "lineHeight": "1.2", "fontWeight": "600" }],
                            "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                            "display-lg": ["48px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                            "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                            "headline-lg-mobile": ["28px", { "lineHeight": "1.2", "fontWeight": "600" }],
                            "label-sm": ["12px", { "lineHeight": "1.2", "fontWeight": "500" }],
                            "label-md": ["14px", { "lineHeight": "1.2", "letterSpacing": "0.05em", "fontWeight": "600" }],
                            "headline-md": ["24px", { "lineHeight": "1.3", "fontWeight": "500" }]
                        }
                    }
                }
            };
        } catch (_e) {}
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased h-screen w-full flex overflow-hidden font-body-md">

    <!-- Left Panel: Brand & Context -->
    <div class="hidden lg:flex flex-col w-1/2 bg-primary-container relative h-full">
        <!-- Background Pattern/Illustration -->
        <div class="absolute inset-0 z-0 opacity-40 mix-blend-overlay" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBW5d1ST2GQNN-chDuGexnX9e5hvO29w9WG4L2_QBftnn8X1g6N6UxjDu_uAqCekng2UKdW1cwJQpYWEVrXXV2Ha5pJF_LaTA1P7GPYNMfCaUUDpgum0oNXRjt4RGP_y-G92DqxMGyBgeN8Ew6AEf0-1HUcoUmaVBjPfFiKW9EqDWxVp54FLtCICinNkbrXG-5--WQrf255QzfA7UznTeOlPC4J-LORGQu1g1n6oid_cLFKe0Ay5f1f7fyrz29npKREZMOHQ-qws0s'); background-size: cover; background-position: center;"></div>
        
        <!-- Architectural Overlay Lines -->
        <div class="absolute inset-0 z-10 pointer-events-none">
            <div class="absolute left-1/4 top-0 bottom-0 w-px bg-on-primary/10"></div>
            <div class="absolute right-1/4 top-0 bottom-0 w-px bg-on-primary/10"></div>
            <div class="absolute top-1/3 left-0 right-0 h-px bg-on-primary/10"></div>
        </div>

        <!-- Content Container -->
        <div class="relative z-20 flex flex-col justify-between h-full p-margin-desktop text-on-primary">
            
            <!-- Logo / Brand Anchor -->
            <div class="font-headline-md text-headline-md font-bold tracking-tight">
                Ruang Administrasi.
            </div>
            <div class="flex items-center gap-2 mt-1">
                <div class="h-px w-8 bg-secondary-container"></div>
                <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container">Sistem Informasi</span>
            </div>

            <!-- Value Proposition -->
            <div class="max-w-md">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-[1px] bg-secondary-container"></div>
                    <span class="font-label-sm text-label-sm uppercase tracking-widest text-secondary-container">Sistem Informasi</span>
                </div>
                <h1 class="font-display-lg text-display-lg mb-6 leading-tight">
                    Efisiensi Administrasi Terpusat
                </h1>
                <p class="font-body-lg text-body-lg text-on-primary-container">
                    Kelola alur surat masuk, surat keluar, dan persetujuan dokumen dalam satu platform yang aman dan berwibawa.
                </p>
            </div>

            <!-- Contextual UI Mockup (Bento/Card Style) -->
            <div class="relative w-full max-w-sm mt-12 backdrop-blur-md bg-white/5 border border-white/10 p-6 rounded-none shadow-2xl">
                <!-- Vertical Gold Accent -->
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-secondary-container"></div>
                
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="font-label-sm text-label-sm text-on-primary-container uppercase tracking-wider mb-1">Status Terkini</p>
                        <h3 class="font-body-md text-body-md font-medium text-on-primary">Surat Keputusan #412</h3>
                    </div>
                    <span class="material-symbols-outlined text-secondary-container">verified</span>
                </div>
                <div class="h-[1px] w-full bg-white/10 mb-4"></div>
                <div class="flex justify-between items-center">
                    <span class="font-label-sm text-label-sm text-on-primary-container">Oleh: Direktur Utama</span>
                    <span class="font-label-sm text-label-sm text-secondary-container font-semibold">Disetujui</span>
                </div>
            </div>
            
            <div class="mt-auto pt-12">
                <p class="font-label-sm text-label-sm text-on-primary-container opacity-60">
                    &copy; {{ date('Y') }} Institusi Berwibawa. Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </div>

    <!-- Right Panel: Login Form (Editorial Style) -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-margin-mobile md:p-margin-desktop bg-surface relative z-10 h-full overflow-y-auto">
        
        <!-- Mobile Logo -->
        <div class="lg:hidden w-full max-w-md mb-12 text-center">
            <div class="font-headline-md text-headline-md font-bold tracking-tight text-primary">
                Ruang Administrasi.
            </div>
        </div>

        <div class="w-full max-w-md relative">
            <!-- Decorative Framing Frame (Editorial Touch) -->
            <div class="absolute -left-6 top-0 bottom-0 w-[1px] bg-primary/10 hidden md:block"></div>
            <div class="absolute -top-6 -left-6 w-3 h-[1px] bg-secondary hidden md:block"></div>
            <div class="absolute -bottom-6 -left-6 w-3 h-[1px] bg-secondary hidden md:block"></div>

            <div class="mb-12 opacity-0 animate-fade-in-up">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-2">Selamat Datang</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Silakan masuk ke akun Anda untuk melanjutkan.</p>
            </div>

            @if (session('status'))
                <div class="bg-surface-variant text-on-surface border border-outline px-4 py-3 mb-6 font-label-md flex items-center gap-3">
                    <span class="material-symbols-outlined">check_circle</span>
                    {{ session('status') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="bg-error-container text-on-error-container border border-error-container/50 px-4 py-3 mb-6 font-label-md flex items-start gap-3">
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

            <form action="{{ route('login') }}" method="POST" class="space-y-8 opacity-0 animate-fade-in-up delay-100">
                @csrf
                
                <!-- NIP Input (Changed from Email as per instruction) -->
                <div class="relative group">
                    <label for="nip" class="block font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant mb-2 transition-colors group-focus-within:text-secondary">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" id="nip" name="nip" value="{{ old('nip') }}" required autofocus autocomplete="username" class="block w-full px-0 py-3 bg-transparent border-0 border-b border-primary/20 text-primary font-body-md focus:ring-0 focus:border-secondary focus:border-b-2 transition-all duration-300 placeholder:text-on-surface-variant/50 hover:border-primary/50" placeholder="Contoh: 198001012005011001">
                    <span class="material-symbols-outlined absolute right-0 top-10 text-on-surface-variant/50 pointer-events-none group-focus-within:text-secondary transition-colors">badge</span>
                </div>

                <!-- Password Input -->
                <div class="relative group">
                    <label for="password" class="block font-label-sm text-label-sm uppercase tracking-wider text-on-surface-variant mb-2 transition-colors group-focus-within:text-secondary">Kata Sandi</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" class="block w-full px-0 py-3 bg-transparent border-0 border-b border-primary/20 text-primary font-body-md focus:ring-0 focus:border-secondary focus:border-b-2 transition-all duration-300 placeholder:text-on-surface-variant/50 hover:border-primary/50" placeholder="••••••••">
                    <button type="button" onclick="togglePassword()" class="absolute right-0 top-10 text-on-surface-variant/50 hover:text-primary transition-colors focus:outline-none">
                        <span class="material-symbols-outlined" id="eye-icon">visibility_off</span>
                    </button>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded-none border-primary/30 text-primary focus:ring-primary bg-transparent accent-secondary">
                        <label for="remember_me" class="ml-2 block font-label-md text-label-md text-on-surface-variant cursor-pointer hover:text-on-background transition-colors">
                            Ingat saya
                        </label>
                    </div>
                    <div class="text-sm">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-label-md text-label-md font-semibold text-primary hover:text-secondary border-b border-transparent hover:border-secondary transition-all duration-200">
                                Lupa Kata Sandi?
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-6">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent font-label-md text-label-md font-bold text-on-primary bg-primary hover:bg-secondary-container hover:text-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-300 uppercase tracking-widest shadow-[0_4px_14px_0_rgba(0,2,16,0.1)] hover:shadow-[0_6px_20px_rgba(255,197,95,0.23)] hover:-translate-y-1">
                        Masuk Sistem
                    </button>
                </div>
            </form>

        </div>
    </div>
    
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }
    </script>
</body>
</html>
