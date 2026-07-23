<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe - {{ $planName }} | Coole-Bill POS</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 antialiased">

<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-2xl">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-orange-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="font-medium">Kembali</span>
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-600 to-orange-500 px-8 py-6 text-white">
                <h1 class="text-3xl font-black mb-2">Subscribe {{ $planName }}</h1>
                <p class="text-orange-100">Lengkapi data untuk memulai subscription Anda</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('subscribe.process') }}" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="plan_type" value="{{ $planType }}">

                <!-- Plan Info -->
                <div class="bg-orange-50 border-2 border-orange-200 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-black text-gray-900">{{ $planName }}</h3>
                            <p class="text-gray-600 mt-1">Durasi: {{ $planDuration }} hari</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-black text-orange-600">
                                @if($planPrice == 0)
                                    Gratis
                                @else
                                    Rp {{ number_format($planPrice, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Masukkan nama lengkap"
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        placeholder="email@example.com"
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor Telepon (WhatsApp)
                    </label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                        placeholder="08123456789"
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                    >
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if($planPrice > 0)
                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-orange-500 transition-all">
                            <input type="radio" name="payment_method" value="transfer" class="w-4 h-4 text-orange-600" required>
                            <div>
                                <p class="font-semibold text-gray-900">Transfer Bank</p>
                                <p class="text-sm text-gray-600">BCA: 1234567890 a.n. Coole-Bill</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-orange-500 transition-all">
                            <input type="radio" name="payment_method" value="ewallet" class="w-4 h-4 text-orange-600" required>
                            <div>
                                <p class="font-semibold text-gray-900">E-Wallet</p>
                                <p class="text-sm text-gray-600">GoPay / OVO / DANA</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Payment Proof -->
                <div>
                    <label for="payment_proof" class="block text-sm font-semibold text-slate-700 mb-2">
                        Upload Bukti Pembayaran
                    </label>
                    <input
                        type="file"
                        id="payment_proof"
                        name="payment_proof"
                        accept="image/jpeg,image/png,image/jpg"
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                    >
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                    @error('payment_proof')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endif

                <!-- Submit Button -->
                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-bold py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        @if($planPrice == 0)
                            Mulai Trial Gratis
                        @else
                            Lanjutkan ke Registrasi
                        @endif
                    </button>
                </div>

                <!-- Info Text -->
                <div class="text-center text-sm text-gray-600">
                    @if($planPrice == 0)
                        <p>Trial gratis akan aktif otomatis setelah registrasi</p>
                    @else
                        <p>Subscription akan diaktifkan setelah pembayaran dikonfirmasi</p>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
