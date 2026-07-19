@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-blue-50 p-4 md:p-8">
    <div class="max-w-3xl mx-auto">
        
        <!-- Success Banner -->
        <div class="mb-8 bg-green-100 border-l-4 border-green-600 rounded-lg p-6">
            <div class="flex items-center gap-4">
                <div class="text-4xl">✓</div>
                <div>
                    <h1 class="text-2xl font-bold text-green-900">Pembayaran Berhasil!</h1>
                    <p class="text-green-700 text-sm mt-1">Transaksi telah diproses dan stok produk telah berkurang</p>
                </div>
            </div>
        </div>

        <!-- Receipt/Struk Container -->
        <div id="struk" class="bg-white rounded-xl shadow-2xl p-8 mb-8">
            
            <!-- Store Header -->
            <div class="text-center mb-8 pb-6 border-b-4 border-dashed border-gray-300">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="px-4 py-2 bg-black rounded">
                        <span class="text-white font-black text-lg">COOL</span>
                    </div>
                    <div class="px-4 py-2 bg-orange-600 rounded">
                        <span class="text-white font-black text-lg">E-BILL</span>
                    </div>
                </div>
                <h2 class="text-3xl font-black text-gray-900">STRUK PEMBAYARAN</h2>
                <p class="text-xs text-gray-600 mt-2">Sistem POS Terpadu</p>
            </div>

            <!-- Transaction Details -->
            <div class="space-y-2 mb-6 pb-6 border-b-2 border-dashed border-gray-300">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Kode Transaksi</span>
                    <span class="font-bold text-gray-900">{{ $transaksi->kode_transaksi }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Tanggal</span>
                    <span class="font-semibold text-gray-900">{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Kasir</span>
                    <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Metode Pembayaran</span>
                    <span class="font-bold">
                        @if($transaksi->metode_pembayaran === 'tunai')
                            <span class="text-blue-600">💵 TUNAI</span>
                        @else
                            <span class="text-green-600">🆔 KARTU ID</span>
                        @endif
                    </span>
                </div>
                @if($transaksi->payment_card_id)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Kartu Pembayaran</span>
                    <span class="font-semibold text-gray-900">{{ $transaksi->paymentCard->username ?? 'N/A' }}</span>
                </div>
                @endif
            </div>

            <!-- Items List -->
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase">Daftar Barang</h3>
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-300">
                        <tr>
                            <th class="text-left py-2 px-0 text-gray-600">Produk</th>
                            <th class="text-right py-2 px-0 text-gray-600">Qty</th>
                            <th class="text-right py-2 px-0 text-gray-600">Harga</th>
                            <th class="text-right py-2 px-0 text-gray-600">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $detail)
                        <tr class="border-b border-gray-200">
                            <td class="py-2 px-0 text-gray-900">{{ $detail->produk->nama_produk }}</td>
                            <td class="text-right py-2 px-0 text-gray-900">{{ $detail->qty }}</td>
                            <td class="text-right py-2 px-0 text-gray-900">Rp{{ number_format($detail->harga, 0) }}</td>
                            <td class="text-right py-2 px-0 font-semibold text-gray-900">Rp{{ number_format($detail->subtotal, 0) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="space-y-2 mb-8 pb-8 border-b-4 border-dashed border-gray-300">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-700">Subtotal</span>
                    <span class="text-gray-900">Rp{{ number_format($transaksi->subtotal, 0) }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold bg-gradient-to-r from-orange-50 to-yellow-50 p-3 rounded">
                    <span class="text-gray-900">TOTAL</span>
                    <span class="text-orange-600">Rp{{ number_format($transaksi->total, 0) }}</span>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center space-y-1 text-xs text-gray-600">
                <p class="font-semibold">Terima Kasih Telah Berbelanja!</p>
                <p>Mohon simpan struk ini sebagai bukti transaksi</p>
                <p class="text-gray-500 mt-2">{{ date('d/m/Y H:i:s') }}</p>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button onclick="printReceipt()" 
                    class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200"
                    id="btnCetakStruk">
                🖨️ Cetak Struk
            </button>
            <a href="{{ route('transaksi.index') }}" 
               class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 text-center"
               id="btnSelesai">
                ✓ Selesai & Kembali ke Daftar Transaksi
            </a>
        </div>

    </div>
</div>

<!-- Keyboard Shortcuts Script -->
<script defer>
    console.log('CONFIRMATION PAGE KEYBOARD SHORTCUTS LOADED');
    
    function printReceipt() {
        console.log('PRINT RECEIPT CALLED');
        const printContent = document.getElementById('struk').innerHTML;
        const printWindow = window.open('', '', 'height=600,width=400');
        printWindow.document.write(
            '<!DOCTYPE html><html><head><title>Struk Pembayaran</title><style>' +
            'body { font-family: Arial, sans-serif; padding: 20px; }' +
            '#struk { max-width: 80mm; margin: 0 auto; }' +
            '* { margin: 0; padding: 0; }' +
            '.text-center { text-align: center; }' +
            '.border-b { border-bottom: 1px solid #000; }' +
            '.border-dashed { border-bottom-style: dashed; }' +
            '.font-bold { font-weight: bold; }' +
            '.text-sm { font-size: 12px; }' +
            '.flex { display: flex; justify-content: space-between; }' +
            'table { width: 100%; border-collapse: collapse; }' +
            'th, td { padding: 5px; text-align: left; }' +
            '@media print { body { margin: 0; padding: 0; } }' +
            '</style></head><body>' +
            printContent +
            '</body></html>'
        );
        printWindow.document.close();
        setTimeout(() => { printWindow.print(); }, 250);
    }

    function setupKeyboardShortcuts() {
        console.log('setupKeyboardShortcuts() called');
        
        document.addEventListener('keydown', function(e) {
            console.log('Key:', e.key, 'Code:', e.code, 'Ctrl:', e.ctrlKey);
            
            // Ctrl+Enter: print receipt
            if (e.ctrlKey && e.key === 'Enter') {
                console.log('CTRL+ENTER PRESSED - printing receipt');
                e.preventDefault();
                printReceipt();
                return;
            }
            
            // Enter: go back to list
            if (e.key === 'Enter') {
                console.log('ENTER PRESSED - going to transaction list');
                window.location.href = '{{ route("transaksi.index") }}';
            }
        });
    }
    
    // Run immediately
    setupKeyboardShortcuts();
</script>
@endsection
