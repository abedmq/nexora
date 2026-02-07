<?php

namespace App\Domains\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'hall_id',
        'billing_type',
        'booking_date',
        'start_time',
        'end_time',
        'unit_price',
        'total_price',
        'is_open',
        'closed_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'is_open' => 'boolean',
        'closed_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Domains\Customer\Models\Customer::class);
    }

    public function hall()
    {
        return $this->belongsTo(\App\Domains\Hall\Models\Hall::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'confirmed' => 'مؤكد',
            'pending' => 'قيد الانتظار',
            'cancelled' => 'ملغي',
            'open' => 'مفتوح',
            'closed' => 'مغلق',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'confirmed' => 'success',
            'pending' => 'warning',
            'cancelled' => 'danger',
            'open' => 'info',
            'closed' => 'purple',
            default => 'info',
        };
    }

    public function getBillingTypeLabelAttribute(): string
    {
        return match($this->billing_type) {
            'hourly' => 'بالساعة',
            'daily' => 'يومي',
            'weekly' => 'أسبوعي',
            'monthly' => 'شهري',
            default => $this->billing_type,
        };
    }

    public function getDurationAttribute(): string
    {
        if ($this->is_open && !$this->end_time) {
            return 'مفتوح';
        }

        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        $hours = $start->diffInHours($end);

        if ($hours >= 8) {
            return 'يوم كامل';
        }

        return $hours . ' ساعات';
    }

    /**
     * Calculate total price based on billing type and duration
     */
    public function calculateTotal(): float
    {
        if ($this->billing_type === 'daily') {
            if ($this->is_open && $this->closed_at) {
                $days = Carbon::parse($this->booking_date)->diffInDays($this->closed_at) ?: 1;
            } elseif ($this->end_time) {
                $days = 1;
            } else {
                $days = Carbon::parse($this->booking_date)->diffInDays(now()) ?: 1;
            }
            return $days * $this->unit_price;
        }

        if ($this->billing_type === 'weekly') {
            if ($this->is_open && $this->closed_at) {
                $weeks = ceil(Carbon::parse($this->booking_date)->diffInDays($this->closed_at) / 7) ?: 1;
            } else {
                $weeks = 1;
            }
            return $weeks * $this->unit_price;
        }

        if ($this->billing_type === 'monthly') {
            if ($this->is_open && $this->closed_at) {
                $months = ceil(Carbon::parse($this->booking_date)->diffInDays($this->closed_at) / 30) ?: 1;
            } else {
                $months = 1;
            }
            return $months * $this->unit_price;
        }

        // hourly
        if ($this->is_open && !$this->end_time) {
            if ($this->closed_at) {
                $start = Carbon::parse($this->booking_date->format('Y-m-d') . ' ' . $this->start_time);
                $hours = $start->diffInHours($this->closed_at) ?: 1;
            } else {
                $start = Carbon::parse($this->booking_date->format('Y-m-d') . ' ' . $this->start_time);
                $hours = $start->diffInHours(now()) ?: 1;
            }
        } else {
            $start = Carbon::parse($this->start_time);
            $end = Carbon::parse($this->end_time);
            $hours = $start->diffInHours($end) ?: 1;
        }

        return $hours * $this->unit_price;
    }
}
