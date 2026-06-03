<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
<x-guest-layout>
    {{-- Tampilan Background Parallax --}}
    <div class="min-h-screen flex items-center justify-center p-6 bg-blur-illustration font-sans">
        
        <div class="w-full max-w-[440px] bg-white rounded-xl p-8 shadow-sm border border-slate-200">
            
            {{-- Brand Identity --}}
            <div class="flex flex-col items-center mb-8 text-center">
                <div class="mb-4 p-2 bg-[#1e3a8a] rounded-lg">
                    <span class="material-symbols-outlined text-white text-5xl">menu_book</span>
                </div>
                <h1 class="text-3xl font-bold text-[#00236f] tracking-tight">BookStock</h1>
                <p class="text-sm text-slate-500 mt-1">Inventory Management System</p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Email Address --}}
                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-600 block ml-1" for="email">Email Address</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#00236f] transition-colors">
                            person
                        </span>
                        <input class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#00236f] focus:border-[#00236f] transition-all text-sm" 
                               id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label class="text-xs font-semibold text-slate-600 block ml-1" for="password">Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#00236f] transition-colors">
                            lock
                        </span>
                        <input class="w-full pl-11 pr-12 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-[#00236f] focus:border-[#00236f] transition-all text-sm" 
                               id="password" name="password" type="password" placeholder="••••••••" required autocomplete="current-password" />
                        
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors" 
                                onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined" id="eyeIcon">visibility</span>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input name="remember" type="checkbox" class="w-4 h-4 rounded border-slate-300 text-[#00236f] focus:ring-[#00236f]" />
                        <span class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-semibold text-[#00236f] hover:underline transition-all" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button class="w-full py-3 px-6 bg-[#00236f] text-white rounded-lg font-semibold shadow-md hover:shadow-lg hover:bg-opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                    <span>Login</span>
                    <span class="material-symbols-outlined text-xl">login</span>
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-8 text-center border-t border-slate-100 pt-4">
                <p class="text-xs text-slate-500">
                    © {{ date('Y') }} BookStock Inc. v2.4.1
                </p>
                <div class="mt-2 flex justify-center gap-4 text-xs">
                    <a class="text-slate-400 hover:text-[#00236f] transition-colors" href="#">Terms</a>
                    <span class="text-slate-200">•</span>
                    <a class="text-outline hover:text-[#00236f] transition-colors" href="#">Privacy</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Styling Kustom (Inject ke Head melalui push jika perlu, atau taruh di sini) --}}
    <style>
        .bg-blur-illustration {
            background-image: linear-gradient(rgba(248, 249, 255, 0.85), rgba(248, 249, 255, 0.85)), 
                              url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
        }
        .material-symbols-outlined { 
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
            display: block;
        }
    </style>

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
            const container = document.querySelector('.bg-blur-illustration');
            if (container) {
                const x = (e.clientX / window.innerWidth) * 15;
                const y = (e.clientY / window.innerHeight) * 15;
                container.style.backgroundPosition = `calc(50% + ${x}px) calc(50% + ${y}px)`;
            }
        });
    </script>
</x-guest-layout>