{{-- Footer Template 2: Columns --}}
<footer style="background:#1e293b;color:#94a3b8;padding:48px 0 24px;font-size:13px;">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                    @if(setting('company_logo_dark') ?: setting('company_logo'))<img src="{{ asset(setting('company_logo_dark') ?: setting('company_logo')) }}" alt="" style="height:32px;">@endif
                    <span style="font-size:18px;font-weight:700;color:#fff;">{{ setting('company_name', 'نكسورا') }}</span>
                </div>
                <p style="color:#64748b;line-height:1.8;margin:0;">{{ setting('footer_description', '') }}</p>
            </div>
            <div class="col-lg-4">
                <h6 style="color:#fff;font-weight:600;margin-bottom:16px;">روابط سريعة</h6>
                @foreach($footerMenu as $item)
                <div style="margin-bottom:8px;"><a href="{{ $item->resolved_url }}" style="color:#94a3b8;transition:color 0.2s;" onmouseover="this.style.color='var(--primary-light)'" onmouseout="this.style.color='#94a3b8'">{{ $item->title }}</a></div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <h6 style="color:#fff;font-weight:600;margin-bottom:16px;">تواصل معنا</h6>
                @if(setting('company_address'))<div style="margin-bottom:8px;"><i class="fas fa-map-marker-alt me-2" style="color:var(--primary);width:16px;"></i>{{ setting('company_address') }}</div>@endif
                @if(setting('company_phone'))<div style="margin-bottom:8px;"><i class="fas fa-phone me-2" style="color:var(--primary);width:16px;"></i><span dir="ltr">{{ setting('company_phone') }}</span></div>@endif
                @if(setting('company_email'))<div style="margin-bottom:8px;"><i class="fas fa-envelope me-2" style="color:var(--primary);width:16px;"></i>{{ setting('company_email') }}</div>@endif
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:16px;text-align:center;color:#64748b;">
            &copy; {{ date('Y') }} {{ setting('company_name', 'نكسورا') }}. جميع الحقوق محفوظة.
        </div>
    </div>
</footer>
