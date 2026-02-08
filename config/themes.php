<?php

return [
    'nexora' => [
        'name' => 'نكسورا الكلاسيكي',
        'description' => 'الثيم الافتراضي مع محرر الصفحة الرئيسية، إعدادات الألوان، وتصدير الديمو.',
        'colors' => ['#7c3aed', '#a78bfa', '#f3f0ff'],
        'supports' => [
            'theme_settings' => true,
            'demo' => true,
            'homepage_builder' => true,
        ],
    ],
    'minimal' => [
        'name' => 'Minimal Light',
        'description' => 'قالب خفيف بدون محرر الصفحة الرئيسية أو إعدادات ثيم متقدمة.',
        'colors' => ['#0f172a', '#94a3b8', '#f8fafc'],
        'supports' => [
            'theme_settings' => false,
            'demo' => false,
            'homepage_builder' => false,
        ],
    ],
];
