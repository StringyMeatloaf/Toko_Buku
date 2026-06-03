<x-guest-layout>
    <head>
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
        <script id="tailwind-config">
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        "colors": {
                            "primary": "#00236f",
                            "on-primary": "#ffffff",
                            "primary-container": "#1e3a8a",
                            "on-primary-container": "#90a8ff",
                            "background": "#f8f9ff",
                            "surface-container-lowest": "#ffffff",
                            "on-surface": "#0b1c30",
                            "on-surface-variant": "#444651",
                            "outline": "#757682",
                            "outline-variant": "#c5c5d3",
                            "secondary": "#006c49",
                        },
                        "spacing": {
                            "sm": "8px",
                            "md": "16px",
                            "lg": "24px",
                            "xl": "32px",
                            "2xl": "48px",
                            "xs": "4px",
                        }
                    },
                },
            }
        </script>
        <style>
            .material-symbols-outlined { font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24 }
            .bg-blur-illustration {
                background-image: linear-gradient(rgba(248, 249, 255, 0.85), rgba(248, 249, 255, 0.85)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&q=80&w=2000');
                background-size: cover;
                background-position: center;
            }
            .login-card-shadow { box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 4px 6px rgba(0, 0, 0, 0.02) }
        </style>
    </head>

    <div class="min-h-screen flex items-center justify-center p-6 bg-blur-illustration font-['Inter']">
        <div class="w-full max-w-[440px] bg-white rounded-xl p-8 login-card-shadow border border-outline-variant">
            
            <div class="flex flex-col items-center mb-8 text-center">
                <div class="mb-4 p-2 bg-primary-container rounded-lg">
                    <span class="material-symbols-outlined text-white text-5xl">menu_book</span>
                </div>
                <h1 class="text-3xl font-bold text-primary tracking-tight">BookStock</h1>
                <p class="text-sm text-on-surface-variant mt-1">Inventory Management System</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-on-surface-variant block ml-1" for="email">Email Address</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">person</span>
                        <input class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-sm" 
                               id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-semibold text-on-surface-variant block ml-1" for="password">Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">lock</span>
                        <input class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-all text-sm" 
                               id="password" name="password" type="password" placeholder="••••••••" required autocomplete="current-password" />
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface-variant transition-colors" onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined" id="eyeIcon">visibility</span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input name="remember" type="checkbox" class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary" />
                        <span class="text-sm text-on-surface-variant group-hover:text-on-surface transition-colors">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold text-primary hover:underline transition-all" href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>

                <button class="w-full py-3 px-6 bg-primary text-white rounded-lg font-semibold shadow-md hover:shadow-lg hover:bg-opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                    <span>Login</span>
                    <span class="material-symbols-outlined text-xl">login</span>
                </button>
            </form>

            <div class="mt-8 text-center border-t border-outline-variant pt-4">
                <p class="text-xs text-on-surface-variant">
                    © {{ date('Y') }} BookStock Inc. v2.4.1
                </p>
                <div class="mt-2 flex justify-center gap-4 text-xs">
                    <a class="text-outline hover:text-primary transition-colors" href="#">Terms</a>
                    <span class="text-outline-variant">•</span>
                    <a class="text-outline hover:text-primary transition-colors" href="#">Privacy</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = 'visibility';
            }
        }

        // Parallax effect
        document.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth) * 15;
            const y = (e.clientY / window.innerHeight) * 15;
            document.querySelector('.bg-blur-illustration').style.backgroundPosition = `calc(50% + ${x}px) calc(50% + ${y}px)`;
        });
    </script>
</x-guest-layout>