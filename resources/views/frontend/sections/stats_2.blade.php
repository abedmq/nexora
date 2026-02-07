{{-- Stats Template 2: Dark background --}}
<section style="padding:60px 0;background:linear-gradient(135deg,#1e293b,#334155);color:#fff;">
    <div class="container">
        @if($section->title)<div class="section-title" style="margin-bottom:32px;"><h2 style="color:#fff;">{{ $section->title }}</h2></div>@endif
        <div class="row g-4 text-center">
            @foreach($statItems as $item)
            <div class="col-6 col-md-3">
                <div style="padding:24px;background:rgba(255,255,255,0.05);border-radius:16px;border:1px solid rgba(255,255,255,0.1);">
                    <i class="{{ $item->icon }}" style="font-size:24px;color:var(--primary-light);margin-bottom:8px;"></i>
                    <div style="font-size:36px;font-weight:800;color:#fff;">{{ $item->value }}</div>
                    <div style="font-size:13px;color:rgba(255,255,255,0.6);">{{ $item->label }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
