<?php

namespace App\Domains\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'notes',
    ];

    public function bookings()
    {
        return $this->hasMany(\App\Domains\Booking\Models\Booking::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(\App\Domains\Subscription\Models\Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(\App\Domains\Subscription\Models\Subscription::class)
            ->where('status', 'active')
            ->latest();
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'vip' => 'عميل VIP',
            default => 'عميل عادي',
        };
    }
}
