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
                    <option value="kartu_id">Kartu ID</option>
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
        totalAmount = subtotal;

        document.getElementById('subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('totalAmount').textContent = formatCurrency(totalAmount);
    }

    // Process Payment - Redirect to payment method selection
    function processPayment() {
        const cartArray = Object.values(cart);
        if (cartArray.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }

        // Prepare form data
        const items = cartArray.map(item => ({
            produk_id: item.id,
            qty: item.qty
        }));

        const subtotal = cartArray.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const total = subtotal;

        // Submit to select payment endpoint
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("transaksi.select-payment") }}';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
        
        form.innerHTML = `
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="items" value='${JSON.stringify(items)}'>
            <input type="hidden" name="subtotal" value="${subtotal}">
            <input type="hidden" name="total" value="${total}">
        `;
        
        document.body.appendChild(form);
        form.submit();
    }

    // Handle nominal bayar change - No longer used
    // (kept reference in case needed later)

    // Close Payment Modal - No longer used

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
