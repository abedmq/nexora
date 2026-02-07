<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('company_name', 'نكسورا') }}</title>
    <meta name="description" content="{{ setting('footer_description', '') }}">
    @if(setting('site_favicon'))
    <link rel="icon" href="{{ asset(setting('site_favicon')) }}">
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome/css/all.min.css') }}">
    <style>
        :root {
            --primary:{{ setting('theme_color_primary', '#7c3aed') }};
            --primary-light:{{ setting('theme_color_light', '#a78bfa') }};
            --primary-dark:{{ setting('theme_color_dark', '#6d28d9') }};
            --primary-accent:{{ setting('theme_color_accent', '#f3f0ff') }};
            --dark:#1e293b;
            --text:#334155;
            --text-muted:#64748b;
            --bg:#ffffff;
            --bg-alt:#f8fafc;
            --border:#e2e8f0;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Cairo',sans-serif; color:var(--text); background:var(--bg); direction:rtl; }
        a { text-decoration:none; color:inherit; }

        /* Navbar */
        .site-nav { background:var(--bg); border-bottom:1px solid var(--border); padding:16px 0; position:sticky; top:0; z-index:100; backdrop-filter:blur(12px); }
        .site-nav .container { display:flex; align-items:center; justify-content:space-between; }
        .site-nav .brand { display:flex; align-items:center; gap:10px; font-size:20px; font-weight:700; color:var(--dark); }
        .site-nav .brand img { height:36px; }
        .site-nav .nav-links { display:flex; gap:24px; align-items:center; }
        .site-nav .nav-links a { color:var(--text-muted); font-weight:500; font-size:14px; transition:color 0.2s; }
        .site-nav .nav-links a:hover { color:var(--primary); }
        .nav-dropdown { position:relative; }
        .nav-dropdown > a { display:flex; align-items:center; gap:4px; }
        .nav-dropdown > a::after { content:"\f107"; font-family:"Font Awesome 5 Free"; font-weight:900; font-size:10px; }
        .nav-dropdown-menu { display:none; position:absolute; top:100%; right:0; min-width:180px; background:var(--bg); border:1px solid var(--border); border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.1); padding:8px 0; z-index:200; margin-top:8px; }
        .nav-dropdown-menu a { display:block; padding:8px 16px; font-size:13px; }
        .nav-dropdown-menu a:hover { background:var(--bg-alt); color:var(--primary); }
        .nav-dropdown:hover > .nav-dropdown-menu { display:block; }

        /* Section base + Divider */
        .nx-section-outer { position:relative; }
        .nx-section-divider svg { fill:var(--bg,#fff); }
        section { overflow:hidden; }
        .section-title { text-align:center; margin-bottom:40px; }
        .section-title h2 { font-size:32px; font-weight:700; color:var(--dark); margin-bottom:8px; }
        .section-title p { font-size:16px; color:var(--text-muted); max-width:600px; margin:0 auto; }
        .btn-primary { background:var(--primary); border:none; padding:12px 28px; border-radius:12px; font-size:15px; font-weight:600; color:#fff; transition:all 0.2s; }
        .btn-primary:hover { background:var(--primary-dark); transform:translateY(-2px); box-shadow:0 8px 24px rgba(124,58,237,0.3); color:#fff; }
        .btn-outline-primary { border:2px solid var(--primary); color:var(--primary); padding:10px 24px; border-radius:12px; font-weight:600; background:transparent; }
        .btn-outline-primary:hover { background:var(--primary); color:#fff; }

        /* Demo Categories */
        .demo-section { padding:80px 0; background:var(--bg-alt); }
        .demo-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:20px; }
        .demo-card {
            background:var(--bg); border:1px solid var(--border); border-radius:18px; padding:20px;
            box-shadow:0 10px 30px rgba(15,23,42,0.06); transition:transform 0.2s, box-shadow 0.2s;
            display:flex; flex-direction:column; gap:12px; min-height:210px;
        }
        .demo-card:hover { transform:translateY(-4px); box-shadow:0 18px 40px rgba(15,23,42,0.12); }
        .demo-icon {
            width:48px; height:48px; border-radius:14px; background:var(--primary-accent);
            display:flex; align-items:center; justify-content:center; color:var(--primary);
            font-size:20px;
        }
        .demo-card h4 { font-size:18px; font-weight:700; color:var(--dark); margin:0; }
        .demo-card p { margin:0; color:var(--text-muted); font-size:13px; line-height:1.7; }
        .demo-meta { display:flex; align-items:center; gap:8px; margin-top:auto; font-size:12px; color:var(--text-muted); }
        .demo-meta span { background:rgba(124,58,237,0.08); color:var(--primary); padding:4px 10px; border-radius:999px; font-weight:600; }

        @media (max-width:768px) {
            .site-nav .nav-links { gap:12px; font-size:13px; }
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="site-nav">
        <div class="container">
            <a href="/" class="brand">
                @if(setting('company_logo'))
                    <img src="{{ asset(setting('company_logo')) }}" alt="">
                @endif
                {{ setting('company_name', 'نكسورا') }}
            </a>
            <div class="nav-links">
                @if($headerMenu->count() > 0)
                    @foreach($headerMenu as $menuItem)
                        @if(isset($menuItem->children_items) && $menuItem->children_items->count() > 0)
                        <div class="nav-dropdown">
                            <a href="{{ $menuItem->resolved_url }}" target="{{ $menuItem->target }}">
                                @if($menuItem->icon)<i class="{{ $menuItem->icon }} me-1"></i>@endif
                                {{ $menuItem->title }}
                            </a>
                            <div class="nav-dropdown-menu">
                                @foreach($menuItem->children_items as $child)
                                <a href="{{ $child->resolved_url }}" target="{{ $child->target }}">
                                    @if($child->icon)<i class="{{ $child->icon }} me-1"></i>@endif
                                    {{ $child->title }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <a href="{{ $menuItem->resolved_url }}" target="{{ $menuItem->target }}">
                            @if($menuItem->icon)<i class="{{ $menuItem->icon }} me-1"></i>@endif
                            {{ $menuItem->title }}
                        </a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </nav>

    {{-- Demo Categories --}}
    <section class="demo-section" id="demos">
        <div class="container">
            <div class="section-title">
                <h2>ديموهات جاهزة لمواقع اللاندق بيج</h2>
                <p>اختر قالباً مناسباً لنوع مشروعك، وابدأ بتخصيص المحتوى والألوان خلال دقائق.</p>
            </div>
            <div class="demo-grid">
                <div class="demo-card">
                    <div class="demo-icon"><i class="fas fa-laptop-code"></i></div>
                    <h4>تطبيقات SaaS</h4>
                    <p>صفحات مهيأة لشرح المزايا، التسعير، وتجارب العملاء بوضوح.</p>
                    <div class="demo-meta"><span>تقني</span><span>اشتراكات</span></div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fas fa-store"></i></div>
                    <h4>متجر إلكتروني</h4>
                    <p>عرض منتجاتك بشكل جذاب مع CTA واضح وتجربة شراء مبسطة.</p>
                    <div class="demo-meta"><span>تجارة</span><span>منتجات</span></div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fas fa-mobile-alt"></i></div>
                    <h4>تطبيق جوال</h4>
                    <p>قسم مخصص للمزايا والتنزيل مع إبراز لقطات الشاشة والتقييمات.</p>
                    <div class="demo-meta"><span>موبايل</span><span>تحميل</span></div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fas fa-graduation-cap"></i></div>
                    <h4>دورات وتعليم</h4>
                    <p>صفحات تسجيل للدورات، البرامج التدريبية، والورش الاحترافية.</p>
                    <div class="demo-meta"><span>تعليمي</span><span>تسجيل</span></div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fas fa-utensils"></i></div>
                    <h4>مطاعم ومقاهي</h4>
                    <p>عرض قوائم الطعام والحجوزات والعروض الموسمية بسهولة.</p>
                    <div class="demo-meta"><span>ضيافة</span><span>حجز</span></div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fas fa-calendar-check"></i></div>
                    <h4>فعاليات ومؤتمرات</h4>
                    <p>ترويج الحدث، جدول المتحدثين، وحجوزات التذاكر.</p>
                    <div class="demo-meta"><span>حدث</span><span>تذاكر</span></div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fas fa-briefcase"></i></div>
                    <h4>خدمات الشركات</h4>
                    <p>قوالب مناسبة لوكالات التسويق، الاستشارات، والخدمات المهنية.</p>
                    <div class="demo-meta"><span>أعمال</span><span>عملاء</span></div>
                </div>
                <div class="demo-card">
                    <div class="demo-icon"><i class="fas fa-building"></i></div>
                    <h4>عقارات</h4>
                    <p>صفحات تسويق للمشاريع والوحدات مع نماذج تواصل سريعة.</p>
                    <div class="demo-meta"><span>عقاري</span><span>نماذج</span></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sections --}}
    @foreach($sections as $sectionIndex => $section)
        <div class="nx-section-outer" style="z-index:{{ 50 - $sectionIndex }};">
            @include('frontend.sections.' . $section->type . '_' . $section->template, [
                'section' => $section,
                'features' => $features ?? collect(),
                'services' => $services ?? collect(),
                'statItems' => $statItems ?? collect(),
                'testimonials' => $testimonials ?? collect(),
                'partners' => $partners ?? collect(),
                'faqItems' => $faqItems ?? collect(),
                'sliderItems' => $sliderItems ?? collect(),
            ])
        </div>
        @if(!$loop->last)
            @include('frontend.partials.section_divider', ['dividerIndex' => $sectionIndex])
        @endif
    @endforeach

    {{-- Footer --}}
    @include('frontend.footers.footer_' . $footerTemplate, [
        'footerMenu' => $footerMenu,
    ])

    <script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
