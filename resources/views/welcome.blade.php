<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coole-Bill POS - Sistem Kasir Modern untuk Bisnis Anda</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-white">

<!-- Navbar - Minimal & Clean -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1">
                    <!-- COOL: BG Hitam, Text Putih -->
                    <div class="px-3 py-1 rounded-lg" style="background-color: #000000 !important;">
                        <span class="font-black text-lg" style="color: #FFFFFF !important;">COOL</span>
                    </div>
                    <!-- E-BILL: BG Putih, Text Orange -->
                    <div class="px-3 py-1 rounded-lg" style="background-color: #FFFFFF !important;">
                        <span class="font-black text-lg" style="color: #EA580C !important;">E-BILL</span>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                    Fitur
                </a>
                <a href="#pricing" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                    Harga
                </a>
                <a href="#keunggulan" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                    Keunggulan
                </a>
                <a href="#tentang" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                    Tentang
                </a>
            </div>

            <!-- CTA Button -->
            @auth
            <!-- User Profile Dropdown (if logged in) -->
            <div class="relative">
                <button 
                    id="userMenuButtonWelcome"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50 transition-all duration-200 group border-2 border-orange-200">
                    
                    <!-- Avatar -->
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 p-0.5 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=ea580c"
                            class="w-full h-full rounded-full"
                            alt="avatar">
                    </div>

                    <!-- User Info -->
                    <div class="hidden md:block text-left">
                        <p class="font-semibold text-sm leading-tight text-gray-900">
                            {{ Auth::user()->name }}
                        </p>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-orange-100 text-orange-700">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        </div>
                    </div>

                    <!-- Dropdown Icon -->
                    <svg id="dropdownIconWelcome" class="w-4 h-4 text-gray-700 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div 
                    id="userMenuWelcome"
                    class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-50 opacity-0 scale-95 transition-all duration-100">
                    
                    <!-- User Info Mobile -->
                    <div class="md:hidden px-4 py-3 border-b border-slate-100">
                        <p class="font-semibold text-sm text-gray-900">
                            {{ Auth::user()->name }}
                        </p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-orange-100 text-orange-700 mt-1">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>

                    <!-- Menu Items -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-slate-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <div class="border-t border-slate-100 my-2"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            @else
            <!-- Login Button (if not logged in) -->
            <a href="{{ route('login') }}" 
               class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-200">
                Masuk Sekarang
            </a>
            @endauth

        </div>
    </div>
</nav>

<!-- Hero Section - Bold & Engaging -->
<section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden bg-gradient-to-b from-orange-300 to-orange-100">
    
    <!-- Decorative Background -->
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Content -->
            <div>
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-orange-100 rounded-full text-orange-600 font-medium text-sm mb-8">
                    <span class="w-2 h-2 bg-orange-600 rounded-full animate-pulse"></span>
                    Sistem POS Terpercaya
                </div>

                <!-- Headline -->
