{{-- Slider Template 2: Contained rounded slider --}}
<section style="padding:60px 0;background:var(--bg-alt);">
    <div class="container">
        @if($section->title || $section->subtitle)
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        @endif
        <div id="sliderContained{{ $section->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000" style="border-radius:20px;overflow:hidden;box-shadow:0 12px 40px rgba(0,0,0,0.12);">
            <div class="carousel-indicators" style="margin-bottom:12px;">
                @foreach($sliderItems as $i => $slide)
                <button type="button" data-bs-target="#sliderContained{{ $section->id }}" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" style="width:10px;height:10px;border-radius:50%;border:2px solid #fff;opacity:{{ $i === 0 ? '1' : '0.5' }};"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach($sliderItems as $i => $slide)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <div style="position:relative;height:400px;background:{{ $slide->image ? 'url('.asset($slide->image).')' : 'linear-gradient(135deg,var(--primary),var(--primary-light))' }};background-size:cover;background-position:center;">
                        <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.6) 0%,transparent 60%);display:flex;align-items:flex-end;padding:40px;">
                            <div style="color:#fff;">
                                @if($slide->title)<h3 style="font-size:28px;font-weight:700;margin-bottom:8px;">{{ $slide->title }}</h3>@endif
                                @if($slide->subtitle)<p style="font-size:15px;opacity:0.85;margin-bottom:16px;">{{ $slide->subtitle }}</p>@endif
                                @if($slide->button_text)<a href="{{ $slide->button_url ?? '#' }}" style="display:inline-block;background:var(--primary);color:#fff;padding:10px 24px;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;">{{ $slide->button_text }}</a>@endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($sliderItems->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#sliderContained{{ $section->id }}" data-bs-slide="prev" style="width:50px;">
                <span style="background:rgba(255,255,255,0.15);width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);"><i class="fas fa-chevron-right" style="color:#fff;font-size:14px;"></i></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#sliderContained{{ $section->id }}" data-bs-slide="next" style="width:50px;">
                <span style="background:rgba(255,255,255,0.15);width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);"><i class="fas fa-chevron-left" style="color:#fff;font-size:14px;"></i></span>
            </button>
            @endif
        </div>
    </div>
</section>
