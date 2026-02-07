@extends('admin.layouts.app')

@section('title', 'تصميم الصفحة الرئيسية')
@section('page-title', 'الصفحة الرئيسية')
@section('breadcrumb')@endsection

@section('styles')
{{-- Frontend CSS for preview --}}
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* ===== Hide admin sidebar + go full-width ===== */
    body.builder-page .nx-sidebar,
    body.builder-page .sidebar-overlay { display:none !important; }
    body.builder-page .nx-main { margin-right:0 !important; }
    body.builder-page .nx-content { padding:0; }
    body.builder-page .nx-breadcrumb { display:none; }
    body.builder-page .nx-footer { display:none; }
    body.builder-page .nx-navbar { padding-right:16px; }

    /* ===== Builder Layout ===== */
    .builder-layout { display:flex; height:calc(100vh - 56px); }

    /* Builder Sidebar (section types) */
    .builder-sidebar {
        width:260px; flex-shrink:0; background:var(--nx-card-bg,#fff);
        border-left:1px solid var(--nx-border); display:flex; flex-direction:column;
        overflow-y:auto; z-index:10;
    }
    .builder-sidebar .bs-header {
        padding:14px 16px; border-bottom:1px solid var(--nx-border);
        display:flex; align-items:center; justify-content:space-between;
    }
    .builder-sidebar .bs-header h6 { margin:0; font-size:14px; font-weight:700; }
    .builder-sidebar .bs-body { flex:1; overflow-y:auto; padding:12px; }

    .add-sec-btn {
        display:flex; align-items:center; gap:8px; padding:9px 12px; width:100%;
        border:1px solid var(--nx-border); border-radius:8px; cursor:pointer;
        transition:all 0.15s; background:transparent; font-size:12px; font-weight:500;
        text-align:right; margin-bottom:6px; color:var(--nx-text);
    }
    .add-sec-btn:hover { border-color:var(--nx-primary); background:rgba(124,58,237,0.04); }
    .add-sec-btn i.si { color:var(--nx-primary); width:16px; text-align:center; font-size:13px; }

    /* Builder Preview */
    .builder-preview {
        flex:1; overflow-y:auto; background:#f8fafc; position:relative;
    }

    /* Frontend CSS variables for preview */
    .builder-preview {
        --primary:{{ setting('theme_color_primary', '#7c3aed') }};
        --primary-light:{{ setting('theme_color_light', '#a78bfa') }};
        --primary-dark:{{ setting('theme_color_dark', '#6d28d9') }};
        --primary-accent:{{ setting('theme_color_accent', '#f3f0ff') }};
        --dark:#1e293b; --text:#334155; --text-muted:#64748b;
        --bg:#ffffff; --bg-alt:#f8fafc; --border:#e2e8f0;
        font-family:'Cairo',sans-serif; color:var(--text);
    }
    .builder-preview .btn-primary {
        background:var(--primary) !important; border:none !important; padding:12px 28px;
        border-radius:12px; font-size:15px; font-weight:600; color:#fff !important;
    }
    .builder-preview .section-title { text-align:center; margin-bottom:40px; }
    .builder-preview .section-title h2 { font-size:32px; font-weight:700; color:var(--dark); margin-bottom:8px; }
    .builder-preview .section-title p { font-size:16px; color:var(--text-muted); max-width:600px; margin:0 auto; }

    /* Section Divider in builder */
    .builder-preview .nx-section-divider svg { fill:var(--bg,#fff); }

    /* Section Wrapper + Overlay Controls */
    .section-wrap {
        position:relative; transition:outline 0.15s;
        outline:2px solid transparent; outline-offset:-2px;
    }
    .section-wrap:hover { outline-color:rgba(124,58,237,0.5); }
    .section-wrap:hover .sec-overlay { opacity:1; pointer-events:auto; }
    .section-wrap.is-disabled { opacity:0.35; }

    .sec-overlay {
        position:absolute; top:10px; left:10px; z-index:20;
        display:flex; align-items:center; gap:4px;
        opacity:0; pointer-events:none; transition:opacity 0.2s;
    }
    .sec-overlay .sec-label {
        background:rgba(30,41,59,0.85); color:#fff; font-size:11px; font-weight:600;
        padding:4px 10px; border-radius:6px; white-space:nowrap; backdrop-filter:blur(4px);
    }
    .sec-overlay .sec-btn {
        width:30px; height:30px; border-radius:6px; border:none; cursor:pointer;
        display:flex; align-items:center; justify-content:center; font-size:12px;
        background:rgba(255,255,255,0.95); color:#334155; box-shadow:0 2px 8px rgba(0,0,0,0.15);
        transition:all 0.15s; backdrop-filter:blur(4px);
    }
    .sec-overlay .sec-btn:hover { background:#fff; color:var(--nx-primary); transform:scale(1.1); }
    .sec-overlay .sec-btn.danger:hover { color:#ef4444; }
    .sec-overlay a.sec-btn.manage-sec-btn { background:rgba(124,58,237,0.9); color:#fff; text-decoration:none; }
    .sec-overlay a.sec-btn.manage-sec-btn:hover { background:var(--nx-primary); color:#fff; transform:scale(1.1); }

    /* Add Section Drop Zone */
    .add-section-zone {
        padding:40px 20px; text-align:center; border:2px dashed var(--nx-border);
        margin:20px; border-radius:16px; background:rgba(124,58,237,0.02);
    }
    .add-section-zone i { font-size:36px; color:var(--nx-text-muted); opacity:0.3; }

    /* Edit Section Modal */
    .template-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:10px; }
    .template-option {
        border:2px solid var(--nx-border); border-radius:10px; padding:0; text-align:center;
        cursor:pointer; transition:all 0.2s; font-size:11px; overflow:hidden;
    }
    .template-option:hover { border-color:var(--nx-primary); box-shadow:0 2px 12px rgba(124,58,237,0.1); }
    .template-option.selected { border-color:var(--nx-primary); background:rgba(124,58,237,0.04); box-shadow:0 2px 12px rgba(124,58,237,0.15); }
    .template-option .tpl-preview { padding:8px 10px 4px; }
    .template-option .tpl-preview svg { width:100%; height:auto; border-radius:4px; }
    .template-option .tpl-info { padding:6px 8px 8px; border-top:1px solid var(--nx-border); }
    .template-option.selected .tpl-info { border-top-color:rgba(124,58,237,0.2); }
    .template-option .tpl-name { font-size:12px; font-weight:700; color:var(--nx-text); margin-bottom:2px; }
    .template-option.selected .tpl-name { color:var(--nx-primary); }
    .template-option .tpl-desc { font-size:10px; color:var(--nx-text-muted); line-height:1.3; }
    .template-option .tpl-badge { display:inline-block; font-size:9px; background:rgba(124,58,237,0.08); color:var(--nx-primary); padding:1px 6px; border-radius:4px; margin-top:3px; }
    .template-option.selected .tpl-badge { background:var(--nx-primary); color:#fff; }

    @media (max-width:992px) {
        .builder-layout { flex-direction:column; height:auto; }
        .builder-sidebar { width:100%; height:auto; max-height:200px; border-left:none; border-bottom:1px solid var(--nx-border); }
    }
</style>
@endsection

@section('content')
<div class="builder-layout">

    {{-- ===== Sidebar: Section Types ===== --}}
    <div class="builder-sidebar">
        <div class="bs-header">
            <h6><i class="fas fa-puzzle-piece me-2"></i> الأقسام</h6>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-nx-secondary" style="font-size:11px;padding:3px 10px;">
                <i class="fas fa-arrow-right me-1"></i> العودة
            </a>
        </div>
        <div class="bs-body">
            <div class="text-muted mb-2" style="font-size:11px;font-weight:600;">إضافة قسم جديد</div>
            @foreach($sectionTypes as $type => $info)
            <button class="add-sec-btn" data-type="{{ $type }}" data-templates="{{ $info['templates'] }}" data-label="{{ $info['label'] }}" data-icon="{{ $info['icon'] }}">
                <i class="{{ $info['icon'] }} si"></i>
                <span>{{ $info['label'] }}</span>
            </button>
            @endforeach

            <hr style="margin:16px 0;border-color:var(--nx-border);">
            <div class="text-muted mb-2" style="font-size:11px;font-weight:600;">إدارة البيانات</div>
            <a href="{{ route('admin.website.features') }}" class="add-sec-btn" style="text-decoration:none;"><i class="fas fa-star si"></i><span>المميزات</span><i class="fas fa-external-link-alt ms-auto" style="font-size:10px;opacity:0.4;"></i></a>
            <a href="{{ route('admin.website.services') }}" class="add-sec-btn" style="text-decoration:none;"><i class="fas fa-concierge-bell si"></i><span>الخدمات</span><i class="fas fa-external-link-alt ms-auto" style="font-size:10px;opacity:0.4;"></i></a>
            <a href="{{ route('admin.website.stats') }}" class="add-sec-btn" style="text-decoration:none;"><i class="fas fa-chart-bar si"></i><span>الإحصائيات</span><i class="fas fa-external-link-alt ms-auto" style="font-size:10px;opacity:0.4;"></i></a>
            <a href="{{ route('admin.website.testimonials') }}" class="add-sec-btn" style="text-decoration:none;"><i class="fas fa-quote-right si"></i><span>آراء العملاء</span><i class="fas fa-external-link-alt ms-auto" style="font-size:10px;opacity:0.4;"></i></a>
            <a href="{{ route('admin.website.partners') }}" class="add-sec-btn" style="text-decoration:none;"><i class="fas fa-handshake si"></i><span>الشركاء</span><i class="fas fa-external-link-alt ms-auto" style="font-size:10px;opacity:0.4;"></i></a>
            <a href="{{ route('admin.website.faq') }}" class="add-sec-btn" style="text-decoration:none;"><i class="fas fa-question-circle si"></i><span>الأسئلة الشائعة</span><i class="fas fa-external-link-alt ms-auto" style="font-size:10px;opacity:0.4;"></i></a>
            <a href="{{ route('admin.website.sliders') }}" class="add-sec-btn" style="text-decoration:none;"><i class="fas fa-images si"></i><span>السلايدر</span><i class="fas fa-external-link-alt ms-auto" style="font-size:10px;opacity:0.4;"></i></a>
        </div>
    </div>

    {{-- ===== Preview with Overlay Controls ===== --}}
    <div class="builder-preview" id="builderPreview">

        {{-- Navbar Preview --}}
        <nav style="background:#fff;border-bottom:1px solid #e2e8f0;padding:16px 0;">
            <div class="container">
                <div style="display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:20px;font-weight:700;color:#1e293b;display:flex;align-items:center;gap:8px;">
                        @if(setting('company_logo'))<img src="{{ asset(setting('company_logo')) }}" alt="" style="height:32px;">@endif
                        {{ setting('company_name', 'نكسورا') }}
                    </span>
                    <div style="display:flex;gap:16px;font-size:13px;color:#64748b;">
                        <span>الرئيسية</span><span>خدماتنا</span><span>من نحن</span><span>تواصل</span>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Sections Container --}}
        <div id="sectionsContainer">
            @forelse($sections as $sectionIdx => $section)
                @include('admin.website._section_wrap', [
                    'section' => $section,
                    'features' => $features ?? collect(),
                    'services' => $services ?? collect(),
                    'statItems' => $statItems ?? collect(),
                    'testimonials' => $testimonials ?? collect(),
                    'partners' => $partners ?? collect(),
                    'faqItems' => $faqItems ?? collect(),
                    'sliderItems' => $sliderItems ?? collect(),
                ])
                @if(!$loop->last)
                    @include('frontend.partials.section_divider', ['dividerIndex' => $sectionIdx])
                @endif
            @empty
                <div class="add-section-zone" id="emptySections">
                    <i class="fas fa-puzzle-piece"></i>
                    <h6 class="mt-2 text-muted">لا توجد أقسام بعد</h6>
                    <p class="text-muted small">اختر نوع القسم من القائمة الجانبية</p>
                </div>
            @endforelse
        </div>

        {{-- Footer Preview --}}
        @include('frontend.footers.footer_' . ($footerTemplate ?? '1'), ['footerMenu' => $footerMenu ?? collect()])

    </div>
</div>

{{-- Add Section Modal --}}
<div class="modal fade" id="addSectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i> إضافة قسم — <span id="addSectionTypeLabel"></span></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" id="addType">
                <div class="mb-3"><label class="form-label fw-semibold">العنوان (اختياري)</label><input type="text" class="form-control" id="addTitle"></div>
                <div class="mb-3"><label class="form-label fw-semibold">العنوان الفرعي (اختياري)</label><input type="text" class="form-control" id="addSubtitle"></div>
                <label class="form-label fw-semibold">اختر التصميم</label>
                <div class="template-grid" id="addTemplateGrid"></div>
                <input type="hidden" id="addTemplate" value="1">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-nx-primary" id="confirmAddSection"><i class="fas fa-plus me-1"></i> إضافة</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Section Modal --}}
<div class="modal fade" id="editSectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title"><i class="fas fa-cog me-2"></i> إعدادات القسم</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" id="editSecId">
                <input type="hidden" id="editSecType">
                <div class="row g-2 mb-3">
                    <div class="col-md-6"><label class="form-label small fw-semibold">العنوان</label><input type="text" class="form-control form-control-sm" id="editSecTitle"></div>
                    <div class="col-md-6"><label class="form-label small fw-semibold">العنوان الفرعي</label><input type="text" class="form-control form-control-sm" id="editSecSubtitle"></div>
                </div>
                <label class="form-label small fw-semibold">القالب</label>
                <div class="template-grid mb-3" id="editTemplateGrid"></div>
                <input type="hidden" id="editSecTemplate">
                <div id="editExtraFields"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-nx-primary" id="confirmEditSection"><i class="fas fa-save me-1"></i> حفظ وتحديث</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(function() {
    // Add builder-page class to body
    $('body').addClass('builder-page');

    var csrf = $('meta[name="csrf-token"]').attr('content');
    var sectionTypes = @json($sectionTypes);
    var templatePreviews = {
        "hero_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f3f0ff"/><rect x="30" y="12" width="60" height="5" rx="2" fill="#7c3aed" opacity=".5"/><rect x="20" y="22" width="80" height="3" rx="1" fill="#94a3b8" opacity=".4"/><rect x="35" y="28" width="50" height="3" rx="1" fill="#94a3b8" opacity=".3"/><rect x="42" y="40" width="36" height="10" rx="5" fill="#7c3aed" opacity=".7"/></svg>',
        "hero_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="6" y="14" width="45" height="5" rx="2" fill="#7c3aed" opacity=".5"/><rect x="6" y="24" width="50" height="3" rx="1" fill="#94a3b8" opacity=".4"/><rect x="6" y="30" width="40" height="3" rx="1" fill="#94a3b8" opacity=".3"/><rect x="6" y="42" width="28" height="8" rx="4" fill="#7c3aed" opacity=".7"/><rect x="65" y="10" width="48" height="50" rx="6" fill="#ede9fe"/></svg>',
        "hero_3": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#1e293b"/><rect x="25" y="14" width="70" height="5" rx="2" fill="#fff" opacity=".6"/><rect x="20" y="24" width="80" height="3" rx="1" fill="#fff" opacity=".3"/><rect x="30" y="30" width="60" height="3" rx="1" fill="#fff" opacity=".2"/><rect x="42" y="42" width="36" height="10" rx="5" fill="#7c3aed" opacity=".8"/></svg>',
        "features_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><circle cx="20" cy="30" r="5" fill="#7c3aed" opacity=".3"/><rect x="12" y="38" width="16" height="2" rx="1" fill="#94a3b8" opacity=".4"/><rect x="10" y="43" width="20" height="2" rx="1" fill="#94a3b8" opacity=".25"/><circle cx="60" cy="30" r="5" fill="#7c3aed" opacity=".3"/><rect x="52" y="38" width="16" height="2" rx="1" fill="#94a3b8" opacity=".4"/><rect x="50" y="43" width="20" height="2" rx="1" fill="#94a3b8" opacity=".25"/><circle cx="100" cy="30" r="5" fill="#7c3aed" opacity=".3"/><rect x="92" y="38" width="16" height="2" rx="1" fill="#94a3b8" opacity=".4"/><rect x="90" y="43" width="20" height="2" rx="1" fill="#94a3b8" opacity=".25"/></svg>',
        "features_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="5" y="18" width="52" height="18" rx="4" stroke="#e2e8f0" stroke-width=".8" fill="none"/><circle cx="15" cy="27" r="4" fill="#7c3aed" opacity=".3"/><rect x="22" y="24" width="30" height="2" rx="1" fill="#94a3b8" opacity=".4"/><rect x="22" y="29" width="25" height="2" rx="1" fill="#94a3b8" opacity=".25"/><rect x="63" y="18" width="52" height="18" rx="4" stroke="#e2e8f0" stroke-width=".8" fill="none"/><circle cx="73" cy="27" r="4" fill="#7c3aed" opacity=".3"/><rect x="80" y="24" width="30" height="2" rx="1" fill="#94a3b8" opacity=".4"/><rect x="80" y="29" width="25" height="2" rx="1" fill="#94a3b8" opacity=".25"/></svg>',
        "features_3": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="6" y="14" width="35" height="5" rx="2" fill="#334155" opacity=".35"/><rect x="6" y="24" width="40" height="3" rx="1" fill="#94a3b8" opacity=".3"/><rect x="56" y="12" width="56" height="13" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><circle cx="62" cy="18" r="4" fill="#7c3aed" opacity=".6"/><rect x="68" y="16" width="38" height="2" rx="1" fill="#94a3b8" opacity=".35"/><rect x="56" y="28" width="56" height="13" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><circle cx="62" cy="34" r="4" fill="#7c3aed" opacity=".6"/><rect x="68" y="32" width="38" height="2" rx="1" fill="#94a3b8" opacity=".35"/><rect x="56" y="44" width="56" height="13" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><circle cx="62" cy="50" r="4" fill="#7c3aed" opacity=".6"/><rect x="68" y="48" width="38" height="2" rx="1" fill="#94a3b8" opacity=".35"/></svg>',
        "services_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="5" y="18" width="33" height="44" rx="5" fill="#f8fafc"/><rect x="14" y="25" width="16" height="8" rx="3" fill="#7c3aed" opacity=".15"/><rect x="10" y="38" width="23" height="2" rx="1" fill="#94a3b8" opacity=".35"/><rect x="43" y="18" width="33" height="44" rx="5" fill="#f8fafc"/><rect x="52" y="25" width="16" height="8" rx="3" fill="#7c3aed" opacity=".15"/><rect x="48" y="38" width="23" height="2" rx="1" fill="#94a3b8" opacity=".35"/><rect x="81" y="18" width="33" height="44" rx="5" fill="#f8fafc"/><rect x="90" y="25" width="16" height="8" rx="3" fill="#7c3aed" opacity=".15"/><rect x="86" y="38" width="23" height="2" rx="1" fill="#94a3b8" opacity=".35"/></svg>',
        "services_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="5" y="16" width="33" height="46" rx="5" fill="#fff"/><rect x="5" y="16" width="33" height="3" rx="2 2 0 0" fill="#7c3aed" opacity=".6"/><rect x="14" y="28" width="14" height="2" rx="1" fill="#94a3b8" opacity=".35"/><rect x="43" y="16" width="33" height="46" rx="5" fill="#fff"/><rect x="43" y="16" width="33" height="3" rx="2 2 0 0" fill="#ec4899" opacity=".6"/><rect x="52" y="28" width="14" height="2" rx="1" fill="#94a3b8" opacity=".35"/><rect x="81" y="16" width="33" height="46" rx="5" fill="#fff"/><rect x="81" y="16" width="33" height="3" rx="2 2 0 0" fill="#3b82f6" opacity=".6"/><rect x="90" y="28" width="14" height="2" rx="1" fill="#94a3b8" opacity=".35"/></svg>',
        "testimonials_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="4" y="16" width="34" height="46" rx="5" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="8" y="32" width="26" height="2" rx="1" fill="#94a3b8" opacity=".3"/><circle cx="14" cy="52" r="4" fill="#7c3aed" opacity=".25"/><rect x="43" y="16" width="34" height="46" rx="5" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="47" y="32" width="26" height="2" rx="1" fill="#94a3b8" opacity=".3"/><circle cx="53" cy="52" r="4" fill="#7c3aed" opacity=".25"/><rect x="82" y="16" width="34" height="46" rx="5" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="86" y="32" width="26" height="2" rx="1" fill="#94a3b8" opacity=".3"/><circle cx="92" cy="52" r="4" fill="#7c3aed" opacity=".25"/></svg>',
        "testimonials_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="15" y="16" width="28" height="46" rx="6" fill="#f8fafc"/><circle cx="29" cy="48" r="5" fill="#7c3aed" opacity=".2"/><rect x="46" y="16" width="28" height="46" rx="6" fill="#f8fafc"/><circle cx="60" cy="48" r="5" fill="#7c3aed" opacity=".2"/><rect x="77" y="16" width="28" height="46" rx="6" fill="#f8fafc"/><circle cx="91" cy="48" r="5" fill="#7c3aed" opacity=".2"/></svg>',
        "testimonials_3": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f3f0ff"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><circle cx="60" cy="22" r="8" fill="#7c3aed" opacity=".2" stroke="#7c3aed" stroke-width=".5"/><rect x="25" y="35" width="70" height="3" rx="1" fill="#94a3b8" opacity=".3"/><rect x="30" y="41" width="60" height="3" rx="1" fill="#94a3b8" opacity=".2"/><rect x="50" y="50" width="20" height="2" rx="1" fill="#334155" opacity=".3"/><circle cx="12" cy="35" r="3" fill="#94a3b8" opacity=".2"/><circle cx="108" cy="35" r="3" fill="#94a3b8" opacity=".2"/></svg>',
        "stats_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><text x="14" y="32" font-size="14" fill="#7c3aed" opacity=".5" font-weight="bold">500</text><rect x="12" y="38" width="20" height="2" rx="1" fill="#94a3b8" opacity=".3"/><text x="50" y="32" font-size="14" fill="#7c3aed" opacity=".5" font-weight="bold">50+</text><rect x="50" y="38" width="18" height="2" rx="1" fill="#94a3b8" opacity=".3"/><text x="82" y="32" font-size="14" fill="#7c3aed" opacity=".5" font-weight="bold">10K</text><rect x="82" y="38" width="22" height="2" rx="1" fill="#94a3b8" opacity=".3"/></svg>',
        "stats_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#1e293b"/><rect x="6" y="14" width="24" height="42" rx="6" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.1)" stroke-width=".5"/><text x="10" y="36" font-size="12" fill="#fff" opacity=".5" font-weight="bold">500</text><rect x="10" y="42" width="16" height="2" rx="1" fill="#fff" opacity=".2"/><rect x="34" y="14" width="24" height="42" rx="6" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.1)" stroke-width=".5"/><text x="40" y="36" font-size="12" fill="#fff" opacity=".5" font-weight="bold">50</text><rect x="38" y="42" width="16" height="2" rx="1" fill="#fff" opacity=".2"/><rect x="62" y="14" width="24" height="42" rx="6" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.1)" stroke-width=".5"/><text x="66" y="36" font-size="12" fill="#fff" opacity=".5" font-weight="bold">10K</text><rect x="66" y="42" width="16" height="2" rx="1" fill="#fff" opacity=".2"/><rect x="90" y="14" width="24" height="42" rx="6" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.1)" stroke-width=".5"/><text x="94" y="36" font-size="12" fill="#fff" opacity=".5" font-weight="bold">4.9</text><rect x="94" y="42" width="16" height="2" rx="1" fill="#fff" opacity=".2"/></svg>',
        "cta_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="g1" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#7c3aed"/><stop offset="1" stop-color="#6d28d9"/></linearGradient></defs><rect width="120" height="70" rx="4" fill="url(#g1)"/><rect x="25" y="18" width="70" height="5" rx="2" fill="#fff" opacity=".6"/><rect x="30" y="28" width="60" height="3" rx="1" fill="#fff" opacity=".3"/><rect x="40" y="42" width="40" height="10" rx="5" fill="#fff" opacity=".8"/></svg>',
        "cta_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="15" y="10" width="90" height="50" rx="10" fill="#f3f0ff"/><rect x="30" y="20" width="60" height="5" rx="2" fill="#334155" opacity=".3"/><rect x="35" y="30" width="50" height="3" rx="1" fill="#94a3b8" opacity=".3"/><rect x="42" y="42" width="36" height="8" rx="4" fill="#7c3aed" opacity=".6"/></svg>',
        "cta_3": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="6" y="14" width="50" height="5" rx="2" fill="#334155" opacity=".35"/><rect x="6" y="24" width="55" height="3" rx="1" fill="#94a3b8" opacity=".3"/><rect x="6" y="30" width="45" height="3" rx="1" fill="#94a3b8" opacity=".2"/><rect x="6" y="44" width="32" height="8" rx="4" fill="#7c3aed" opacity=".6"/><rect x="68" y="10" width="46" height="50" rx="8" fill="#ede9fe"/></svg>',
        "partners_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="35" y="8" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="8" y="30" width="18" height="12" rx="3" fill="#94a3b8" opacity=".15"/><rect x="30" y="30" width="18" height="12" rx="3" fill="#94a3b8" opacity=".15"/><rect x="52" y="30" width="18" height="12" rx="3" fill="#94a3b8" opacity=".15"/><rect x="74" y="30" width="18" height="12" rx="3" fill="#94a3b8" opacity=".15"/><rect x="96" y="30" width="18" height="12" rx="3" fill="#94a3b8" opacity=".15"/></svg>',
        "partners_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="35" y="8" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="6" y="22" width="24" height="20" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="12" y="28" width="12" height="8" rx="2" fill="#94a3b8" opacity=".2"/><rect x="34" y="22" width="24" height="20" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="40" y="28" width="12" height="8" rx="2" fill="#94a3b8" opacity=".2"/><rect x="62" y="22" width="24" height="20" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="68" y="28" width="12" height="8" rx="2" fill="#94a3b8" opacity=".2"/><rect x="90" y="22" width="24" height="20" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="96" y="28" width="12" height="8" rx="2" fill="#94a3b8" opacity=".2"/></svg>',
        "faq_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="15" y="16" width="90" height="12" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="20" y="20" width="50" height="2" rx="1" fill="#94a3b8" opacity=".4"/><rect x="15" y="32" width="90" height="12" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="20" y="36" width="45" height="2" rx="1" fill="#94a3b8" opacity=".4"/><rect x="15" y="48" width="90" height="12" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="20" y="52" width="55" height="2" rx="1" fill="#94a3b8" opacity=".4"/></svg>',
        "faq_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="5" y="16" width="53" height="22" rx="4" fill="#f8fafc"/><rect x="5" y="16" width="2" height="22" rx="1" fill="#7c3aed" opacity=".5"/><rect x="12" y="22" width="38" height="2" rx="1" fill="#334155" opacity=".3"/><rect x="12" y="28" width="35" height="2" rx="1" fill="#94a3b8" opacity=".25"/><rect x="62" y="16" width="53" height="22" rx="4" fill="#f8fafc"/><rect x="62" y="16" width="2" height="22" rx="1" fill="#7c3aed" opacity=".5"/><rect x="69" y="22" width="38" height="2" rx="1" fill="#334155" opacity=".3"/><rect x="69" y="28" width="35" height="2" rx="1" fill="#94a3b8" opacity=".25"/></svg>',
        "contact_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="5" y="16" width="40" height="46" rx="6" fill="#7c3aed" opacity=".7"/><rect x="10" y="24" width="25" height="2" rx="1" fill="#fff" opacity=".5"/><rect x="10" y="30" width="20" height="2" rx="1" fill="#fff" opacity=".3"/><rect x="10" y="36" width="22" height="2" rx="1" fill="#fff" opacity=".3"/><rect x="50" y="16" width="65" height="46" rx="6" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="56" y="24" width="24" height="6" rx="2" fill="#f1f5f9"/><rect x="84" y="24" width="24" height="6" rx="2" fill="#f1f5f9"/><rect x="56" y="34" width="52" height="6" rx="2" fill="#f1f5f9"/><rect x="56" y="44" width="52" height="10" rx="2" fill="#f1f5f9"/></svg>',
        "contact_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><circle cx="30" cy="18" r="4" fill="#7c3aed" opacity=".2"/><circle cx="60" cy="18" r="4" fill="#7c3aed" opacity=".2"/><circle cx="90" cy="18" r="4" fill="#7c3aed" opacity=".2"/><rect x="20" y="30" width="80" height="32" rx="6" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><rect x="26" y="36" width="32" height="5" rx="2" fill="#f1f5f9"/><rect x="62" y="36" width="32" height="5" rx="2" fill="#f1f5f9"/><rect x="26" y="45" width="68" height="5" rx="2" fill="#f1f5f9"/><rect x="26" y="54" width="68" height="4" rx="2" fill="#7c3aed" opacity=".5"/></svg>',
        "custom_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#fff" stroke="#e2e8f0" stroke-width=".5"/><text x="36" y="30" font-size="10" fill="#7c3aed" opacity=".3" font-family="monospace">&lt;/&gt;</text><rect x="30" y="40" width="60" height="3" rx="1" fill="#94a3b8" opacity=".2"/><rect x="35" y="48" width="50" height="3" rx="1" fill="#94a3b8" opacity=".15"/></svg>',
        "slider_1": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#1e293b"/><rect x="20" y="16" width="80" height="6" rx="2" fill="#fff" opacity=".5"/><rect x="30" y="26" width="60" height="3" rx="1" fill="#fff" opacity=".3"/><rect x="42" y="38" width="36" height="8" rx="4" fill="#7c3aed" opacity=".7"/><circle cx="55" cy="58" r="3" fill="#fff" opacity=".7"/><circle cx="65" cy="58" r="3" fill="#fff" opacity=".3"/><circle cx="45" cy="58" r="3" fill="#fff" opacity=".3"/><circle cx="8" cy="35" r="5" fill="rgba(255,255,255,0.1)"/><circle cx="112" cy="35" r="5" fill="rgba(255,255,255,0.1)"/></svg>',
        "slider_2": '<svg viewBox="0 0 120 70" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="70" rx="4" fill="#f8fafc"/><rect x="35" y="4" width="50" height="4" rx="2" fill="#334155" opacity=".3"/><rect x="10" y="16" width="100" height="46" rx="8" fill="#1e293b"/><rect x="14" y="44" width="50" height="4" rx="2" fill="#fff" opacity=".5"/><rect x="14" y="52" width="30" height="3" rx="1" fill="#fff" opacity=".3"/><circle cx="55" cy="58" r="2" fill="#fff" opacity=".6"/><circle cx="62" cy="58" r="2" fill="#fff" opacity=".3"/></svg>'
    };

    // Build template grid HTML
    function buildTemplateGrid(type, selectedTemplate) {
        var info = sectionTypes[type] || { templates: 1, designs: {} };
        var designs = info.designs || {};
        var grid = '';
        for (var i = 1; i <= info.templates; i++) {
            var key = type + '_' + i;
            var design = designs[String(i)] || { name: 'تصميم ' + i, desc: '' };
            var svg = templatePreviews[key] || '';
            var sel = (selectedTemplate == i) ? 'selected' : '';
            grid += '<div class="template-option '+sel+'" data-template="'+i+'">';
            grid += '<div class="tpl-preview">' + svg + '</div>';
            grid += '<div class="tpl-info">';
            grid += '<div class="tpl-name">' + design.name + '</div>';
            if (design.desc) grid += '<div class="tpl-desc">' + design.desc + '</div>';
            grid += '</div></div>';
        }
        return grid;
    }

    // ===== Add Section =====
    $('.add-sec-btn[data-type]').on('click', function() {
        var type = $(this).data('type');
        var label = $(this).data('label');
        $('#addType').val(type);
        $('#addSectionTypeLabel').text(label);
        $('#addTitle').val('');
        $('#addSubtitle').val('');
        $('#addTemplate').val('1');
        $('#addTemplateGrid').html(buildTemplateGrid(type, 1));
        new bootstrap.Modal('#addSectionModal').show();
    });

    $(document).on('click', '#addTemplateGrid .template-option', function() {
        $('#addTemplateGrid .template-option').removeClass('selected');
        $(this).addClass('selected');
        $('#addTemplate').val($(this).data('template'));
    });

    $('#confirmAddSection').on('click', function() {
        var $btn = $(this).prop('disabled', true);
        $.ajax({
            url: "{{ route('admin.website.sections.store') }}",
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf },
            data: { type: $('#addType').val(), template: $('#addTemplate').val(), title: $('#addTitle').val(), subtitle: $('#addSubtitle').val() },
            success: function(res) {
                if (res.success) {
                    // Remove empty state if exists
                    $('#emptySections').remove();
                    // Append new section HTML before footer
                    $('#sectionsContainer').append(res.html);
                    // Scroll to new section
                    var $newSec = $('#section-' + res.section.id);
                    if ($newSec.length) {
                        $newSec[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                        $newSec.css('outline-color', 'rgba(124,58,237,0.6)');
                        setTimeout(function(){ $newSec.css('outline-color', ''); }, 2000);
                    }
                    bootstrap.Modal.getInstance('#addSectionModal').hide();
                    toastr.success(res.message);
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'حدث خطأ.';
                toastr.error(msg);
            },
            complete: function() { $btn.prop('disabled', false); }
        });
    });

    // ===== Edit Section =====
    $(document).on('click', '.edit-sec-btn', function() {
        var $wrap = $(this).closest('.section-wrap');
        var id = $wrap.data('id');
        var type = $wrap.data('type');
        var template = $wrap.data('template');
        var info = sectionTypes[type] || { templates: 1, icon: 'fas fa-puzzle-piece' };

        $('#editSecId').val(id);
        $('#editSecType').val(type);
        $('#editSecTemplate').val(template);
        $('#editSecTitle').val($wrap.find('section').first().find('h1,h2').first().text() || '');
        $('#editSecSubtitle').val('');

        // Fetch current data
        $.get('/admin/website/homepage/sections/' + id + '/data', { _token: csrf }, function(data) {
            if (data.section) {
                $('#editSecTitle').val(data.section.title || '');
                $('#editSecSubtitle').val(data.section.subtitle || '');
            }
            $('#editTemplateGrid').html(buildTemplateGrid(type, template));

            // Extra fields for hero/cta
            var extra = '';
            if (type === 'hero' || type === 'cta') {
                var s = data.section.settings || {};
                extra += '<div class="row g-2"><div class="col-md-4"><label class="form-label small fw-semibold">نص الزر</label><input type="text" class="form-control form-control-sm edit-setting" data-key="button_text" value="'+(s.button_text||'')+'"></div>';
                extra += '<div class="col-md-4"><label class="form-label small fw-semibold">رابط الزر</label><input type="text" class="form-control form-control-sm edit-setting" data-key="button_url" value="'+(s.button_url||'')+'" dir="ltr"></div>';
                extra += '<div class="col-md-4"><label class="form-label small fw-semibold">صورة خلفية</label><input type="text" class="form-control form-control-sm edit-setting" data-key="bg_image" value="'+(s.bg_image||'')+'" dir="ltr"></div></div>';
            }
            $('#editExtraFields').html(extra);
        });

        new bootstrap.Modal('#editSectionModal').show();
    });

    $(document).on('click', '#editTemplateGrid .template-option', function() {
        $('#editTemplateGrid .template-option').removeClass('selected');
        $(this).addClass('selected');
        $('#editSecTemplate').val($(this).data('template'));
    });

    $('#confirmEditSection').on('click', function() {
        var $btn = $(this).prop('disabled', true);
        var id = $('#editSecId').val();
        var data = { title: $('#editSecTitle').val(), subtitle: $('#editSecSubtitle').val(), template: $('#editSecTemplate').val() };
        var settings = {};
        $('.edit-setting').each(function() { settings[$(this).data('key')] = $(this).val(); });
        data.settings = JSON.stringify(settings);

        $.ajax({
            url: '/admin/website/homepage/sections/' + id,
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': csrf },
            data: data,
            success: function(res) {
                if (res.success) {
                    // Replace the section wrapper in place
                    var $old = $('#section-' + id);
                    if ($old.length && res.html) {
                        var $new = $(res.html);
                        $old.replaceWith($new);
                        // Flash highlight
                        $new.css('outline-color', 'rgba(124,58,237,0.6)');
                        setTimeout(function(){ $new.css('outline-color', ''); }, 2000);
                    }
                    bootstrap.Modal.getInstance('#editSectionModal').hide();
                    toastr.success(res.message);
                }
            },
            error: function(xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'حدث خطأ.';
                toastr.error(msg);
            },
            complete: function() { $btn.prop('disabled', false); }
        });
    });

    // ===== Toggle Section =====
    $(document).on('click', '.toggle-sec-btn', function() {
        var $wrap = $(this).closest('.section-wrap');
        var id = $wrap.data('id');
        $.ajax({
            url: '/admin/website/homepage/sections/' + id + '/toggle',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(res) {
                if (res.success) {
                    $wrap.toggleClass('is-disabled', !res.is_active);
                    // Update toggle button icon and title
                    var $tbtn = $wrap.find('.toggle-sec-btn');
                    $tbtn.find('i').attr('class', 'fas ' + (res.is_active ? 'fa-eye' : 'fa-eye-slash'));
                    $tbtn.attr('title', res.is_active ? 'تعطيل' : 'تفعيل');
                    toastr.success(res.message);
                }
            }
        });
    });

    // ===== Delete Section =====
    $(document).on('click', '.delete-sec-btn', function() {
        var $wrap = $(this).closest('.section-wrap');
        var id = $wrap.data('id');
        Swal.fire({ title:'حذف القسم؟', icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', confirmButtonText:'نعم، احذف', cancelButtonText:'إلغاء' })
        .then(function(r) {
            if (r.isConfirmed) {
                $.ajax({
                    url: '/admin/website/homepage/sections/' + id,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function(res) {
                        if (res.success) {
                            $wrap.fadeOut(300, function() {
                                $(this).remove();
                                // Show empty state if no sections left
                                if ($('#sectionsContainer .section-wrap').length === 0) {
                                    $('#sectionsContainer').html('<div class="add-section-zone" id="emptySections"><i class="fas fa-puzzle-piece"></i><h6 class="mt-2 text-muted">لا توجد أقسام بعد</h6><p class="text-muted small">اختر نوع القسم من القائمة الجانبية</p></div>');
                                }
                            });
                            toastr.success(res.message);
                        }
                    }
                });
            }
        });
    });

    // ===== Move Up/Down =====
    $(document).on('click', '.move-up-btn', function() {
        var $wrap = $(this).closest('.section-wrap');
        var $prev = $wrap.prev('.section-wrap');
        if ($prev.length) { $wrap.insertBefore($prev); saveOrder(); }
    });

    $(document).on('click', '.move-down-btn', function() {
        var $wrap = $(this).closest('.section-wrap');
        var $next = $wrap.next('.section-wrap');
        if ($next.length) { $wrap.insertAfter($next); saveOrder(); }
    });

    function saveOrder() {
        var items = [];
        $('.section-wrap').each(function() { items.push($(this).data('id')); });
        $.ajax({
            url: "{{ route('admin.website.sections.reorder') }}",
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf },
            data: { items: items },
            success: function(res) { if (res.success) toastr.success('تم تحديث الترتيب'); }
        });
    }
});
</script>
@endsection
