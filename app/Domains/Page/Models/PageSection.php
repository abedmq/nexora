<?php

namespace App\Domains\Page\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'page_id', 'type', 'title', 'content', 'settings', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function getDecodedSettingsAttribute(): array
    {
        return json_decode($this->settings ?? '{}', true) ?: [];
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'hero' => 'بانر رئيسي',
            'text' => 'نص وصورة',
            'features' => 'مميزات',
            'gallery' => 'معرض صور',
            'cta' => 'دعوة للإجراء',
            'custom_html' => 'HTML مخصص',
            'testimonials' => 'آراء العملاء',
            'stats' => 'إحصائيات',
            default => $this->type,
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'hero' => 'fas fa-flag',
            'text' => 'fas fa-align-right',
            'features' => 'fas fa-th-large',
            'gallery' => 'fas fa-images',
            'cta' => 'fas fa-bullhorn',
            'custom_html' => 'fas fa-code',
            'testimonials' => 'fas fa-quote-right',
            'stats' => 'fas fa-chart-bar',
            default => 'fas fa-puzzle-piece',
        };
    }
}
