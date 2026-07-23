<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Get remember me checkbox value
        $remember = $request->has('remember');

        // Attempt login with remember me
        if (Auth::attempt($credential, $remember)) {

            $request->session()->regenerate();

            // Check if user has active subscription
            $user = Auth::user();
            if (!$user->hasActiveSubscription() && $user->role !== 'admin') {
                Auth::logout();
                return back()->with('warning', 'Subscription Anda telah berakhir. Silakan perpanjang untuk melanjutkan.');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('login');
    }

    // Handle user registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6|confirmed',
            'subscription_id' => 'required|exists:subscriptions,id'
        ]);

        // Check if subscription is valid
        $subscription = \App\Models\Subscription::find($validated['subscription_id']);
        
        if (!$subscription || ($subscription->status !== 'active' && $subscription->status !== 'pending')) {
            return back()->with('error', 'Subscription tidak valid atau sudah digunakan.');
        }

        // Check if subscription already has a user
        if ($subscription->user) {
            return back()->with('error', 'Subscription ini sudah digunakan oleh akun lain.');
        }

        // Create user
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'role' => 'kasir',
            'subscription_id' => $validated['subscription_id']
        ]);

        // Auto login after register
        Auth::login($user, true); // true = remember me

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang di Coole-Bill.');
    }
}