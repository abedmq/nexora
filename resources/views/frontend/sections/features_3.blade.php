{{-- Features Template 3: Numbered list --}}
<section style="padding:80px 0;background:var(--bg-alt);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                @if($section->title)<h2 style="font-size:32px;font-weight:700;color:var(--dark);margin-bottom:12px;">{{ $section->title }}</h2>@endif
                @if($section->subtitle)<p style="color:var(--text-muted);line-height:1.8;">{{ $section->subtitle }}</p>@endif
            </div>
            <div class="col-lg-7">
                @foreach($features as $i => $item)
                <div style="display:flex;gap:16px;margin-bottom:20px;padding:20px;background:#fff;border-radius:12px;border:1px solid var(--border);">
                    <div style="width:40px;height:40px;background:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;flex-shrink:0;">{{ $loop->iteration }}</div>
                    <div>
                        <h6 style="font-weight:600;margin-bottom:4px;">{{ $item->title }}</h6>
                        <p style="font-size:13px;color:var(--text-muted);margin:0;">{{ $item->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
