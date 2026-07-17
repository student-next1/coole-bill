<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user', 'details.produk')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $produks = Produk::with('kategori')->where('stok', '>', 0)->get();
        return view('transaksi.create', compact('produks'));
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
            'pajak' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer,kartu_kredit',
            'nominal_bayar' => 'required|numeric|min:0',
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
                'pajak' => $validated['pajak'],
                'total' => $validated['total'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
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

            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan. Kode: ' . $kode_transaksi);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
