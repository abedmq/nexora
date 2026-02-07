{{-- Stats Template 1: Simple counters --}}
<section style="padding:60px 0;background:var(--bg);">
    <div class="container">
        @if($section->title)<div class="section-title"><h2>{{ $section->title }}</h2></div>@endif
        <div class="row g-4 text-center">
            @foreach($statItems as $item)
            <div class="col-6 col-md-3">
                <div style="padding:20px;">
                    <i class="{{ $item->icon }}" style="font-size:28px;color:var(--primary);margin-bottom:8px;"></i>
                    <div style="font-size:42px;font-weight:800;color:var(--primary);">{{ $item->value }}</div>
                    <div style="font-size:14px;color:var(--text-muted);">{{ $item->label }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
