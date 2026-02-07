{{-- Footer Template 4: With newsletter --}}
<footer style="font-size:13px;">
    {{-- Newsletter Bar --}}
    <div style="background:linear-gradient(135deg,var(--primary),var(--primary-dark));padding:40px 0;color:#fff;text-align:center;">
        <div class="container">
            <h4 style="font-weight:700;margin-bottom:8px;">اشترك في النشرة البريدية</h4>
            <p style="opacity:0.8;margin-bottom:20px;">احصل على آخر الأخبار والعروض مباشرة في بريدك</p>
            <div style="max-width:480px;margin:0 auto;display:flex;gap:8px;">
                <input type="email" placeholder="بريدك الإلكتروني..." style="flex:1;padding:12px 16px;border-radius:12px;border:none;font-family:Cairo,sans-serif;font-size:14px;">
                <button style="padding:12px 24px;background:#fff;color:var(--primary);border:none;border-radius:12px;font-weight:700;cursor:pointer;font-family:Cairo,sans-serif;">اشترك</button>
            </div>
        </div>
    </div>

    {{-- Footer Content --}}
    <div style="background:#1e293b;color:#94a3b8;padding:40px 0 20px;">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                        @if(setting('company_logo_dark') ?: setting('company_logo'))<img src="{{ asset(setting('company_logo_dark') ?: setting('company_logo')) }}" alt="" style="height:32px;">@endif
                        <span style="font-size:18px;font-weight:700;color:#fff;">{{ setting('company_name', 'نكسورا') }}</span>
                    </div>
                    <p style="color:#64748b;line-height:1.8;">{{ setting('footer_description', '') }}</p>
                    <div style="display:flex;gap:8px;margin-top:16px;">
                        @if(setting('social_twitter'))<a href="{{ setting('social_twitter') }}" style="width:32px;height:32px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;"><i class="fab fa-twitter"></i></a>@endif
                        @if(setting('social_instagram'))<a href="{{ setting('social_instagram') }}" style="width:32px;height:32px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;"><i class="fab fa-instagram"></i></a>@endif
                        @if(setting('social_linkedin'))<a href="{{ setting('social_linkedin') }}" style="width:32px;height:32px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;"><i class="fab fa-linkedin-in"></i></a>@endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <h6 style="color:#fff;font-weight:600;margin-bottom:16px;">روابط</h6>
                    @foreach($footerMenu as $item)
                    <div style="margin-bottom:8px;"><a href="{{ $item->resolved_url }}" style="color:#94a3b8;">{{ $item->title }}</a></div>
                    @endforeach
                </div>
                <div class="col-lg-4">
                    <h6 style="color:#fff;font-weight:600;margin-bottom:16px;">تواصل معنا</h6>
                    @if(setting('company_address'))<div style="margin-bottom:8px;"><i class="fas fa-map-marker-alt me-2" style="color:var(--primary);"></i>{{ setting('company_address') }}</div>@endif
                    @if(setting('company_phone'))<div style="margin-bottom:8px;"><i class="fas fa-phone me-2" style="color:var(--primary);"></i><span dir="ltr">{{ setting('company_phone') }}</span></div>@endif
                    @if(setting('company_email'))<div style="margin-bottom:8px;"><i class="fas fa-envelope me-2" style="color:var(--primary);"></i>{{ setting('company_email') }}</div>@endif
                </div>
            </div>
            <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:16px;text-align:center;color:#64748b;">
                &copy; {{ date('Y') }} {{ setting('company_name', 'نكسورا') }}. جميع الحقوق محفوظة.
            </div>
        </div>
    </div>
</footer>
