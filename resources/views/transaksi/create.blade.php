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
                <!-- Products will be loaded here -->
                <div class="col-span-full py-12 text-center text-gray-500">
                    <p class="text-sm">Memuat produk...</p>
                </div>
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
                    <option value="e-wallet">E-Wallet</option>
                    <option value="kartu">Kartu Kredit/Debit</option>
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
                <span class="text-3xl">✓</span>
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
    // Sample Products Data
    const products = [
        { id: 1, name: 'Nasi Goreng', category: 'Makanan', price: 15000, stock: 50 },
        { id: 2, name: 'Mie Ayam', category: 'Makanan', price: 12000, stock: 30 },
        { id: 3, name: 'Nasi Uduk', category: 'Makanan', price: 10000, stock: 40 },
        { id: 4, name: 'Es Teh Manis', category: 'Minuman', price: 5000, stock: 100 },
        { id: 5, name: 'Kopi Hitam', category: 'Minuman', price: 8000, stock: 80 },
        { id: 6, name: 'Jus Jeruk', category: 'Minuman', price: 12000, stock: 60 },
        { id: 7, name: 'Pisang Goreng', category: 'Snack', price: 8000, stock: 35 },
        { id: 8, name: 'Kentang Goreng', category: 'Snack', price: 10000, stock: 40 },
        { id: 9, name: 'Popcorn', category: 'Snack', price: 10000, stock: 40 },
        { id: 10, name: 'Cake Coklat', category: 'Dessert', price: 25000, stock: 15 },
        { id: 11, name: 'Puding', category: 'Dessert', price: 8000, stock: 25 },
        { id: 12, name: 'Es Krim', category: 'Dessert', price: 15000, stock: 30 },
    ];

    let cart = {};

    // Format Currency
    function formatCurrency(amount) {
        return 'Rp' + amount.toLocaleString('id-ID');
    }

    // Load Products
    function loadProducts(filter = '') {
        const productGrid = document.getElementById('productGrid');
        const filtered = products.filter(p => 
            p.name.toLowerCase().includes(filter.toLowerCase()) ||
            p.category.toLowerCase().includes(filter.toLowerCase())
        );

        if (filtered.length === 0) {
            productGrid.innerHTML = '<div class="col-span-full py-12 text-center text-gray-500"><p class="text-sm">Produk tidak ditemukan</p></div>';
            return;
        }

        productGrid.innerHTML = filtered.map(product => `
            <button onclick="addToCart(${product.id})" 
                    class="bg-slate-50 rounded-lg p-3 md:p-4 hover:bg-orange-50 hover:border-orange-300 border-2 border-transparent transition-all duration-150 text-left">
                <h4 class="font-semibold text-gray-900 text-sm mb-1">${product.name}</h4>
                <p class="text-orange-600 font-bold text-sm mb-1">${formatCurrency(product.price)}</p>
                <p class="text-xs text-gray-500">Stok: ${product.stock}</p>
            </button>
        `).join('');
    }

    // Add to Cart
    function addToCart(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

        if (cart[productId]) {
            if (cart[productId].qty < product.stock) {
                cart[productId].qty++;
            } else {
                alert('Stok tidak cukup!');
                return;
            }
        } else {
            cart[productId] = { ...product, qty: 1 };
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
                        <p class="text-xs text-gray-600">${formatCurrency(item.price)}</p>
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
        const total = subtotal + tax;

        document.getElementById('subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('taxAmount').textContent = formatCurrency(tax);
        document.getElementById('totalAmount').textContent = formatCurrency(total);
    }

    // Process Payment
    function processPayment() {
        const cartArray = Object.values(cart);
        if (cartArray.length === 0) {
            alert('Keranjang masih kosong!');
            return;
        }

        const paymentMethod = document.getElementById('paymentMethod').value;
        const subtotal = cartArray.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const total = Math.round(subtotal * 1.1);

        // Show success
        document.getElementById('successMessage').textContent = `Total pembayaran: ${formatCurrency(total)} via ${paymentMethod}`;
        document.getElementById('successModal').classList.remove('hidden');

        // Reset cart after 2 seconds
        setTimeout(() => {
            resetCart();
            document.getElementById('successModal').classList.add('hidden');
        }, 2000);
    }

    // Reset Cart
    function resetCart() {
        cart = {};
        updateCart();
        loadProducts();
    }

    // Close Success Modal
    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden');
        resetCart();
    }

    // Search
    document.getElementById('searchProduct').addEventListener('input', (e) => {
        loadProducts(e.target.value);
    });

    // Initialize
    loadProducts();
</script>

@endsection
