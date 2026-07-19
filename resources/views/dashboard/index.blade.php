@extends('layouts.app')

@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

<div class="space-y-6">

    <!-- Hero Welcome Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-orange-600 via-orange-500 to-orange-400 rounded-2xl shadow-2xl">
        <!-- Decorative circles -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
        
        <div class="relative z-10 p-8 md:p-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1">
                    <div class="inline-block px-4 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-4">
                        👋 Selamat datang kembali
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black text-white mb-3">
                        {{ Auth::user()->name }}
                    </h1>
                    <p class="text-orange-100 text-lg max-w-xl">
                        Sistem POS siap membantu mengelola bisnis Anda. Mari mulai hari yang produktif!
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('transaksi.create') }}" 
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-orange-600 font-bold rounded-xl hover:shadow-2xl hover:scale-105 transition-all duration-200">
                        <span class="text-xl">🛒</span>
                        <span>Mulai Transaksi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid - Modern Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">

        <!-- Total Produk -->
        <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 p-6 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500/10 to-blue-600/10 rounded-bl-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-2xl">📦</span>
                    </div>
                    <span class="text-xs font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Produk</span>
                </div>
                <h3 class="text-4xl font-black text-gray-900 mb-1">{{ number_format($totalProduk) }}</h3>
                <p class="text-sm text-gray-500">Total Produk</p>
                @if($stokRendah > 0)
                <p class="text-xs text-red-600 mt-2">⚠️ {{ $stokRendah }} stok rendah</p>
                @endif
            </div>
        </div>

        <!-- Kategori -->
        <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 p-6 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-500/10 to-purple-600/10 rounded-bl-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-2xl">🏷️</span>
                    </div>
                    <span class="text-xs font-medium text-purple-600 bg-purple-50 px-3 py-1 rounded-full">Kategori</span>
                </div>
                <h3 class="text-4xl font-black text-gray-900 mb-1">{{ number_format($totalKategori) }}</h3>
                <p class="text-sm text-gray-500">Total Kategori</p>
            </div>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl border border-slate-200 p-6 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-500/10 to-green-600/10 rounded-bl-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-2xl">📊</span>
                    </div>
                    <span class="text-xs font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full">Hari Ini</span>
                </div>
                <h3 class="text-4xl font-black bg-gradient-to-r from-green-600 to-green-500 bg-clip-text text-transparent mb-1">
                    {{ number_format($transaksiHariIni) }}
                </h3>
                <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
                <p class="text-xs text-gray-400 mt-2">{{ number_format($transaksiMingguIni) }} minggu ini</p>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="group relative bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg hover:shadow-2xl p-6 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-bl-full"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="text-2xl">💰</span>
                    </div>
                    <span class="text-xs font-medium text-white bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">Pendapatan</span>
                </div>
                <h3 class="text-3xl font-black text-white mb-1">
                    Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}
                </h3>
                <p class="text-sm text-orange-100">Pendapatan Hari Ini</p>
            </div>
        </div>

    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column - Quick Actions & Top Products -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
                    <span class="text-xl">⚡</span>
                    <span>Aksi Cepat</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <!-- Transaksi Baru -->
                    <a href="{{ route('transaksi.create') }}" 
                       class="group relative overflow-hidden bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl p-5 hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-orange-200/50 rounded-bl-full"></div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center mb-3">
                                <span class="text-xl">🛒</span>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Transaksi Baru</h4>
                            <p class="text-xs text-gray-600">Mulai penjualan →</p>
                        </div>
                    </a>

                    <!-- Kelola Produk -->
                    <a href="{{ route('produk.index') }}" 
                       class="group relative overflow-hidden bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-5 hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-blue-200/50 rounded-bl-full"></div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mb-3">
                                <span class="text-xl">📦</span>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Kelola Produk</h4>
                            <p class="text-xs text-gray-600">Lihat & edit →</p>
                        </div>
                    </a>

                    <!-- Riwayat Transaksi -->
                    <a href="{{ route('transaksi.index') }}" 
                       class="group relative overflow-hidden bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-5 hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-green-200/50 rounded-bl-full"></div>
                        <div class="relative">
                            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center mb-3">
                                <span class="text-xl">📋</span>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Riwayat</h4>
                            <p class="text-xs text-gray-600">Lihat transaksi →</p>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Produk Terlaris -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="text-xl">🔥</span>
                        <span>Produk Terlaris Bulan Ini</span>
                    </h3>
                    <a href="{{ route('produk.index') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>
                @if($produkTerlaris->count() > 0)
                <div class="space-y-3">
                    @foreach($produkTerlaris as $index => $item)
                    <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-500' : ($index === 1 ? 'bg-gradient-to-br from-gray-400 to-gray-500' : ($index === 2 ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-slate-200')) }} flex items-center justify-center text-white font-bold">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $item->nama_produk }}</p>
                            <p class="text-xs text-gray-500">Terjual {{ number_format($item->total_qty) }} unit</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                {{ number_format($item->total_qty) }}x
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-400">
                    <span class="text-4xl mb-2 block">📦</span>
                    <p class="text-sm">Belum ada data penjualan bulan ini</p>
                </div>
                @endif
            </div>

        </div>

        <!-- Right Column - Recent Transactions & Stock Alert -->
        <div class="space-y-6">
            
            <!-- Recent Transactions -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="text-xl">📝</span>
                        <span>Transaksi Terbaru</span>
                    </h3>
                </div>
                @if($transaksiTerbaru->count() > 0)
                <div class="space-y-3">
                    @foreach($transaksiTerbaru as $transaksi)
                    <div class="p-3 border border-slate-100 rounded-xl hover:bg-slate-50 transition-colors">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="text-xs font-mono text-gray-500">{{ $transaksi->kode_transaksi }}</p>
                                <p class="text-xs text-gray-400">{{ $transaksi->created_at->diffForHumans() }}</p>
                            </div>
                            @if($transaksi->metode_pembayaran === 'tunai')
                            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-medium">Tunai</span>
                            @else
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Kartu</span>
                            @endif
                        </div>
                        <p class="font-bold text-orange-600">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('transaksi.index') }}" class="block mt-4 text-center text-sm text-orange-600 hover:text-orange-700 font-medium">
                    Lihat Semua Transaksi →
                </a>
                @else
                <div class="text-center py-8 text-gray-400">
                    <span class="text-4xl mb-2 block">📋</span>
                    <p class="text-sm">Belum ada transaksi</p>
                </div>
                @endif
            </div>

            <!-- Stock Alert -->
            <div class="bg-gradient-to-br from-red-50 to-orange-50 border-2 border-red-200 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-red-900 flex items-center gap-2">
                        <span class="text-xl">⚠️</span>
                        <span>Stok Rendah</span>
                    </h3>
                </div>
                @if($produkStokRendah->count() > 0)
                <div class="space-y-3">
                    @foreach($produkStokRendah as $produk)
                    <div class="flex items-center justify-between p-3 bg-white rounded-xl">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $produk->nama_produk }}</p>
                            <p class="text-xs text-gray-500">{{ $produk->kategori->nama_kategori ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 {{ $produk->stok === 0 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }} rounded-full text-xs font-bold">
                                {{ $produk->stok }} unit
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('produk.index') }}" class="block mt-4 text-center text-sm text-red-600 hover:text-red-700 font-medium">
                    Kelola Stok Produk →
                </a>
                @else
                <div class="text-center py-6 text-gray-400">
                    <span class="text-3xl mb-2 block">✅</span>
                    <p class="text-sm text-green-700 font-medium">Semua stok aman!</p>
                </div>
                @endif
            </div>

            <!-- System Info Card -->
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl p-6 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-white/10 backdrop-blur-sm rounded-lg flex items-center justify-center">
                        <span class="text-xl">💳</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Kartu Pembayaran</h4>
                        <p class="text-xs text-slate-400">Total aktif</p>
                    </div>
                </div>
                <div class="text-3xl font-black mb-2">{{ number_format($totalKartu) }}</div>
                <a href="{{ route('payment-cards.index') }}" class="text-xs text-orange-400 hover:text-orange-300 font-medium">
                    Kelola Kartu →
                </a>
            </div>

        </div>

    </div>

</div>

@endsection