<h1 class="text-5xl lg:text-6xl font-black text-gray-900 leading-tight mb-6">
                    Atur Bisnis Anda
                    <span class="text-orange-600">
                        dengan Sistem Kasir
                    </span>
                    Terbaik dan Cepat 
                </h1>

                <!-- Subheadline -->
                <p class="text-xl text-gray-600 mb-10 leading-relaxed">
                    Kelola penjualan, produk, dan stok dengan mudah. Sistem POS yang cepat, aman, dan dirancang untuk meningkatkan produktivitas bisnis Anda.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    @auth
                    <!-- If logged in - Go to Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-200">
                        <span>Mulai Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    @else
                    <!-- If not logged in - Go to Login -->
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-200">
                        <span>Mulai Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    @endauth
                    <a href="#fitur" 
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white border-2 border-gray-300 text-gray-900 font-bold rounded-xl hover:border-orange-500 hover:text-orange-600 transition-all duration-200">
                        <span>Lihat Fitur</span>
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-8 mt-12 pt-12 border-t border-gray-200">
                    <div>
                        <div class="text-3xl font-black text-gray-900">100%</div>
                        <div class="text-sm text-gray-600 mt-1">Responsive</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-gray-900">Fast</div>
                        <div class="text-sm text-gray-600 mt-1">Performance</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-gray-900">24/7</div>
                        <div class="text-sm text-gray-600 mt-1">Available</div>
                    </div>
                </div>
            </div>

            <!-- Right Visual -->
            <div class="relative hidden lg:block">
                <div class="relative">
                    <!-- Main Card - Combined Table & Chart -->
                    <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
                        <div class="grid grid-cols-2 min-h-96">
                            
                            <!-- LEFT: Transaction Table -->
                            <div class="p-5 border-r border-gray-200 flex flex-col bg-white">
                                <div class="flex-1 flex flex-col">
                                    <!-- Header -->
                                    <div class="pb-3 border-b border-gray-200 mb-3">
                                        <div class="text-xs text-gray-500 mb-1">Tabel Transaksi</div>
                                        <div class="text-lg font-bold text-gray-900">Rp 115K</div>
                                    </div>
                                    
                                    <!-- Transaction Items -->
                                    <div class="space-y-1 text-sm flex-1 overflow-y-auto">
                                        <div class="flex justify-between items-center hover:bg-gray-50 p-2 rounded">
                                            <span class="font-medium text-gray-900 text-xs">Produk A</span>
                                            <span class="text-gray-600 text-xs">x2</span>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-600 px-2">
                                            <span>Rp 25K</span>
                                            <span class="font-semibold text-gray-900">Rp 50K</span>
                                        </div>

                                        <div class="flex justify-between items-center hover:bg-gray-50 p-2 rounded">
                                            <span class="font-medium text-gray-900 text-xs">Produk B</span>
                                            <span class="text-gray-600 text-xs">x3</span>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-600 px-2">
                                            <span>Rp 15K</span>
                                            <span class="font-semibold text-gray-900">Rp 45K</span>
                                        </div>

                                        <div class="flex justify-between items-center hover:bg-gray-50 p-2 rounded">
                                            <span class="font-medium text-gray-900 text-xs">Produk C</span>
                                            <span class="text-gray-600 text-xs">x1</span>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-600 px-2">
                                            <span>Rp 20K</span>
                                            <span class="font-semibold text-gray-900">Rp 20K</span>
                                        </div>
                                    </div>

                                    <!-- Summary -->
                                    <div class="pt-2 mt-3 border-t-2 border-gray-200 space-y-1 text-xs">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span class="font-semibold">Rp 115K</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Diskon</span>
                                            <span class="font-semibold text-orange-600">- Rp 0</span>
                                        </div>
                                        <div class="flex justify-between text-sm font-bold bg-orange-50 -mx-5 px-5 py-2 mt-2 rounded-bl-3xl">
                                            <span>Total</span>
                                            <span class="text-orange-600">Rp 115K</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT: Chart -->
                            <div class="p-5 bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col justify-between rounded-br-3xl">
                                <div>
                                    <div class="text-xs text-gray-500 mb-4 font-semibold">Grafik Penjualan 7 Hari</div>
                                </div>
                                
                                <!-- Bar Chart with Chart.js -->
                                <div class="flex-1 flex items-center justify-center">
                                    <canvas id="weeklyChart" style="max-height: 160px; max-width: 100%;"></canvas>
                                </div>

                                <div class="text-center mt-2">
                                    <span class="text-xs text-gray-500">Penjualan Mingguan (Rp)</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Floating Badge -->
                    <div class="absolute -top-4 -right-4 bg-green-500 text-white px-4 py-2 rounded-xl shadow-lg font-bold text-sm">
                        Proses
                    </div>
                </div>
            </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Features Section -->
