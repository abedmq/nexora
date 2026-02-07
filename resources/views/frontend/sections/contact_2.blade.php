{{-- Contact Template 2: Simple centered --}}
<section style="padding:80px 0;background:var(--bg);">
    <div class="container" style="max-width:600px;">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-3 text-center mb-4">
            <div class="col-md-4"><i class="fas fa-map-marker-alt" style="font-size:24px;color:var(--primary);"></i><div style="font-size:13px;color:var(--text-muted);margin-top:4px;">{{ setting('company_address', '') }}</div></div>
            <div class="col-md-4"><i class="fas fa-phone" style="font-size:24px;color:var(--primary);"></i><div style="font-size:13px;color:var(--text-muted);margin-top:4px;" dir="ltr">{{ setting('company_phone', '') }}</div></div>
            <div class="col-md-4"><i class="fas fa-envelope" style="font-size:24px;color:var(--primary);"></i><div style="font-size:13px;color:var(--text-muted);margin-top:4px;">{{ setting('company_email', '') }}</div></div>
        </div>
        <div style="background:#fff;border-radius:16px;padding:28px;border:1px solid var(--border);">
            <div class="row g-3">
                <div class="col-md-6"><input type="text" class="form-control" placeholder="الاسم" style="border-radius:10px;"></div>
                <div class="col-md-6"><input type="email" class="form-control" placeholder="البريد" style="border-radius:10px;"></div>
                <div class="col-12"><textarea class="form-control" rows="3" placeholder="رسالتك..." style="border-radius:10px;"></textarea></div>
                <div class="col-12"><button class="btn btn-primary w-100">إرسال</button></div>
            </div>
        </div>
    </div>
</section>
