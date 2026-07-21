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

    <!-- Step Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-orange-600 text-white flex items-center justify-center font-bold">1</div>
                <span class="text-sm font-medium text-gray-900">Pilih Jumlah</span>
            </div>
            <div class="w-16 h-1 bg-gray-300"></div>
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">2</div>
                <span class="text-sm font-medium text-gray-500">Konfirmasi</span>
            </div>
            <div class="w-16 h-1 bg-gray-300"></div>
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">3</div>
                <span class="text-sm font-medium text-gray-500">Selesai</span>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8">
        <form action="{{ route('payment-cards.do-topup', $card) }}" method="POST" id="topupForm">
            @csrf

            <!-- Quick Amount Buttons (Move to top) -->
            <div class="mb-6">
                <label class="block text-lg font-bold text-gray-900 mb-4">Pilih Nominal Top-up</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach([50000, 100000, 200000, 250000, 500000, 1000000] as $preset)
                        <button type="button"
                                onclick="setAmount({{ $preset }})"
                                class="preset-btn px-4 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:border-orange-500 hover:bg-orange-50 hover:text-orange-600 transition-all duration-200 text-center">
                            <div class="text-lg">Rp{{ number_format($preset / 1000, 0) }}K</div>
                            <div class="text-xs text-gray-500 mt-1">Rp{{ number_format($preset, 0, ',', '.') }}</div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- OR Divider -->
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500 font-medium">ATAU</span>
                </div>
            </div>

            <!-- Custom Amount -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Masukkan Nominal Custom <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                    <input type="number" 
                           name="amount" 
                           id="amountInput"
                           placeholder="0"
                           value="{{ old('amount') }}"
                           class="w-full pl-12 pr-4 py-3 border-2 border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-lg font-bold @error('amount') border-red-500 @enderror"
                           min="10000"
                           step="1000">
                </div>
                <p class="text-xs text-gray-500 mt-2">Minimal top-up Rp10.000</p>
                @error('amount')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-900 mb-2">Catatan (Opsional)</label>
                <input type="text" 
                       name="notes" 
                       placeholder="Contoh: Top-up via transfer bank"
                       value="{{ old('notes') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
            </div>

            <!-- Preview Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-xl p-5 mb-6">
                <div class="flex items-start gap-3">
                    <div class="flex-1">
                        <p class="text-sm font-bold text-blue-900 mb-2">Ringkasan Top-up</p>
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-blue-800">Saldo Saat Ini:</span>
                                <span class="font-bold text-blue-900">Rp{{ number_format($card->saldo, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-blue-800">Nominal Top-up:</span>
                                <span class="font-bold text-orange-600">+Rp<span id="topupAmount">0</span></span>
                            </div>
                            <div class="border-t-2 border-blue-300 pt-1 mt-1"></div>
                            <div class="flex justify-between text-base">
                                <span class="text-blue-900 font-bold">Saldo Baru:</span>
                                <span id="previewSaldo" class="font-bold text-green-600 text-lg">Rp{{ number_format($card->saldo, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning -->
            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 mb-6">
                <div class="flex gap-3">
                    <div class="text-xs text-yellow-800">
                        <p class="font-bold mb-1">Perhatian:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pastikan nominal top-up sudah benar</li>
                            <li>Proses top-up tidak dapat dibatalkan</li>
                            <li>Saldo akan langsung bertambah setelah konfirmasi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4 border-t-2 border-slate-200">
                <a href="{{ route('payment-cards.show', $card) }}" 
                   class="flex-1 px-6 py-3 border-2 border-slate-300 text-gray-900 font-bold rounded-lg hover:bg-slate-50 transition-colors text-center">
                    Batal
                </a>
                <button type="submit" 
                        id="submitBtn"
                        disabled
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-lg hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Konfirmasi Top-up
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const currentSaldo = {{ $card->saldo }};
    const amountInput = document.querySelector('#amountInput');
    const submitBtn = document.querySelector('#submitBtn');
    
    function updatePreview() {
        const amount = parseInt(amountInput.value) || 0;
        const newSaldo = currentSaldo + amount;
        
        document.getElementById('topupAmount').textContent = amount.toLocaleString('id-ID');
        document.getElementById('previewSaldo').textContent = 'Rp' + newSaldo.toLocaleString('id-ID');
        
        // Enable/disable submit button
        if (amount >= 10000) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }
    
    function setAmount(amount) {
        amountInput.value = amount;
        updatePreview();
        
        // Visual feedback for selected preset
        document.querySelectorAll('.preset-btn').forEach(btn => {
            btn.classList.remove('border-orange-500', 'bg-orange-100', 'text-orange-600');
            btn.classList.add('border-gray-300', 'text-gray-700');
        });
        
        event.target.closest('.preset-btn').classList.remove('border-gray-300', 'text-gray-700');
        event.target.closest('.preset-btn').classList.add('border-orange-500', 'bg-orange-100', 'text-orange-600');
        
        amountInput.focus();
    }
    
    amountInput.addEventListener('input', function() {
        // Clear preset selection
        document.querySelectorAll('.preset-btn').forEach(btn => {
            btn.classList.remove('border-orange-500', 'bg-orange-100', 'text-orange-600');
            btn.classList.add('border-gray-300', 'text-gray-700');
        });
        updatePreview();
    });
    
    // Confirmation before submit
    document.getElementById('topupForm').addEventListener('submit', function(e) {
        const amount = parseInt(amountInput.value) || 0;
        if (!confirm(`Konfirmasi top-up Rp${amount.toLocaleString('id-ID')}?\n\nSaldo akan menjadi Rp${(currentSaldo + amount).toLocaleString('id-ID')}`)) {
            e.preventDefault();
        }
    });
</script>

@endsection
