{{-- Features Template 2: Horizontal cards --}}
<section style="padding:80px 0;background:var(--bg);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-4">
            @foreach($features as $item)
            <div class="col-md-6">
                <div style="display:flex;gap:16px;padding:24px;border:1px solid var(--border);border-radius:16px;background:#fff;height:100%;">
                    <div style="width:50px;height:50px;background:rgba(124,58,237,0.1);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="{{ $item->icon ?? 'fas fa-star' }}" style="font-size:20px;color:var(--primary);"></i>
                    </div>
                    <div>
                        <h5 style="font-weight:600;margin-bottom:4px;font-size:16px;">{{ $item->title }}</h5>
                        <p style="font-size:14px;color:var(--text-muted);margin:0;">{{ $item->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
