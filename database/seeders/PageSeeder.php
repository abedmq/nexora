<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Page\Models\Page;
use App\Domains\Page\Models\PageSection;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // ===== About Page =====
        $about = Page::create([
            'title' => 'من نحن',
            'slug' => 'about',
            'content' => '',
            'excerpt' => 'تعرف على شركة نكسورا ورؤيتنا',
            'status' => 'published',
            'show_in_nav' => true,
            'sort_order' => 1,
            'meta_title' => 'من نحن - نكسورا',
            'meta_description' => 'تعرف على شركة نكسورا لحلول مساحات العمل المشتركة',
        ]);

        PageSection::insert([
            [
                'page_id' => $about->id, 'type' => 'hero', 'sort_order' => 1, 'is_active' => true,
                'title' => 'مرحباً بك في نكسورا',
                'content' => 'نوفر لك مساحات عمل مبتكرة وقاعات اجتماعات مجهزة بأحدث التقنيات لتعزيز إنتاجيتك.',
                'settings' => json_encode(['button_text' => 'احجز الآن', 'button_url' => '/admin/bookings/create']),
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'page_id' => $about->id, 'type' => 'features', 'sort_order' => 2, 'is_active' => true,
                'title' => 'لماذا نكسورا؟',
                'content' => '
                    <div class="col-md-4"><div class="feature-card"><i class="fas fa-wifi"></i><h5>إنترنت فائق السرعة</h5><p>اتصال إنترنت عالي السرعة في جميع المساحات.</p></div></div>
                    <div class="col-md-4"><div class="feature-card"><i class="fas fa-coffee"></i><h5>مرافق متكاملة</h5><p>مطبخ، مشروبات، وضيافة على مدار الساعة.</p></div></div>
                    <div class="col-md-4"><div class="feature-card"><i class="fas fa-shield-alt"></i><h5>أمان وخصوصية</h5><p>نظام أمني متكامل وخصوصية تامة.</p></div></div>
                ',
                'settings' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'page_id' => $about->id, 'type' => 'stats', 'sort_order' => 3, 'is_active' => true,
                'title' => 'إنجازاتنا بالأرقام',
                'content' => '
                    <div class="col-md-3 col-6"><div class="stat-box"><div class="num">500+</div><div class="label">عميل سعيد</div></div></div>
                    <div class="col-md-3 col-6"><div class="stat-box"><div class="num">10</div><div class="label">قاعة ومكتب</div></div></div>
                    <div class="col-md-3 col-6"><div class="stat-box"><div class="num">3000+</div><div class="label">حجز مكتمل</div></div></div>
                    <div class="col-md-3 col-6"><div class="stat-box"><div class="num">98%</div><div class="label">نسبة الرضا</div></div></div>
                ',
                'settings' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'page_id' => $about->id, 'type' => 'cta', 'sort_order' => 4, 'is_active' => true,
                'title' => 'جاهز لتجربة بيئة عمل مختلفة؟',
                'content' => 'تواصل معنا اليوم واحجز مساحة عملك المثالية.',
                'settings' => json_encode(['button_text' => 'تواصل معنا', 'button_url' => '/page/contact']),
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // ===== Services Page =====
        $services = Page::create([
            'title' => 'خدماتنا',
            'slug' => 'services',
            'content' => '',
            'excerpt' => 'اكتشف خدمات نكسورا المتنوعة',
            'status' => 'published',
            'show_in_nav' => true,
            'sort_order' => 2,
            'meta_title' => 'خدماتنا - نكسورا',
        ]);

        PageSection::insert([
            [
                'page_id' => $services->id, 'type' => 'hero', 'sort_order' => 1, 'is_active' => true,
                'title' => 'خدماتنا',
                'content' => 'نقدم لك مجموعة متكاملة من خدمات مساحات العمل.',
                'settings' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'page_id' => $services->id, 'type' => 'features', 'sort_order' => 2, 'is_active' => true,
                'title' => 'ماذا نقدم؟',
                'content' => '
                    <div class="col-md-4 col-6"><div class="feature-card"><i class="fas fa-users"></i><h5>قاعات اجتماعات</h5><p>قاعات مجهزة بأحدث تقنيات العرض والصوت.</p></div></div>
                    <div class="col-md-4 col-6"><div class="feature-card"><i class="fas fa-laptop-house"></i><h5>مكاتب خاصة</h5><p>مكاتب مؤثثة بالكامل وجاهزة للاستخدام الفوري.</p></div></div>
                    <div class="col-md-4 col-6"><div class="feature-card"><i class="fas fa-couch"></i><h5>مساحات مشتركة</h5><p>بيئة عمل محفزة مع زملاء من مختلف المجالات.</p></div></div>
                    <div class="col-md-4 col-6"><div class="feature-card"><i class="fas fa-graduation-cap"></i><h5>قاعات تدريب</h5><p>مصممة خصيصاً للورش والدورات التدريبية.</p></div></div>
                    <div class="col-md-4 col-6"><div class="feature-card"><i class="fas fa-print"></i><h5>خدمات الطباعة</h5><p>طباعة ومسح ضوئي ونسخ وتغليف.</p></div></div>
                    <div class="col-md-4 col-6"><div class="feature-card"><i class="fas fa-envelope-open-text"></i><h5>عنوان بريدي</h5><p>عنوان تجاري مميز لأعمالك.</p></div></div>
                ',
                'settings' => null,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // ===== Contact Page =====
        $contact = Page::create([
            'title' => 'تواصل معنا',
            'slug' => 'contact',
            'content' => '<h2>تواصل معنا</h2><p>يسعدنا تواصلك معنا. يمكنك زيارتنا أو الاتصال بنا عبر:</p><ul><li><strong>الهاتف:</strong> 0501234567</li><li><strong>البريد:</strong> info@nexora.com</li><li><strong>العنوان:</strong> الرياض، المملكة العربية السعودية</li></ul>',
            'excerpt' => 'تواصل معنا لحجز مساحة عملك',
            'status' => 'published',
            'show_in_nav' => true,
            'sort_order' => 3,
            'meta_title' => 'تواصل معنا - نكسورا',
        ]);
    }
}
