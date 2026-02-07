<?php

namespace App\Domains\Website\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    protected $fillable = [
        'type', 'template', 'title', 'subtitle', 'content', 'settings', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'hero' => 'البانر الرئيسي',
            'slider' => 'السلايدر',
            'features' => 'المميزات',
            'services' => 'الخدمات',
            'testimonials' => 'آراء العملاء',
            'stats' => 'الإحصائيات',
            'cta' => 'دعوة للإجراء',
            'partners' => 'الشركاء',
            'faq' => 'الأسئلة الشائعة',
            'contact' => 'تواصل معنا',
            'custom' => 'محتوى مخصص',
            default => $this->type,
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'hero' => 'fas fa-flag',
            'slider' => 'fas fa-images',
            'features' => 'fas fa-star',
            'services' => 'fas fa-concierge-bell',
            'testimonials' => 'fas fa-quote-right',
            'stats' => 'fas fa-chart-bar',
            'cta' => 'fas fa-bullhorn',
            'partners' => 'fas fa-handshake',
            'faq' => 'fas fa-question-circle',
            'contact' => 'fas fa-envelope',
            'custom' => 'fas fa-code',
            default => 'fas fa-puzzle-piece',
        };
    }

    /**
     * Get the management URL for this section's data (opens in new tab).
     */
    public function getManageUrlAttribute(): ?string
    {
        return match($this->type) {
            'features' => route('admin.website.features'),
            'services' => route('admin.website.services'),
            'stats' => route('admin.website.stats'),
            'testimonials' => route('admin.website.testimonials'),
            'partners' => route('admin.website.partners'),
            'faq' => route('admin.website.faq'),
            'slider' => route('admin.website.sliders'),
            default => null,
        };
    }

    public static function sectionTypes(): array
    {
        return [
            'hero' => [
                'label' => 'البانر الرئيسي', 'icon' => 'fas fa-flag', 'templates' => 3,
                'designs' => [
                    '1' => ['name' => 'تدرج مركزي', 'desc' => 'نص وزر في الوسط مع خلفية متدرجة'],
                    '2' => ['name' => 'تقسيم جانبي', 'desc' => 'نص يسار وصورة يمين'],
                    '3' => ['name' => 'خلفية كاملة', 'desc' => 'صورة خلفية مع طبقة داكنة ونص'],
                ],
            ],
            'slider' => [
                'label' => 'السلايدر', 'icon' => 'fas fa-images', 'templates' => 2, 'data' => 'sliders',
                'designs' => [
                    '1' => ['name' => 'سلايدر كامل', 'desc' => 'صور بعرض كامل مع نص وزر فوقها'],
                    '2' => ['name' => 'سلايدر مصغر', 'desc' => 'سلايدر بإطار مستدير داخل حاوية'],
                ],
            ],
            'features' => [
                'label' => 'المميزات', 'icon' => 'fas fa-star', 'templates' => 3,
                'designs' => [
                    '1' => ['name' => 'بطاقات شبكية', 'desc' => 'أيقونات وعناوين في شبكة 3 أعمدة'],
                    '2' => ['name' => 'بطاقات أفقية', 'desc' => 'أيقونة مع نص بجانبها في عمودين'],
                    '3' => ['name' => 'قائمة مرقمة', 'desc' => 'عنوان جانبي مع عناصر مرقمة'],
                ],
            ],
            'services' => [
                'label' => 'الخدمات', 'icon' => 'fas fa-concierge-bell', 'templates' => 2,
                'designs' => [
                    '1' => ['name' => 'بطاقات متحركة', 'desc' => 'بطاقات مع تأثير عند التمرير'],
                    '2' => ['name' => 'بطاقات ملونة', 'desc' => 'بطاقات مع شريط لون علوي مميز'],
                ],
            ],
            'testimonials' => [
                'label' => 'آراء العملاء', 'icon' => 'fas fa-quote-right', 'templates' => 3, 'data' => 'testimonials',
                'designs' => [
                    '1' => ['name' => 'بطاقات متساوية', 'desc' => 'بطاقات آراء في شبكة 3 أعمدة'],
                    '2' => ['name' => 'اقتباسات كبيرة', 'desc' => 'اقتباس كبير مع صورة مركزية'],
                    '3' => ['name' => 'عرض دائري', 'desc' => 'سلايدر ينتقل بين الآراء تلقائياً'],
                ],
            ],
            'stats' => [
                'label' => 'الإحصائيات', 'icon' => 'fas fa-chart-bar', 'templates' => 2,
                'designs' => [
                    '1' => ['name' => 'عدادات فاتحة', 'desc' => 'أرقام كبيرة على خلفية بيضاء'],
                    '2' => ['name' => 'عدادات داكنة', 'desc' => 'أرقام على خلفية داكنة أنيقة'],
                ],
            ],
            'cta' => [
                'label' => 'دعوة للإجراء', 'icon' => 'fas fa-bullhorn', 'templates' => 3,
                'designs' => [
                    '1' => ['name' => 'شريط متدرج', 'desc' => 'نص وزر على خلفية بنفسجية متدرجة'],
                    '2' => ['name' => 'بطاقة مركزية', 'desc' => 'بطاقة مستديرة بخلفية فاتحة'],
                    '3' => ['name' => 'تقسيم مع صورة', 'desc' => 'نص جانبي مع صورة بالطرف الآخر'],
                ],
            ],
            'partners' => [
                'label' => 'الشركاء', 'icon' => 'fas fa-handshake', 'templates' => 2, 'data' => 'partners',
                'designs' => [
                    '1' => ['name' => 'صف شعارات', 'desc' => 'شعارات بتأثير رمادي عند التمرير تلون'],
                    '2' => ['name' => 'شبكة بطاقات', 'desc' => 'شعارات داخل بطاقات مع إطار'],
                ],
            ],
            'faq' => [
                'label' => 'الأسئلة الشائعة', 'icon' => 'fas fa-question-circle', 'templates' => 2,
                'designs' => [
                    '1' => ['name' => 'أكورديون', 'desc' => 'أسئلة قابلة للطي ضغط لعرض الإجابة'],
                    '2' => ['name' => 'عمودين', 'desc' => 'أسئلة مع إجابات في شبكة عمودين'],
                ],
            ],
            'contact' => [
                'label' => 'تواصل معنا', 'icon' => 'fas fa-envelope', 'templates' => 2,
                'designs' => [
                    '1' => ['name' => 'نموذج ومعلومات', 'desc' => 'معلومات التواصل مع نموذج جانبي'],
                    '2' => ['name' => 'نموذج مركزي', 'desc' => 'نموذج إرسال رسالة في الوسط'],
                ],
            ],
            'custom' => [
                'label' => 'محتوى مخصص', 'icon' => 'fas fa-code', 'templates' => 1,
                'designs' => [
                    '1' => ['name' => 'HTML حر', 'desc' => 'أضف أي محتوى HTML مخصص'],
                ],
            ],
        ];
    }

    /**
     * Get the template name for the current section.
     */
    public function getTemplateNameAttribute(): string
    {
        $types = self::sectionTypes();
        return $types[$this->type]['designs'][$this->template]['name'] ?? 'تصميم ' . $this->template;
    }
}