<section id="fitur" class="py-20 lg:py-32 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-orange-100 rounded-full text-orange-600 font-bold text-sm mb-4">
                Fitur Lengkap
            </div>
            <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                Semua yang Anda Butuhkan
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Dilengkapi dengan fitur-fitur modern untuk mengelola bisnis dengan lebih efisien
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Feature 1 -->
            <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">📦</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kelola Produk</h3>
                <p class="text-gray-600 leading-relaxed">
                    Manajemen produk lengkap dengan stok, harga, kategori, dan barcode scanning.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">🛒</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Transaksi Cepat</h3>
                <p class="text-gray-600 leading-relaxed">
                    Interface POS modern dengan keyboard shortcuts untuk transaksi yang lebih cepat.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">💳</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Multi Payment</h3>
                <p class="text-gray-600 leading-relaxed">
                    Mendukung pembayaran tunai dan kartu ID dengan sistem yang aman dan terintegrasi.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">📊</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Dashboard Real-time</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pantau performa bisnis dengan statistik dan laporan yang update secara real-time.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">📈</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan Lengkap</h3>
                <p class="text-gray-600 leading-relaxed">
                    Laporan penjualan harian, mingguan, dan bulanan dengan visualisasi yang jelas.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">🖨️</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Cetak Struk</h3>
                <p class="text-gray-600 leading-relaxed">
                    Cetak struk pembayaran otomatis untuk setiap transaksi dengan format profesional.
                </p>
            </div>

            <!-- Feature 7 -->
            <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">⚡</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Barcode Scanner</h3>
                <p class="text-gray-600 leading-relaxed">
                    Dukungan barcode scanner untuk input produk yang lebih cepat dan akurat.
                </p>
            </div>

            <!-- Feature 8 -->
            <div class="group bg-white rounded-2xl p-8 border border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">📱</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Responsive Design</h3>
                <p class="text-gray-600 leading-relaxed">
                    Tampilan yang optimal di semua perangkat: desktop, tablet, dan smartphone.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Benefits Section -->
<section id="keunggulan" class="py-20 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Left Content -->
            <div>
                <div class="inline-block px-4 py-2 bg-orange-100 rounded-full text-orange-600 font-bold text-sm mb-6">
                    Keunggulan Kami
                </div>
                <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-6">
                    Mengapa Memilih 
                    <span class="bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">
                        Coole-Bill?
                    </span>
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Dirancang khusus untuk bisnis retail dan UMKM dengan fokus pada kemudahan penggunaan dan performa tinggi.
                </p>

                <!-- Benefits List -->
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Interface User-Friendly</h4>
                            <p class="text-gray-600">Mudah dipelajari dan digunakan, bahkan untuk pemula sekalipun.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Performa Cepat & Stabil</h4>
                            <p class="text-gray-600">Dibangun dengan Laravel modern untuk performa optimal.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Aman & Terpercaya</h4>
                            <p class="text-gray-600">Sistem keamanan berlapis untuk melindungi data bisnis Anda.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-1">Terus Berkembang</h4>
                            <p class="text-gray-600">Update reguler dengan fitur-fitur baru berdasarkan feedback pengguna.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Visual -->
            <div class="relative">
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl p-8 border border-orange-200">
                    <div class="space-y-4">
                        <!-- Stat Cards -->
                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Transaksi Hari Ini</div>
                                    <div class="text-3xl font-black text-gray-900">127</div>
                                </div>
                                <div class="text-4xl">📊</div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Total Produk</div>
                                    <div class="text-3xl font-black text-gray-900">456</div>
                                </div>
                                <div class="text-4xl">📦</div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Pendapatan</div>
                                    <div class="text-3xl font-black text-gray-900">
                                        Rp 8.5jt
                                    </div>
                                </div>
                                <div class="text-4xl">💰</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- About Section -->
