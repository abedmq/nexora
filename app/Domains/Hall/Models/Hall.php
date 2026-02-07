<?php

namespace App\Domains\Hall\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'capacity',
        'price_per_hour',
        'price_per_day',
        'price_per_week',
        'price_per_month',
        'amenities',
        'status',
        'image',
    ];

    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'price_per_day' => 'decimal:2',
        'price_per_week' => 'decimal:2',
        'price_per_month' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(\App\Domains\Booking\Models\Booking::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'meeting_room' => 'قاعة اجتماعات',
            'private_office' => 'مكتب خاص',
            'coworking' => 'مساحة عمل مشتركة',
            'training_room' => 'قاعة تدريب',
            default => $this->type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'متاحة',
            'booked' => 'محجوزة',
            'maintenance' => 'صيانة',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'available' => 'success',
            'booked' => 'warning',
            'maintenance' => 'danger',
            default => 'info',
        };
    }

    /**
     * Get price by billing type, falling back to settings defaults
     */
    public function getPriceFor(string $billingType): float
    {
        $price = match($billingType) {
            'hourly' => $this->price_per_hour,
            'daily' => $this->price_per_day,
            'weekly' => $this->price_per_week,
            'monthly' => $this->price_per_month,
            default => $this->price_per_hour,
        };

        // Fall back to default settings if hall doesn't have custom pricing
        if (!$price) {
            $settingKey = match($billingType) {
                'hourly' => 'default_price_per_hour',
                'daily' => 'default_price_per_day',
                'weekly' => 'default_price_per_week',
                'monthly' => 'default_price_per_month',
                default => 'default_price_per_hour',
            };
            $price = \DB::table('settings')->where('key', $settingKey)->value('value') ?? 0;
        }

        return (float) $price;
    }
}
