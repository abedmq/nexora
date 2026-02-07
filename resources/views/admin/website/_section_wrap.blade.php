{{-- Single section wrapper with overlay controls (used by AJAX) --}}
<div class="section-wrap {{ !$section->is_active ? 'is-disabled' : '' }}"
     data-id="{{ $section->id }}"
     data-type="{{ $section->type }}"
     data-template="{{ $section->template }}"
     id="section-{{ $section->id }}">
    <div class="sec-overlay">
        <span class="sec-label"><i class="{{ $section->type_icon }} me-1"></i> {{ $section->type_label }} — {{ $section->template_name }}</span>
        @if($section->manage_url)
        <a href="{{ $section->manage_url }}" target="_blank" class="sec-btn manage-sec-btn" title="إدارة العناصر"><i class="fas fa-external-link-alt"></i></a>
        @endif
        <button class="sec-btn edit-sec-btn" title="تعديل"><i class="fas fa-cog"></i></button>
        <button class="sec-btn toggle-sec-btn" title="{{ $section->is_active ? 'تعطيل' : 'تفعيل' }}"><i class="fas {{ $section->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i></button>
        <button class="sec-btn move-up-btn" title="نقل للأعلى"><i class="fas fa-arrow-up"></i></button>
        <button class="sec-btn move-down-btn" title="نقل للأسفل"><i class="fas fa-arrow-down"></i></button>
        <button class="sec-btn danger delete-sec-btn" title="حذف"><i class="fas fa-trash"></i></button>
    </div>
    @include('frontend.sections.' . $section->type . '_' . $section->template, [
        'section' => $section,
        'features' => $features ?? collect(),
        'services' => $services ?? collect(),
        'statItems' => $statItems ?? collect(),
        'testimonials' => $testimonials ?? collect(),
        'partners' => $partners ?? collect(),
        'faqItems' => $faqItems ?? collect(),
        'sliderItems' => $sliderItems ?? collect(),
    ])
</div>