<section id="tentang" class="py-20 lg:py-32 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
        <div class="inline-block px-4 py-2 bg-orange-100 rounded-full text-orange-600 font-bold text-sm mb-6">
            Tentang Kami
        </div>
        <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-6">
            Solusi POS Terpadu untuk UMKM Indonesia
        </h2>
        <p class="text-xl text-gray-600 leading-relaxed mb-8">
            Coole-Bill adalah sistem Point of Sale berbasis web yang dikembangkan dengan teknologi Laravel modern. 
            Dirancang khusus untuk membantu pelaku UMKM dan bisnis retail dalam mengelola operasional harian dengan lebih efisien.
        </p>
        <p class="text-lg text-gray-600 leading-relaxed">
            Dengan interface yang intuitif dan fitur yang lengkap, kami berkomitmen untuk terus berinovasi 
            dan memberikan pengalaman terbaik bagi pengguna kami.
        </p>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="py-20 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2 bg-orange-100 rounded-full text-orange-600 font-bold text-sm mb-4">
                Harga Terjangkau
            </div>
            <h2 class="text-4xl lg:text-5xl font-black text-gray-900 mb-4">
                Pilih Paket yang Tepat
                <span class="text-orange-600">untuk Bisnis Anda</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Mulai gratis atau pilih paket yang sesuai kebutuhan bisnis Anda
            </p>
        </div>

        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            
            <!-- Trial Package -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-8 border-2 border-gray-200 hover:border-gray-300 transition-all duration-300 hover:shadow-lg">
                <div class="text-center mb-6">
                    <div class="inline-block px-4 py-2 bg-gray-600 text-white text-sm font-bold rounded-full mb-4">
                        TRIAL
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">Gratis 7 Hari</h3>
                    <div class="flex items-baseline justify-center gap-1">
                        <span class="text-5xl font-black text-gray-900">Rp 0</span>
                    </div>
                    <p class="text-gray-600 mt-2">Perfect untuk trial</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Akses penuh 7 hari</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Semua fitur tersedia</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Tanpa kartu kredit</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Support email</span>
                    </li>
                </ul>

                <a href="{{ route('register') }}?plan=trial" 
                   class="block w-full text-center px-6 py-4 bg-gray-700 hover:bg-gray-800 text-white font-bold rounded-xl transition-all duration-200">
                    Mulai Trial Gratis
                </a>
            </div>

            <!-- Monthly Package - POPULAR -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-3xl p-8 border-2 border-orange-500 hover:border-orange-600 transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-2 relative">
                <!-- Popular Badge -->
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-orange-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                        PALING POPULER
                    </span>
                </div>

                <div class="text-center mb-6 mt-4">
                    <div class="inline-block px-4 py-2 bg-orange-600 text-white text-sm font-bold rounded-full mb-4">
                        BULANAN
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">Paket Bulanan</h3>
                    <div class="flex items-baseline justify-center gap-1">
                        <span class="text-5xl font-black text-orange-600">Rp 99K</span>
                    </div>
                    <p class="text-gray-700 mt-2 font-medium">/ bulan</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Akses penuh 30 hari</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Semua fitur premium</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Update rutin gratis</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Support prioritas</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Backup data otomatis</span>
                    </li>
                </ul>

                <a href="{{ route('register') }}?plan=monthly" 
                   class="block w-full text-center px-6 py-4 bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 text-white font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                    Pilih Paket Ini
                </a>
            </div>

            <!-- Semester Package - BEST VALUE -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl p-8 border-2 border-blue-500 hover:border-blue-600 transition-all duration-300 hover:shadow-xl relative">
                <!-- Best Value Badge -->
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-blue-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                        HEMAT Rp 95K
                    </span>
                </div>

                <div class="text-center mb-6 mt-4">
                    <div class="inline-block px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-full mb-4">
                        6 BULAN
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">Paket Semester</h3>
                    <div class="flex items-baseline justify-center gap-1">
                        <span class="text-5xl font-black text-blue-600">Rp 499K</span>
                    </div>
                    <p class="text-gray-700 mt-2 font-medium">/ 6 bulan</p>
                    <p class="text-sm text-green-600 font-bold mt-1">~Rp 83K/bulan</p>
                </div>

                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Akses penuh 180 hari</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Semua fitur premium</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Update & fitur baru</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Support VIP 24/7</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700 font-medium">Konsultasi bisnis gratis</span>
                    </li>
                </ul>

                <a href="{{ route('register') }}?plan=semester" 
                   class="block w-full text-center px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg">
                    Pilih Paket Hemat
                </a>
            </div>

        </div>

        <!-- Money Back Guarantee -->
        <div class="mt-16 text-center">
            <div class="inline-flex items-center gap-3 bg-green-50 border-2 border-green-500 rounded-full px-6 py-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span class="font-bold text-green-800">Garansi 100% Aman · Data Terenkripsi · Support Cepat</span>
            </div>
        </div>

    </div>
</section>

