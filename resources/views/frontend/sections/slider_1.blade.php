{{-- Slider Template 1: Full-width slider with overlay text --}}
<section style="position:relative;overflow:hidden;">
    <div id="sliderCarousel{{ $section->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            @foreach($sliderItems as $i => $slide)
            <button type="button" data-bs-target="#sliderCarousel{{ $section->id }}" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" style="width:12px;height:12px;border-radius:50%;border:2px solid #fff;opacity:{{ $i === 0 ? '1' : '0.5' }};"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($sliderItems as $i => $slide)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                <div style="position:relative;height:500px;background:{{ $slide->image ? 'url('.asset($slide->image).')' : 'linear-gradient(135deg,var(--primary),var(--primary-dark))' }};background-size:cover;background-position:center;">
                    <div style="position:absolute;inset:0;background:rgba(0,0,0,0.45);display:flex;align-items:center;justify-content:center;">
                        <div style="text-align:center;color:#fff;max-width:700px;padding:0 24px;">
                            @if($slide->title)<h2 style="font-size:42px;font-weight:800;margin-bottom:12px;text-shadow:0 2px 8px rgba(0,0,0,0.3);">{{ $slide->title }}</h2>@endif
                            @if($slide->subtitle)<p style="font-size:18px;opacity:0.9;margin-bottom:24px;text-shadow:0 1px 4px rgba(0,0,0,0.2);">{{ $slide->subtitle }}</p>@endif
                            @if($slide->button_text)<a href="{{ $slide->button_url ?? '#' }}" class="btn btn-primary btn-lg">{{ $slide->button_text }}</a>@endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if($sliderItems->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#sliderCarousel{{ $section->id }}" data-bs-slide="prev" style="width:60px;">
            <span style="background:rgba(255,255,255,0.2);width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);"><i class="fas fa-chevron-right" style="color:#fff;font-size:16px;"></i></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#sliderCarousel{{ $section->id }}" data-bs-slide="next" style="width:60px;">
            <span style="background:rgba(255,255,255,0.2);width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);"><i class="fas fa-chevron-left" style="color:#fff;font-size:16px;"></i></span>
        </button>
        @endif
    </div>
</section>
