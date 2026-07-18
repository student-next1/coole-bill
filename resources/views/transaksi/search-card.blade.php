@extends('layouts.app')

@section('title','Cari Kartu Pembayaran')
@section('page-title','Cari Kartu Pembayaran')

@section('content')

<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold text-gray-900">Cari Kartu Pembayaran</h3>
        <p class="text-sm text-gray-600 mt-2">Total: Rp{{ number_format($total, 0, ',', '.') }}</p>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-8 mb-8">
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-900 mb-2">Scan Barcode atau Cari Card:</label>
            <input type="text" 
                   id="cardSearch"
                   placeholder="Ketik kode kartu, username, atau nama..."
                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm"
                   autofocus>
            <p class="text-xs text-gray-600 mt-2">Mulai mengetik untuk mencari kartu pembayaran</p>
        </div>
    </div>

    <!-- Search Results -->
    <div id="searchResults" class="space-y-3">
        <div class="text-center text-gray-500 py-8">
            <p class="text-sm">Hasil pencarian akan muncul di sini...</p>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('transaksi.create') }}" 
           class="w-full px-4 py-3 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-center block">
            Kembali
        </a>
    </div>
</div>

<!-- Card Detail Modal -->
<div id="cardModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pembayaran</h3>
        </div>
        <div id="modalContent" class="p-6 space-y-4">
            <!-- Content will be filled by JS -->
        </div>
        <div class="p-6 border-t border-slate-200 flex gap-3">
            <button type="button"
                    onclick="closeModal()"
                    class="flex-1 px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50">
                Batal
            </button>
            <button type="button"
                    id="confirmBtn"
                    class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg">
                Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
    const total = {{ $total }};
    const items = @json($items);
    const subtotal = {{ $subtotal }};

    let searchTimeout;
    let selectedCardId;

    document.getElementById('cardSearch').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();
        
        if (query.length < 2) {
            document.getElementById('searchResults').innerHTML = '<div class="text-center text-gray-500 py-8"><p class="text-sm">Minimal 2 karakter</p></div>';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('transaksi.find-card') }}?q=${encodeURIComponent(query)}`)
                .then(r => r.json())
                .then(cards => {
                    if (cards.length === 0) {
                        document.getElementById('searchResults').innerHTML = '<div class="text-center text-gray-500 py-8"><p class="text-sm">Kartu tidak ditemukan</p></div>';
                        return;
                    }

                    document.getElementById('searchResults').innerHTML = cards.map(card => `
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 cursor-pointer hover:border-orange-300 hover:shadow-md transition-all"
                             onclick="selectCard(${card.id}, '${card.card_code}', '${card.username || '-'}', '${card.holder_name}', ${card.saldo})">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">${card.holder_name}</p>
                                    <p class="text-xs text-gray-600 mt-1">
                                        Kode: <span class="font-mono">${card.card_code}</span>
                                    </p>
                                    @if($username)
                                        <p class="text-xs text-gray-600">Username: @${card.username}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-orange-600">Rp${card.saldo.toLocaleString('id-ID')}</p>
                                    <p class="text-xs ${card.saldo >= ${total} ? 'text-green-600' : 'text-red-600'}">
                                        ${card.saldo >= ${total} ? '✓ Cukup' : '✗ Kurang'}
                                    </p>
                                </div>
                            </div>
                        </div>
                    `).join('');
                })
                .catch(e => {
                    console.error(e);
                    document.getElementById('searchResults').innerHTML = '<div class="text-center text-red-500 py-8"><p class="text-sm">Error mencari kartu</p></div>';
                });
        }, 300);
    });

    function selectCard(cardId, cardCode, username, holderName, saldo) {
        selectedCardId = cardId;
        
        if (saldo < total) {
            alert('Saldo kartu tidak cukup untuk transaksi ini');
            return;
        }

        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = `
            <div class="space-y-4">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4 text-white">
                    <p class="text-sm opacity-90">Pemilik Kartu</p>
                    <p class="text-lg font-bold">${holderName}</p>
                    <p class="text-xs opacity-90 mt-2">Kode: ${cardCode}</p>
                </div>

                <div class="border-t border-slate-200 pt-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp${subtotal.toLocaleString('id-ID')}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t border-slate-200 pt-2">
                        <span>Total Pembayaran</span>
                        <span class="text-orange-600">Rp${total.toLocaleString('id-ID')}</span>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-sm text-blue-900">
                        Saldo kartu akan dikurangi sebesar <strong>Rp${total.toLocaleString('id-ID')}</strong>
                    </p>
                </div>
            </div>
        `;

        document.getElementById('confirmBtn').onclick = () => confirmPayment(cardId);
        document.getElementById('cardModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('cardModal').classList.add('hidden');
    }

    function confirmPayment(cardId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('transaksi.store') }}';
        
        const csrf = '{{ csrf_token() }}';
        
        form.innerHTML = `
            <input type="hidden" name="_token" value="${csrf}">
            <input type="hidden" name="items" value='${JSON.stringify(items)}'>
            <input type="hidden" name="subtotal" value="${subtotal}">
            <input type="hidden" name="pajak" value="${pajak}">
            <input type="hidden" name="total" value="${total}">
            <input type="hidden" name="metode_pembayaran" value="tunai">
            <input type="hidden" name="nominal_bayar" value="${total}">
            <input type="hidden" name="payment_card_id" value="${cardId}">
        `;
        
        document.body.appendChild(form);
        form.submit();
    }

    // Auto-focus input
    document.getElementById('cardSearch').focus();
</script>

@endsection
