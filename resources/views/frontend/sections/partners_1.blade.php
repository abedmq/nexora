{{-- Partners Template 1: Logo row --}}
<section style="padding:60px 0;background:var(--bg);">
    <div class="container">
        @if($section->title)<div class="section-title"><h2>{{ $section->title }}</h2>@if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif</div>@endif
        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:40px;">
            @foreach($partners as $p)
            <a href="{{ $p->url ?: '#' }}" target="{{ $p->url ? '_blank' : '_self' }}" style="opacity:0.5;transition:opacity 0.3s;filter:grayscale(100%);" onmouseover="this.style.opacity='1';this.style.filter=''" onmouseout="this.style.opacity='0.5';this.style.filter='grayscale(100%)'">
                @if($p->logo)
                <img src="{{ asset($p->logo) }}" alt="{{ $p->name }}" style="max-height:48px;max-width:120px;object-fit:contain;">
                @else
                <span style="font-size:16px;font-weight:600;color:var(--text-muted);">{{ $p->name }}</span>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</section>
