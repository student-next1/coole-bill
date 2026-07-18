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

        // Store in session for next step
        session([
            'cart_items' => $items,
            'subtotal' => $validated['subtotal'],
            'total' => $validated['total'],
        ]);

        return view('transaksi.select-payment', [
            'items' => $items,
            'subtotal' => $validated['subtotal'],
            'total' => $validated['total'],
        ]);
    }

    public function selectCard(Request $request)
    {
        $method = $request->query('method');
        
        if (!in_array($method, ['kartu_id', 'tunai'])) {
            return back()->with('error', 'Metode pembayaran tidak valid');
        }

        if ($method === 'tunai') {
            // Langsung proses untuk tunai
            return $this->processPayment($request, $method);
        }

        // Untuk kartu ID, tampilkan form pencarian
        return view('transaksi.search-card', [
            'method' => $method,
            'items' => session('cart_items'),
            'subtotal' => session('subtotal'),
            'total' => session('total'),
        ]);
    }

    public function findCard(Request $request)
    {
        $query = $request->query('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json(['error' => 'Masukkan minimal 2 karakter'], 400);
        }

        $cards = PaymentCard::where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('card_code', 'like', "%{$query}%")
                  ->orWhere('username', 'like', "%{$query}%")
                  ->orWhere('holder_name', 'like', "%{$query}%");
            })
            ->get(['id', 'card_code', 'username', 'holder_name', 'saldo']);

        return response()->json($cards);
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
