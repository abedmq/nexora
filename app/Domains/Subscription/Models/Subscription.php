<?php

namespace App\Domains\Subscription\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'type',
        'start_date',
        'end_date',
        'price',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(\App\Domains\Customer\Models\Customer::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'daily' => 'يومي',
            'monthly' => 'شهري',
            'special' => 'خاص',
            default => $this->type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'نشط',
            'expiring_soon' => 'قريب الانتهاء',
            'expired' => 'منتهي',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'expiring_soon' => 'warning',
            'expired' => 'danger',
            default => 'info',
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'daily' => 'fas fa-sun',
            'monthly' => 'fas fa-calendar-alt',
            'special' => 'fas fa-star',
            default => 'fas fa-file-contract',
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'daily' => 'success',
            'monthly' => 'primary',
            'special' => 'warning',
            default => 'info',
        };
    }
}
