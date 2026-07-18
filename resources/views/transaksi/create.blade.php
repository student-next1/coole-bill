@extends('layouts.app')

@section('title','Transaksi Baru')
@section('page-title','Transaksi Baru')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">

    <!-- Left Section - POS Input Table -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 flex flex-col" style="height: calc(100vh - 200px); min-height: 600px;">
            
            <!-- Header -->
            <div class="p-4 md:p-6 border-b border-slate-200 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">📦 Input Produk</h3>
                    <span class="text-xs text-gray-500">Scan barcode / ketik kode / nama produk</span>
                </div>
            </div>

            <!-- POS Table - Scrollable -->
            <div class="flex-1 overflow-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-full">Nama Produk / Barcode / Kode</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Qty</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Harga</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Subtotal</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="posTableBody">
                        <!-- Initial empty row -->
                        <tr class="border-b border-slate-100 hover:bg-slate-50 input-row" data-row="0">
                            <td class="px-4 py-3 text-sm text-gray-600">1</td>
                            <td class="px-4 py-3">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        class="product-search w-full px-3 py-2 text-sm border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                                        placeholder="Scan barcode / ketik kode / nama produk..."
                                        data-row="0"
                                        autocomplete="off"
                                    >
                                    <!-- Autocomplete dropdown -->
                                    <div class="search-results hidden absolute z-10 w-full mt-1 bg-white border border-slate-300 rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <input 
                                    type="number" 
                                    class="qty-input w-16 px-2 py-2 text-sm text-center border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                    value="1" 
                                    min="1"
                                    data-row="0"
                                >
                            </td>
                            <td class="px-4 py-3 text-right text-sm font-medium price-display text-gray-900">-</td>
                            <td class="px-4 py-3 text-right text-sm font-bold subtotal-display text-orange-600">-</td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="removeRow(0)" class="text-red-500 hover:text-red-700 text-sm font-medium opacity-0 remove-btn">
                                    ✕
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Instructions -->
            <div class="p-4 bg-slate-50 border-t border-slate-200 flex-shrink-0">
                <div class="flex items-start gap-3 text-xs text-gray-600">
                    <div class="flex-shrink-0 w-5 h-5 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold">
                        i
                    </div>
                    <div class="space-y-1">
                        <p><strong>Cara pakai:</strong></p>
                        <ul class="list-disc list-inside space-y-0.5 ml-2">
                            <li>Scan barcode / ketik kode produk / ketik nama produk</li>
                            <li>Setelah produk terpilih, akan otomatis lanjut ke baris baru</li>
                            <li>Ubah qty jika perlu</li>
                            <li>Klik ✕ untuk hapus item</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Right Section - Cart Summary -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 md:p-6 sticky top-24">
            
            <h3 class="text-lg font-semibold text-gray-900 mb-4">🛒 Keranjang</h3>

            <!-- Cart Items -->
            <div id="cartItems" class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                <div class="text-center py-8 text-gray-500">
                    <p class="text-sm">Keranjang kosong</p>
                    <p class="text-xs mt-1">Scan produk untuk mulai</p>
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

            <!-- Status Message -->
            <div id="statusMessage" class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-xs text-blue-700">
                    <span id="statusText">📝 Scan produk untuk memulai</span>
                </p>
            </div>

            <!-- Payment Method Selection -->
            <div class="mt-6 grid grid-cols-2 gap-2">
                <button type="button"
                        id="btnTunai"
                        onclick="selectPaymentMethod('tunai')"
                        class="px-4 py-3 bg-blue-100 border-2 border-blue-300 text-blue-700 font-semibold rounded-lg hover:bg-blue-200 transition-all duration-150 text-sm transform hover:scale-105">
                    💵 Tunai
                </button>
                <button type="button"
                        id="btnKartuId"
                        onclick="selectPaymentMethod('kartu_id')"
                        class="px-4 py-3 bg-green-100 border-2 border-green-300 text-green-700 font-semibold rounded-lg hover:bg-green-200 transition-all duration-150 text-sm transform hover:scale-105">
                    🆔 Kartu ID
                </button>
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

