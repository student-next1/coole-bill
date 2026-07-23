<!DOCTYPE html>
<html lang="id" class="light-mode-only">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Coole-Bill POS</title>
    @vite('resources/css/app.css')
    <style>
        /* Force light mode for login page - override any dark mode styles */
        html.light-mode-only,
        html.light-mode-only body {
            background: #f8fafc !important;
            color: #1e293b !important;
        }
        
        html.light-mode-only * {
            color-scheme: light !important;
        }
    </style>
    <script>
        // Prevent dark mode from affecting login page
        (function() {
            const html = document.documentElement;
            html.classList.remove('dark');
            // Don't read theme from localStorage on login page
        })();
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 antialiased">

<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
    
    <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 lg:gap-0">
        
        <!-- LEFT SIDE - Branding (Hidden on mobile) -->
        <div class="hidden lg:flex flex-col items-center justify-center bg-gradient-to-br from-orange-600 via-orange-500 to-orange-600 rounded-l-3xl p-12 relative overflow-hidden">
            
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-black/5 rounded-full -ml-40 -mb-40"></div>
            
            <div class="relative z-10 text-center space-y-8">
                
                <!-- Logo -->
                <div class="flex items-center justify-center gap-2 mb-8">
                    <div class="px-5 py-2.5 rounded-lg shadow-xl transform hover:scale-105 transition-transform" style="background-color: #000000 !important;">
                        <span class="font-black text-2xl tracking-tight" style="color: #FFFFFF !important;">COOL</span>
                    </div>
                    <div class="px-5 py-2.5 rounded-lg shadow-xl transform hover:scale-105 transition-transform" style="background-color: #FFFFFF !important;">
                        <span class="font-black text-2xl tracking-tight" style="color: #EA580C !important;">E-BILL</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <h1 class="text-4xl md:text-5xl font-black leading-tight" style="color: #ffffff !important;">
                        Smart POS System
                    </h1>
                    <p class="text-lg font-medium" style="color: #ffffff !important;">
                        Kelola bisnis Anda dengan mudah
                    </p>
                </div>

                <!-- Features -->
                <div class="mt-12 grid grid-cols-2 gap-4 text-left">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="color: #ffffff !important;">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold" style="color: #ffffff !important;">Transaksi Cepat</p>
                            <p class="text-sm" style="color: #ffffff !important;">Proses dalam detik</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="color: #ffffff !important;">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold" style="color: #ffffff !important;">Kelola Stok</p>
                            <p class="text-sm" style="color: #ffffff !important;">Real-time update</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="color: #ffffff !important;">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold" style="color: #ffffff !important;">Laporan</p>
                            <p class="text-sm" style="color: #ffffff !important;">Analisis lengkap</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-1 w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" style="color: #ffffff !important;">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold" style="color: #ffffff !important;">Multi Payment</p>
                            <p class="text-sm" style="color: #ffffff !important;">Tunai & Kartu ID</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT SIDE - Login Form -->
        <div class="bg-white rounded-3xl lg:rounded-l-none lg:rounded-r-3xl shadow-2xl p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            
            <!-- Mobile Logo (Visible only on mobile) -->
            <div class="lg:hidden flex flex-col items-center mb-8">
                <div class="flex items-center gap-2 mb-3">
                    <div class="px-4 py-2 rounded-lg" style="background-color: #000000 !important;">
                        <span class="font-black text-lg" style="color: #FFFFFF !important;">COOL</span>
                    </div>
                    <div class="px-4 py-2 rounded-lg" style="background-color: #FFFFFF !important;">
                        <span class="font-black text-lg" style="color: #EA580C !important;">E-BILL</span>
                    </div>
                </div>
                <p class="text-sm text-slate-600 font-medium">Smart POS System</p>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl sm:text-4xl font-black text-slate-800 mb-2">
                    Selamat Datang
                </h2>
                <p class="text-slate-500">
                    Masuk ke akun Anda untuk melanjutkan
                </p>
            </div>

            <!-- Warning Alert Notification -->
            @if(session('warning'))
            <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg flex gap-3 items-start animate-in fade-in slide-in-from-top-2 duration-300">
                <div class="flex-shrink-0 mt-0.5">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-yellow-800">
                        {{ session('warning') }}
                    </p>
                </div>
                <button type="button" 
                        onclick="this.parentElement.style.display='none'"
                        class="flex-shrink-0 text-yellow-400 hover:text-yellow-600 transition-colors">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            placeholder="Masukkan username"
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-slate-200 rounded-xl
                            focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent
                            transition-all duration-200 text-slate-900 placeholder-slate-400"
                        >
                    </div>
                    @error('username')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="Masukkan password"
                            class="w-full pl-12 pr-12 py-3.5 border-2 border-slate-200 rounded-xl
                            focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent
                            transition-all duration-200 text-slate-900 placeholder-slate-400"
                        >
                        <!-- Toggle Password Visibility -->
                        <button
                            type="button"
                            id="togglePassword"
                            onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors duration-200 focus:outline-none"
                        >
                            <!-- Eye Icon (Show) -->
                            <svg id="eyeIcon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <!-- Eye Off Icon (Hide) -->
                            <svg id="eyeOffIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        class="w-4 h-4 text-orange-600 bg-slate-100 border-slate-300 rounded focus:ring-orange-500 focus:ring-2"
                    >
                    <label for="remember" class="ml-2 text-sm text-slate-600 font-medium cursor-pointer">
                        Ingat saya
                    </label>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600
                    text-white font-bold py-4 rounded-xl
                    transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5
                    focus:outline-none focus:ring-4 focus:ring-orange-500 focus:ring-opacity-50"
                >
                    Masuk
                </button>

                <!-- Sign Up Link -->
                <div class="text-center mt-6">
                    <p class="text-slate-600 text-sm">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-semibold text-orange-600 hover:text-orange-700 transition-colors duration-200">
                            Buat sekarang
                        </a>
                    </p>
                </div>

                <!-- Back to Home Link -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-orange-600 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>

            </form>

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-slate-200 text-center">
                <p class="text-sm text-slate-500">
                    © {{ date('Y') }} <span class="font-semibold text-slate-700">Coole-Bill</span> · Smart POS System
                </p>
            </div>

        </div>

    </div>

</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeOffIcon = document.getElementById('eyeOffIcon');
        
        if (passwordInput.type === 'password') {
            // Show password
            passwordInput.type = 'text';
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        } else {
            // Hide password
            passwordInput.type = 'password';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        }
    }
</script>

</body>
</html>