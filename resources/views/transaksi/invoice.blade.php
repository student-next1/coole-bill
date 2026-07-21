@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 md:p-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">📄 Struk Pembayaran</h1>
            <p class="text-sm text-gray-600 mt-2">Metode: <span class="font-semibold text-{{ $method === 'tunai' ? 'blue' : 'green' }}-600">{{ $method === 'tunai' ? '💵 Tunai' : '🆔 Kartu ID' }}</span></p>
        </div>

        @php
            $paymentCard = null;
            if ($method === 'kartu_id' && $paymentCardId) {
                $paymentCard = \App\Models\PaymentCard::find($paymentCardId);
            }
        @endphp

        <!-- Payment Card Info (if using card) -->
        @if($paymentCard)
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg text-white p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm opacity-90 mb-1">Kartu Pembayaran</p>
                    <p class="text-2xl font-bold">{{ $paymentCard->holder_name }}</p>
                    <p class="text-xs opacity-75 font-mono mt-1">{{ $paymentCard->card_code }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs opacity-90 mb-1">Saldo</p>
                    <p class="text-2xl font-bold">Rp{{ number_format($paymentCard->saldo, 0, ',', '.') }}</p>
                </div>
            </div>
            
            @php
                $hasEnoughBalance = $paymentCard->saldo >= $total;
                $remainingBalance = $paymentCard->saldo - $total;
            @endphp
            
            <!-- Balance Validation -->
            <div class="p-3 bg-white/20 backdrop-blur rounded-lg">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span>Total Belanja:</span>
                    <span class="font-bold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-sm border-t border-white/30 pt-2">
                    <span>Saldo Setelah Bayar:</span>
                    <span class="font-bold {{ $hasEnoughBalance ? 'text-green-300' : 'text-red-300' }}">
                        Rp{{ number_format($remainingBalance, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            
            @if(!$hasEnoughBalance)
            <div class="mt-3 p-3 bg-red-500 rounded-lg">
                <p class="text-sm font-bold">⚠️ Saldo Tidak Mencukupi!</p>
                <p class="text-xs mt-1">Kurang Rp{{ number_format(abs($remainingBalance), 0, ',', '.') }}</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Struk Container -->
        <div id="struk" class="bg-white rounded-xl shadow-lg p-6 md:p-8">
            
            <!-- Store Header -->
            <div class="text-center mb-8 pb-6 border-b-2 border-dotted border-slate-300">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <div class="px-3 py-1.5 bg-black rounded flex items-center justify-center">
                        <span class="text-white font-black text-sm">COOL</span>
                    </div>
                    <div class="px-3 py-1.5 bg-orange-600 rounded flex items-center justify-center">
                        <span class="text-white font-black text-sm">E-BILL</span>
                    </div>
                </div>
                <h2 class="text-2xl font-black text-gray-900">STRUK PEMBAYARAN</h2>
                <p class="text-xs text-gray-600 mt-2">Smart POS System</p>
            </div>

            <!-- Items Section -->
            <form id="invoiceForm" class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Daftar Produk</h3>
                
                <div id="itemsContainer" class="space-y-3 mb-6">
                    @foreach($items as $idx => $item)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Product Name -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Produk</label>
                                <input type="hidden" name="items[{{ $idx }}][produk_id]" value="{{ $item['produk_id'] }}">
                                <input type="text" 
                                       name="items[{{ $idx }}][nama_produk]" 
                                       value="{{ $item['nama_produk'] }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Qty</label>
                                <input type="number" 
                                       name="items[{{ $idx }}][qty]" 
                                       value="{{ $item['qty'] }}"
                                       min="1"
                                       onchange="calculateTotal()"
                                       class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>

                            <!-- Price -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Harga</label>
                                <input type="number" 
                                       name="items[{{ $idx }}][harga]" 
                                       value="{{ $item['harga'] }}"
                                       min="0"
                                       onchange="calculateTotal()"
                                       class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>

                            <!-- Subtotal -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Subtotal</label>
                                <div class="px-3 py-2 bg-gray-100 rounded text-sm font-semibold text-gray-900">
                                    Rp<span class="subtotal-{{ $idx }}">{{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                </div>
                                <input type="hidden" name="items[{{ $idx }}][subtotal]" value="{{ $item['subtotal'] }}" class="subtotal-input-{{ $idx }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mb-6 pb-6 border-b-2 border-dotted border-slate-300"></div>

                <!-- Summary -->
                <div class="space-y-3">
                    <div class="flex justify-between text-base">
                        <span class="text-gray-700">Subtotal</span>
                        <span class="font-semibold text-gray-900">Rp<span id="displaySubtotal">{{ number_format($subtotal, 0, ',', '.') }}</span></span>
                        <input type="hidden" name="subtotal" id="subtotalInput" value="{{ $subtotal }}">
                    </div>

                    <div class="flex justify-between text-xl font-bold border-t-2 border-slate-300 pt-3">
                        <span class="text-gray-900">TOTAL</span>
                        <span class="text-orange-600">Rp<span id="displayTotal">{{ number_format($total, 0, ',', '.') }}</span></span>
                        <input type="hidden" name="total" id="totalInput" value="{{ $total }}">
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="method" value="{{ $method }}">
                    <input type="hidden" name="payment_card_id" value="{{ $paymentCardId }}">
                    <input type="hidden" name="items_json" id="itemsJson">
                </div>
            </form>

            <div class="mb-6 pb-6 border-b-2 border-dotted border-slate-300"></div>

            <!-- Footer -->
            <div class="text-center space-y-2 text-xs text-gray-600 mb-8">
                <p class="font-semibold">Terima Kasih Telah Berbelanja</p>
                <p>Mohon verifikasi data sebelum dikonfirmasi</p>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex gap-3">
            <a href="{{ route('transaksi.create') }}" 
               class="flex-1 px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-200 text-center">
                ↩️ Kembali
            </a>
            <button onclick="confirmPayment()" 
                    id="confirmBtn"
                    @if($paymentCard && !($paymentCard->saldo >= $total)) disabled @endif
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-lg hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                ✓ Konfirmasi Pembayaran
            </button>
        </div>
        
        @if($paymentCard && !($paymentCard->saldo >= $total))
        <div class="mt-4 p-4 bg-red-100 border border-red-300 rounded-lg">
            <p class="text-sm font-bold text-red-800">⚠️ Tidak dapat melanjutkan pembayaran</p>
            <p class="text-xs text-red-700 mt-1">Saldo kartu tidak mencukupi. Silakan top-up kartu atau pilih metode pembayaran lain.</p>
            <a href="{{ route('payment-cards.topup', $paymentCard) }}" 
               class="inline-block mt-3 px-4 py-2 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700">
                💰 Top-up Sekarang
            </a>
        </div>
        @endif
    </div>
</div>

<script>
    const paymentMethod = '{{ $method }}';
    const paymentCardId = {{ $paymentCardId ?? 'null' }};
    @if($paymentCard)
    const cardBalance = {{ $paymentCard->saldo }};
    const hasEnoughBalance = {{ $paymentCard->saldo >= $total ? 'true' : 'false' }};
    @endif
    // Calculate subtotals when qty or price changes
    function calculateTotal() {
        let grandTotal = 0;
        
        @foreach($items as $idx => $item)
        const qty{{ $idx }} = document.querySelector('input[name="items[{{ $idx }}][qty]"]').value || 0;
        const harga{{ $idx }} = document.querySelector('input[name="items[{{ $idx }}][harga]"]').value || 0;
        const subtotal{{ $idx }} = qty{{ $idx }} * harga{{ $idx }};
        
        document.querySelector('.subtotal-{{ $idx }}').textContent = subtotal{{ $idx }}.toLocaleString('id-ID');
        document.querySelector('.subtotal-input-{{ $idx }}').value = subtotal{{ $idx }};
        
        grandTotal += parseInt(subtotal{{ $idx }});
        @endforeach

        document.getElementById('displaySubtotal').textContent = grandTotal.toLocaleString('id-ID');
        document.getElementById('displayTotal').textContent = grandTotal.toLocaleString('id-ID');
        document.getElementById('subtotalInput').value = grandTotal;
        document.getElementById('totalInput').value = grandTotal;
    }

    // Confirm Payment
    function confirmPayment() {
        @if($paymentCard)
        // Validate balance again before submit
        if (!hasEnoughBalance) {
            alert('⚠️ Saldo kartu tidak mencukupi!\n\nSilakan top-up kartu terlebih dahulu.');
            return false;
        }
        @endif
        
        const form = document.getElementById('invoiceForm');
        
        // Collect items data
        const items = [];
        @foreach($items as $idx => $item)
        items.push({
            produk_id: parseInt(document.querySelector('input[name="items[{{ $idx }}][produk_id]"]').value),
            nama_produk: document.querySelector('input[name="items[{{ $idx }}][nama_produk]"]').value,
            harga: parseInt(document.querySelector('input[name="items[{{ $idx }}][harga]"]').value),
            qty: parseInt(document.querySelector('input[name="items[{{ $idx }}][qty]"]').value),
            subtotal: parseInt(document.querySelector('.subtotal-input-{{ $idx }}').value),
        });
        @endforeach

        // Validate
        if (items.some(item => item.qty <= 0 || item.harga <= 0)) {
            alert('Semua item harus memiliki qty dan harga lebih dari 0!');
            return;
        }

        const total = parseInt(document.getElementById('totalInput').value);
        
        // Final confirmation
        let confirmMsg = `Konfirmasi pembayaran?\n\nTotal: Rp${total.toLocaleString('id-ID')}`;
        @if($paymentCard)
        confirmMsg += `\n\nMetode: Kartu ${$paymentCard->holder_name}`;
        confirmMsg += `\nSaldo saat ini: Rp${cardBalance.toLocaleString('id-ID')}`;
        confirmMsg += `\nSaldo setelah bayar: Rp${(cardBalance - total).toLocaleString('id-ID')}`;
        @else
        confirmMsg += `\n\nMetode: Tunai`;
        @endif
        
        if (!confirm(confirmMsg)) {
            return;
        }

        // Submit form
        document.getElementById('itemsJson').value = JSON.stringify(items);
        
        const submitForm = document.createElement('form');
        submitForm.method = 'POST';
        submitForm.action = '{{ route("transaksi.confirm") }}';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        
        submitForm.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="method" value="{{ $method }}">
            <input type="hidden" name="items" value='${JSON.stringify(items)}'>
            <input type="hidden" name="subtotal" value="${document.getElementById('subtotalInput').value}">
            <input type="hidden" name="total" value="${document.getElementById('totalInput').value}">
            <input type="hidden" name="payment_card_id" value="{{ $paymentCardId }}">
        `;
        
        document.body.appendChild(submitForm);
        submitForm.submit();
    }

    // Calculate on page load
    calculateTotal();
</script>
@endsection
