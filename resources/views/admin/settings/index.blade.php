@extends('admin.layouts.app')

@section('title', 'الإعدادات')
@section('page-title', 'الإعدادات')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>الإعدادات</span>
@endsection

@section('content')

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-success-light);color:var(--nx-success);">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-danger-light);color:var(--nx-danger);">
        <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(!theme_supports('theme_settings') || !theme_supports('demo'))
        <div class="alert alert-warning" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-warning-light);color:var(--nx-warning);">
            <i class="fas fa-info-circle me-1"></i>
            بعض إعدادات الثيم غير متاحة للثيم الحالي. يمكنك تفعيل ثيم يدعمها من صفحة
            <a href="{{ route('admin.themes.index') }}" class="fw-semibold text-decoration-underline">الثيمات</a>.
        </div>
    @endif

    <!-- Tabs -->
    <ul class="nav nx-tabs mb-4" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#generalTab">الإعدادات العامة</a></li>
        @if(theme_supports('theme_settings'))
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#themeTab">إعدادات الثيم</a></li>
        @endif
        @if(theme_supports('demo'))
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#demoTab">الديمو</a></li>
        @endif
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#footerTab">تصميم الفوتر</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pricingTab">الأسعار</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#accountTab">الحساب</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#passwordTab">كلمة المرور</a></li>
    </ul>

    <div class="tab-content">
        <!-- General Settings -->
        <div class="tab-pane fade show active" id="generalTab">

            {{-- Logo Upload Card --}}
            <div class="nx-card mb-4">
                <div class="card-header"><h5 class="card-title"><i class="fas fa-image me-1 text-purple"></i> شعار الشركة</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update-logo') }}" method="POST" enctype="multipart/form-data" class="nx-form">
                        @csrf
                        <div class="d-flex align-items-center gap-4 flex-wrap">
                            {{-- Current Logo Preview --}}
                            <div class="logo-preview-box" id="logoPreviewBox">
                                @if(!empty($settings['company_logo']))
                                    <img src="{{ asset($settings['company_logo']) }}" alt="شعار الشركة" id="logoPreviewImg">
                                @else
                                    <div class="logo-placeholder" id="logoPlaceholder">
                                        <i class="fas fa-image"></i>
                                        <small>لا يوجد شعار</small>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-fill">
                                <label class="form-label">اختر صورة الشعار</label>
                                <input type="file" name="logo" id="logoInput" class="form-control" accept="image/*">
                                <small class="text-muted d-block mt-1">الصيغ المسموحة: PNG, JPG, SVG, WEBP — الحد الأقصى: 2 ميجابايت</small>
                                @error('logo') <small class="text-danger">{{ $message }}</small> @enderror
                                <button type="submit" class="btn btn-nx-primary btn-sm mt-3"><i class="fas fa-upload me-1"></i> رفع الشعار</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">الإعدادات العامة</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="nx-form">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">اسم الشركة</label>
                                <input type="text" name="settings[company_name]" class="form-control" value="{{ $settings['company_name'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="settings[company_email]" class="form-control" value="{{ $settings['company_email'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="text" name="settings[company_phone]" class="form-control" value="{{ $settings['company_phone'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">العنوان</label>
                                <input type="text" name="settings[company_address]" class="form-control" value="{{ $settings['company_address'] ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">العملة</label>
                                <select name="settings[currency]" class="form-select">
                                    <option value="SAR" {{ ($settings['currency'] ?? '') == 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                                    <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                                    <option value="AED" {{ ($settings['currency'] ?? '') == 'AED' ? 'selected' : '' }}>درهم إماراتي (AED)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">المنطقة الزمنية</label>
                                <select name="settings[timezone]" class="form-select">
                                    <option value="Asia/Riyadh" {{ ($settings['timezone'] ?? '') == 'Asia/Riyadh' ? 'selected' : '' }}>الرياض (UTC+3)</option>
                                    <option value="Asia/Dubai" {{ ($settings['timezone'] ?? '') == 'Asia/Dubai' ? 'selected' : '' }}>دبي (UTC+4)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> حفظ الإعدادات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Theme Settings -->
        @if(theme_supports('theme_settings'))
            <div class="tab-pane fade" id="themeTab">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                {{-- Logo Section --}}
                <div class="nx-card mb-4">
                    <div class="card-header"><h5 class="card-title"><i class="fas fa-image me-1 text-purple"></i> شعار الموقع</h5></div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">الشعار الرئيسي</label>
                                <p class="text-muted small mb-2">يظهر في الناف بار والفوتر</p>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="theme-logo-box" id="mainLogoBox">
                                        @if(!empty($settings['company_logo']))
                                            <img src="{{ asset($settings['company_logo']) }}" alt="">
                                        @else
                                            <i class="fas fa-image" style="font-size:24px;color:var(--nx-text-muted);opacity:0.3;"></i>
                                        @endif
                                    </div>
                                    <div class="flex-fill">
                                        <input type="file" name="site_logo" class="form-control form-control-sm logo-preview-input" data-target="mainLogoBox" accept="image/*">
                                        <small class="text-muted">PNG, SVG, WEBP — الحد: 2MB</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">الشعار المقلوب (للخلفيات الداكنة)</label>
                                <p class="text-muted small mb-2">يظهر على الخلفيات الداكنة مثل الفوتر</p>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="theme-logo-box dark" id="darkLogoBox">
                                        @if(!empty($settings['company_logo_dark']))
                                            <img src="{{ asset($settings['company_logo_dark']) }}" alt="">
                                        @else
                                            <i class="fas fa-image" style="font-size:24px;color:rgba(255,255,255,0.3);"></i>
                                        @endif
                                    </div>
                                    <div class="flex-fill">
                                        <input type="file" name="site_logo_dark" class="form-control form-control-sm logo-preview-input" data-target="darkLogoBox" accept="image/*">
                                        <small class="text-muted">PNG, SVG, WEBP — الحد: 2MB</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">أيقونة الموقع (Favicon)</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="theme-logo-box small" id="faviconBox">
                                        @if(!empty($settings['site_favicon']))
                                            <img src="{{ asset($settings['site_favicon']) }}" alt="">
                                        @else
                                            <i class="fas fa-globe" style="font-size:18px;color:var(--nx-text-muted);opacity:0.3;"></i>
                                        @endif
                                    </div>
                                    <div class="flex-fill">
                                        <input type="file" name="site_favicon" class="form-control form-control-sm logo-preview-input" data-target="faviconBox" accept="image/*">
                                        <small class="text-muted">ICO, PNG — 32x32 أو 64x64</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Color Palette --}}
                <div class="nx-card mb-4">
                    <div class="card-header"><h5 class="card-title"><i class="fas fa-palette me-1 text-purple"></i> نمط الألوان</h5></div>
                    <div class="card-body">
                        <p class="text-muted mb-3" style="font-size:13px;">اختر نمط الألوان الأساسي للموقع. يمكنك تخصيص الألوان يدوياً أسفل الأنماط.</p>
                        @php $currentPalette = $settings['color_palette'] ?? 'purple'; @endphp
                        <div class="row g-3 mb-4">
                            @php
                            $palettes = [
                                'purple'  => ['name' => 'بنفسجي', 'primary' => '#7c3aed', 'dark' => '#6d28d9', 'light' => '#a78bfa', 'accent' => '#f3f0ff'],
                                'blue'    => ['name' => 'أزرق', 'primary' => '#2563eb', 'dark' => '#1d4ed8', 'light' => '#60a5fa', 'accent' => '#eff6ff'],
                                'emerald' => ['name' => 'أخضر زمردي', 'primary' => '#059669', 'dark' => '#047857', 'light' => '#34d399', 'accent' => '#ecfdf5'],
                                'rose'    => ['name' => 'وردي', 'primary' => '#e11d48', 'dark' => '#be123c', 'light' => '#fb7185', 'accent' => '#fff1f2'],
                                'amber'   => ['name' => 'ذهبي', 'primary' => '#d97706', 'dark' => '#b45309', 'light' => '#fbbf24', 'accent' => '#fffbeb'],
                                'teal'    => ['name' => 'تركوازي', 'primary' => '#0d9488', 'dark' => '#0f766e', 'light' => '#2dd4bf', 'accent' => '#f0fdfa'],
                                'indigo'  => ['name' => 'نيلي', 'primary' => '#4f46e5', 'dark' => '#4338ca', 'light' => '#818cf8', 'accent' => '#eef2ff'],
                                'slate'   => ['name' => 'رمادي أنيق', 'primary' => '#475569', 'dark' => '#334155', 'light' => '#94a3b8', 'accent' => '#f8fafc'],
                            ];
                            @endphp
                            @foreach($palettes as $key => $pal)
                            <div class="col-md-3 col-sm-4 col-6">
                                <label class="palette-card {{ $currentPalette == $key ? 'selected' : '' }}">
                                    <input type="radio" name="settings[color_palette]" value="{{ $key }}" {{ $currentPalette == $key ? 'checked' : '' }}>
                                    <div class="palette-preview">
                                        <div class="palette-colors">
                                            <span style="background:{{ $pal['primary'] }};"></span>
                                            <span style="background:{{ $pal['dark'] }};"></span>
                                            <span style="background:{{ $pal['light'] }};"></span>
                                            <span style="background:{{ $pal['accent'] }};"></span>
                                        </div>
                                    </div>
                                    <div class="palette-name">{{ $pal['name'] }}</div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="p-3 rounded-3" style="background:var(--nx-body-bg,#f9fafb);border:1px solid var(--nx-border);">
                            <label class="form-label fw-semibold mb-2"><i class="fas fa-sliders-h me-1"></i> تخصيص يدوي</label>
                            <div class="row g-3">
                                <div class="col-md-3 col-6">
                                    <label class="form-label small">اللون الأساسي</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="color" value="{{ $settings['theme_color_primary'] ?? '#7c3aed' }}" class="form-control form-control-color color-picker-sync" style="width:42px;height:36px;">
                                        <input type="text" name="settings[theme_color_primary]" value="{{ $settings['theme_color_primary'] ?? '#7c3aed' }}" class="form-control form-control-sm color-hex-input" dir="ltr" style="font-size:12px;">
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <label class="form-label small">اللون الداكن</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="color" value="{{ $settings['theme_color_dark'] ?? '#6d28d9' }}" class="form-control form-control-color color-picker-sync" style="width:42px;height:36px;">
                                        <input type="text" name="settings[theme_color_dark]" value="{{ $settings['theme_color_dark'] ?? '#6d28d9' }}" class="form-control form-control-sm color-hex-input" dir="ltr" style="font-size:12px;">
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <label class="form-label small">اللون الفاتح</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="color" value="{{ $settings['theme_color_light'] ?? '#a78bfa' }}" class="form-control form-control-color color-picker-sync" style="width:42px;height:36px;">
                                        <input type="text" name="settings[theme_color_light]" value="{{ $settings['theme_color_light'] ?? '#a78bfa' }}" class="form-control form-control-sm color-hex-input" dir="ltr" style="font-size:12px;">
                                    </div>
                                </div>
                                <div class="col-md-3 col-6">
                                    <label class="form-label small">لون الخلفية الثانوية</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="color" value="{{ $settings['theme_color_accent'] ?? '#f3f0ff' }}" class="form-control form-control-color color-picker-sync" style="width:42px;height:36px;">
                                        <input type="text" name="settings[theme_color_accent]" value="{{ $settings['theme_color_accent'] ?? '#f3f0ff' }}" class="form-control form-control-sm color-hex-input" dir="ltr" style="font-size:12px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section Dividers --}}
                <div class="nx-card mb-4">
                    <div class="card-header"><h5 class="card-title"><i class="fas fa-wave-square me-1 text-purple"></i> الفواصل بين الأقسام</h5></div>
                    <div class="card-body">
                        <p class="text-muted mb-3" style="font-size:13px;">اختر شكل الفاصل بين الأقسام — يأخذ الفاصل لون القسم تلقائياً ليبدو جزءاً منه</p>
                        @php
                        $currentDivider = $settings['section_divider'] ?? 'none';
                        $dividers = [
                            'none'        => ['name' => 'بدون فاصل', 'path' => ''],
                            'wave'        => ['name' => 'موجة ناعمة', 'path' => 'M0,40 C200,100 400,0 600,60 C800,120 1000,20 1200,80 L1200,120 L0,120 Z'],
                            'waves-multi' => ['name' => 'أمواج متدرجة', 'path' => 'multi'],
                            'curve'       => ['name' => 'قوس دائري', 'path' => 'M0,80 Q600,-20 1200,80 L1200,120 L0,120 Z'],
                            'tilt'        => ['name' => 'قص مائل', 'path' => 'M0,0 L1200,80 L1200,120 L0,120 Z'],
                            'triangle'    => ['name' => 'سهم مركزي', 'path' => 'M600,0 L1200,120 L0,120 Z'],
                            'mountains'   => ['name' => 'قمم جبلية', 'path' => 'M0,120 L100,40 L200,80 L350,10 L500,60 L650,20 L800,70 L950,0 L1100,50 L1200,30 L1200,120 Z'],
                            'clouds'      => ['name' => 'غيوم ناعمة', 'path' => 'M0,80 C80,50 150,30 250,50 C350,20 400,0 500,30 C600,0 650,10 750,40 C850,10 950,0 1050,30 C1100,50 1150,60 1200,50 L1200,120 L0,120 Z'],
                            'zigzag'      => ['name' => 'متعرج', 'path' => 'M0,60 L60,20 L120,60 L180,20 L240,60 L300,20 L360,60 L420,20 L480,60 L540,20 L600,60 L660,20 L720,60 L780,20 L840,60 L900,20 L960,60 L1020,20 L1080,60 L1140,20 L1200,60 L1200,120 L0,120 Z'],
                            'torn'        => ['name' => 'ورق ممزق', 'path' => 'M0,50 L30,62 L60,44 L100,72 L130,34 L170,60 L200,42 L240,70 L280,36 L320,56 L360,40 L400,66 L440,34 L480,58 L520,38 L560,64 L600,46 L640,72 L680,36 L720,56 L760,44 L800,70 L840,30 L880,58 L920,42 L960,66 L1000,48 L1040,72 L1080,38 L1120,62 L1160,46 L1200,56 L1200,120 L0,120 Z'],
                            'rounded'     => ['name' => 'قوس عميق', 'path' => 'M0,0 C300,120 900,120 1200,0 L1200,120 L0,120 Z'],
                            'split'       => ['name' => 'شق مركزي', 'path' => 'M0,70 L540,70 L600,0 L660,70 L1200,70 L1200,120 L0,120 Z'],
                            'leaves'      => ['name' => 'أوراق عضوية', 'path' => 'M0,50 C100,20 200,80 300,40 C400,0 500,60 600,30 C700,0 800,70 900,40 C1000,10 1100,60 1200,30 L1200,120 L0,120 Z'],
                            'swoosh'      => ['name' => 'انسياب', 'path' => 'M0,0 C0,0 100,120 400,80 C700,40 900,120 1200,100 L1200,120 L0,120 Z'],
                        ];
                        @endphp
                        <div class="row g-3">
                            @foreach($dividers as $dKey => $div)
                            <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                <label class="divider-card {{ $currentDivider == $dKey ? 'selected' : '' }}">
                                    <input type="radio" name="settings[section_divider]" value="{{ $dKey }}" {{ $currentDivider == $dKey ? 'checked' : '' }}>
                                    <div class="divider-preview">
                                        @if($dKey === 'none')
                                            <div style="height:44px;display:flex;align-items:center;justify-content:center;">
                                                <i class="fas fa-minus" style="font-size:20px;color:#94a3b8;opacity:0.2;"></i>
                                            </div>
                                        @else
                                            <div style="height:26px;background:linear-gradient(135deg,var(--nx-primary,#7c3aed),#a78bfa);position:relative;border-radius:4px 4px 0 0;">
                                                <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position:absolute;bottom:-1px;left:0;width:100%;height:18px;display:block;">
                                                    @if($dKey === 'waves-multi')
                                                        <path d="M0,60 C300,120 600,0 1200,60 L1200,120 L0,120 Z" fill="#fff" opacity="0.33"/>
                                                        <path d="M0,40 C200,80 500,20 700,60 C900,100 1100,20 1200,50 L1200,120 L0,120 Z" fill="#fff" opacity="0.55"/>
                                                        <path d="M0,50 C150,90 350,10 600,50 C850,90 1050,20 1200,60 L1200,120 L0,120 Z" fill="#fff"/>
                                                    @else
                                                        <path d="{{ $div['path'] }}" fill="#fff"/>
                                                    @endif
                                                </svg>
                                            </div>
                                            <div style="height:18px;background:#f8f9fb;border-radius:0 0 4px 4px;"></div>
                                        @endif
                                    </div>
                                    <div class="divider-name">{{ $div['name'] }}</div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">ارتفاع الفاصل</label>
                                <select name="settings[divider_height]" class="form-select form-select-sm">
                                    @php $dh = $settings['divider_height'] ?? '60'; @endphp
                                    <option value="30" {{ $dh == '30' ? 'selected' : '' }}>صغير (30px)</option>
                                    <option value="60" {{ $dh == '60' ? 'selected' : '' }}>متوسط (60px)</option>
                                    <option value="80" {{ $dh == '80' ? 'selected' : '' }}>كبير (80px)</option>
                                    <option value="100" {{ $dh == '100' ? 'selected' : '' }}>كبير جداً (100px)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">اتجاه الفاصل</label>
                                <select name="settings[divider_flip]" class="form-select form-select-sm">
                                    @php $df = $settings['divider_flip'] ?? '0'; @endphp
                                    <option value="0" {{ $df == '0' ? 'selected' : '' }}>عادي</option>
                                    <option value="1" {{ $df == '1' ? 'selected' : '' }}>مقلوب</option>
                                    <option value="alternate" {{ $df == 'alternate' ? 'selected' : '' }}>متناوب (عادي/مقلوب)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="mt-2 mb-4">
                        <button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> حفظ إعدادات الثيم</button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Demo Export/Import -->
        @if(theme_supports('demo'))
            <div class="tab-pane fade" id="demoTab">
                <div class="nx-card mb-4">
                    <div class="card-header"><h5 class="card-title"><i class="fas fa-file-export me-1 text-purple"></i> تصدير الديمو الحالي</h5></div>
                    <div class="card-body">
                        <p class="text-muted mb-3" style="font-size:13px;">سيتم تصدير إعدادات الثيم، تصميم الصفحة الرئيسية، وجميع الصور المرتبطة ضمن ملف ZIP.</p>
                        <a href="{{ route('admin.settings.demo.export') }}" class="btn btn-nx-primary"><i class="fas fa-download me-1"></i> تحميل الديمو</a>
                    </div>
                </div>

                <div class="nx-card">
                    <div class="card-header"><h5 class="card-title"><i class="fas fa-file-import me-1 text-purple"></i> استيراد ديمو</h5></div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.demo.import') }}" method="POST" enctype="multipart/form-data" class="nx-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">استيراد من ملف مضغوط</label>
                                    <input type="file" name="demo_zip" class="form-control" accept=".zip">
                                    <small class="text-muted d-block mt-1">ملف ZIP يحتوي على demo.sql وملف الصور.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">استيراد من ديمو محفوظ بالموقع</label>
                                    <select name="preset" class="form-select">
                                        <option value="">اختر ديمو محفوظ</option>
                                        @foreach($demoPresets as $preset)
                                            <option value="{{ $preset }}">{{ $preset }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted d-block mt-1">يتم قراءة الديمو من storage/app/demos.</small>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-nx-primary"><i class="fas fa-upload me-1"></i> استيراد الديمو</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Footer Template -->
        <div class="tab-pane fade" id="footerTab">
            <div class="nx-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-window-minimize me-1 text-purple"></i> تصميم الفوتر</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4" style="font-size:13px;">اختر التصميم المناسب لفوتر الموقع</p>
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-3 mb-4">
                            @php $currentFooter = $settings['footer_template'] ?? '1'; @endphp
                            <div class="col-md-3 col-sm-6">
                                <label class="footer-tpl-card {{ $currentFooter == '1' ? 'selected' : '' }}">
                                    <input type="radio" name="settings[footer_template]" value="1" {{ $currentFooter == '1' ? 'checked' : '' }}>
                                    <div class="footer-tpl-preview">
                                        <div style="background:#1e293b;padding:16px;border-radius:8px;color:#fff;text-align:center;font-size:10px;">
                                            <div style="opacity:0.6;">© 2026 نكسورا</div>
                                        </div>
                                    </div>
                                    <div class="footer-tpl-label">بسيط</div>
                                </label>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="footer-tpl-card {{ $currentFooter == '2' ? 'selected' : '' }}">
                                    <input type="radio" name="settings[footer_template]" value="2" {{ $currentFooter == '2' ? 'checked' : '' }}>
                                    <div class="footer-tpl-preview">
                                        <div style="background:#1e293b;padding:10px;border-radius:8px;color:#fff;font-size:8px;">
                                            <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                                                <div><div style="width:24px;height:3px;background:#7c3aed;margin-bottom:3px;border-radius:2px;"></div><div style="opacity:0.4;">نكسورا</div></div>
                                                <div style="opacity:0.4;text-align:left;"><div>الصفحات</div><div>خدماتنا</div></div>
                                                <div style="opacity:0.4;text-align:left;"><div>تواصل</div><div>البريد</div></div>
                                            </div>
                                            <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:4px;opacity:0.4;text-align:center;">© 2026</div>
                                        </div>
                                    </div>
                                    <div class="footer-tpl-label">أعمدة</div>
                                </label>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="footer-tpl-card {{ $currentFooter == '3' ? 'selected' : '' }}">
                                    <input type="radio" name="settings[footer_template]" value="3" {{ $currentFooter == '3' ? 'checked' : '' }}>
                                    <div class="footer-tpl-preview">
                                        <div style="background:#1e293b;padding:10px;border-radius:8px;color:#fff;font-size:8px;">
                                            <div style="text-align:center;margin-bottom:6px;"><div style="width:24px;height:3px;background:#7c3aed;margin:0 auto 3px;border-radius:2px;"></div><div style="opacity:0.4;">نكسورا</div><div style="opacity:0.3;font-size:7px;">وصف الشركة</div></div>
                                            <div style="display:flex;justify-content:center;gap:4px;margin-bottom:4px;">
                                                <span style="width:14px;height:14px;background:rgba(255,255,255,0.1);border-radius:50%;display:inline-block;"></span>
                                                <span style="width:14px;height:14px;background:rgba(255,255,255,0.1);border-radius:50%;display:inline-block;"></span>
                                                <span style="width:14px;height:14px;background:rgba(255,255,255,0.1);border-radius:50%;display:inline-block;"></span>
                                            </div>
                                            <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:4px;opacity:0.4;text-align:center;">© 2026</div>
                                        </div>
                                    </div>
                                    <div class="footer-tpl-label">مع التواصل</div>
                                </label>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="footer-tpl-card {{ $currentFooter == '4' ? 'selected' : '' }}">
                                    <input type="radio" name="settings[footer_template]" value="4" {{ $currentFooter == '4' ? 'checked' : '' }}>
                                    <div class="footer-tpl-preview">
                                        <div style="background:linear-gradient(135deg,#7c3aed,#6d28d9);padding:12px;border-radius:8px;color:#fff;font-size:8px;text-align:center;">
                                            <div style="margin-bottom:4px;font-weight:bold;">انضم إلينا</div>
                                            <div style="width:70%;height:10px;background:rgba(255,255,255,0.2);border-radius:4px;margin:0 auto 6px;"></div>
                                            <div style="opacity:0.6;">© 2026 نكسورا</div>
                                        </div>
                                    </div>
                                    <div class="footer-tpl-label">مع نشرة بريدية</div>
                                </label>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">وصف الشركة (يظهر في الفوتر)</label>
                                <textarea name="settings[footer_description]" class="form-control" rows="2">{{ $settings['footer_description'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">روابط التواصل الاجتماعي</label>
                                <input type="text" name="settings[social_twitter]" class="form-control form-control-sm mb-2" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="رابط تويتر" dir="ltr">
                                <input type="text" name="settings[social_instagram]" class="form-control form-control-sm mb-2" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="رابط انستقرام" dir="ltr">
                                <input type="text" name="settings[social_linkedin]" class="form-control form-control-sm" value="{{ $settings['social_linkedin'] ?? '' }}" placeholder="رابط لينكدإن" dir="ltr">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> حفظ تصميم الفوتر</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pricing Settings -->
        <div class="tab-pane fade" id="pricingTab">
            <div class="nx-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-coins me-1 text-purple"></i> الأسعار الافتراضية</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4" style="font-size:13px;">
                        هذه الأسعار الافتراضية تُستخدم عند إنشاء الحجوزات إذا لم يكن للقاعة سعر مخصص. يمكن تعديل السعر لكل حجز على حدة.
                    </p>
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="nx-form">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-clock text-purple me-1"></i> سعر الساعة (ر.س)
                                </label>
                                <input type="number" name="settings[default_price_per_hour]" class="form-control"
                                       step="0.01" min="0" value="{{ $settings['default_price_per_hour'] ?? '50' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-sun text-orange me-1"></i> سعر اليوم (ر.س)
                                </label>
                                <input type="number" name="settings[default_price_per_day]" class="form-control"
                                       step="0.01" min="0" value="{{ $settings['default_price_per_day'] ?? '300' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar-week text-info me-1"></i> سعر الأسبوع (ر.س)
                                </label>
                                <input type="number" name="settings[default_price_per_week]" class="form-control"
                                       step="0.01" min="0" value="{{ $settings['default_price_per_week'] ?? '1500' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt text-success me-1"></i> سعر الشهر (ر.س)
                                </label>
                                <input type="number" name="settings[default_price_per_month]" class="form-control"
                                       step="0.01" min="0" value="{{ $settings['default_price_per_month'] ?? '4000' }}">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> حفظ الأسعار</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Account -->
        <div class="tab-pane fade" id="accountTab">
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">معلومات الحساب</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="nx-form">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">الاسم</label>
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> تحديث الحساب</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Password -->
        <div class="tab-pane fade" id="passwordTab">
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">تغيير كلمة المرور</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="nx-form">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">كلمة المرور الحالية</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> تغيير كلمة المرور</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .logo-preview-box {
        width: 120px; height: 120px; border-radius: var(--nx-radius);
        border: 2px dashed var(--nx-border); display: flex; align-items: center;
        justify-content: center; overflow: hidden; background: var(--nx-body-bg, #f9fafb);
        flex-shrink: 0;
    }
    .logo-preview-box img {
        max-width: 100%; max-height: 100%; object-fit: contain;
    }
    .logo-placeholder {
        display: flex; flex-direction: column; align-items: center; gap: 6px;
        color: var(--nx-text-muted); font-size: 13px;
    }
    .logo-placeholder i { font-size: 28px; }

    .footer-tpl-card { display:block; cursor:pointer; }
    .footer-tpl-card input { display:none; }
    .footer-tpl-preview { border:2px solid var(--nx-border); border-radius:10px; overflow:hidden; padding:8px; transition:all 0.2s; }
    .footer-tpl-card:hover .footer-tpl-preview { border-color:var(--nx-primary); }
    .footer-tpl-card.selected .footer-tpl-preview,
    .footer-tpl-card input:checked ~ .footer-tpl-preview { border-color:var(--nx-primary); box-shadow:0 0 0 3px rgba(124,58,237,0.15); }
    .footer-tpl-label { text-align:center; font-size:13px; font-weight:600; margin-top:8px; }

    /* Theme Logo Boxes */
    .theme-logo-box { width:80px; height:80px; border-radius:var(--nx-radius); border:2px dashed var(--nx-border); display:flex; align-items:center; justify-content:center; overflow:hidden; background:var(--nx-body-bg,#f9fafb); flex-shrink:0; }
    .theme-logo-box.dark { background:#1e293b; border-color:#334155; }
    .theme-logo-box.small { width:52px; height:52px; }
    .theme-logo-box img { max-width:100%; max-height:100%; object-fit:contain; }

    /* Palette Cards */
    .palette-card { display:block; cursor:pointer; text-align:center; }
    .palette-card input { display:none; }
    .palette-preview { border:2px solid var(--nx-border); border-radius:10px; padding:12px; transition:all 0.2s; }
    .palette-card:hover .palette-preview { border-color:var(--nx-primary); }
    .palette-card.selected .palette-preview,
    .palette-card input:checked ~ .palette-preview { border-color:var(--nx-primary); box-shadow:0 0 0 3px rgba(124,58,237,0.15); }
    .palette-colors { display:flex; gap:6px; justify-content:center; }
    .palette-colors span { width:28px; height:28px; border-radius:50%; display:block; border:2px solid rgba(0,0,0,0.06); }
    .palette-name { font-size:12px; font-weight:600; margin-top:8px; }

    /* Divider Cards */
    .divider-card { display:block; cursor:pointer; text-align:center; }
    .divider-card input { display:none; }
    .divider-preview { border:2px solid var(--nx-border); border-radius:10px; overflow:hidden; transition:all 0.2s; background:var(--nx-body-bg,#f9fafb); }
    .divider-card:hover .divider-preview { border-color:var(--nx-primary); }
    .divider-card.selected .divider-preview,
    .divider-card input:checked ~ .divider-preview { border-color:var(--nx-primary); box-shadow:0 0 0 3px rgba(124,58,237,0.15); }
    .divider-preview svg { display:block; width:100%; }
    .divider-name { font-size:11px; font-weight:600; margin-top:6px; color:var(--nx-text-muted); }
</style>
@endsection

@section('scripts')
<script>
    // Footer template selection
    $('input[name="settings[footer_template]"]').on('change', function() {
        $('.footer-tpl-card').removeClass('selected');
        $(this).closest('.footer-tpl-card').addClass('selected');
    });

    // Live preview on file select
    $('#logoInput').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#logoPreviewBox').html('<img src="' + e.target.result + '" alt="معاينة" id="logoPreviewImg">');
            };
            reader.readAsDataURL(file);
        }
    });

    // Palette card selection
    $('input[name="settings[color_palette]"]').on('change', function() {
        $('.palette-card').removeClass('selected');
        $(this).closest('.palette-card').addClass('selected');

        // Auto-fill custom color inputs based on palette
        var palettes = {
            'purple':  { primary:'#7c3aed', dark:'#6d28d9', light:'#a78bfa', accent:'#f3f0ff' },
            'blue':    { primary:'#2563eb', dark:'#1d4ed8', light:'#60a5fa', accent:'#eff6ff' },
            'emerald': { primary:'#059669', dark:'#047857', light:'#34d399', accent:'#ecfdf5' },
            'rose':    { primary:'#e11d48', dark:'#be123c', light:'#fb7185', accent:'#fff1f2' },
            'amber':   { primary:'#d97706', dark:'#b45309', light:'#fbbf24', accent:'#fffbeb' },
            'teal':    { primary:'#0d9488', dark:'#0f766e', light:'#2dd4bf', accent:'#f0fdfa' },
            'indigo':  { primary:'#4f46e5', dark:'#4338ca', light:'#818cf8', accent:'#eef2ff' },
            'slate':   { primary:'#475569', dark:'#334155', light:'#94a3b8', accent:'#f8fafc' }
        };
        var p = palettes[$(this).val()];
        if (p) {
            $('input[name="settings[theme_color_primary]"]').val(p.primary).siblings('.color-picker-sync').val(p.primary);
            $('input[name="settings[theme_color_dark]"]').val(p.dark).siblings('.color-picker-sync').val(p.dark);
            $('input[name="settings[theme_color_light]"]').val(p.light).siblings('.color-picker-sync').val(p.light);
            $('input[name="settings[theme_color_accent]"]').val(p.accent).siblings('.color-picker-sync').val(p.accent);
        }
    });

    // Sync color picker with text input
    $(document).on('input change', '.color-picker-sync', function() {
        $(this).siblings('.color-hex-input').val($(this).val());
    });
    $(document).on('input', '.color-hex-input', function() {
        var hex = $(this).val();
        if (/^#[0-9a-fA-F]{6}$/.test(hex)) {
            $(this).siblings('.color-picker-sync').val(hex);
        }
    });

    // Divider card selection
    $('input[name="settings[section_divider]"]').on('change', function() {
        $('.divider-card').removeClass('selected');
        $(this).closest('.divider-card').addClass('selected');
    });

    // Theme logo preview
    $(document).on('change', '.logo-preview-input', function() {
        var targetId = $(this).data('target');
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + targetId).html('<img src="' + e.target.result + '" alt="">');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
