@extends('layouts.app')

@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <!-- Total Produk -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="mb-4">
            <p class="text-sm font-medium text-gray-600 mb-3">Total Produk</p>
            <h3 class="text-4xl font-bold text-gray-900">120</h3>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-green-600">↑ 8%</span>
            <span class="text-xs text-gray-500">dari bulan lalu</span>
        </div>
    </div>

    <!-- Kategori -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="mb-4">
            <p class="text-sm font-medium text-gray-600 mb-3">Kategori</p>
            <h3 class="text-4xl font-bold text-gray-900">12</h3>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-gray-500">Kategori aktif</span>
        </div>
    </div>

    <!-- Transaksi Hari Ini -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="mb-4">
            <p class="text-sm font-medium text-gray-600 mb-3">Transaksi Hari Ini</p>
            <h3 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">25</h3>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold text-green-600">↑ 15%</span>
            <span class="text-xs text-gray-500">lebih aktif</span>
        </div>
    </div>

    <!-- Pendapatan -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:border-orange-300 transition-all duration-200">
        <div class="mb-4">
            <p class="text-sm font-medium text-gray-600 mb-3">Pendapatan</p>
            <h3 class="text-3xl font-bold text-gray-900">Rp2.5M</h3>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-gray-500">Hari ini</span>
        </div>
    </div>

</div>

<!-- Welcome Card -->
<div class="bg-gradient-to-r from-orange-600 to-orange-500 rounded-xl shadow-lg p-8">

    <div class="flex items-start justify-between">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-white mb-4">Selamat Datang</h2>

            <p class="text-orange-50 leading-relaxed mb-2">
                Halo <span class="font-semibold text-white">{{ Auth::user()->name }}</span>,
                selamat datang di sistem kasir pintar 
                <span class="font-semibold text-white">CoolE-Bill POS</span>.
            </p>
            <p class="text-sm text-orange-100">Kelola toko Anda dengan mudah, cepat, dan efisien.</p>
        </div>
    </div>

</div>

@endsection