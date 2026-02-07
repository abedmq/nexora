<?php

namespace App\Domains\Page\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'featured_image',
        'meta_title', 'meta_description', 'custom_css', 'custom_js',
        'status', 'template', 'sort_order', 'show_in_nav',
    ];

    protected $casts = [
        'show_in_nav' => 'boolean',
    ];

    public function sections()
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    public function activeSections()
    {
        return $this->hasMany(PageSection::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'published' ? 'منشورة' : 'مسودة';
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status === 'published' ? 'success' : 'warning';
    }

    public function getUrlAttribute(): string
    {
        return url('/page/' . $this->slug);
    }

    public static function generateSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title, '-', null);
        if (empty($slug)) {
            $slug = Str::random(8);
        }

        $query = static::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        if ($query->exists()) {
            $slug .= '-' . Str::random(4);
        }

        return $slug;
    }
}
