<?php

namespace App\Http\Controllers;

use App\Models\PaymentCard;
use App\Models\PaymentCardTransaction;
use Illuminate\Http\Request;

class PaymentCardController extends Controller
{
    public function index()
    {
        $cards = PaymentCard::orderBy('created_at', 'desc')->paginate(10);
        $stats = [
            'total_cards' => PaymentCard::count(),
            'active_cards' => PaymentCard::where('status', 'active')->count(),
            'total_saldo' => PaymentCard::sum('saldo'),
        ];
        return view('payment-cards.index', compact('cards', 'stats'));
    }

    public function create()
    {
        return view('payment-cards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'nullable|string|unique:payment_cards',
            'holder_name' => 'required|string',
            'saldo' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $cardCode = PaymentCard::generateCardCode();
        
        $card = PaymentCard::create([
            'card_code' => $cardCode,
            'barcode_data' => $cardCode,
            'username' => $validated['username'] ?? null,
            'holder_name' => $validated['holder_name'],
            'saldo' => $validated['saldo'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'active',
        ]);

        return redirect()->route('payment-cards.show', $card)->with('success', 'Kartu pembayaran berhasil dibuat');
    }

    public function show($id)
    {
        $card = PaymentCard::with(['transactions' => function($q) {
            $q->orderBy('created_at', 'desc')->limit(10);
        }])->findOrFail($id);
        
        return view('payment-cards.show', compact('card'));
    }

    public function edit($id)
    {
        $card = PaymentCard::findOrFail($id);
        return view('payment-cards.edit', compact('card'));
    }

    public function update(Request $request, $id)
    {
        $card = PaymentCard::findOrFail($id);

        $validated = $request->validate([
            'username' => 'nullable|string|unique:payment_cards,username,' . $id,
            'holder_name' => 'required|string',
            'status' => 'required|in:active,inactive,blocked',
            'notes' => 'nullable|string',
        ]);

        $card->update($validated);

        return redirect()->route('payment-cards.show', $card)->with('success', 'Kartu pembayaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $card = PaymentCard::findOrFail($id);
        $card->delete();

        return redirect()->route('payment-cards.index')->with('success', 'Kartu pembayaran berhasil dihapus');
    }

    public function topup($id)
    {
        $card = PaymentCard::findOrFail($id);
        return view('payment-cards.topup', compact('card'));
    }

    public function doTopup(Request $request, $id)
    {
        $card = PaymentCard::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        $card->addBalance($validated['amount'], 'Topup: ' . ($validated['notes'] ?? ''));

        return redirect()->route('payment-cards.show', $card)->with('success', 'Saldo berhasil ditambahkan');
    }

    public function transactions($id)
    {
        $card = PaymentCard::findOrFail($id);
        $transactions = $card->transactions()->orderBy('created_at', 'desc')->paginate(20);

        return view('payment-cards.transactions', compact('card', 'transactions'));
    }

    public function search(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return response()->json(['error' => 'Query required'], 400);
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
}
