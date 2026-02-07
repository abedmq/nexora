{{-- Footer Template 1: Simple --}}
<footer style="background:#1e293b;color:#94a3b8;padding:24px 0;text-align:center;font-size:13px;">
    <div class="container">
        @if($footerMenu->count() > 0)
        <div style="display:flex;flex-wrap:wrap;gap:16px;justify-content:center;margin-bottom:12px;">
            @foreach($footerMenu as $item)
            <a href="{{ $item->resolved_url }}" style="color:#94a3b8;transition:color 0.2s;" onmouseover="this.style.color='var(--primary-light)'" onmouseout="this.style.color='#94a3b8'">{{ $item->title }}</a>
            @endforeach
        </div>
        @endif
        <div>&copy; {{ date('Y') }} {{ setting('company_name', 'نكسورا') }}. جميع الحقوق محفوظة.</div>
    </div>
</footer>
