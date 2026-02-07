{{-- Testimonials Template 3: Carousel style (single view) --}}
<section style="padding:80px 0;background:linear-gradient(135deg,#f5f3ff,#ede9fe);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($testimonials as $i => $t)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <div style="max-width:700px;margin:0 auto;text-align:center;padding:20px;">
                        <img src="{{ $t->avatar ? asset($t->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($t->name).'&background=7c3aed&color=fff&rounded=true&size=72' }}" style="width:72px;height:72px;border-radius:50%;margin-bottom:16px;border:3px solid var(--primary);object-fit:cover;">
                        <p style="font-size:18px;line-height:1.9;color:var(--text);margin-bottom:20px;">{{ $t->content }}</p>
                        <div style="font-weight:700;font-size:16px;">{{ $t->name }}</div>
                        <div style="font-size:14px;color:var(--text-muted);">{{ $t->position }}{{ $t->company ? ' - '.$t->company : '' }}</div>
                        <div style="color:#f59e0b;margin-top:8px;">@for($s=1;$s<=5;$s++)<i class="fas fa-star {{ $s<=$t->rating ? '' : 'opacity-25' }}"></i>@endfor</div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($testimonials->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" style="filter:invert(0.5);"></span></button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" style="filter:invert(0.5);"></span></button>
            @endif
        </div>
    </div>
</section>
