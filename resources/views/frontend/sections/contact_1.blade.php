{{-- Contact Template 1: Info + Form --}}
<section style="padding:80px 0;background:var(--bg-alt);">
    <div class="container">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="row g-5">
            <div class="col-lg-5">
                <div style="padding:32px;background:var(--primary);color:#fff;border-radius:20px;height:100%;">
                    <h4 style="font-weight:700;margin-bottom:24px;">معلومات التواصل</h4>
                    <div style="display:flex;gap:12px;margin-bottom:20px;align-items:center;">
                        <i class="fas fa-map-marker-alt" style="font-size:18px;opacity:0.8;width:20px;"></i>
                        <span>{{ setting('company_address', 'الرياض، المملكة العربية السعودية') }}</span>
                    </div>
                    <div style="display:flex;gap:12px;margin-bottom:20px;align-items:center;">
                        <i class="fas fa-phone" style="font-size:18px;opacity:0.8;width:20px;"></i>
                        <span dir="ltr">{{ setting('company_phone', '0501234567') }}</span>
                    </div>
                    <div style="display:flex;gap:12px;margin-bottom:20px;align-items:center;">
                        <i class="fas fa-envelope" style="font-size:18px;opacity:0.8;width:20px;"></i>
                        <span>{{ setting('company_email', 'info@nexora.com') }}</span>
                    </div>
                    <div style="display:flex;gap:12px;margin-top:32px;">
                        @if(setting('social_twitter'))<a href="{{ setting('social_twitter') }}" style="width:36px;height:36px;background:rgba(255,255,255,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;"><i class="fab fa-twitter"></i></a>@endif
                        @if(setting('social_instagram'))<a href="{{ setting('social_instagram') }}" style="width:36px;height:36px;background:rgba(255,255,255,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;"><i class="fab fa-instagram"></i></a>@endif
                        @if(setting('social_linkedin'))<a href="{{ setting('social_linkedin') }}" style="width:36px;height:36px;background:rgba(255,255,255,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;"><i class="fab fa-linkedin-in"></i></a>@endif
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div style="background:#fff;border-radius:20px;padding:32px;border:1px solid var(--border);">
                    <div class="row g-3">
                        <div class="col-md-6"><input type="text" class="form-control" placeholder="الاسم" style="border-radius:10px;padding:12px;"></div>
                        <div class="col-md-6"><input type="email" class="form-control" placeholder="البريد الإلكتروني" style="border-radius:10px;padding:12px;"></div>
                        <div class="col-12"><input type="text" class="form-control" placeholder="الموضوع" style="border-radius:10px;padding:12px;"></div>
                        <div class="col-12"><textarea class="form-control" rows="4" placeholder="رسالتك..." style="border-radius:10px;padding:12px;"></textarea></div>
                        <div class="col-12"><button class="btn btn-primary w-100">إرسال الرسالة</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
