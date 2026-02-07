{{-- Testimonials Template 1: Cards grid --}}
<section style="padding:80px 0;background:var(--bg-alt);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-4">
            @foreach($testimonials as $t)
            <div class="col-md-6 col-lg-4">
                <div style="background:#fff;border-radius:16px;padding:28px 24px;border:1px solid var(--border);height:100%;">
                    <div style="color:#f59e0b;margin-bottom:12px;">
                        @for($i=1;$i<=5;$i++)<i class="fas fa-star {{ $i <= $t->rating ? '' : 'opacity-25' }}" style="font-size:13px;"></i>@endfor
                    </div>
                    <p style="font-size:14px;color:var(--text);line-height:1.8;margin-bottom:16px;">{{ $t->content }}</p>
                    <div style="display:flex;align-items:center;gap:12px;border-top:1px solid var(--border);padding-top:14px;">
                        <img src="{{ $t->avatar ? asset($t->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($t->name).'&background=7c3aed&color=fff&rounded=true&size=40' }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                        <div>
                            <div style="font-weight:600;font-size:14px;">{{ $t->name }}</div>
                            <div style="font-size:12px;color:var(--text-muted);">{{ $t->position }}{{ $t->company ? ' - '.$t->company : '' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
