{{-- Services Template 1: Cards with hover --}}
<section style="padding:80px 0;background:var(--bg);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-4">
            @foreach($services as $item)
            <div class="col-md-6 col-lg-4">
                <div style="background:var(--bg-alt);border-radius:16px;padding:32px 24px;text-align:center;transition:all 0.3s;height:100%;border:1px solid transparent;" onmouseover="this.style.background='#fff';this.style.borderColor='var(--primary)';this.style.boxShadow='0 12px 32px rgba(124,58,237,0.1)'" onmouseout="this.style.background='var(--bg-alt)';this.style.borderColor='transparent';this.style.boxShadow=''">
                    <div style="width:64px;height:64px;background:rgba(124,58,237,0.1);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                        <i class="{{ $item->icon ?? 'fas fa-concierge-bell' }}" style="font-size:24px;color:var(--primary);"></i>
                    </div>
                    <h5 style="font-weight:600;margin-bottom:8px;">{{ $item->title }}</h5>
                    <p style="font-size:14px;color:var(--text-muted);margin:0;">{{ $item->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
