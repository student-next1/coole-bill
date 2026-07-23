<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    // Halaman subscribe (form input data)
    public function subscribe(Request $request)
    {
        $planType = $request->query('plan', 'trial');
        
        // Validasi plan type
        if (!in_array($planType, ['trial', 'monthly', 'semester'])) {
            $planType = 'trial';
        }

        return view('subscription.subscribe', [
            'planType' => $planType,
            'planName' => Subscription::getPlanName($planType),
            'planPrice' => Subscription::getPlanPrice($planType),
            'planDuration' => Subscription::getPlanDuration($planType)
        ]);
    }

    // Proses subscribe
    public function processSubscribe(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:subscriptions,email',
            'phone' => 'nullable|string|max:20',
            'plan_type' => 'required|in:trial,monthly,semester',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $planType = $validated['plan_type'];
        $amount = Subscription::getPlanPrice($planType);
        $duration = Subscription::getPlanDuration($planType);

        // Upload payment proof jika ada
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        // Buat subscription
        $subscription = Subscription::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'plan_type' => $planType,
            'amount' => $amount,
            'status' => $planType === 'trial' ? 'active' : 'pending',
            'start_date' => $planType === 'trial' ? Carbon::now() : null,
            'end_date' => $planType === 'trial' ? Carbon::now()->addDays($duration) : null,
            'payment_proof' => $paymentProofPath,
            'payment_method' => $request->input('payment_method')
        ]);

        // Simpan subscription_id ke session untuk digunakan saat register
        session(['pending_subscription_id' => $subscription->id]);

        return redirect()->route('register', ['subscription' => $subscription->id])
                         ->with('success', 'Subscription berhasil! Silakan buat akun Anda.');
    }

    // Check subscription status
    public function checkStatus(Request $request)
    {
        $email = $request->input('email');
        
        $subscription = Subscription::where('email', $email)->first();
        
        if (!$subscription) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Email tidak terdaftar'
            ], 404);
        }

        return response()->json([
            'status' => $subscription->status,
            'plan_type' => $subscription->plan_type,
            'end_date' => $subscription->end_date,
            'days_remaining' => $subscription->daysRemaining()
        ]);
    }
}
