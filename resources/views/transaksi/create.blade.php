@extends('layouts.app')

@section('title','Transaksi Baru')
@section('page-title','Transaksi Baru')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">

    <!-- Left Section - Product Selection -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Search Product -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
            <input type="text" 
                   id="searchProduct" 
                   placeholder="Cari produk atau scan barcode..." 
                   class="w-full px-4 py-3 text-sm md:text-base border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
        </div>

        <!-- Product Grid -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Produk</h3>
            
            <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-4">
                @forelse($produks as $produk)
                    <button onclick="addToCart({{ $produk->id }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, {{ $produk->stok }})" 
                            class="bg-slate-50 rounded-lg p-3 md:p-4 hover:bg-orange-50 hover:border-orange-300 border-2 border-transparent transition-all duration-150 text-left">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1 truncate">{{ $produk->nama_produk }}</h4>
                        <p class="text-orange-600 font-bold text-sm mb-1">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">Stok: {{ $produk->stok }}</p>
                    </button>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500">
                        <p class="text-sm">Tidak ada produk tersedia. <a href="{{ route('produk.create') }}" class="text-orange-600 font-medium">Tambah produk</a></p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Right Section - Cart -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6 sticky top-24">
            
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Keranjang</h3>

            <!-- Cart Items -->
            <div id="cartItems" class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                <div class="text-center py-8 text-gray-500">
                    <p class="text-sm">Keranjang kosong</p>
                </div>
            </div>

            <!-- Summary -->
            <div class="space-y-3 pt-4 border-t border-slate-200">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span id="subtotal" class="font-medium text-gray-900">Rp0</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Pajak (10%)</span>
                    <span id="taxAmount" class="font-medium text-gray-900">Rp0</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-3 border-t border-slate-200">
                    <span class="text-gray-900">Total</span>
                    <span id="totalAmount" class="bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">Rp0</span>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <select id="paymentMethod" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                    <option value="tunai">Tunai</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="kartu_kredit">Kartu Kredit/Debit</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 space-y-2">
                <button onclick="processPayment()" 
                        id="checkoutBtn"
                        disabled
                        class="w-full px-4 py-3 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-semibold rounded-lg hover:shadow-lg transition-all duration-150 disabled:opacity-50 disabled:cursor-not-allowed text-sm md:text-base">
                    Proses Pembayaran
                </button>
                <button onclick="resetCart()" 
                        class="w-full px-4 py-3 border border-slate-300 text-gray-700 font-medium rounded-lg hover:bg-slate-50 transition-colors duration-150 text-sm md:text-base">
                    Reset
                </button>
            </div>

        </div>
    </div>

</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-3xl text-green-600">✓</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Transaksi Berhasil!</h3>
            <p id="successMessage" class="text-gray-600 mb-6 text-sm">Transaksi telah berhasil diproses</p>
            <button onclick="closeSuccessModal()" 
                    class="w-full px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg">
                Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pembayaran</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="bg-slate-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Total Pembayaran</p>
                <p id="paymentTotal" class="text-2xl font-bold text-gray-900 mt-1">Rp0</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                <p id="paymentMethodDisplay" class="text-sm text-gray-900 font-medium">-</p>
            </div>
            <div id="nominalBayarDiv" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Bayar (Tunai)</label>
                <input type="number" 
                       id="nominalBayar"
                       placeholder="Masukkan nominal"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm"
                       min="0">
                <p id="changeDisplay" class="text-sm text-gray-600 mt-2"></p>
            </div>
        </div>
        <div class="p-6 border-t border-slate-200 flex gap-3">
            <button type="button" 
                    onclick="closePaymentModal()"
                    class="flex-1 px-4 py-2 border border-slate-300 text-gray-900 font-medium rounded-lg hover:bg-slate-50 transition-colors text-sm">
                Batal
            </button>
            <button type="button" 
                    onclick="submitPayment()"
                    class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200 text-sm">
                Bayar
            </button>
        </div>
    </div>
</div>

