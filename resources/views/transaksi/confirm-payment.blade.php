@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Konfirmasi Pembayaran</h1>
            <p class="text-gray-600">Verifikasi detail pembayaran sebelum melanjutkan</p>
        </div>

        <!-- Card Info -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Detail Kartu Pembayaran</h2>
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-xs text-gray-600 mb-1">Nama Pemegang</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $card->holder_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Kode Kartu</p>
                    <p class="text-lg font-semibold text-gray-900 font-mono">{{ $card->card_code }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 mb-1">Saldo Saat Ini</p>
                    <p class="text-lg font-semibold text-green-600">Rp{{ number_format($card->saldo, 0, ',', '.') }}</p>
                </div>
                @if($card->username)
                <div>
                    <p class="text-xs text-gray-600 mb-1">Username</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $card->username }}</p>
                </div>
                @endif
            </div>

            <!-- Balance Warning if needed -->
            @php
                $remainingBalance = $card->saldo - $total;
            @endphp
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-900">
                    <span class="font-semibold">Saldo setelah transaksi:</span>
                    <span class="font-bold text-blue-700">Rp{{ number_format($remainingBalance, 0, ',', '.') }}</span>
                </p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>
            
            <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                @foreach($items as $item)
                    @php
                        $produk = App\Models\Produk::find($item['produk_id']);
                    @endphp
                    @if($produk)
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-lg">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $produk->nama_produk }}</p>
                            <p class="text-xs text-gray-600">{{ $item['qty'] }}x @ Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold text-gray-900">Rp{{ number_format($produk->harga * $item['qty'], 0, ',', '.') }}</p>
                    </div>
                    @endif
                @endforeach
            </div>

            <div class="border-t border-slate-200 pt-4 space-y-2">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-900 mt-4 pt-4 border-t border-slate-200">
                    <span>Total</span>
                    <span class="text-orange-600">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>  
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <a href="{{ route('transaksi.create') }}"
               class="flex-1 px-6 py-3 bg-gray-200 text-gray-900 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 text-center"
               id="btnBatal">
                Batal
            </a>
            <form action="{{ route('transaksi.store') }}" method="POST" class="flex-1" id="formKonfirmasi">
                @csrf
                <input type="hidden" name="items" value="{{ json_encode($items) }}">
                <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                <input type="hidden" name="total" value="{{ $total }}">
                <input type="hidden" name="metode_pembayaran" value="kartu_id">
                <input type="hidden" name="nominal_bayar" value="{{ $total }}">
                <input type="hidden" name="payment_card_id" value="{{ $card->id }}">
                
                <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-lg hover:shadow-lg hover:from-orange-700 hover:to-orange-600 transition-all duration-200 flex items-center justify-center gap-2"
                        id="btnKonfirmasi">
                    <span id="btnText">Konfirmasi Pembayaran</span>
                    <span id="btnLoading" class="hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Error Alert (if any) -->
@if(session('error'))
<div class="fixed top-4 right-4 z-50 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg max-w-md" role="alert" id="errorAlert">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        const alert = document.getElementById('errorAlert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>
@endif

<!-- Keyboard Shortcuts & Form Handler Script -->
<script>
    console.log('🚀 Payment Confirmation Page Loaded');
    
    const form = document.getElementById('formKonfirmasi');
    const btnKonfirmasi = document.getElementById('btnKonfirmasi');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    
    let isSubmitting = false;
    
    // Form submit handler
    if (form) {
        form.addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                console.log('⚠️ Already submitting, prevented duplicate');
                return false;
            }
            
            console.log('✅ Form submitting...');
            isSubmitting = true;
            
            // Show loading state
            if (btnText && btnLoading && btnKonfirmasi) {
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');
                btnKonfirmasi.disabled = true;
                btnKonfirmasi.classList.add('opacity-75', 'cursor-not-allowed');
            }
            
            // Allow form to submit
            return true;
        });
    } else {
        console.error('❌ Form not found!');
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Prevent shortcuts if already submitting
        if (isSubmitting) {
            return;
        }
        
        // Escape key: go back
        if (e.key === 'Escape') {
            console.log('⬅️ ESC pressed - going back');
            window.location.href = '{{ route("transaksi.create") }}';
            return;
        }
        
        // Enter key: submit form
        if (e.key === 'Enter' && !e.shiftKey && !e.ctrlKey && !e.altKey) {
            console.log('⏎ ENTER pressed - submitting form');
            e.preventDefault();
            if (form && !isSubmitting) {
                form.submit();
            }
        }
    });
    
    console.log('✅ Form handlers attached');
</script>
@endsection
