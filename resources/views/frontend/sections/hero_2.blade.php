{{-- Hero Template 2: Split layout --}}
<section style="padding:80px 0;background:var(--bg);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                @if($section->title)<h1 style="font-size:44px;font-weight:800;color:#1e293b;margin-bottom:16px;line-height:1.3;">{{ $section->title }}</h1>@endif
                @if($section->subtitle)<p style="font-size:18px;color:#64748b;line-height:1.8;margin-bottom:24px;">{{ $section->subtitle }}</p>@endif
                @if(!empty($section->settings['button_text']))
                <a href="{{ $section->settings['button_url'] ?? '#' }}" class="btn btn-primary me-2">{{ $section->settings['button_text'] }}</a>
                @endif
            </div>
            <div class="col-lg-6 text-center">
                @if(!empty($section->settings['bg_image']))
                <img src="{{ $section->settings['bg_image'] }}" alt="" style="max-width:100%;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,0.1);">
                @else
                <div style="background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:20px;padding:60px;text-align:center;">
                    <i class="fas fa-building" style="font-size:80px;color:rgba(255,255,255,0.3);"></i>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
