<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Produk;
use App\Models\PaymentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user', 'details.produk', 'paymentCard')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::with('kategori')->where('stok', '>', 0)->get();
        return view('transaksi.create', compact('produks'));
    }

    public function selectPaymentMethod(Request $request)
    {
        // Validate cart items first
        $items = json_decode($request->input('items'), true);
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        // Store in session
        session([
            'cart_items' => $items,
            'subtotal' => $validated['subtotal'],
            'total' => $validated['total'],
        ]);

        // Get payment method from request
        $method = $request->input('method');
        
        if ($method === 'tunai') {
            // Tunai: Langsung ke struk
            return redirect()->route('transaksi.invoice', ['method' => 'tunai']);
        } elseif ($method === 'kartu_id') {
            // Kartu ID: Cari kartu dulu
            return redirect()->route('transaksi.search-card');
        }
        
        return back()->with('error', 'Metode pembayaran tidak valid');
    }

    public function searchCard(Request $request)
    {
        // Tampilkan form pencarian kartu
        return view('transaksi.search-card', [
            'items' => session('cart_items'),
            'subtotal' => session('subtotal'),
            'total' => session('total'),
        ]);
    }

    public function selectCard(Request $request)
    {
        // Setelah pilih kartu, redirect ke invoice dengan payment_card_id
        $cardId = $request->input('card_id');
        
        if (!$cardId) {
            return back()->with('error', 'Silakan pilih kartu');
        }

        session(['payment_card_id' => $cardId]);
        return redirect()->route('transaksi.invoice', ['method' => 'kartu_id']);
    }

    public function findCard(Request $request)
    {
        $search = $request->query('search');
        
        if (!$search || strlen($search) < 1) {
            return response()->json(['success' => false, 'message' => 'Masukkan kata kunci pencarian'], 400);
        }

        try {
            $cards = PaymentCard::where('status', 'active')
                ->where(function($q) use ($search) {
                    $q->where('barcode_data', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%")
                      ->orWhere('holder_name', 'like', "%{$search}%");
                })
                ->get(['id', 'barcode_data', 'username', 'holder_name', 'saldo', 'status']);

            return response()->json([
                'success' => true,
                'cards' => $cards,
                'count' => $cards->count()
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function confirmPayment(Request $request, $cardId)
    {
        $card = PaymentCard::findOrFail($cardId);
        $total = session('total');

        if (!$card->hasEnoughBalance($total)) {
            return back()->with('error', 'Saldo kartu tidak cukup');
        }

        return view('transaksi.confirm-payment', [
            'card' => $card,
            'items' => session('cart_items'),
            'subtotal' => session('subtotal'),
            'total' => session('total'),
        ]);
    }

    public function processPayment(Request $request, $paymentMethod = null)
    {
        $itemsInput = $request->input('items') ?? json_encode(session('cart_items'));
        $items = is_string($itemsInput) ? json_decode($itemsInput, true) : $itemsInput;

        $validated = $request->validate([
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,kartu_id',
            'payment_card_id' => 'nullable|exists:payment_cards,id',
        ]);

        try {
            DB::beginTransaction();

            // Generate kode transaksi
            $kode_transaksi = 'TRX-' . date('YmdHis') . rand(100, 999);

            // Create transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kode_transaksi,
                'user_id' => auth()->id(),
                'subtotal' => $validated['subtotal'],
                'total' => $validated['total'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'payment_card_id' => $validated['payment_card_id'] ?? null,
                'status' => 'selesai',
            ]);

            // Create transaksi details & reduce stock
            foreach ($items as $item) {
                $produk = Produk::findOrFail($item['produk_id']);

                // Check stock
                if ($produk->stok < $item['qty']) {
                    throw new \Exception("Stok {$produk->nama_produk} tidak cukup");
                }

                // Create detail
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'harga' => $produk->harga,
                    'qty' => $item['qty'],
                    'subtotal' => $produk->harga * $item['qty'],
                ]);

                // Reduce stock
                $produk->decrement('stok', $item['qty']);
            }

            // Deduct from payment card if used
            if ($validated['payment_card_id']) {
                $card = PaymentCard::findOrFail($validated['payment_card_id']);
                $card->deductBalance($validated['total'], $transaksi->id, "Pembelian - {$kode_transaksi}");
            }

            DB::commit();

            session()->forget(['cart_items', 'subtotal', 'total']);

            return redirect()->route('transaksi.receipt', ['id' => $transaksi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $itemsInput = $request->input('items');
        $items = is_string($itemsInput) ? json_decode($itemsInput, true) : $itemsInput;

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,kartu_id',
            'nominal_bayar' => 'required|numeric|min:0',
            'payment_card_id' => 'nullable|exists:payment_cards,id',
        ]);

        try {
            DB::beginTransaction();

            // Generate kode transaksi
            $kode_transaksi = 'TRX-' . date('YmdHis') . rand(100, 999);

            // Create transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kode_transaksi,
                'user_id' => auth()->id(),
                'subtotal' => $validated['subtotal'],
                'total' => $validated['total'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'payment_card_id' => $validated['payment_card_id'] ?? null,
                'status' => 'selesai',
            ]);

            // Create transaksi details & reduce stock
            foreach ($items as $item) {
                $produk = Produk::findOrFail($item['produk_id']);

                // Check stock
                if ($produk->stok < $item['qty']) {
                    throw new \Exception("Stok {$produk->nama_produk} tidak cukup");
                }

                // Create detail
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'harga' => $produk->harga,
                    'qty' => $item['qty'],
                    'subtotal' => $produk->harga * $item['qty'],
                ]);

                // Reduce stock
                $produk->decrement('stok', $item['qty']);
            }

            // Deduct from payment card if used
            if ($validated['payment_card_id']) {
                $card = PaymentCard::findOrFail($validated['payment_card_id']);
                $card->deductBalance($validated['total'], $transaksi->id, "Pembelian - {$kode_transaksi}");
            }

            DB::commit();

            return redirect()->route('transaksi.receipt', ['id' => $transaksi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function receipt($id)
    {
        $transaksi = Transaksi::with('user', 'details.produk', 'paymentCard')
            ->findOrFail($id);
        return view('transaksi.receipt', compact('transaksi'));
    }

    public function invoice(Request $request)
    {
        $method = $request->query('method');
        $items = session('cart_items', []);
        $subtotal = session('subtotal', 0);
        $total = session('total', 0);
        $paymentCardId = session('payment_card_id');

        if (empty($items)) {
            return redirect()->route('transaksi.create')->with('error', 'Keranjang kosong');
        }

        // Load produk details
        $itemsWithDetails = [];
        foreach ($items as $item) {
            $produk = Produk::find($item['produk_id']);
            if ($produk) {
                $itemsWithDetails[] = [
                    'produk_id' => $produk->id,
                    'nama_produk' => $produk->nama_produk,
                    'harga' => $produk->harga,
                    'qty' => $item['qty'],
                    'subtotal' => $produk->harga * $item['qty'],
                ];
            }
        }

        return view('transaksi.invoice', [
            'method' => $method,
            'items' => $itemsWithDetails,
            'subtotal' => $subtotal,
            'total' => $total,
            'paymentCardId' => $paymentCardId,
        ]);
    }

    public function confirmPayment(Request $request)
    {
        $method = $request->input('method');
        $items = json_decode($request->input('items'), true);
        $total = $request->input('total');
        $paymentCardId = $request->input('payment_card_id');

        try {
            DB::beginTransaction();

            // Validate cart items
            if (empty($items)) {
                throw new \Exception('Keranjang kosong');
            }

            // Validate payment card if using kartu_id
            if ($method === 'kartu_id') {
                if (!$paymentCardId) {
                    throw new \Exception('Silakan pilih kartu pembayaran');
                }
                $card = PaymentCard::findOrFail($paymentCardId);
                if (!$card->hasEnoughBalance($total)) {
                    throw new \Exception('Saldo kartu tidak cukup');
                }
            }

            // Generate kode transaksi
            $kode_transaksi = 'TRX-' . date('YmdHis') . rand(100, 999);

            // Create transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kode_transaksi,
                'user_id' => auth()->id(),
                'subtotal' => $request->input('subtotal'),
                'total' => $total,
                'metode_pembayaran' => $method,
                'payment_card_id' => $method === 'kartu_id' ? $paymentCardId : null,
                'status' => 'selesai',
            ]);

            // Create transaksi details & reduce stock
            foreach ($items as $item) {
                $produk = Produk::findOrFail($item['produk_id']);

                // Check stock
                if ($produk->stok < $item['qty']) {
                    throw new \Exception("Stok {$produk->nama_produk} tidak cukup");
                }

                // Create detail
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'harga' => $item['harga'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Reduce stock
                $produk->decrement('stok', $item['qty']);
            }

            // Deduct from payment card if used
            if ($method === 'kartu_id') {
                $card = PaymentCard::findOrFail($paymentCardId);
                $card->deductBalance($total, $transaksi->id, "Pembelian - {$kode_transaksi}");
            }

            DB::commit();

            // Clear session
            session()->forget(['cart_items', 'subtotal', 'total', 'payment_card_id']);

            // Redirect to transaction list with success
            return redirect()->route('transaksi.index')->with('success', 'Pembayaran berhasil! Kode: ' . $kode_transaksi);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function deleteAll()
    {
        // Only admin can delete all transactions
        if (auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            Transaksi::query()->delete();
            return response()->json(['success' => true, 'message' => 'All transactions deleted']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
