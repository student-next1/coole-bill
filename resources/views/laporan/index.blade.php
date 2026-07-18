@extends('layouts.app')

@section('title','Laporan')
@section('page-title','Laporan')

@section('content')

<!-- Header Section -->
<div class="mb-8">
    <h3 class="text-lg md:text-xl font-semibold text-gray-900">Laporan Penjualan</h3>
    <p class="text-sm text-gray-600 mt-1">Analisis dan laporan bisnis Anda</p>
</div>

<!-- Empty State -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <div class="mb-4">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
            <span class="text-3xl">📊</span>
        </div>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data Laporan</h3>
    <p class="text-gray-600 mb-4">Mulai buat transaksi untuk melihat laporan penjualan Anda</p>
    <a href="{{ route('transaksi.create') }}" class="inline-flex px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-200">
        ➕ Buat Transaksi Baru
    </a>
</div>

@endsection
