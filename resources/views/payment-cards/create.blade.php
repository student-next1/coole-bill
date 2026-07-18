@extends('layouts.app')

@section('title','Buat Kartu Pembayaran')
@section('page-title','Buat Kartu Pembayaran')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold text-gray-900">Buat Kartu Pembayaran Baru</h3>
        <p class="text-sm text-gray-600 mt-2">Isi form di bawah untuk membuat kartu pembayaran dengan barcode</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('payment-cards.store') }}" method="POST">
            @csrf

            <!-- Nama Pemilik -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Nama Pemilik Kartu <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="holder_name" 
                       placeholder="Misal: Budi Santoso"
                       value="{{ old('holder_name') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('holder_name') border-red-500 @enderror">
                @error('holder_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Username (Opsional)</label>
                <input type="text" 
                       name="username" 
                       placeholder="Misal: budi_santoso"
                       value="{{ old('username') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('username') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Username akan dibuat otomatis jika kosong</p>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Saldo Awal -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Saldo Awal (Rp) <span class="text-red-500">*</span></label>
                <input type="number" 
                       name="saldo" 
                       placeholder="0"
                       value="{{ old('saldo', 0) }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('saldo') border-red-500 @enderror"
                       min="0">
                @error('saldo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Catatan (Opsional)</label>
                <textarea name="notes" 
                          placeholder="Masukkan catatan tambahan..."
                          rows="3"
                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">{{ old('notes') }}</textarea>
            </div>

            <!-- Preview Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-900">
                    <strong>ℹ️ Info:</strong> Kode kartu dan barcode akan dibuat otomatis. Anda bisa mencetak kartu setelah dibuat.
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('payment-cards.index') }}" 
                   class="flex-1 px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-center text-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm">
                    Buat Kartu
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
