@extends('layouts.app')

@section('title','Pilih Metode Pembayaran')
@section('page-title','Pilih Metode Pembayaran')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold text-gray-900">Pilih Metode Pembayaran</h3>
        <p class="text-sm text-gray-600 mt-2">Total Rp{{ number_format($total, 0, ',', '.') }}</p>
    </div>

    <!-- Payment Methods Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        
        <!-- Payment Card -->
        <a href="{{ route('transaksi.select-card', ['method' => 'card']) }}"
           class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-orange-300 hover:shadow-md transition-all duration-200 text-center cursor-pointer group">
            <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">💳</div>
            <h4 class="font-semibold text-gray-900 mb-1">Kartu Pembayaran</h4>
            <p class="text-xs text-gray-600">Scan atau cari kartu</p>
        </a>

        <!-- Cash -->
        <form action="{{ route('transaksi.select-card', ['method' => 'cash']) }}" method="GET" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-orange-300 hover:shadow-md transition-all duration-200">
            <button type="submit" class="w-full text-center group">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">💵</div>
                <h4 class="font-semibold text-gray-900 mb-1">Tunai</h4>
                <p class="text-xs text-gray-600">Pembayaran cash</p>
            </button>
        </form>

        <!-- Transfer -->
        <form action="{{ route('transaksi.select-card', ['method' => 'transfer']) }}" method="GET" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:border-orange-300 hover:shadow-md transition-all duration-200">
            <button type="submit" class="w-full text-center group">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🏦</div>
                <h4 class="font-semibold text-gray-900 mb-1">Transfer</h4>
                <p class="text-xs text-gray-600">Transfer bank/e-wallet</p>
            </button>
        </form>

    </div>

    <!-- Back Button -->
    <div class="flex gap-3">
        <a href="{{ route('transaksi.create') }}" 
           class="flex-1 px-4 py-3 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-center">
            Kembali ke Keranjang
        </a>
    </div>
</div>

@endsection
