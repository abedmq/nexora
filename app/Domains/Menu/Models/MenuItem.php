<?php

namespace App\Domains\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Page\Models\Page;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id', 'parent_id', 'title', 'type', 'page_id',
        'url', 'target', 'icon', 'css_class', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function activeChildren()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Get the resolved URL for this menu item
     */
    public function getResolvedUrlAttribute(): string
    {
        if ($this->type === 'page' && $this->page) {
            return url('/page/' . $this->page->slug);
        }

        return $this->url ?: '#';
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'page' => 'صفحة',
            'custom' => 'رابط مخصص',
            default => $this->type,
        };
    }
}
