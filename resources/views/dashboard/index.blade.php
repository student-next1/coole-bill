@extends('layouts.app')

@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

<div class="space-y-6">

    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-orange-600 to-orange-500 rounded-xl shadow-lg p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-orange-100">Sistem POS CoolE-Bill siap membantu Anda mengelola penjualan dengan mudah.</p>
            </div>
            <a href="{{ route('transaksi.create') }}" 
               class="inline-block px-6 py-3 bg-white text-orange-600 font-semibold rounded-lg hover:shadow-lg transition-all duration-200 whitespace-nowrap">
                Mulai Transaksi
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">

        <!-- Total Produk -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
            <p class="text-sm font-medium text-gray-600 mb-3">Total Produk</p>
            <h3 class="text-3xl md:text-4xl font-bold text-gray-900">-</h3>
            <p class="text-xs text-gray-500 mt-3">Data akan muncul saat ada transaksi</p>
        </div>

        <!-- Kategori -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
            <p class="text-sm font-medium text-gray-600 mb-3">Kategori</p>
            <h3 class="text-3xl md:text-4xl font-bold text-gray-900">-</h3>
            <p class="text-xs text-gray-500 mt-3">Kategori aktif</p>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
            <p class="text-sm font-medium text-gray-600 mb-3">Transaksi Hari Ini</p>
            <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">0</h3>
            <p class="text-xs text-gray-500 mt-3">Belum ada transaksi</p>
        </div>

        <!-- Pendapatan -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
            <p class="text-sm font-medium text-gray-600 mb-3">Pendapatan</p>
            <h3 class="text-3xl md:text-4xl font-bold text-gray-900">Rp0</h3>
            <p class="text-xs text-gray-500 mt-3">Hari ini</p>
        </div>

    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Transaksi Baru -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                <span class="text-2xl">🛒</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Transaksi Baru</h3>
            <p class="text-sm text-gray-600 mb-4">Mulai membuat transaksi penjualan baru</p>
            <a href="{{ route('transaksi.create') }}" 
               class="text-orange-600 font-medium hover:text-orange-700 text-sm">
                Buat Transaksi →
            </a>
        </div>

        <!-- Kelola Produk -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                <span class="text-2xl">📦</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Kelola Produk</h3>
            <p class="text-sm text-gray-600 mb-4">Tambah, edit, atau hapus produk</p>
            <a href="{{ route('produk.index') }}" 
               class="text-blue-600 font-medium hover:text-blue-700 text-sm">
                Lihat Produk →
            </a>
        </div>

        <!-- Lihat Transaksi -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition-all duration-200">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                <span class="text-2xl">📋</span>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Riwayat Transaksi</h3>
            <p class="text-sm text-gray-600 mb-4">Lihat semua transaksi yang telah dilakukan</p>
            <a href="{{ route('transaksi.index') }}" 
               class="text-green-600 font-medium hover:text-green-700 text-sm">
                Lihat Riwayat →
            </a>
        </div>

    </div>

    <!-- Info Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Getting Started -->
        <div class="bg-blue-50 rounded-xl border border-blue-200 p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Panduan Memulai</h3>
            <ol class="space-y-2 text-sm text-blue-800">
                <li class="flex gap-3">
                    <span class="font-bold flex-shrink-0">1.</span>
                    <span>Siapkan produk di menu Produk</span>
                </li>
                <li class="flex gap-3">
                    <span class="font-bold flex-shrink-0">2.</span>
                    <span>Tambahkan kategori untuk pengorganisasian</span>
                </li>
                <li class="flex gap-3">
                    <span class="font-bold flex-shrink-0">3.</span>
                    <span>Mulai membuat transaksi penjualan</span>
                </li>
                <li class="flex gap-3">
                    <span class="font-bold flex-shrink-0">4.</span>
                    <span>Pantau laporan penjualan Anda</span>
                </li>
            </ol>
        </div>

        <!-- System Status -->
        <div class="bg-green-50 rounded-xl border border-green-200 p-6">
            <h3 class="text-lg font-semibold text-green-900 mb-4">Status Sistem</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-800">Database</span>
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-800">Server</span>
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-green-800">Autentikasi</span>
                    <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                </div>
                <p class="text-xs text-green-700 mt-4">Semua sistem berjalan normal</p>
            </div>
        </div>

    </div>

</div>

@endsection