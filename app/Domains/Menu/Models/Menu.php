<?php

namespace App\Domains\Menu\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'location', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public function rootItems()
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    /**
     * Get the full hierarchical tree of menu items
     */
    public function getTreeAttribute(): \Illuminate\Support\Collection
    {
        $items = $this->items()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return $this->buildTree($items);
    }

    protected function buildTree($items, $parentId = null): \Illuminate\Support\Collection
    {
        return $items
            ->where('parent_id', $parentId)
            ->map(function ($item) use ($items) {
                $item->children_items = $this->buildTree($items, $item->id);
                return $item;
            })
            ->values();
    }

    public function getLocationLabelAttribute(): string
    {
        return match($this->location) {
            'header' => 'الهيدر (القائمة العلوية)',
            'footer' => 'الفوتر (القائمة السفلية)',
            default => $this->location,
        };
    }
}
