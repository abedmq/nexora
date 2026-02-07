{{-- Partners Template 2: Cards grid --}}
<section style="padding:60px 0;background:var(--bg-alt);">
    <div class="container">
        @if($section->title)<div class="section-title"><h2>{{ $section->title }}</h2>@if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif</div>@endif
        <div class="row g-3 justify-content-center">
            @foreach($partners as $p)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ $p->url ?: '#' }}" target="{{ $p->url ? '_blank' : '_self' }}" style="display:flex;align-items:center;justify-content:center;padding:24px 16px;background:#fff;border-radius:12px;border:1px solid var(--border);height:100%;transition:all 0.3s;" onmouseover="this.style.borderColor='var(--primary)';this.style.boxShadow='0 4px 16px rgba(124,58,237,0.1)'" onmouseout="this.style.borderColor='var(--border)';this.style.boxShadow=''">
                    @if($p->logo)
                    <img src="{{ asset($p->logo) }}" alt="{{ $p->name }}" style="max-height:40px;max-width:100px;object-fit:contain;">
                    @else
                    <span style="font-weight:600;color:var(--text-muted);font-size:14px;">{{ $p->name }}</span>
                    @endif
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
