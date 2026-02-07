{{-- FAQ Template 1: Accordion --}}
<section style="padding:80px 0;background:var(--bg-alt);">
    <div class="container" style="max-width:800px;">
        <div class="section-title">
            @if($section->title)<h2>{{ $section->title }}</h2>@endif
            @if($section->subtitle)<p>{{ $section->subtitle }}</p>@endif
        </div>
        <div class="accordion" id="faqAccordion{{ $section->id }}">
            @foreach($faqItems as $i => $item)
            <div class="accordion-item" style="border:1px solid var(--border);border-radius:12px;margin-bottom:8px;overflow:hidden;">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $loop->index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $section->id }}_{{ $loop->index }}" style="font-weight:600;font-size:15px;font-family:Cairo,sans-serif;">
                        {{ $item->question }}
                    </button>
                </h2>
                <div id="faq{{ $section->id }}_{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#faqAccordion{{ $section->id }}">
                    <div class="accordion-body" style="font-size:14px;color:var(--text-muted);line-height:1.8;">
                        {{ $item->answer }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
