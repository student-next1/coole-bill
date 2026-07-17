@extends('layouts.app')

@section('title','Laporan')
@section('page-title','Laporan')

@section('content')

<!-- Header Section -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-gray-900">Laporan Penjualan</h3>
    <p class="text-sm text-gray-600 mt-1">Analisis dan laporan bisnis Anda</p>
</div>

<!-- Period Selection -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
            <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <option>Hari Ini</option>
                <option>Minggu Ini</option>
                <option>Bulan Ini</option>
                <option>Tahun Ini</option>
                <option>Custom</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
            <input type="date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
            <input type="date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>
        <div class="flex items-end gap-2">
            <button class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg hover:shadow-lg transition-all duration-150">
                Tampilkan
            </button>
            <button class="px-4 py-2 border border-slate-300 text-gray-700 rounded-lg hover:bg-slate-50 transition-colors duration-150">
                Export
            </button>
        </div>
    </div>
</div>

<!-- Overview Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Penjualan</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">Rp15.5M</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center text-xl">
                💰
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-green-600">↑ 12%</span>
            <span class="text-xs text-gray-500">dari periode sebelumnya</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">450</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center text-xl">
                🛒
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-green-600">↑ 8%</span>
            <span class="text-xs text-gray-500">dari periode sebelumnya</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-gray-600">Rata-rata</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">Rp34K</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center text-xl">
                📊
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-gray-500">per transaksi</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-start justify-between mb-4">
            <div>
                <p class="text-sm font-medium text-gray-600">Produk Terjual</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-2">1,234</h3>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-orange-100 to-orange-200 rounded-lg flex items-center justify-center text-xl">
                📦
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-green-600">↑ 15%</span>
            <span class="text-xs text-gray-500">dari periode sebelumnya</span>
        </div>
    </div>

</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- Sales Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Grafik Penjualan</h3>
        <div class="h-64 flex items-center justify-center bg-slate-50 rounded-lg">
            <p class="text-gray-500">Chart akan ditampilkan disini</p>
        </div>
    </div>

    <!-- Category Distribution -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Kategori</h3>
        <div class="h-64 flex items-center justify-center bg-slate-50 rounded-lg">
            <p class="text-gray-500">Chart akan ditampilkan disini</p>
        </div>
    </div>

</div>

<!-- Top Products -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Best Selling Products -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Terlaris</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center text-white font-bold">
                        1
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Nasi Goreng</h4>
                        <p class="text-sm text-gray-600">145 terjual</p>
                    </div>
                </div>
                <span class="font-semibold text-gray-900">Rp2.17M</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-slate-300 to-slate-400 rounded-lg flex items-center justify-center text-white font-bold">
                        2
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Es Teh Manis</h4>
                        <p class="text-sm text-gray-600">230 terjual</p>
                    </div>
                </div>
                <span class="font-semibold text-gray-900">Rp1.15M</span>
            </div>
            
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-600 to-amber-700 rounded-lg flex items-center justify-center text-white font-bold">
                        3
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Mie Ayam</h4>
                        <p class="text-sm text-gray-600">98 terjual</p>
                    </div>
                </div>
                <span class="font-semibold text-gray-900">Rp1.17M</span>
            </div>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h3>
        <div class="space-y-3">
            <div class="p-4 bg-slate-50 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-medium text-gray-900">Tunai</span>
                    <span class="text-sm font-semibold text-gray-900">60%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-orange-600 to-orange-500 h-2 rounded-full" style="width: 60%"></div>
                </div>
                <p class="text-sm text-gray-600 mt-2">270 transaksi</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-medium text-gray-900">Transfer Bank</span>
                    <span class="text-sm font-semibold text-gray-900">25%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-500 h-2 rounded-full" style="width: 25%"></div>
                </div>
                <p class="text-sm text-gray-600 mt-2">113 transaksi</p>
            </div>

            <div class="p-4 bg-slate-50 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-medium text-gray-900">E-Wallet</span>
                    <span class="text-sm font-semibold text-gray-900">15%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-600 to-green-500 h-2 rounded-full" style="width: 15%"></div>
                </div>
                <p class="text-sm text-gray-600 mt-2">67 transaksi</p>
            </div>
        </div>
    </div>

</div>

@endsection
