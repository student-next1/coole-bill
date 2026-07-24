<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Coole-Bill POS</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-slate-50 antialiased">

<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-5xl">
        <div class="grid lg:grid-cols-2 gap-8 items-start">
            
            <!-- Left Side: Registration Form -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 lg:p-10">
                
                <!-- Header -->
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="px-3 py-1.5 bg-black rounded">
                            <span class="text-white font-black text-sm">COOL</span>
                        </div>
                        <div class="px-3 py-1.5 bg-orange-600 rounded">
                            <span class="text-white font-black text-sm">E-BILL</span>
                        </div>
                    </div>
                    <h1 class="text-3xl font-black text-slate-800 mb-2">Buat Akun Admin</h1>
                    <p class="text-slate-600">Lengkapi data untuk memulai subscription</p>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                    @csrf

                    <!-- Subscription ID (hidden, from query param) -->
                    @php
                        $subscriptionId = request()->query('subscription');
                        $plan = request()->query('plan', 'trial');
                    @endphp
                    <input type="hidden" name="subscription_id" value="{{ $subscriptionId }}">
                    <input type="hidden" name="plan" value="{{ $plan }}">

                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               required
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               required
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                               placeholder="nama@email.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required
                                   minlength="6"
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Minimal 6 karakter">
                            <button type="button" 
                                    onclick="togglePassword('password')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">
                            Konfirmasi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   minlength="6"
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Ulangi password">
                            <button type="button" 
                                    onclick="togglePassword('password_confirmation')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms" 
                               required
                               class="mt-1 w-4 h-4 text-orange-600 border-slate-300 rounded focus:ring-orange-500">
                        <label for="terms" class="text-sm text-slate-600">
                            Saya menyetujui <a href="#" class="text-orange-600 hover:text-orange-700 font-semibold">Syarat & Ketentuan</a> dan <a href="#" class="text-orange-600 hover:text-orange-700 font-semibold">Kebijakan Privasi</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full px-6 py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-xl hover:shadow-lg hover:from-orange-700 hover:to-orange-600 transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Daftar Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </form>

                <!-- Link to Login -->
                <div class="mt-6 pt-6 border-t border-slate-200 text-center">
                    <p class="text-sm text-slate-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-bold text-orange-600 hover:text-orange-700 transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>

                <!-- Back to Home -->
                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>

            <!-- Right Side: Subscription Info -->
            <div class="hidden lg:block">
                <div class="sticky top-8 space-y-6">
                    
                    <!-- Selected Plan Card -->
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl shadow-xl p-8 text-white">
                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-bold opacity-90">PAKET DIPILIH</span>
                        </div>
                        
                        @php
                            $planNames = [
                                'trial' => 'Trial Gratis',
                                'monthly' => 'Bulanan',
                                'semester' => 'Semester'
                            ];
                            $planPrices = [
                                'trial' => 'Rp 0',
                                'monthly' => 'Rp 99.000',
                                'semester' => 'Rp 499.000'
                            ];
                            $planDurations = [
                                'trial' => '7 Hari',
                                'monthly' => '30 Hari',
                                'semester' => '180 Hari'
                            ];
                            $selectedPlan = $planNames[$plan] ?? 'Trial Gratis';
                            $selectedPrice = $planPrices[$plan] ?? 'Rp 0';
                            $selectedDuration = $planDurations[$plan] ?? '7 Hari';
                        @endphp
                        
                        <h2 class="text-3xl font-black mb-2">{{ $selectedPlan }}</h2>
                        <p class="text-5xl font-black mb-1">{{ $selectedPrice }}</p>
                        <p class="text-sm opacity-75">{{ $selectedDuration }}</p>
                        
                        <div class="mt-8 pt-6 border-t border-white/20">
                            <p class="text-sm font-bold mb-3 opacity-90">YANG ANDA DAPATKAN:</p>
                            <ul class="space-y-3 text-sm">
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Akses penuh sebagai <strong>Admin</strong></span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Kelola produk & kategori</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Sistem kasir lengkap</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Laporan penjualan</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Kelola user & hak akses</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Support prioritas</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="font-bold text-blue-900 mb-1">Akun Admin Otomatis</h3>
                                <p class="text-sm text-blue-700">Setelah registrasi, Anda langsung mendapat akses penuh sebagai Admin dengan semua fitur tersedia.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        if (field.type === 'password') {
            field.type = 'text';
        } else {
            field.type = 'password';
        }
    }
</script>

</body>
</html>
