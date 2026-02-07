{{-- Services Template 2: Bordered cards --}}
@php $colors = [setting('theme_color_primary', '#7c3aed'),'#ec4899','#3b82f6','#10b981','#f59e0b','#ef4444']; @endphp
<section style="padding:80px 0;background:var(--bg-alt);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-4">
            @foreach($services as $i => $item)
            <div class="col-md-6 col-lg-4">
                <div style="background:#fff;border-radius:16px;padding:28px 24px;border-top:4px solid {{ $colors[$loop->index % count($colors)] }};box-shadow:0 2px 12px rgba(0,0,0,0.04);height:100%;">
                    <i class="{{ $item->icon ?? 'fas fa-concierge-bell' }}" style="font-size:28px;color:{{ $colors[$loop->index % count($colors)] }};margin-bottom:14px;"></i>
                    <h5 style="font-weight:600;margin-bottom:8px;">{{ $item->title }}</h5>
                    <p style="font-size:14px;color:var(--text-muted);margin:0;">{{ $item->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
