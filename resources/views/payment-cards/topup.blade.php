@extends('layouts.app')

@section('title','Topup Saldo')
@section('page-title','Topup Saldo')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('payment-cards.show', $card) }}" 
           class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali</span>
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold text-gray-900">Topup Saldo Kartu</h3>
        <p class="text-sm text-gray-600 mt-2">{{ $card->holder_name }} ({{ $card->card_code }})</p>
    </div>

    <!-- Saldo Info -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg text-white p-6 md:p-8 mb-8">
        <p class="text-sm opacity-90 mb-2">Saldo Saat Ini</p>
        <h2 class="text-4xl md:text-5xl font-bold">Rp{{ number_format($card->saldo, 0, ',', '.') }}</h2>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('payment-cards.do-topup', $card) }}" method="POST">
            @csrf

            <!-- Jumlah Topup -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Jumlah Topup (Rp) <span class="text-red-500">*</span></label>
                <input type="number" 
                       name="amount" 
                       placeholder="0"
                       value="{{ old('amount') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm @error('amount') border-red-500 @enderror"
                       min="1">
                @error('amount')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quick Amount Buttons -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Atau pilih preset:</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach([50000, 100000, 250000, 500000, 1000000] as $preset)
                        <button type="button"
                                onclick="document.querySelector('input[name=\"amount\"]').value = {{ $preset }}; document.querySelector('input[name=\"amount\"]').focus();"
                                class="px-3 py-2 border border-orange-300 text-orange-600 font-medium rounded-lg hover:bg-orange-50 transition-colors text-sm">
                            Rp{{ number_format($preset, 0, ',', '.') }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Catatan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Catatan (Opsional)</label>
                <input type="text" 
                       name="notes" 
                       placeholder="Misal: Topup dari airtawangkl"
                       value="{{ old('notes') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            </div>

            <!-- Preview -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-900">
                    <strong>Preview:</strong> Saldo akan menjadi <span id="previewSaldo" class="font-bold text-orange-600">Rp{{ number_format($card->saldo, 0, ',', '.') }}</span>
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
                    Proses Topup
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const currentSaldo = {{ $card->saldo }};
    const amountInput = document.querySelector('input[name="amount"]');
    
    function updatePreview() {
        const amount = parseInt(amountInput.value) || 0;
        const newSaldo = currentSaldo + amount;
        document.getElementById('previewSaldo').textContent = 'Rp' + newSaldo.toLocaleString('id-ID');
    }
    
    amountInput.addEventListener('input', updatePreview);
</script>

@endsection
