<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date', now()->firstOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        // Sales data
        $transaksis = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPenjualan = $transaksis->sum('total');
        $totalSubtotal = $transaksis->sum('subtotal');
        $totalPajak = $transaksis->sum('pajak');
        $jumlahTransaksi = $transaksis->count();

        // Top products
        $topProducts = Produk::with(['transaksiDetails' => function($q) use ($startDate, $endDate) {
            $q->whereHas('transaksi', function($q2) use ($startDate, $endDate) {
                $q2->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->get()
        ->map(function($p) {
            return [
                'name' => $p->nama_produk,
                'qty' => $p->transaksiDetails->sum('qty'),
                'total' => $p->transaksiDetails->sum('subtotal'),
            ];
        })
        ->filter(fn($p) => $p['qty'] > 0)
        ->sortByDesc('qty')
        ->take(5);

        // Daily sales
        $dailySales = $transaksis->groupBy(function($t) {
            return $t->created_at->format('Y-m-d');
        })->map(function($group) {
            return [
                'date' => $group->first()->created_at->format('d/m/Y'),
                'total' => $group->sum('total'),
                'count' => $group->count(),
            ];
        })->values();

        // Payment methods
        $paymentMethods = $transaksis->groupBy('metode_pembayaran')->map(function($group) {
            return [
                'method' => ucfirst(str_replace('_', ' ', $group->first()->metode_pembayaran)),
                'total' => $group->sum('total'),
                'count' => $group->count(),
            ];
        })->values();

        return view('laporan.index', compact(
            'totalPenjualan',
            'totalSubtotal',
            'totalPajak',
            'jumlahTransaksi',
            'topProducts',
            'dailySales',
            'paymentMethods',
            'transaksis',
            'startDate',
            'endDate'
        ));
    }
}
