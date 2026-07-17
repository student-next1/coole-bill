@extends('layouts.app')

@section('title','Transaksi Baru')
@section('page-title','Transaksi Baru')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Section - Product Selection -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Search Product -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <input type="text" 
                   placeholder="Cari produk atau scan barcode..." 
                   class="w-full px-4 py-3 text-lg border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Product Grid -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Produk</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                
                <!-- Product Card -->
                <button class="bg-slate-50 rounded-lg p-4 hover:bg-orange-50 hover:border-orange-300 border-2 border-transparent transition-all duration-150 text-left">
                    <div class="text-3xl mb-2">🍔</div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">Nasi Goreng</h4>
                    <p class="text-orange-600 font-bold text-sm">Rp15.000</p>
                    <p class="text-xs text-gray-500 mt-1">Stok: 50</p>
                </button>

                <button class="bg-slate-50 rounded-lg p-4 hover:bg-orange-50 hover:border-orange-300 border-2 border-transparent transition-all duration-150 text-left">
                    <div class="text-3xl mb-2">🥤</div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">Es Teh Manis</h4>
                    <p class="text-orange-600 font-bold text-sm">Rp5.000</p>
                    <p class="text-xs text-gray-500 mt-1">Stok: 100</p>
                </button>

                <button class="bg-slate-50 rounded-lg p-4 hover:bg-orange-50 hover:border-orange-300 border-2 border-transparent transition-all duration-150 text-left">
                    <div class="text-3xl mb-2">🍜</div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">Mie Ayam</h4>
                    <p class="text-orange-600 font-bold text-sm">Rp12.000</p>
                    <p class="text-xs text-gray-500 mt-1">Stok: 30</p>
                </button>

                <button class="bg-slate-50 rounded-lg p-4 hover:bg-orange-50 hover:border-orange-300 border-2 border-transparent transition-all duration-150 text-left">
                    <div class="text-3xl mb-2">☕</div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">Kopi Hitam</h4>
                    <p class="text-orange-600 font-bold text-sm">Rp8.000</p>
                    <p class="text-xs text-gray-500 mt-1">Stok: 80</p>
                </button>

                <button class="bg-slate-50 rounded-lg p-4 hover:bg-orange-50 hover:border-orange-300 border-2 border-transparent transition-all duration-150 text-left">
                    <div class="text-3xl mb-2">🍰</div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">Cake Coklat</h4>
                    <p class="text-orange-600 font-bold text-sm">Rp25.000</p>
                    <p class="text-xs text-gray-500 mt-1">Stok: 15</p>
                </button>

                <button class="bg-slate-50 rounded-lg p-4 hover:bg-orange-50 hover:border-orange-300 border-2 border-transparent transition-all duration-150 text-left">
                    <div class="text-3xl mb-2">🍿</div>
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">Popcorn</h4>
                    <p class="text-orange-600 font-bold text-sm">Rp10.000</p>
                    <p class="text-xs text-gray-500 mt-1">Stok: 40</p>
                </button>

            </div>
        </div>

    </div>

    <!-- Right Section - Cart -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-24">
            
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Keranjang</h3>

            <!-- Cart Items -->
            <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900 text-sm">Nasi Goreng</h4>
                        <p class="text-xs text-gray-600">Rp15.000</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="w-6 h-6 bg-slate-200 rounded text-sm hover:bg-slate-300">-</button>
                        <span class="w-8 text-center text-sm font-medium">1</span>
                        <button class="w-6 h-6 bg-slate-200 rounded text-sm hover:bg-slate-300">+</button>
                    </div>
                    <button class="text-red-500 hover:text-red-700 text-sm">✕</button>
                </div>

                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900 text-sm">Es Teh Manis</h4>
                        <p class="text-xs text-gray-600">Rp5.000</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="w-6 h-6 bg-slate-200 rounded text-sm hover:bg-slate-300">-</button>
                        <span class="w-8 text-center text-sm font-medium">2</span>
                        <button class="w-6 h-6 bg-slate-200 rounded text-sm hover:bg-slate-300">+</button>
                    </div>
                    <button class="text-red-500 hover:text-red-700 text-sm">✕</button>
                </div>

            </div>

            <!-- Summary -->
            <div class="space-y-3 pt-4 border-t border-slate-200">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium text-gray-900">Rp25.000</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Pajak (10%)</span>
                    <span class="font-medium text-gray-900">Rp2.500</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-3 border-t border-slate-200">
                    <span class="text-gray-900">Total</span>
                    <span class="bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">Rp27.500</span>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option>Tunai</option>
                    <option>Transfer Bank</option>
                    <option>E-Wallet</option>
                    <option>Kartu Kredit/Debit</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 space-y-2">
                <button class="w-full px-4 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-150">
                    Proses Pembayaran
                </button>
                <button class="w-full px-4 py-3 border border-slate-300 text-gray-700 font-medium rounded-lg hover:bg-slate-50 transition-colors duration-150">
                    Reset
                </button>
            </div>

        </div>
    </div>

</div>

@endsection
