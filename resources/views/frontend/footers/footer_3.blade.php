{{-- Footer Template 3: With social --}}
<footer style="background:#1e293b;color:#94a3b8;padding:48px 0 24px;font-size:13px;">
    <div class="container text-center">
        <div style="margin-bottom:20px;">
            @if(setting('company_logo_dark') ?: setting('company_logo'))<img src="{{ asset(setting('company_logo_dark') ?: setting('company_logo')) }}" alt="" style="height:40px;margin-bottom:8px;display:block;margin-left:auto;margin-right:auto;">@endif
            <span style="font-size:20px;font-weight:700;color:#fff;">{{ setting('company_name', 'نكسورا') }}</span>
        </div>
        @if(setting('footer_description'))
        <p style="color:#64748b;max-width:500px;margin:0 auto 24px;line-height:1.8;">{{ setting('footer_description') }}</p>
        @endif

        @if($footerMenu->count() > 0)
        <div style="display:flex;flex-wrap:wrap;gap:16px;justify-content:center;margin-bottom:24px;">
            @foreach($footerMenu as $item)
            <a href="{{ $item->resolved_url }}" style="color:#94a3b8;transition:color 0.2s;" onmouseover="this.style.color='var(--primary-light)'" onmouseout="this.style.color='#94a3b8'">{{ $item->title }}</a>
            @endforeach
        </div>
        @endif

        <div style="display:flex;gap:12px;justify-content:center;margin-bottom:24px;">
            @if(setting('social_twitter'))<a href="{{ setting('social_twitter') }}" style="width:40px;height:40px;background:rgba(255,255,255,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#94a3b8;transition:all 0.2s;" onmouseover="this.style.background='var(--primary)';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='#94a3b8'"><i class="fab fa-twitter"></i></a>@endif
            @if(setting('social_instagram'))<a href="{{ setting('social_instagram') }}" style="width:40px;height:40px;background:rgba(255,255,255,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#94a3b8;transition:all 0.2s;" onmouseover="this.style.background='var(--primary)';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='#94a3b8'"><i class="fab fa-instagram"></i></a>@endif
            @if(setting('social_linkedin'))<a href="{{ setting('social_linkedin') }}" style="width:40px;height:40px;background:rgba(255,255,255,0.08);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#94a3b8;transition:all 0.2s;" onmouseover="this.style.background='var(--primary)';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='#94a3b8'"><i class="fab fa-linkedin-in"></i></a>@endif
        </div>

        <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:16px;color:#64748b;">
            &copy; {{ date('Y') }} {{ setting('company_name', 'نكسورا') }}. جميع الحقوق محفوظة.
        </div>
    </div>
</footer>
