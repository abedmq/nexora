{{-- CTA Template 1: Gradient centered --}}
<section style="padding:80px 0;background:linear-gradient(135deg,var(--primary),var(--primary-dark));text-align:center;color:#fff;">
    <div class="container">
        @if($section->title)<h2 style="font-size:32px;font-weight:700;margin-bottom:12px;">{{ $section->title }}</h2>@endif
        @if($section->subtitle)<p style="font-size:16px;opacity:0.9;margin-bottom:24px;max-width:500px;margin-left:auto;margin-right:auto;">{{ $section->subtitle }}</p>@endif
        @if(!empty($section->settings['button_text']))
        <a href="{{ $section->settings['button_url'] ?? '#' }}" style="background:#fff;color:var(--primary);border:none;padding:14px 36px;border-radius:12px;font-weight:700;font-size:15px;display:inline-block;transition:all 0.2s;">{{ $section->settings['button_text'] }}</a>
        @endif
    </div>
</section>
