@extends('layouts.app')

@section('title','Edit Kartu')
@section('page-title','Edit Kartu')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold text-gray-900">Edit Kartu Pembayaran</h3>
        <p class="text-sm text-gray-600 mt-2">{{ $card->card_code }}</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('payment-cards.update', $card) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Pemilik -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Nama Pemilik Kartu <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="holder_name" 
                       placeholder="Misal: Budi Santoso"
                       value="{{ old('holder_name', $card->holder_name) }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('holder_name') border-red-500 @enderror">
                @error('holder_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Username -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Username</label>
                <input type="text" 
                       name="username" 
                       placeholder="Misal: budi_santoso"
                       value="{{ old('username', $card->username) }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('username') border-red-500 @enderror">
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" 
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('status') border-red-500 @enderror">
                    <option value="active" @selected(old('status', $card->status) === 'active')>Aktif</option>
                    <option value="inactive" @selected(old('status', $card->status) === 'inactive')>Tidak Aktif</option>
                    <option value="blocked" @selected(old('status', $card->status) === 'blocked')>Diblokir</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Catatan</label>
                <textarea name="notes" 
                          placeholder="Masukkan catatan tambahan..."
                          rows="3"
                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">{{ old('notes', $card->notes) }}</textarea>
            </div>

            <!-- Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-900">
                    <strong>ℹ️ Info:</strong> Saldo kartu tidak dapat diubah dari halaman ini. Gunakan fitur "Topup" untuk menambah saldo atau hapus transaksi jika diperlukan.
                </p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <a href="{{ route('payment-cards.show', $card) }}" 
                   class="flex-1 px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-center text-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