<!-- CTA Section -->
<section class="py-20 lg:py-32 bg-gradient-to-br from-orange-600 to-orange-500 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full -ml-48 -mb-48"></div>
    
    <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-4xl lg:text-5xl font-black text-white mb-6">
            Siap Meningkatkan Bisnis Anda?
        </h2>
        <p class="text-xl text-orange-100 mb-10">
            Mulai gunakan Coole-Bill sekarang dan rasakan perbedaannya
        </p>
        @auth
        <!-- If logged in - Go to Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center justify-center gap-2 px-10 py-5 bg-white text-orange-600 font-black rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-200 text-lg">
            <span>Masuk ke Dashboard</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
        @else
        <!-- If not logged in - Go to Login -->
        <a href="{{ route('login') }}" 
           class="inline-flex items-center justify-center gap-2 px-10 py-5 bg-white text-orange-600 font-black rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-200 text-lg">
            <span>Masuk ke Dashboard</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
        @endauth
    </div>
</section>

<!-- Footer -->
<footer class="bg-slate-900 text-white py-2">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            
            <!-- Logo & Copyright -->
            <div class="text-center md:text-left">
                <div class="flex items-center gap-1 justify-center md:justify-start mb-1">
                    <!-- COOL: BG Hitam, Text Putih -->
                    <div class="px-3 py-1 rounded-lg" style="background-color: #000000 !important;">
                        <span class="font-black" style="color: #FFFFFF !important;">COOL</span>
                    </div>
                    <!-- E-BILL: BG Putih, Text Orange -->
                    <div class="px-3 py-1 rounded-lg" style="background-color: #FFFFFF !important;">
                        <span class="font-black" style="color: #EA580C !important;">E-BILL</span>
                    </div>
                <p class="text-slate-400 text-sm">
                    © {{ date('Y') }} Coole-Bill POS. All rights reserved.
                </div>  
                </p>
            </div>

            <!-- Links -->
            <div class="flex gap-8">
                <a href="#fitur" class="text-slate-400 hover:text-white transition-colors">Fitur</a>
                <a href="#keunggulan" class="text-slate-400 hover:text-white transition-colors">Keunggulan</a>
                <a href="#tentang" class="text-slate-400 hover:text-white transition-colors">Tentang</a>
            </div>

        </div>
    </div>
</footer>

<!-- Custom Animations -->
<style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .animate-blob {
        animation: blob 7s infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>

<!-- Chart Initialization Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('weeklyChart');
    if (ctx) {
        const weeklyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: [750000, 950000, 650000, 1100000, 850000, 920000, 780000],
                    backgroundColor: [
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(234, 88, 12, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(249, 115, 22, 0.8)'
                    ],
                    borderColor: [
                        'rgba(249, 115, 22, 1)',
                        'rgba(249, 115, 22, 1)',
                        'rgba(249, 115, 22, 1)',
                        'rgba(234, 88, 12, 1)',
                        'rgba(249, 115, 22, 1)',
                        'rgba(249, 115, 22, 1)',
                        'rgba(249, 115, 22, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'K';
                            },
                            font: {
                                size: 10
                            },
                            color: 'rgba(107, 114, 128, 0.7)'
                        },
                        grid: {
                            color: 'rgba(229, 231, 235, 0.5)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10
                            },
                            color: 'rgba(107, 114, 128, 0.7)'
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    }
});
</script>

<!-- User Menu Dropdown Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userMenuButton = document.getElementById('userMenuButtonWelcome');
    const userMenu = document.getElementById('userMenuWelcome');
    const dropdownIcon = document.getElementById('dropdownIconWelcome');

    if (userMenuButton && userMenu) {
        // Toggle dropdown
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = userMenu.classList.contains('hidden');
            
            if (isHidden) {
                userMenu.classList.remove('hidden');
                setTimeout(() => {
                    userMenu.classList.remove('opacity-0', 'scale-95');
                    userMenu.classList.add('opacity-100', 'scale-100');
                }, 10);
                dropdownIcon.classList.add('rotate-180');
            } else {
                userMenu.classList.remove('opacity-100', 'scale-100');
                userMenu.classList.add('opacity-0', 'scale-95');
                dropdownIcon.classList.remove('rotate-180');
                setTimeout(() => {
                    userMenu.classList.add('hidden');
                }, 100);
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
                if (!userMenu.classList.contains('hidden')) {
                    userMenu.classList.remove('opacity-100', 'scale-100');
                    userMenu.classList.add('opacity-0', 'scale-95');
                    dropdownIcon.classList.remove('rotate-180');
                    setTimeout(() => {
                        userMenu.classList.add('hidden');
                    }, 100);
                }
            }
        });
    }
});
</script>

</body>
</html>
