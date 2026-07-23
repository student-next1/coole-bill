<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'email',
        'name',
        'phone',
        'plan_type',
        'amount',
        'status',
        'start_date',
        'end_date',
        'payment_method',
        'payment_proof',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // Check apakah subscription masih aktif
    public function isActive()
    {
        return $this->status === 'active' && $this->end_date && $this->end_date->isFuture();
    }

    // Get sisa hari subscription
    public function daysRemaining()
    {
        if (!$this->end_date) {
            return 0;
        }
        return max(0, Carbon::now()->diffInDays($this->end_date, false));
    }

    // Get nama paket
    public function getPlanName()
    {
        return match($this->plan_type) {
            'trial' => 'Trial Gratis',
            'monthly' => 'Paket Bulanan',
            'semester' => 'Paket 6 Bulan',
            default => 'Unknown'
        };
    }

    // Get durasi paket dalam hari
    public static function getPlanDuration($planType)
    {
        return match($planType) {
            'trial' => 7,
            'monthly' => 30,
            'semester' => 180,
            default => 0
        };
    }

    // Get harga paket
    public static function getPlanPrice($planType)
    {
        return match($planType) {
            'trial' => 0,
            'monthly' => 99000,
            'semester' => 499000,
            default => 0
        };
    }
}
