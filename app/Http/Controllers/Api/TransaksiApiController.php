<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Produk;
use App\Models\PaymentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransaksiApiController extends Controller
{
    /**
     * Get all transactions
     */
    public function index(Request $request)
    {
        $query = Transaksi::with('details.produk', 'user', 'paymentCard');

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        // Filter by payment method
        if ($request->has('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $transaksis = $query->orderBy('created_at', 'desc')->paginate($request->per_page ?? 15);

        return response()->json([
            'success' => true,
            'message' => 'Data transaksi berhasil diambil',
            'data' => $transaksis->items(),
            'meta' => [
                'current_page' => $transaksis->currentPage(),
                'last_page' => $transaksis->lastPage(),
                'per_page' => $transaksis->perPage(),
                'total' => $transaksis->total(),
            ]
        ], 200);
    }

    /**
     * Get single transaction
     */
    public function show($id)
    {
        $transaksi = Transaksi::with('details.produk', 'user', 'paymentCard')->find($id);

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data transaksi berhasil diambil',
            'data' => $transaksi
        ], 200);
    }

    /**
     * Create new transaction
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:tunai,kartu_debit,kartu_kredit,qris,e_wallet',
            'payment_card_id' => 'nullable|exists:payment_cards,id',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Calculate total
            $subtotal = 0;
            foreach ($request->items as $item) {
                $produk = Produk::find($item['produk_id']);
                
                // Check stock
                if ($produk->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$produk->nama} tidak mencukupi");
                }
                
                $subtotal += $produk->harga * $item['jumlah'];
            }

            $diskon = $request->diskon ?? 0;
            $total = $subtotal - $diskon;

            // Validate payment
            if ($request->jumlah_bayar < $total) {
                throw new \Exception("Jumlah bayar tidak mencukupi");
            }

            // Generate kode transaksi
            $kodeTransaksi = 'TRX-' . date('Ymd') . '-' . str_pad(Transaksi::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Create transaction
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'user_id' => $request->user()->id,
                'subtotal' => $subtotal,
                'diskon' => $diskon,
                'total' => $total,
                'jumlah_bayar' => $request->jumlah_bayar,
                'kembalian' => $request->jumlah_bayar - $total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'payment_card_id' => $request->payment_card_id,
            ]);

            // Create transaction details and update stock
            foreach ($request->items as $item) {
                $produk = Produk::find($item['produk_id']);
                
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produk->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $produk->harga,
                    'subtotal' => $produk->harga * $item['jumlah'],
                ]);

                // Update stock
                $produk->decrement('stok', $item['jumlah']);
            }

            // Update payment card balance if using card
            if ($request->payment_card_id) {
                $paymentCard = PaymentCard::find($request->payment_card_id);
                if ($paymentCard->saldo < $total) {
                    throw new \Exception("Saldo kartu tidak mencukupi");
                }
                $paymentCard->decrement('saldo', $total);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transaksi->load('details.produk', 'user', 'paymentCard')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Transaksi gagal: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get transaction statistics
     */
    public function statistics(Request $request)
    {
        $startDate = $request->start_date ?? now()->subDays(30);
        $endDate = $request->end_date ?? now();

        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])->get();

        $statistics = [
            'total_transaksi' => $transaksis->count(),
            'total_penjualan' => $transaksis->sum('total'),
            'rata_rata_transaksi' => $transaksis->count() > 0 ? $transaksis->sum('total') / $transaksis->count() : 0,
            'metode_pembayaran' => Transaksi::whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('metode_pembayaran')
                ->selectRaw('metode_pembayaran, COUNT(*) as count, SUM(total) as total')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'message' => 'Statistik transaksi berhasil diambil',
            'data' => $statistics
        ], 200);
    }
}
