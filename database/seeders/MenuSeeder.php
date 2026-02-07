<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Menu\Models\Menu;
use App\Domains\Menu\Models\MenuItem;
use App\Domains\Page\Models\Page;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Header Menu =====
        $headerMenu = Menu::create([
            'name' => 'القائمة الرئيسية',
            'location' => 'header',
            'description' => 'القائمة العلوية في الهيدر',
            'is_active' => true,
        ]);

        // Home link
        $headerMenu->items()->create([
            'title' => 'الرئيسية',
            'type' => 'custom',
            'url' => '/',
            'icon' => 'fas fa-home',
            'sort_order' => 0,
        ]);

        // Add published pages to header
        $pages = Page::where('status', 'published')->orderBy('sort_order')->get();
        $order = 1;
        foreach ($pages as $page) {
            $headerMenu->items()->create([
                'title' => $page->title,
                'type' => 'page',
                'page_id' => $page->id,
                'sort_order' => $order++,
            ]);
        }

        // Services dropdown with children (example)
        $servicesItem = $headerMenu->items()->create([
            'title' => 'خدمات أخرى',
            'type' => 'custom',
            'url' => '#',
            'icon' => 'fas fa-concierge-bell',
            'sort_order' => $order++,
        ]);

        $servicesItem->children()->create([
            'menu_id' => $headerMenu->id,
            'title' => 'حجز قاعات',
            'type' => 'custom',
            'url' => '#',
            'icon' => 'fas fa-building',
            'sort_order' => 0,
        ]);

        $servicesItem->children()->create([
            'menu_id' => $headerMenu->id,
            'title' => 'مساحات عمل مشتركة',
            'type' => 'custom',
            'url' => '#',
            'icon' => 'fas fa-users',
            'sort_order' => 1,
        ]);

        $servicesItem->children()->create([
            'menu_id' => $headerMenu->id,
            'title' => 'اشتراكات شهرية',
            'type' => 'custom',
            'url' => '#',
            'icon' => 'fas fa-file-contract',
            'sort_order' => 2,
        ]);

        // ===== Footer Menu =====
        $footerMenu = Menu::create([
            'name' => 'قائمة الفوتر',
            'location' => 'footer',
            'description' => 'القائمة السفلية في الفوتر',
            'is_active' => true,
        ]);

        $footerMenu->items()->create([
            'title' => 'الرئيسية',
            'type' => 'custom',
            'url' => '/',
            'sort_order' => 0,
        ]);

        foreach ($pages as $i => $page) {
            $footerMenu->items()->create([
                'title' => $page->title,
                'type' => 'page',
                'page_id' => $page->id,
                'sort_order' => $i + 1,
            ]);
        }

        $footerMenu->items()->create([
            'title' => 'سياسة الخصوصية',
            'type' => 'custom',
            'url' => '#',
            'sort_order' => $pages->count() + 1,
        ]);

        $footerMenu->items()->create([
            'title' => 'الشروط والأحكام',
            'type' => 'custom',
            'url' => '#',
            'sort_order' => $pages->count() + 2,
        ]);

        // Clear menu cache
        clear_menu_cache();
    }
}
