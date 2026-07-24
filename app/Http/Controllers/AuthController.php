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
            'password' => 'required|string|min:6|confirmed',
            'plan' => 'required|in:trial,monthly,semester',
            'terms' => 'required|accepted'
        ]);

        try {
            \DB::beginTransaction();

            // Create subscription first
            $subscription = \App\Models\Subscription::create([
                'email' => $validated['email'],
                'plan_type' => $validated['plan'],
                'status' => $validated['plan'] === 'trial' ? 'active' : 'pending', // Trial aktif langsung, yang lain pending
                'start_date' => now(),
                'end_date' => $this->calculateEndDate($validated['plan']),
                'payment_method' => 'manual',
                'payment_status' => $validated['plan'] === 'trial' ? 'paid' : 'pending'
            ]);

            // Create user with ADMIN role
            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'username' => $this->generateUsername($validated['email']),
                'password' => bcrypt($validated['password']),
                'role' => 'admin', // OTOMATIS ADMIN
                'subscription_id' => $subscription->id
            ]);

            \DB::commit();

            // Auto login after register
            Auth::login($user, true); // true = remember me

            return redirect()->route('dashboard')->with('success', 'Akun Admin berhasil dibuat! Selamat datang di Coole-Bill.');
            
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withInput()->with('error', 'Gagal membuat akun: ' . $e->getMessage());
        }
    }

    /**
     * Calculate subscription end date based on plan
     */
    private function calculateEndDate($plan)
    {
        switch ($plan) {
            case 'trial':
                return now()->addDays(7);
            case 'monthly':
                return now()->addDays(30);
            case 'semester':
                return now()->addDays(180);
            default:
                return now()->addDays(7);
        }
    }

    /**
     * Generate username from email
     */
    private function generateUsername($email)
    {
        $username = explode('@', $email)[0];
        $baseUsername = $username;
        $counter = 1;

        // Check if username exists, if yes add number suffix
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}