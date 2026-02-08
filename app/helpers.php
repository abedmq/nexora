<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (!function_exists('setting')) {
    /**
     * Get a setting value by key, with caching.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return Cache::rememberForever('app_settings', function () {
                return DB::table('settings')->pluck('value', 'key')->toArray();
            });
        }

        $settings = Cache::rememberForever('app_settings', function () {
            return DB::table('settings')->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }
}

if (!function_exists('clear_settings_cache')) {
    /**
     * Clear the settings cache.
     */
    function clear_settings_cache(): void
    {
        Cache::forget('app_settings');
    }
}

if (!function_exists('get_menu')) {
    /**
     * Get a menu by its location with cached hierarchical items.
     *
     * @param  string  $location  'header' or 'footer'
     * @return \Illuminate\Support\Collection
     */
    function get_menu(string $location): \Illuminate\Support\Collection
    {
        return Cache::remember('menu_' . $location, 3600, function () use ($location) {
            $menu = \App\Domains\Menu\Models\Menu::where('location', $location)
                ->where('is_active', true)
                ->first();

            if (!$menu) {
                return collect();
            }

            return $menu->tree;
        });
    }
}

if (!function_exists('clear_menu_cache')) {
    /**
     * Clear all menu caches.
     */
    function clear_menu_cache(): void
    {
        Cache::forget('menu_header');
        Cache::forget('menu_footer');
    }
}

if (!function_exists('available_themes')) {
    /**
     * Get the available themes configuration.
     */
    function available_themes(): array
    {
        return config('themes', []);
    }
}

if (!function_exists('active_theme')) {
    /**
     * Get the current active theme slug.
     */
    function active_theme(): string
    {
        $themes = available_themes();
        $fallback = array_key_first($themes) ?: 'nexora';

        return setting('active_theme', $fallback);
    }
}

if (!function_exists('theme_supports')) {
    /**
     * Check if the active theme supports a feature.
     */
    function theme_supports(string $feature): bool
    {
        $themes = available_themes();
        $theme = active_theme();

        return (bool) data_get($themes, $theme . '.supports.' . $feature, false);
    }
}