<!-- Product data for JavaScript -->
<script>
    // Product data from backend
    const productsData = @json($produks);
    const products = productsData;
    
    console.log('Products loaded:', products.length, 'items');
    console.log('Product data:', products);
    
    // Cart and state
    let cart = {};
    let totalAmount = 0;
    let selectedPaymentMethod = null;
    let currentRow = 0;
    let searchTimeout = null;

    // Format Currency
    function formatCurrency(amount) {
        return 'Rp' + amount.toLocaleString('id-ID');
    }

    // Initialize POS Table
    function initPOSTable() {
        const firstInput = document.querySelector('.product-search[data-row="0"]');
        if (firstInput) {
            firstInput.focus();
            setupProductSearch(firstInput);
            setupQtyInput(firstInput.closest('tr').querySelector('.qty-input'));
        }
    }

    // Setup Product Search with Autocomplete
    function setupProductSearch(input) {
        const row = input.dataset.row;
        const dropdown = input.nextElementSibling;
        
        console.log('Setup search for row:', row);
        
        input.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim().toLowerCase();
            
            console.log('Search term:', searchTerm);
            
            clearTimeout(searchTimeout);
            
            if (searchTerm.length < 2) {
                dropdown.classList.add('hidden');
                return;
            }
            
            searchTimeout = setTimeout(() => {
                console.log('Searching products...');
                console.log('Available products:', products);
                
                // Search by name, barcode, or product ID (kode)
                const results = products.filter(p => {
                    const nameMatch = p.nama_produk.toLowerCase().includes(searchTerm);
                    const barcodeMatch = p.kode_barcode && p.kode_barcode.toLowerCase().includes(searchTerm);
                    const idMatch = p.id.toString() === searchTerm; // Exact match for ID
                    return nameMatch || barcodeMatch || idMatch;
                });
                
                console.log('Search results:', results.length, 'found');
                console.log('Results:', results);
                
                if (results.length > 0) {
                    showSearchResults(dropdown, results, row);
                } else {
                    dropdown.innerHTML = '<div class="p-3 text-sm text-gray-500">Produk tidak ditemukan</div>';
                    dropdown.classList.remove('hidden');
                }
            }, 300);
        });
        
        // Close dropdown on click outside
        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }

    // Show Search Results Dropdown
    function showSearchResults(dropdown, results, row) {
        dropdown.innerHTML = results.map(product => `
            <div class="p-3 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-b-0" 
                 onclick="selectProduct(${product.id}, '${product.nama_produk.replace(/'/g, "\\'")}', ${product.harga}, ${product.stok}, ${row})">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">${product.nama_produk}</p>
                        <div class="flex gap-3 mt-1">
                            <span class="text-xs text-gray-500">Kode: <span class="font-semibold">${product.id}</span></span>
                            ${product.kode_barcode ? `<span class="text-xs text-gray-500">Barcode: ${product.kode_barcode}</span>` : ''}
                        </div>
                    </div>
                    <div class="text-right ml-3">
                        <p class="text-sm font-bold text-orange-600">${formatCurrency(product.harga)}</p>
                        <p class="text-xs text-gray-500">Stok: ${product.stok}</p>
                    </div>
                </div>
            </div>
        `).join('');
        dropdown.classList.remove('hidden');
    }

    // Select Product from Dropdown
    function selectProduct(productId, name, price, stock, row) {
        const tr = document.querySelector(`tr[data-row="${row}"]`);
        const input = tr.querySelector('.product-search');
        const qtyInput = tr.querySelector('.qty-input');
        const priceDisplay = tr.querySelector('.price-display');
        const subtotalDisplay = tr.querySelector('.subtotal-display');
        const removeBtn = tr.querySelector('.remove-btn');
        const dropdown = input.nextElementSibling;
        
        // Fill in product details
        input.value = name;
        input.dataset.productId = productId;
        input.dataset.price = price;
        input.dataset.stock = stock;
        input.readOnly = true;
        input.classList.add('bg-slate-50');
        
        // Show price and subtotal
        const qty = parseInt(qtyInput.value) || 1;
        priceDisplay.textContent = formatCurrency(price);
        subtotalDisplay.textContent = formatCurrency(price * qty);
        
        // Show remove button
        removeBtn.classList.remove('opacity-0');
        
        // Hide dropdown
        dropdown.classList.add('hidden');
        
        // Add to cart
        addToCartFromTable(productId, name, price, stock, qty);
        
        // Create new row and focus
        setTimeout(() => {
            addNewRow();
            focusNextRow();
        }, 100);
    }

    // Add to Cart from Table
    function addToCartFromTable(productId, name, price, stock, qty) {
        if (cart[productId]) {
            cart[productId].qty += qty;
        } else {
            cart[productId] = {
                id: productId,
                name: name,
                price: price,
                stock: stock,
                qty: qty
            };
        }
        updateCartDisplay();
    }

    // Setup Qty Input
    function setupQtyInput(qtyInput) {
        qtyInput.addEventListener('change', function() {
            const row = this.dataset.row;
            const tr = document.querySelector(`tr[data-row="${row}"]`);
            const input = tr.querySelector('.product-search');
            
            if (input.dataset.productId) {
                updateRowSubtotal(row);
                
                // Update cart
                const productId = input.dataset.productId;
                const qty = parseInt(this.value) || 1;
                if (cart[productId]) {
                    cart[productId].qty = qty;
                    updateCartDisplay();
                }
            }
        });
    }

    // Update Row Subtotal
    function updateRowSubtotal(row) {
        const tr = document.querySelector(`tr[data-row="${row}"]`);
        const input = tr.querySelector('.product-search');
        const qtyInput = tr.querySelector('.qty-input');
        const subtotalDisplay = tr.querySelector('.subtotal-display');
        
        if (input.dataset.productId) {
            const price = parseFloat(input.dataset.price);
            const qty = parseInt(qtyInput.value) || 1;
            subtotalDisplay.textContent = formatCurrency(price * qty);
        }
    }

    // Add New Row
    function addNewRow() {
        currentRow++;
        const tbody = document.getElementById('posTableBody');
        const newRow = document.createElement('tr');
        newRow.className = 'border-b border-slate-100 hover:bg-slate-50 input-row';
        newRow.dataset.row = currentRow;
        
        newRow.innerHTML = `
            <td class="px-4 py-3 text-sm text-gray-600">${currentRow + 1}</td>
            <td class="px-4 py-3">
                <div class="relative">
                    <input 
                        type="text" 
                        class="product-search w-full px-3 py-2 text-sm border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                        placeholder="Scan barcode / ketik kode / nama produk..."
                        data-row="${currentRow}"
                        autocomplete="off"
                    >
                    <div class="search-results hidden absolute z-10 w-full mt-1 bg-white border border-slate-300 rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
                </div>
            </td>
            <td class="px-4 py-3">
                <input 
                    type="number" 
                    class="qty-input w-16 px-2 py-2 text-sm text-center border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500" 
                    value="1" 
                    min="1"
                    data-row="${currentRow}"
                >
            </td>
            <td class="px-4 py-3 text-right text-sm font-medium price-display text-gray-900">-</td>
            <td class="px-4 py-3 text-right text-sm font-bold subtotal-display text-orange-600">-</td>
            <td class="px-4 py-3 text-center">
                <button type="button" onclick="removeRow(${currentRow})" class="text-red-500 hover:text-red-700 text-sm font-medium opacity-0 remove-btn">
                    ✕
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        
        // Setup event listeners for new row
        const newInput = newRow.querySelector('.product-search');
        const newQtyInput = newRow.querySelector('.qty-input');
        setupProductSearch(newInput);
        setupQtyInput(newQtyInput);
    }

    // Focus Next Row
    function focusNextRow() {
        const nextInput = document.querySelector(`.product-search[data-row="${currentRow}"]`);
        if (nextInput) {
            nextInput.focus();
        }
    }

    // Remove Row
    function removeRow(row) {
        const tr = document.querySelector(`tr[data-row="${row}"]`);
        const input = tr.querySelector('.product-search');
        
        if (input.dataset.productId) {
            const productId = input.dataset.productId;
            delete cart[productId];
            updateCartDisplay();
        }
        
        tr.remove();
        renumberRows();
    }

    // Renumber Rows
    function renumberRows() {
        const rows = document.querySelectorAll('#posTableBody tr');
        rows.forEach((row, index) => {
            const numberCell = row.querySelector('td:first-child');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }
        });
    }

    // Update Cart Display
    function updateCartDisplay() {
        const cartItems = document.getElementById('cartItems');
        const cartArray = Object.values(cart);
        const statusText = document.getElementById('statusText');

        if (cartArray.length === 0) {
            cartItems.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <p class="text-sm">Keranjang kosong</p>
                    <p class="text-xs mt-1">Scan produk untuk mulai</p>
                </div>
            `;
            document.getElementById('checkoutBtn').disabled = true;
            statusText.textContent = '📝 Scan produk untuk memulai';
        } else {
            cartItems.innerHTML = cartArray.map(item => `
                <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-lg">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-medium text-gray-900 text-sm truncate">${item.name}</h4>
                        <p class="text-xs text-gray-600">${item.qty} x ${formatCurrency(item.price)}</p>
                    </div>
                    <p class="font-bold text-sm text-orange-600">${formatCurrency(item.price * item.qty)}</p>
                </div>
            `).join('');
            
            if (selectedPaymentMethod) {
                document.getElementById('checkoutBtn').disabled = false;
                statusText.textContent = `✅ Siap! Metode: ${selectedPaymentMethod === 'tunai' ? '💵 Tunai' : '🆔 Kartu ID'}`;
            } else {
                document.getElementById('checkoutBtn').disabled = true;
                statusText.textContent = '⚠️ Pilih metode pembayaran';
            }
        }

        // Update Summary
        const subtotal = cartArray.reduce((sum, item) => sum + (item.price * item.qty), 0);
        totalAmount = subtotal;

        document.getElementById('subtotal').textContent = formatCurrency(subtotal);
        document.getElementById('totalAmount').textContent = formatCurrency(totalAmount);
    }

    // Select Payment Method
    function selectPaymentMethod(method) {
        selectedPaymentMethod = method;
        console.log('✓ Payment method selected:', method);
        
        // Reset all button styles
        document.getElementById('btnTunai').classList.remove('ring-2', 'ring-blue-500', 'scale-110');
        document.getElementById('btnKartuId').classList.remove('ring-2', 'ring-green-500', 'scale-110');
        
        // Highlight selected button
        if (method === 'tunai') {
            document.getElementById('btnTunai').classList.add('ring-2', 'ring-blue-500', 'scale-110');
            document.getElementById('btnTunai').innerHTML = '💵 Tunai ✓ Dipilih';
            document.getElementById('btnKartuId').innerHTML = '🆔 Kartu ID';
        } else if (method === 'kartu_id') {
            document.getElementById('btnKartuId').classList.add('ring-2', 'ring-green-500', 'scale-110');
            document.getElementById('btnKartuId').innerHTML = '🆔 Kartu ID ✓ Dipilih';
            document.getElementById('btnTunai').innerHTML = '💵 Tunai';
        }
        
        updateCartDisplay();
    }

    // Process Payment
    function processPayment() {
        const cartArray = Object.values(cart);
        
        if (cartArray.length === 0) {
            alert('❌ Keranjang masih kosong!\n\nScan produk terlebih dahulu.');
            return;
        }

        if (!selectedPaymentMethod) {
            alert('❌ Pilih metode pembayaran terlebih dahulu!\n\nPilih:\n💵 Tunai atau 🆔 Kartu ID');
            return;
        }

        try {
            // Prepare items
            const items = cartArray.map(item => ({
                produk_id: item.id,
                qty: item.qty,
                harga: item.price,
                subtotal: item.price * item.qty
            }));

            const subtotal = cartArray.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const total = subtotal;

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("transaksi.select-payment") }}';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
            
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="items" value='${JSON.stringify(items)}'>
                <input type="hidden" name="subtotal" value="${subtotal}">
                <input type="hidden" name="total" value="${total}">
                <input type="hidden" name="method" value="${selectedPaymentMethod}">
            `;
            
            document.body.appendChild(form);
            form.submit();
            
        } catch (error) {
            console.error('Error:', error);
            alert('❌ Error: ' + error.message);
        }
    }

    // Reset Cart
    function resetCart() {
        if (Object.keys(cart).length > 0) {
            if (!confirm('Reset transaksi dan hapus semua item?')) {
                return;
            }
        }
        
        cart = {};
        selectedPaymentMethod = null;
        currentRow = 0;
        
        // Reset payment buttons
        document.getElementById('btnTunai').classList.remove('ring-2', 'ring-blue-500', 'scale-110');
        document.getElementById('btnKartuId').classList.remove('ring-2', 'ring-green-500', 'scale-110');
        document.getElementById('btnTunai').innerHTML = '💵 Tunai';
        document.getElementById('btnKartuId').innerHTML = '🆔 Kartu ID';
        
        // Clear table and add fresh first row
        document.getElementById('posTableBody').innerHTML = `
            <tr class="border-b border-slate-100 hover:bg-slate-50 input-row" data-row="0">
                <td class="px-4 py-3 text-sm text-gray-600">1</td>
                <td class="px-4 py-3">
                    <div class="relative">
                        <input 
                            type="text" 
                            class="product-search w-full px-3 py-2 text-sm border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" 
                            placeholder="Scan barcode atau ketik nama produk..."
                            data-row="0"
                            autocomplete="off"
                        >
                        <div class="search-results hidden absolute z-10 w-full mt-1 bg-white border border-slate-300 rounded-lg shadow-lg max-h-60 overflow-y-auto"></div>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <input 
                        type="number" 
                        class="qty-input w-16 px-2 py-2 text-sm text-center border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-500" 
                        value="1" 
                        min="1"
                        data-row="0"
                    >
                </td>
                <td class="px-4 py-3 text-right text-sm font-medium price-display text-gray-900">-</td>
                <td class="px-4 py-3 text-right text-sm font-bold subtotal-display text-orange-600">-</td>
                <td class="px-4 py-3 text-center">
                    <button type="button" onclick="removeRow(0)" class="text-red-500 hover:text-red-700 text-sm font-medium opacity-0 remove-btn">
                        ✕
                    </button>
                </td>
            </tr>
        `;
        
        updateCartDisplay();
        initPOSTable();
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        initPOSTable();
        updateCartDisplay();
    });
</script>

@endsection
