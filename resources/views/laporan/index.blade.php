@extends('layouts.app')

@section('title','Laporan')
@section('page-title','Laporan')

@section('content')

<!-- Header Section -->
<div class="mb-8">
    <h3 class="text-lg md:text-xl font-semibold text-gray-900">Laporan Penjualan</h3>
    <p class="text-sm text-gray-600 mt-1">Analisis dan laporan bisnis Anda</p>
</div>

<!-- Period Selection -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6 mb-8">
    <form method="GET" action="{{ route('laporan.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
            <input type="date" 
                   name="start_date" 
                   value="{{ $startDate }}"
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
        </div>
        <div>
            <label class="block text-xs md:text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
            <input type="date" 
                   name="end_date" 
                   value="{{ $endDate }}"
                   class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg hover:shadow-lg transition-all duration-150 text-sm">
                Tampilkan
            </button>
            <a href="{{ route('laporan.index') }}" class="px-4 py-2 border border-slate-300 text-gray-700 rounded-lg hover:bg-slate-50 transition-colors duration-150 text-sm">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Overview Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Penjualan</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
        <p class="text-xs text-gray-500 mt-2">{{ $jumlahTransaksi }} transaksi</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Transaksi</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">{{ $jumlahTransaksi }}</h3>
        <p class="text-xs text-gray-500 mt-2">Dalam periode ini</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Total Pajak</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Rp{{ number_format($totalPajak, 0, ',', '.') }}</h3>
        <p class="text-xs text-gray-500 mt-2">Terkumpul</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 md:p-6">
        <p class="text-sm font-medium text-gray-600 mb-2">Rata-rata</p>
        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2">Rp{{ $jumlahTransaksi > 0 ? number_format($totalPenjualan / $jumlahTransaksi, 0, ',', '.') : 0 }}</h3>
        <p class="text-xs text-gray-500 mt-2">Per transaksi</p>
    </div>

</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- Payment Methods -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h3>
        @if($paymentMethods->count() > 0)
            <div class="space-y-4">
                @foreach($paymentMethods as $method)
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $method['method'] }}</p>
                            <p class="text-xs text-gray-600">{{ $method['count'] }} transaksi</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-orange-600">Rp{{ number_format($method['total'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-2">
                        <div class="bg-gradient-to-r from-orange-600 to-orange-500 h-2 rounded-full" 
                             style="width: {{ ($method['total'] / $totalPenjualan) * 100 }}%"></div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="h-48 flex items-center justify-center bg-slate-50 rounded-lg">
                <p class="text-gray-500 text-sm">Tidak ada data transaksi</p>
            </div>
        @endif
    </div>

    <!-- Daily Sales -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Penjualan Harian</h3>
        @if($dailySales->count() > 0)
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @foreach($dailySales->sortByDesc('date') as $sale)
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $sale['date'] }}</p>
                            <p class="text-xs text-gray-600">{{ $sale['count'] }} transaksi</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-orange-600">Rp{{ number_format($sale['total'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="h-48 flex items-center justify-center bg-slate-50 rounded-lg">
                <p class="text-gray-500 text-sm">Tidak ada data transaksi</p>
            </div>
        @endif
    </div>

</div>

<!-- Top Products -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Terlaris</h3>
    @if($topProducts->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Produk</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Terjual</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($topProducts as $product)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $product['name'] }}</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $product['qty'] }} unit</td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-orange-600">Rp{{ number_format($product['total'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="h-64 flex items-center justify-center bg-slate-50 rounded-lg">
            <p class="text-gray-500 text-sm">Tidak ada data produk terjual</p>
        </div>
    @endif
</div>

<!-- Transactions History -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Transaksi</h3>
    @if($transaksis->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Kode Transaksi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 hidden sm:table-cell">Kasir</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600">Total</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 hidden md:table-cell">Metode</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 hidden lg:table-cell">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($transaksis->take(10) as $transaksi)
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600 hidden sm:table-cell">{{ $transaksi->user->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-orange-600 text-right">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-600 hidden md:table-cell">
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $transaksi->metode_pembayaran === 'tunai' ? 'bg-blue-100 text-blue-700' : ($transaksi->metode_pembayaran === 'transfer' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700') }}">
                                    {{ ucfirst(str_replace('_', ' ', $transaksi->metode_pembayaran)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 hidden lg:table-cell">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="h-64 flex items-center justify-center bg-slate-50 rounded-lg">
            <p class="text-gray-500 text-sm">Tidak ada transaksi dalam periode ini</p>
        </div>
    @endif
</div>

@endsection