<script>
    let cart = {};
    let totalAmount = 0;

    // Format Currency
    function formatCurrency(amount) {
        return 'Rp' + amount.toLocaleString('id-ID');
    }

    // Add to Cart
    function addToCart(productId, name, price, stock) {
        if (cart[productId]) {
            if (cart[productId].qty < stock) {
                cart[productId].qty++;
            } else {
                alert('Stok tidak cukup!');
                return;
            }
        } else {
            cart[productId] = { 
                id: productId,
                name: name, 
                price: price, 
                stock: stock,
                qty: 1 
            };
        }
        updateCart();
    }

    // Remove from Cart
    function removeFromCart(productId) {
        delete cart[productId];
        updateCart();
    }

    // Update Quantity
    function updateQty(productId, change) {
        if (cart[productId]) {
            const newQty = cart[productId].qty + change;
            if (newQty > 0 && newQty <= cart[productId].stock) {
                cart[productId].qty = newQty;
                updateCart();
            }
        }
    }

    // Update Cart Display
    function updateCart() {
        const cartItems = document.getElementById('cartItems');
        const cartArray = Object.values(cart);

        if (cartArray.length === 0) {
            cartItems.innerHTML = '<div class="text-center py-8 text-gray-500"><p class="text-sm">Keranjang kosong</p></div>';
            document.getElementById('checkoutBtn').disabled = true;
        } else {
            cartItems.innerHTML = cartArray.map(item => `
                <div class="flex items-center gap-2 md:gap-3 p-3 bg-slate-50 rounded-lg">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-medium text-gray-900 text-sm truncate">${item.name}</h4>
                        <p class="text-xs text-gray-600">Rp${item.price.toLocaleString('id-ID')}</p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="updateQty(${item.id}, -1)" class="w-5 h-5 md:w-6 md:h-6 bg-slate-200 rounded text-xs hover:bg-slate-300">−</button>
                        <span class="w-6 md:w-8 text-center text-xs md:text-sm font-medium">${item.qty}</span>
                        <button onclick="updateQty(${item.id}, 1)" class="w-5 h-5 md:w-6 md:h-6 bg-slate-200 rounded text-xs hover:bg-slate-300">+</button>
                    </div>
                    <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 text-sm">✕</button>
                </div>
            `).join('');
            document.getElementById('checkoutBtn').disabled = false;
        }

        // Update Summary
        const subtotal = cartArray.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const tax = Math.round(subtotal * 0.1);
        totalAmount = subtotal + tax;

        document.getElementById('subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('taxAmount').textContent = formatCurrency(tax);
        document.getElementById('totalAmount').textContent = formatCurrency(totalAmount);
    }

    // Process Payment
    function processPayment() {
        const cartArray = Object.values(cart);
        if (cartArray.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }

        const paymentMethod = document.getElementById('paymentMethod').value;
        document.getElementById('paymentTotal').textContent = formatCurrency(totalAmount);
        
        let methodDisplay = 'Tunai';
        if (paymentMethod === 'transfer') methodDisplay = 'Transfer Bank';
        if (paymentMethod === 'kartu_kredit') methodDisplay = 'Kartu Kredit/Debit';
        
        document.getElementById('paymentMethodDisplay').textContent = methodDisplay;

        // Show nominal bayar input only for tunai
        const nominalDiv = document.getElementById('nominalBayarDiv');
        if (paymentMethod === 'tunai') {
            nominalDiv.classList.remove('hidden');
            document.getElementById('nominalBayar').value = '';
        } else {
            nominalDiv.classList.add('hidden');
        }

        document.getElementById('paymentModal').classList.remove('hidden');
    }

    // Handle nominal bayar change
    document.getElementById('nominalBayar')?.addEventListener('input', function() {
        const nominal = parseInt(this.value) || 0;
        const change = nominal - totalAmount;
        const changeDisplay = document.getElementById('changeDisplay');
        
        if (change >= 0) {
            changeDisplay.textContent = 'Kembalian: ' + formatCurrency(change);
            changeDisplay.className = 'text-sm text-green-600 mt-2 font-medium';
        } else {
            changeDisplay.textContent = 'Kurang: ' + formatCurrency(Math.abs(change));
            changeDisplay.className = 'text-sm text-red-600 mt-2 font-medium';
        }
    });

    // Submit Payment
    function submitPayment() {
        const paymentMethod = document.getElementById('paymentMethod').value;
        const cartArray = Object.values(cart);

        if (cartArray.length === 0) {
            alert('Keranjang kosong!');
            return;
        }

        let nominalBayar = totalAmount;
        if (paymentMethod === 'tunai') {
            nominalBayar = parseInt(document.getElementById('nominalBayar').value) || 0;
            if (nominalBayar < totalAmount) {
                alert('Nominal bayar harus >= total transaksi');
                return;
            }
        }

        // Prepare form data
        const items = cartArray.map(item => ({
            produk_id: item.id,
            qty: item.qty
        }));

        const subtotal = cartArray.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const tax = Math.round(subtotal * 0.1);

        // Submit via form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("transaksi.store") }}';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        
        form.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="items" value='${JSON.stringify(items)}'>
            <input type="hidden" name="subtotal" value="${subtotal}">
            <input type="hidden" name="pajak" value="${tax}">
            <input type="hidden" name="total" value="${totalAmount}">
            <input type="hidden" name="metode_pembayaran" value="${paymentMethod}">
            <input type="hidden" name="nominal_bayar" value="${nominalBayar}">
        `;
        
        document.body.appendChild(form);
        form.submit();
    }

    // Close Payment Modal
    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    // Reset Cart
    function resetCart() {
        cart = {};
        updateCart();
        document.getElementById('searchProduct').value = '';
    }

    // Close Success Modal
    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
        window.location.href = '{{ route("transaksi.index") }}';
    }

    // Search
    document.getElementById('searchProduct').addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();
        const buttons = document.querySelectorAll('#productGrid button');
        buttons.forEach(btn => {
            const text = btn.textContent.toLowerCase();
            btn.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });

    // Initialize
    updateCart();
</script>

@endsection
