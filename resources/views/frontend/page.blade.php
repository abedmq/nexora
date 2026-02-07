<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title ?: $page->title }} - {{ setting('company_name', 'نكسورا') }}</title>
    <meta name="description" content="{{ $page->meta_description ?: $page->excerpt }}">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome/css/all.min.css') }}">
    @if(setting('site_favicon'))
    <link rel="icon" href="{{ asset(setting('site_favicon')) }}">
    @endif
    <style>
        :root {
            --primary:{{ setting('theme_color_primary', '#7c3aed') }};
            --primary-light:{{ setting('theme_color_light', '#a78bfa') }};
            --primary-dark:{{ setting('theme_color_dark', '#6d28d9') }};
            --primary-accent:{{ setting('theme_color_accent', '#f3f0ff') }};
            --dark: #1e293b;
            --text: #334155;
            --text-muted: #64748b;
            --bg: #ffffff;
            --bg-alt: #f8fafc;
            --border: #e2e8f0;
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
        .site-nav .nav-links a:hover, .site-nav .nav-links a.active { color:var(--primary); }

        /* Hero Section */
        .section-hero { background:linear-gradient(135deg,#f5f3ff 0%,#ede9fe 50%,#ddd6fe 100%); padding:80px 0; text-align:center; }
        .section-hero h1 { font-size:42px; font-weight:800; color:var(--dark); margin-bottom:16px; }
        .section-hero p { font-size:18px; color:var(--text-muted); max-width:600px; margin:0 auto 24px; line-height:1.8; }
        .section-hero .btn-primary { background:var(--primary); border:none; padding:12px 32px; border-radius:12px; font-size:15px; font-weight:600; color:#fff; transition:all 0.2s; }
        .section-hero .btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(124,58,237,0.3); }

        /* Text Section */
        .section-text { padding:60px 0; }
        .section-text h2 { font-size:28px; font-weight:700; color:var(--dark); margin-bottom:16px; }
        .section-text .content { font-size:16px; line-height:2; color:var(--text); }

        /* Features */
        .section-features { padding:60px 0; background:var(--bg-alt); }
        .section-features h2 { text-align:center; font-size:28px; font-weight:700; margin-bottom:40px; }
        .feature-card { background:var(--bg); border-radius:16px; padding:28px 24px; text-align:center; border:1px solid var(--border); transition:all 0.3s; height:100%; }
        .feature-card:hover { transform:translateY(-4px); box-shadow:0 12px 32px rgba(0,0,0,0.08); }
        .feature-card i { font-size:36px; color:var(--primary); margin-bottom:16px; }
        .feature-card h5 { font-weight:600; margin-bottom:8px; }
        .feature-card p { font-size:14px; color:var(--text-muted); margin:0; }

        /* CTA */
        .section-cta { padding:60px 0; background:linear-gradient(135deg,var(--primary),#6d28d9); text-align:center; color:#fff; }
        .section-cta h2 { font-size:32px; font-weight:700; margin-bottom:12px; }
        .section-cta p { font-size:16px; opacity:0.9; margin-bottom:24px; }
        .section-cta .btn { background:#fff; color:var(--primary); border:none; padding:12px 32px; border-radius:12px; font-weight:600; }

        /* Stats */
        .section-stats { padding:60px 0; background:var(--bg-alt); }
        .stat-box { text-align:center; padding:20px; }
        .stat-box .num { font-size:42px; font-weight:800; color:var(--primary); }
        .stat-box .label { font-size:14px; color:var(--text-muted); }

        /* Testimonials */
        .section-testimonials { padding:60px 0; }
        .section-testimonials h2 { text-align:center; font-size:28px; font-weight:700; margin-bottom:40px; }
        .testimonial-card { background:var(--bg-alt); border-radius:16px; padding:24px; text-align:center; }
        .testimonial-card .quote { font-size:15px; color:var(--text); line-height:1.8; margin-bottom:16px; font-style:italic; }
        .testimonial-card .author { font-weight:600; color:var(--dark); }

        /* Gallery */
        .section-gallery { padding:60px 0; }
        .section-gallery h2 { text-align:center; font-size:28px; font-weight:700; margin-bottom:40px; }

        /* Custom HTML */
        .section-custom { padding:40px 0; }

        /* General Section Title */
        .section-title { text-align:center; font-size:28px; font-weight:700; color:var(--dark); margin-bottom:40px; }

        /* Footer */
        .site-footer { background:var(--dark); color:#94a3b8; padding:40px 0 24px; font-size:13px; }
        .site-footer a { color:var(--primary-light); transition:color 0.2s; }
        .site-footer a:hover { color:#fff; }
        .footer-menu { display:flex; flex-wrap:wrap; gap:16px; justify-content:center; margin-bottom:16px; padding:0; list-style:none; }
        .footer-menu a { color:#94a3b8; font-weight:500; }
        .footer-menu a:hover { color:var(--primary-light); }

        /* Dropdown Nav */
        .nav-dropdown { position:relative; }
        .nav-dropdown > a { display:flex; align-items:center; gap:4px; }
        .nav-dropdown > a::after { content:"\f107"; font-family:"Font Awesome 5 Free"; font-weight:900; font-size:10px; }
        .nav-dropdown-menu {
            display:none; position:absolute; top:100%; right:0; min-width:180px;
            background:var(--bg); border:1px solid var(--border); border-radius:10px;
            box-shadow:0 8px 24px rgba(0,0,0,0.1); padding:8px 0; z-index:200; margin-top:8px;
        }
        .nav-dropdown-menu a { display:block; padding:8px 16px; font-size:13px; color:var(--text); white-space:nowrap; }
        .nav-dropdown-menu a:hover { background:var(--bg-alt); color:var(--primary); }
        .nav-dropdown:hover > .nav-dropdown-menu { display:block; }

        /* Sub-dropdown */
        .nav-dropdown-menu .nav-dropdown { position:relative; }
        .nav-dropdown-menu .nav-dropdown > a::after { content:"\f104"; position:absolute; left:12px; }
        .nav-dropdown-menu .nav-dropdown > .nav-dropdown-menu { top:0; right:100%; margin-top:0; margin-left:4px; }

        @media (max-width:768px) {
            .section-hero h1 { font-size:28px; }
            .site-nav .nav-links { gap:12px; font-size:13px; }
            .nav-dropdown-menu { position:static; box-shadow:none; border:none; padding-right:16px; margin-top:0; }
            .nav-dropdown-menu .nav-dropdown > .nav-dropdown-menu { position:static; margin-left:0; }
        }

        {!! $page->custom_css ?? '' !!}
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
                @if(isset($headerMenu) && $headerMenu->count() > 0)
                    @foreach($headerMenu as $menuItem)
                        @if(isset($menuItem->children_items) && $menuItem->children_items->count() > 0)
                        <div class="nav-dropdown">
                            <a href="{{ $menuItem->resolved_url }}" target="{{ $menuItem->target }}">
                                @if($menuItem->icon)<i class="{{ $menuItem->icon }} me-1"></i>@endif
                                {{ $menuItem->title }}
                            </a>
                            <div class="nav-dropdown-menu">
                                @foreach($menuItem->children_items as $child)
                                    @if(isset($child->children_items) && $child->children_items->count() > 0)
                                    <div class="nav-dropdown">
                                        <a href="{{ $child->resolved_url }}" target="{{ $child->target }}">
                                            @if($child->icon)<i class="{{ $child->icon }} me-1"></i>@endif
                                            {{ $child->title }}
                                        </a>
                                        <div class="nav-dropdown-menu">
                                            @foreach($child->children_items as $subChild)
                                            <a href="{{ $subChild->resolved_url }}" target="{{ $subChild->target }}">
                                                @if($subChild->icon)<i class="{{ $subChild->icon }} me-1"></i>@endif
                                                {{ $subChild->title }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @else
                                    <a href="{{ $child->resolved_url }}" target="{{ $child->target }}">
                                        @if($child->icon)<i class="{{ $child->icon }} me-1"></i>@endif
                                        {{ $child->title }}
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @else
                        <a href="{{ $menuItem->resolved_url }}" target="{{ $menuItem->target }}" class="{{ ($menuItem->type === 'page' && $menuItem->page && $menuItem->page->slug === $page->slug) ? 'active' : '' }}">
                            @if($menuItem->icon)<i class="{{ $menuItem->icon }} me-1"></i>@endif
                            {{ $menuItem->title }}
                        </a>
                        @endif
                    @endforeach
                @else
                    {{-- Fallback to navPages --}}
                    <a href="/">الرئيسية</a>
                    @foreach($navPages as $np)
                        <a href="{{ url('/page/' . $np->slug) }}" class="{{ $np->slug === $page->slug ? 'active' : '' }}">{{ $np->title }}</a>
                    @endforeach
                @endif
            </div>
        </div>
    </nav>

    {{-- Page Sections --}}
    @foreach($page->activeSections as $section)
        @php $s = $section->decoded_settings; @endphp

        @if($section->type === 'hero')
        <section class="section-hero" @if(!empty($s['bg_color'])) style="background:{{ $s['bg_color'] }};" @endif>
            <div class="container">
                @if($section->title)<h1>{{ $section->title }}</h1>@endif
                @if($section->content)<p>{!! $section->content !!}</p>@endif
                @if(!empty($s['button_text']))
                    <a href="{{ $s['button_url'] ?? '#' }}" class="btn btn-primary">{{ $s['button_text'] }}</a>
                @endif
            </div>
        </section>

        @elseif($section->type === 'text')
        <section class="section-text" @if(!empty($s['bg_color'])) style="background:{{ $s['bg_color'] }};" @endif>
            <div class="container">
                @if($section->title)<h2>{{ $section->title }}</h2>@endif
                <div class="content">{!! $section->content !!}</div>
            </div>
        </section>

        @elseif($section->type === 'features')
        <section class="section-features" @if(!empty($s['bg_color'])) style="background:{{ $s['bg_color'] }};" @endif>
            <div class="container">
                @if($section->title)<h2 class="section-title">{{ $section->title }}</h2>@endif
                <div class="row g-4">
                    {!! $section->content !!}
                </div>
            </div>
        </section>

        @elseif($section->type === 'cta')
        <section class="section-cta" @if(!empty($s['bg_color'])) style="background:{{ $s['bg_color'] }};" @endif>
            <div class="container">
                @if($section->title)<h2>{{ $section->title }}</h2>@endif
                @if($section->content)<p>{!! $section->content !!}</p>@endif
                @if(!empty($s['button_text']))
                    <a href="{{ $s['button_url'] ?? '#' }}" class="btn">{{ $s['button_text'] }}</a>
                @endif
            </div>
        </section>

        @elseif($section->type === 'stats')
        <section class="section-stats" @if(!empty($s['bg_color'])) style="background:{{ $s['bg_color'] }};" @endif>
            <div class="container">
                @if($section->title)<h2 class="section-title">{{ $section->title }}</h2>@endif
                <div class="row g-4">
                    {!! $section->content !!}
                </div>
            </div>
        </section>

        @elseif($section->type === 'testimonials')
        <section class="section-testimonials" @if(!empty($s['bg_color'])) style="background:{{ $s['bg_color'] }};" @endif>
            <div class="container">
                @if($section->title)<h2 class="section-title">{{ $section->title }}</h2>@endif
                <div class="row g-4">
                    {!! $section->content !!}
                </div>
            </div>
        </section>

        @elseif($section->type === 'gallery')
        <section class="section-gallery" @if(!empty($s['bg_color'])) style="background:{{ $s['bg_color'] }};" @endif>
            <div class="container">
                @if($section->title)<h2 class="section-title">{{ $section->title }}</h2>@endif
                <div class="row g-3">
                    {!! $section->content !!}
                </div>
            </div>
        </section>

        @elseif($section->type === 'custom_html')
        <section class="section-custom">
            {!! $section->content !!}
        </section>
        @endif
    @endforeach

    {{-- Main Content (if no sections, show content field) --}}
    @if($page->activeSections->isEmpty() && $page->content)
    <section class="section-text">
        <div class="container py-4">
            <h1 style="font-size:32px;font-weight:700;margin-bottom:20px;">{{ $page->title }}</h1>
            <div class="content">{!! $page->content !!}</div>
        </div>
    </section>
    @endif

    {{-- Footer --}}
    <footer class="site-footer">
        <div class="container">
            @if(isset($footerMenu) && $footerMenu->count() > 0)
            <ul class="footer-menu">
                @foreach($footerMenu as $fItem)
                <li>
                    <a href="{{ $fItem->resolved_url }}" target="{{ $fItem->target }}">
                        @if($fItem->icon)<i class="{{ $fItem->icon }} me-1"></i>@endif
                        {{ $fItem->title }}
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
            <div>&copy; {{ date('Y') }} {{ setting('company_name', 'نكسورا') }}. جميع الحقوق محفوظة.</div>
        </div>
    </footer>

    <script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @if($page->custom_js)
    <script>{!! $page->custom_js !!}</script>
    @endif
</body>
</html>
