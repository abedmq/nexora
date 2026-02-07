{{-- Testimonials Template 2: Large centered quotes --}}
<section style="padding:80px 0;background:var(--bg);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($testimonials->take(3) as $t)
            <div class="col-lg-4">
                <div style="text-align:center;padding:32px 24px;background:var(--bg-alt);border-radius:20px;">
                    <i class="fas fa-quote-right" style="font-size:28px;color:var(--primary);opacity:0.3;margin-bottom:16px;"></i>
                    <p style="font-size:15px;color:var(--text);line-height:1.9;margin-bottom:20px;font-style:italic;">{{ $t->content }}</p>
                    <img src="{{ $t->avatar ? asset($t->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($t->name).'&background=7c3aed&color=fff&rounded=true&size=56' }}" style="width:56px;height:56px;border-radius:50%;margin-bottom:8px;object-fit:cover;">
                    <div style="font-weight:700;">{{ $t->name }}</div>
                    <div style="font-size:13px;color:var(--text-muted);">{{ $t->position }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
