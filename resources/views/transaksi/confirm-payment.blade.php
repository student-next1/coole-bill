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
                        class="w-full px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-lg hover:shadow-lg transition-all duration-200"
                        id="btnKonfirmasi">
                    Konfirmasi & Proses Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Keyboard Shortcuts Script -->
<script defer>
    console.log('KEYBOARD SHORTCUTS LOADED');
    
    function setupKeyboardShortcuts() {
        console.log('setupKeyboardShortcuts() called');
        
        document.addEventListener('keydown', function(e) {
            console.log('Key:', e.key, 'Code:', e.code);
            
            // Escape key: go back
            if (e.key === 'Escape') {
                console.log('ESCAPE PRESSED - going back');
                window.location.href = '{{ route("transaksi.create") }}';
                return;
            }
            
            // Enter key: submit form
            if (e.key === 'Enter') {
                console.log('ENTER PRESSED');
                const form = document.getElementById('formKonfirmasi');
                if (form) {
                    console.log('Form found, submitting...');
                    form.submit();
                } else {
                    console.log('Form NOT found');
                }
            }
        });
    }
    
    // Run immediately
    setupKeyboardShortcuts();
</script>
@endsection
