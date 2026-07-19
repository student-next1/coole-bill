@extends('layouts.app')

@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

<div class="space-y-4 md:space-y-6">

    <!-- Hero Welcome Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-orange-600 via-orange-500 to-orange-400 rounded-xl md:rounded-2xl shadow-lg md:shadow-2xl">
        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 w-40 h-40 md:w-64 md:h-64 bg-white/10 rounded-full -mr-20 md:-mr-32 -mt-20 md:-mt-32"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 md:w-48 md:h-48 bg-white/10 rounded-full -ml-16 md:-ml-24 -mb-16 md:-mb-24"></div>
        
        <div class="relative z-10 p-5 md:p-8 lg:p-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 md:gap-6">
                <div class="flex-1">
                    <div class="inline-block px-3 md:px-4 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs md:text-sm font-medium mb-2 md:mb-4">
                        👋 Selamat datang kembali
                    </div>
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-white mb-2 md:mb-3 break-words">
                        {{ Auth::user()->name }}
                    </h1>
                    <p class="text-sm md:text-base text-orange-100 max-w-xl">
                        Sistem POS siap membantu mengelola bisnis Anda. Mari mulai hari yang produktif!
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 md:gap-3 w-full md:w-auto">
                    <a href="{{ route('transaksi.create') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 md:px-8 py-3 md:py-4 bg-white text-orange-600 font-bold rounded-lg md:rounded-xl hover:shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-200 text-sm md:text-base whitespace-nowrap">
                        <span class="text-lg md:text-xl">🛒</span>
                        <span>Mulai Transaksi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid - Modern Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4 lg:gap-6">

        <!-- Total Produk -->
        <div class="group relative bg-white rounded-lg md:rounded-2xl shadow-sm hover:shadow-lg md:hover:shadow-xl border border-slate-200 p-3 md:p-6 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-12 h-12 md:w-20 md:h-20 bg-gradient-to-br from-blue-500/10 to-blue-600/10 rounded-bl-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-2 md:mb-4">
                    <div class="w-8 h-8 md:w-12 md:h-12 bg-blue-100 rounded-lg md:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-lg md:text-2xl">📦</span>
                    </div>
                    <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 md:px-3 py-0.5 md:py-1 rounded-full">Produk</span>
                </div>
                <h3 class="text-2xl md:text-4xl font-black text-gray-900 mb-0.5 md:mb-1">{{ number_format($totalProduk) }}</h3>
                <p class="text-xs md:text-sm text-gray-500">Total Produk</p>
                @if($stokRendah > 0)
                <p class="text-xs text-red-600 mt-1 md:mt-2">⚠️ {{ $stokRendah }} stok rendah</p>
                @endif
            </div>
        </div>

        <!-- Kategori -->
        <div class="group relative bg-white rounded-lg md:rounded-2xl shadow-sm hover:shadow-lg md:hover:shadow-xl border border-slate-200 p-3 md:p-6 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-12 h-12 md:w-20 md:h-20 bg-gradient-to-br from-purple-500/10 to-purple-600/10 rounded-bl-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-2 md:mb-4">
                    <div class="w-8 h-8 md:w-12 md:h-12 bg-purple-100 rounded-lg md:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-lg md:text-2xl">🏷️</span>
                    </div>
                    <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 md:px-3 py-0.5 md:py-1 rounded-full">Kategori</span>
                </div>
                <h3 class="text-2xl md:text-4xl font-black text-gray-900 mb-0.5 md:mb-1">{{ number_format($totalKategori) }}</h3>
                <p class="text-xs md:text-sm text-gray-500">Total Kategori</p>
            </div>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="group relative bg-white rounded-lg md:rounded-2xl shadow-sm hover:shadow-lg md:hover:shadow-xl border border-slate-200 p-3 md:p-6 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-12 h-12 md:w-20 md:h-20 bg-gradient-to-br from-green-500/10 to-green-600/10 rounded-bl-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-2 md:mb-4">
                    <div class="w-8 h-8 md:w-12 md:h-12 bg-green-100 rounded-lg md:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-lg md:text-2xl">📊</span>
                    </div>
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-2 md:px-3 py-0.5 md:py-1 rounded-full">Hari Ini</span>
                </div>
                <h3 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-green-600 to-green-500 bg-clip-text text-transparent mb-0.5 md:mb-1">
                    {{ number_format($transaksiHariIni) }}
                </h3>
                <p class="text-xs md:text-sm text-gray-500">Transaksi Hari Ini</p>
                <p class="text-xs text-gray-400 mt-1 md:mt-2">{{ number_format($transaksiMingguIni) }} minggu ini</p>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="group relative bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg md:rounded-2xl shadow-lg hover:shadow-xl md:hover:shadow-2xl p-3 md:p-6 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-12 h-12 md:w-20 md:h-20 bg-white/10 rounded-bl-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-2 md:mb-4">
                    <div class="w-8 h-8 md:w-12 md:h-12 bg-white/20 backdrop-blur-sm rounded-lg md:rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-lg md:text-2xl">💰</span>
                    </div>
                    <span class="text-xs font-medium text-white bg-white/20 backdrop-blur-sm px-2 md:px-3 py-0.5 md:py-1 rounded-full">Pendapatan</span>
                </div>
                <h3 class="text-xl md:text-3xl font-black text-white mb-0.5 md:mb-1 break-words">
                    Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}
                </h3>
                <p class="text-xs md:text-sm text-orange-100">Pendapatan Hari Ini</p>
            </div>
        </div>

    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        
        <!-- Left Column - Quick Actions & Top Products -->
        <div class="md:col-span-2 lg:col-span-2 space-y-4 md:space-y-6">
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg md:rounded-2xl shadow-sm border border-slate-200 p-4 md:p-6">
                <h3 class="text-base md:text-lg font-bold text-gray-900 mb-3 md:mb-5 flex items-center gap-2">
                    <span class="text-lg md:text-xl">⚡</span>
                    <span>Aksi Cepat</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 md:gap-4">
                    
                    <!-- Transaksi Baru -->
                    <a href="{{ route('transaksi.create') }}" 
                       class="group relative overflow-hidden bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-lg md:rounded-xl p-3 md:p-5 hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <div class="absolute top-0 right-0 w-12 h-12 md:w-16 md:h-16 bg-orange-200/50 rounded-bl-full"></div>
                        <div class="relative">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-orange-600 rounded-lg flex items-center justify-center mb-2 md:mb-3">
                                <span class="text-lg md:text-xl">🛒</span>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-0.5 md:mb-1 text-sm md:text-base">Transaksi Baru</h4>
                            <p class="text-xs text-gray-600">Mulai penjualan →</p>
                        </div>
                    </a>

                    <!-- Kelola Produk -->
                    <a href="{{ route('produk.index') }}" 
                       class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-lg md:rounded-xl p-3 md:p-5 hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <div class="absolute top-0 right-0 w-12 h-12 md:w-16 md:h-16 bg-blue-200/50 rounded-bl-full"></div>
                        <div class="relative">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-600 rounded-lg flex items-center justify-center mb-2 md:mb-3">
                                <span class="text-lg md:text-xl">📦</span>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-0.5 md:mb-1 text-sm md:text-base">Kelola Produk</h4>
                            <p class="text-xs text-gray-600">Lihat & edit →</p>
                        </div>
                    </a>

                    <!-- Riwayat Transaksi -->
                    <a href="{{ route('transaksi.index') }}" 
                       class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-lg md:rounded-xl p-3 md:p-5 hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <div class="absolute top-0 right-0 w-12 h-12 md:w-16 md:h-16 bg-green-200/50 rounded-bl-full"></div>
                        <div class="relative">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-green-600 rounded-lg flex items-center justify-center mb-2 md:mb-3">
                                <span class="text-lg md:text-xl">📋</span>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-0.5 md:mb-1 text-sm md:text-base">Riwayat</h4>
                            <p class="text-xs text-gray-600">Lihat transaksi →</p>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Produk Terlaris -->
            <div class="bg-white rounded-lg md:rounded-2xl shadow-sm border border-slate-200 p-4 md:p-6">
                <div class="flex items-center justify-between mb-3 md:mb-5 flex-wrap gap-2">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="text-lg md:text-xl">🔥</span>
                        <span class="truncate">Produk Terlaris Bulan Ini</span>
                    </h3>
                    <a href="{{ route('produk.index') }}" class="text-xs md:text-sm text-orange-600 hover:text-orange-700 font-medium whitespace-nowrap">
                        Lihat Semua →
                    </a>
                </div>
                @if($produkTerlaris->count() > 0)
                <div class="space-y-2 md:space-y-3">
                    @foreach($produkTerlaris as $index => $item)
                    <div class="flex items-center gap-2 md:gap-4 p-2 md:p-3 rounded-lg md:rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 rounded-lg {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-500' : ($index === 1 ? 'bg-gradient-to-br from-gray-400 to-gray-500' : ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-slate-200')) }} flex items-center justify-center text-white font-bold text-sm md:text-base">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate text-sm md:text-base">{{ $item->nama_produk }}</p>
                            <p class="text-xs text-gray-500">Terjual {{ number_format($item->total_qty) }} unit</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="inline-block px-2 md:px-3 py-0.5 md:py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold whitespace-nowrap">
                                {{ number_format($item->total_qty) }}x
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-6 md:py-8 text-gray-400">
                    <span class="text-3xl md:text-4xl mb-2 block">📦</span>
                    <p class="text-xs md:text-sm">Belum ada data penjualan bulan ini</p>
                </div>
                @endif
            </div>

        </div>

        <!-- Right Column - Recent Transactions & Stock Alert -->
        <div class="space-y-4 md:space-y-6">
            
            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg md:rounded-2xl shadow-sm border border-slate-200 p-4 md:p-6">
                <div class="flex items-center justify-between mb-3 md:mb-5">
                    <h3 class="text-base md:text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="text-lg md:text-xl">📝</span>
                        <span class="truncate">Transaksi Terbaru</span>
                    </h3>
                </div>
                @if($transaksiTerbaru->count() > 0)
                <div class="space-y-2 md:space-y-3">
                    @foreach($transaksiTerbaru as $transaksi)
                    <div class="p-2 md:p-3 border border-slate-100 rounded-lg md:rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex items-start justify-between mb-1 md:mb-2">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-mono text-gray-500 truncate">{{ $transaksi->kode_transaksi }}</p>
                                <p class="text-xs text-gray-400">{{ $transaksi->created_at->diffForHumans() }}</p>
                            </div>
                            @if($transaksi->metode_pembayaran === 'tunai')
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full font-medium flex-shrink-0 ml-2">Tunai</span>
                            @else
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium flex-shrink-0 ml-2">Kartu</span>
                            @endif
                        </div>
                        <p class="font-bold text-orange-600 text-sm md:text-base">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('transaksi.index') }}" class="block mt-3 md:mt-4 text-center text-xs md:text-sm text-orange-600 hover:text-orange-700 font-medium">
                    Lihat Semua Transaksi →
                </a>
                @else
                <div class="text-center py-6 md:py-8 text-gray-400">
                    <span class="text-3xl md:text-4xl mb-2 block">📋</span>
                    <p class="text-xs md:text-sm">Belum ada transaksi</p>
                </div>
                @endif
            </div>

            <!-- Stock Alert -->
            <div class="bg-gradient-to-br from-red-50 to-orange-50 border-2 border-red-200 rounded-lg md:rounded-2xl p-4 md:p-6">
                <div class="flex items-center justify-between mb-3 md:mb-5">
                    <h3 class="text-base md:text-lg font-bold text-red-900 flex items-center gap-2">
                        <span class="text-lg md:text-xl">⚠️</span>
                        <span>Stok Rendah</span>
                    </h3>
                </div>
                @if($produkStokRendah->count() > 0)
                <div class="space-y-2 md:space-y-3 max-h-64 md:max-h-96 overflow-y-auto">
                    @foreach($produkStokRendah as $produk)
                    <div class="flex items-center justify-between p-2 md:p-3 bg-white rounded-lg md:rounded-xl">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate text-sm md:text-base">{{ $produk->nama_produk }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right flex-shrink-0 ml-2">
                            <span class="inline-block px-2 md:px-3 py-0.5 md:py-1 {{ $produk->stok === 0 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }} rounded-full text-xs font-bold whitespace-nowrap">
                                {{ $produk->stok }} unit
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('produk.index') }}" class="block mt-3 md:mt-4 text-center text-xs md:text-sm text-red-600 hover:text-red-700 font-medium">
                    Kelola Stok Produk →
                </a>
                @else
                <div class="text-center py-4 md:py-6 text-gray-400">
                    <span class="text-2xl md:text-3xl mb-2 block">✅</span>
                    <p class="text-xs md:text-sm text-green-700 font-medium">Semua stok aman!</p>
                </div>
                @endif
            </div>

            <!-- System Info Card -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg md:rounded-2xl p-4 md:p-6 text-white">
                <div class="flex items-center gap-2 md:gap-3 mb-3 md:mb-4">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-lg md:text-xl">💳</span>
                    </div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-sm md:text-base truncate">Kartu Pembayaran</h4>
                        <p class="text-xs text-slate-400">Total aktif</p>
                    </div>
                </div>
                <div class="text-2xl md:text-3xl font-black mb-2">{{ number_format($totalKartu) }}</div>
                <a href="{{ route('payment-cards.index') }}" class="text-xs text-orange-400 hover:text-orange-300 font-medium">
                    Kelola Kartu →
                </a>
            </div>

        </div>

    </div>

</div>

@endsection
