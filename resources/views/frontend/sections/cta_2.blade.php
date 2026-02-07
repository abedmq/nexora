{{-- CTA Template 2: Card style --}}
<section style="padding:60px 0;background:var(--bg);">
    <div class="container">
        <div style="background:linear-gradient(135deg,#f5f3ff,#ede9fe);border-radius:24px;padding:60px 40px;text-align:center;">
            @if($section->title)<h2 style="font-size:28px;font-weight:700;color:var(--dark);margin-bottom:12px;">{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p style="color:var(--text-muted);margin-bottom:24px;">{{ $section->subtitle }}</p>@endif
            @if(!empty($section->settings['button_text']))
            <a href="{{ $section->settings['button_url'] ?? '#' }}" class="btn btn-primary">{{ $section->settings['button_text'] }}</a>
            @endif
        </div>
    </div>
</section>
