<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Website\Models\SiteSection;
use App\Domains\Website\Models\Testimonial;
use App\Domains\Website\Models\Partner;
use App\Domains\Website\Models\FeatureItem;
use App\Domains\Website\Models\ServiceItem;
use App\Domains\Website\Models\StatItem;
use App\Domains\Website\Models\FaqItem;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Homepage Sections =====
        SiteSection::create([
            'type' => 'hero',
            'template' => '1',
            'title' => 'مساحات عمل مبتكرة لنجاح أعمالك',
            'subtitle' => 'نوفر لك بيئة عمل احترافية مجهزة بأحدث التقنيات، مع مرونة في الحجز وأسعار تنافسية.',
            'settings' => ['button_text' => 'احجز الآن', 'button_url' => '#contact'],
            'sort_order' => 0,
        ]);

        SiteSection::create([
            'type' => 'features',
            'template' => '1',
            'title' => 'لماذا تختار نكسورا؟',
            'subtitle' => 'نقدم لك تجربة فريدة من نوعها',
            'sort_order' => 1,
        ]);

        SiteSection::create([
            'type' => 'stats',
            'template' => '2',
            'title' => 'نكسورا بالأرقام',
            'sort_order' => 2,
        ]);

        SiteSection::create([
            'type' => 'services',
            'template' => '1',
            'title' => 'خدماتنا',
            'subtitle' => 'حلول متكاملة لبيئة عمل مثالية',
            'sort_order' => 3,
        ]);

        SiteSection::create([
            'type' => 'testimonials',
            'template' => '1',
            'title' => 'ماذا يقول عملاؤنا',
            'subtitle' => 'آراء حقيقية من عملاء سعداء',
            'sort_order' => 4,
        ]);

        SiteSection::create([
            'type' => 'partners',
            'template' => '1',
            'title' => 'شركاؤنا',
            'subtitle' => 'نفتخر بثقة عملائنا وشركائنا',
            'sort_order' => 5,
        ]);

        SiteSection::create([
            'type' => 'faq',
            'template' => '1',
            'title' => 'الأسئلة الشائعة',
            'subtitle' => 'إجابات على أكثر الأسئلة شيوعاً',
            'sort_order' => 6,
        ]);

        SiteSection::create([
            'type' => 'cta',
            'template' => '1',
            'title' => 'جاهز لتجربة بيئة عمل مميزة؟',
            'subtitle' => 'احجز جولة مجانية وتعرف على مساحاتنا عن قرب',
            'settings' => ['button_text' => 'احجز جولتك الآن', 'button_url' => '#'],
            'sort_order' => 7,
        ]);

        SiteSection::create([
            'type' => 'contact',
            'template' => '1',
            'title' => 'تواصل معنا',
            'subtitle' => 'فريقنا جاهز لمساعدتك والإجابة على استفساراتك',
            'sort_order' => 8,
        ]);

        // ===== Testimonials =====
        $testimonials = [
            ['name' => 'أحمد الحربي', 'position' => 'مؤسس', 'company' => 'تقنية المستقبل', 'content' => 'تجربة ممتازة مع نكسورا! المكاتب مريحة والخدمات متكاملة. أنصح بها لكل رائد أعمال.', 'rating' => 5],
            ['name' => 'سارة المطيري', 'position' => 'مديرة تسويق', 'company' => 'كريتف ستوديو', 'content' => 'بيئة عمل محفزة ومجتمع رائع. وجدت في نكسورا كل ما أحتاجه لتنمية مشروعي.', 'rating' => 5],
            ['name' => 'خالد الشهري', 'position' => 'مطور برمجيات', 'company' => 'حلول ذكية', 'content' => 'الإنترنت سريع والأجواء هادئة ومناسبة للعمل. الاشتراك الشهري يستحق كل ريال.', 'rating' => 4],
            ['name' => 'نورة العتيبي', 'position' => 'استشارية أعمال', 'company' => 'نمو للاستشارات', 'content' => 'القاعات مجهزة بشكل احترافي وفريق الدعم متعاون جداً. شكراً لفريق نكسورا!', 'rating' => 5],
            ['name' => 'فهد القحطاني', 'position' => 'مصمم', 'company' => 'بكسل', 'content' => 'المكان أنيق والتصميم الداخلي ملهم. أصبحت أكثر إنتاجية منذ انضمامي.', 'rating' => 5],
            ['name' => 'ليلى الزهراني', 'position' => 'رائدة أعمال', 'company' => '', 'content' => 'مرونة الحجز هي أكثر ما يعجبني. يمكنني الحجز لساعة واحدة فقط عند الحاجة.', 'rating' => 4],
        ];

        foreach ($testimonials as $i => $t) {
            Testimonial::create(array_merge($t, ['sort_order' => $i]));
        }

        // ===== Partners =====
        $partners = [
            ['name' => 'شركة الاتصالات', 'url' => '#'],
            ['name' => 'بنك الرياض', 'url' => '#'],
            ['name' => 'أرامكو', 'url' => '#'],
            ['name' => 'سابك', 'url' => '#'],
            ['name' => 'مايكروسوفت', 'url' => '#'],
            ['name' => 'جوجل', 'url' => '#'],
        ];

        foreach ($partners as $i => $p) {
            Partner::create(array_merge($p, ['sort_order' => $i]));
        }

        // ===== Feature Items =====
        $featureItems = [
            ['icon' => 'fas fa-wifi', 'title' => 'إنترنت فائق السرعة', 'description' => 'اتصال مستقر وسريع يدعم جميع أعمالك'],
            ['icon' => 'fas fa-shield-alt', 'title' => 'أمان وخصوصية', 'description' => 'نظام أمني متكامل على مدار الساعة'],
            ['icon' => 'fas fa-clock', 'title' => 'مرونة في الحجز', 'description' => 'احجز بالساعة أو اليوم أو الشهر حسب حاجتك'],
            ['icon' => 'fas fa-coffee', 'title' => 'ضيافة متميزة', 'description' => 'مشروبات ووجبات خفيفة مجانية طوال اليوم'],
            ['icon' => 'fas fa-print', 'title' => 'خدمات مكتبية', 'description' => 'طباعة ومسح ضوئي وخدمات بريدية'],
            ['icon' => 'fas fa-users', 'title' => 'مجتمع ريادي', 'description' => 'تواصل مع رواد أعمال ومحترفين من مختلف المجالات'],
        ];
        foreach ($featureItems as $i => $f) { FeatureItem::create(array_merge($f, ['sort_order' => $i])); }

        // ===== Service Items =====
        $serviceItems = [
            ['icon' => 'fas fa-door-open', 'title' => 'قاعات اجتماعات', 'description' => 'قاعات مجهزة بأحدث تقنيات العرض والصوت'],
            ['icon' => 'fas fa-laptop-house', 'title' => 'مكاتب خاصة', 'description' => 'مكاتب مؤثثة بالكامل مع خصوصية تامة'],
            ['icon' => 'fas fa-users-cog', 'title' => 'مساحات مشتركة', 'description' => 'بيئة عمل تشاركية محفزة للإبداع'],
            ['icon' => 'fas fa-chalkboard-teacher', 'title' => 'قاعات تدريب', 'description' => 'مساحات واسعة لورش العمل والدورات التدريبية'],
            ['icon' => 'fas fa-mail-bulk', 'title' => 'عنوان تجاري', 'description' => 'عنوان بريدي احترافي لأعمالك'],
            ['icon' => 'fas fa-headset', 'title' => 'دعم فني', 'description' => 'فريق دعم متاح لمساعدتك في أي وقت'],
        ];
        foreach ($serviceItems as $i => $s) { ServiceItem::create(array_merge($s, ['sort_order' => $i])); }

        // ===== Stat Items =====
        $stats = [
            ['icon' => 'fas fa-users', 'value' => '500+', 'label' => 'عميل سعيد'],
            ['icon' => 'fas fa-building', 'value' => '50+', 'label' => 'مساحة عمل'],
            ['icon' => 'fas fa-calendar-check', 'value' => '10K+', 'label' => 'حجز مكتمل'],
            ['icon' => 'fas fa-star', 'value' => '4.9', 'label' => 'تقييم العملاء'],
        ];
        foreach ($stats as $i => $s) { StatItem::create(array_merge($s, ['sort_order' => $i])); }

        // ===== FAQ Items =====
        $faqs = [
            ['question' => 'ما هي ساعات العمل؟', 'answer' => 'مساحات العمل متاحة من الأحد إلى الخميس من 8 صباحاً حتى 10 مساءً، والجمعة والسبت من 10 صباحاً حتى 6 مساءً.'],
            ['question' => 'هل يمكن حجز القاعات بالساعة؟', 'answer' => 'نعم، نوفر مرونة كاملة في الحجز سواء بالساعة أو اليوم أو الأسبوع أو الشهر.'],
            ['question' => 'هل تتوفر خدمة الإنترنت؟', 'answer' => 'نعم، جميع المساحات مزودة بإنترنت فائق السرعة مع شبكة مخصصة لكل عميل.'],
            ['question' => 'كيف يمكنني إلغاء الحجز؟', 'answer' => 'يمكنك إلغاء الحجز قبل 24 ساعة من الموعد المحدد دون أي رسوم. بعد ذلك قد تطبق سياسة الإلغاء.'],
            ['question' => 'هل تتوفر مواقف سيارات؟', 'answer' => 'نعم، نوفر مواقف مجانية لجميع عملائنا في الطابق السفلي.'],
        ];
        foreach ($faqs as $i => $f) { FaqItem::create(array_merge($f, ['sort_order' => $i])); }

        // ===== Footer Template Setting =====
        \DB::table('settings')->updateOrInsert(
            ['key' => 'footer_template'],
            ['value' => '2', 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
