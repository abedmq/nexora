{{-- Features Template 1: Icon cards grid --}}
<section style="padding:80px 0;background:var(--bg-alt);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-4">
            @foreach($features as $item)
            <div class="col-md-6 col-lg-4">
                <div style="background:#fff;border-radius:16px;padding:28px 24px;text-align:center;border:1px solid var(--border);transition:all 0.3s;height:100%;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,0.08)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <i class="{{ $item->icon ?? 'fas fa-star' }}" style="font-size:36px;color:var(--primary);margin-bottom:16px;"></i>
                    <h5 style="font-weight:600;margin-bottom:8px;">{{ $item->title }}</h5>
                    <p style="font-size:14px;color:var(--text-muted);margin:0;">{{ $item->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
