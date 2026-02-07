<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Website\Models\SliderItem;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'مرحباً بكم في نكسورا',
                'subtitle' => 'بيئة عمل مشتركة احترافية تناسب طموحاتكم',
                'button_text' => 'احجز الآن',
                'button_url' => '#',
                'sort_order' => 0,
            ],
            [
                'title' => 'قاعات اجتماعات متطورة',
                'subtitle' => 'مجهزة بأحدث التقنيات لإنجاح اجتماعاتكم',
                'button_text' => 'تعرف أكثر',
                'button_url' => '#',
                'sort_order' => 1,
            ],
            [
                'title' => 'مكاتب خاصة ومساحات مرنة',
                'subtitle' => 'حلول متنوعة تناسب جميع الأحجام والميزانيات',
                'button_text' => 'استكشف',
                'button_url' => '#',
                'sort_order' => 2,
            ],
        ];

        foreach ($items as $item) {
            SliderItem::firstOrCreate(['title' => $item['title']], $item);
        }
    }
}
