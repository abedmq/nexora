{{-- Hero Template 3: Full background with overlay --}}
@php $bgImg = $section->settings['bg_image'] ?? ''; @endphp
<section style="background:linear-gradient(rgba(30,41,59,0.85),rgba(30,41,59,0.9)){{ $bgImg ? ',url('.$bgImg.')' : '' }};background-size:cover;background-position:center;padding:120px 0;text-align:center;color:#fff;">
    <div class="container">
        @if($section->title)<h1 style="font-size:48px;font-weight:800;margin-bottom:16px;">{{ $section->title }}</h1>@endif
        @if($section->subtitle)<p style="font-size:18px;opacity:0.85;max-width:600px;margin:0 auto 32px;line-height:1.8;">{{ $section->subtitle }}</p>@endif
        @if(!empty($section->settings['button_text']))
        <a href="{{ $section->settings['button_url'] ?? '#' }}" class="btn btn-primary btn-lg">{{ $section->settings['button_text'] }}</a>
        @endif
    </div>
</section>
