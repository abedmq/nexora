{{-- Hero Template 1: Centered with gradient --}}
<section style="background:linear-gradient(135deg,#f5f3ff 0%,#ede9fe 50%,#ddd6fe 100%);padding:100px 0;text-align:center;">
    <div class="container">
        @if($section->title)<h1 style="font-size:48px;font-weight:800;color:#1e293b;margin-bottom:16px;">{{ $section->title }}</h1>@endif
        @if($section->subtitle)<p style="font-size:18px;color:#64748b;max-width:600px;margin:0 auto 32px;line-height:1.8;">{{ $section->subtitle }}</p>@endif
        @if($section->content)<div style="font-size:16px;color:#64748b;max-width:700px;margin:0 auto 24px;">{!! $section->content !!}</div>@endif
        @if(!empty($section->settings['button_text']))
        <a href="{{ $section->settings['button_url'] ?? '#' }}" class="btn btn-primary btn-lg">{{ $section->settings['button_text'] }}</a>
        @endif
    </div>
</section>
