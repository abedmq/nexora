{{-- CTA Template 3: Split with image --}}
<section style="padding:80px 0;background:var(--bg-alt);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                @if($section->title)<h2 style="font-size:32px;font-weight:700;color:var(--dark);margin-bottom:12px;">{{ $section->title }}</h2>@endif
                @if($section->subtitle)<p style="color:var(--text-muted);line-height:1.8;margin-bottom:24px;font-size:16px;">{{ $section->subtitle }}</p>@endif
                @if(!empty($section->settings['button_text']))
                <a href="{{ $section->settings['button_url'] ?? '#' }}" class="btn btn-primary">{{ $section->settings['button_text'] }}</a>
                @endif
            </div>
            <div class="col-lg-5 text-center">
                @if(!empty($section->settings['bg_image']))
                <img src="{{ $section->settings['bg_image'] }}" alt="" style="max-width:100%;border-radius:20px;">
                @else
                <div style="background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:20px;padding:50px;"><i class="fas fa-rocket" style="font-size:64px;color:rgba(255,255,255,0.3);"></i></div>
                @endif
            </div>
        </div>
    </div>
</section>
