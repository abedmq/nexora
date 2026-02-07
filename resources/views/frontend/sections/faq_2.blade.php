{{-- FAQ Template 2: Two columns --}}
<section style="padding:80px 0;background:var(--bg);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-4">
            @foreach($faqItems as $item)
            <div class="col-md-6">
                <div style="padding:20px;border-right:3px solid var(--primary);background:var(--bg-alt);border-radius:0 12px 12px 0;">
                    <h6 style="font-weight:600;margin-bottom:6px;color:var(--dark);">{{ $item->question }}</h6>
                    <p style="font-size:14px;color:var(--text-muted);margin:0;line-height:1.7;">{{ $item->answer }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
