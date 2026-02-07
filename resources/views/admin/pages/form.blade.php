@extends('admin.layouts.app')

@section('title', $page ? 'تعديل الصفحة' : 'صفحة جديدة')
@section('page-title', $page ? 'تعديل: ' . $page->title : 'إنشاء صفحة جديدة')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <a href="{{ route('admin.pages.index') }}">الصفحات</a>
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>{{ $page ? 'تعديل' : 'إنشاء' }}</span>
@endsection

@section('content')

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-success-light);color:var(--nx-success);">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form action="{{ $page ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}"
          method="POST" enctype="multipart/form-data" class="nx-form" id="pageForm">
        @csrf
        @if($page) @method('PUT') @endif

        <div class="row g-3">
            {{-- Main Content --}}
            <div class="col-lg-8">
                <div class="nx-card mb-3">
                    <div class="card-header"><h5 class="card-title">محتوى الصفحة</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">عنوان الصفحة</label>
                            <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $page->title ?? '') }}" required placeholder="عنوان الصفحة...">
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        @if($page)
                        <div class="mb-3">
                            <label class="form-label">الرابط (Slug)</label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:12px;direction:ltr;">/page/</span>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" style="direction:ltr;">
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">المحتوى الرئيسي</label>
                            <textarea name="content" id="mainContent" class="form-control" rows="12" placeholder="اكتب محتوى الصفحة هنا...">{{ old('content', $page->content ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">المقتطف (يظهر كوصف مختصر)</label>
                            <textarea name="excerpt" class="form-control" rows="2" placeholder="وصف مختصر للصفحة...">{{ old('excerpt', $page->excerpt ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Sections Builder --}}
                @if($page)
                <div class="nx-card mb-3">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-th-large me-1 text-purple"></i> أقسام الصفحة</h5>
                        <button type="button" class="btn btn-nx-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSectionModal">
                            <i class="fas fa-plus me-1"></i> إضافة قسم
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="sectionsContainer">
                            @forelse($page->sections as $section)
                                @include('admin.pages._section_card', ['section' => $section])
                            @empty
                                <div class="text-center py-4 text-muted" id="noSectionsMsg">
                                    <i class="fas fa-puzzle-piece" style="font-size:32px;"></i>
                                    <p class="mt-2 mb-0">لا توجد أقسام بعد. أضف قسماً لبناء الصفحة.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                @endif

                {{-- Custom Code --}}
                <div class="nx-card">
                    <div class="card-header"><h5 class="card-title"><i class="fas fa-code me-1 text-purple"></i> كود مخصص</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">CSS مخصص</label>
                            <textarea name="custom_css" class="form-control" rows="4" style="font-family:monospace;direction:ltr;font-size:13px;" placeholder=".my-class { color: red; }">{{ old('custom_css', $page->custom_css ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">JavaScript مخصص</label>
                            <textarea name="custom_js" class="form-control" rows="4" style="font-family:monospace;direction:ltr;font-size:13px;" placeholder="console.log('Hello');">{{ old('custom_js', $page->custom_js ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Publish Box --}}
                <div class="nx-card mb-3">
                    <div class="card-header"><h5 class="card-title">النشر</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="draft" {{ old('status', $page->status ?? 'draft') == 'draft' ? 'selected' : '' }}>مسودة</option>
                                <option value="published" {{ old('status', $page->status ?? '') == 'published' ? 'selected' : '' }}>منشورة</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_in_nav" value="1" id="showInNav"
                                       {{ old('show_in_nav', $page->show_in_nav ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="showInNav">إظهار في قائمة الموقع</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-nx-primary flex-fill"><i class="fas fa-save me-1"></i> {{ $page ? 'تحديث' : 'حفظ' }}</button>
                            @if($page && $page->status === 'published')
                            <a href="{{ $page->url }}" target="_blank" class="btn btn-nx-secondary"><i class="fas fa-eye"></i></a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="nx-card mb-3">
                    <div class="card-header"><h5 class="card-title">الصورة البارزة</h5></div>
                    <div class="card-body">
                        <div class="page-img-preview mb-2" id="featuredPreview">
                            @if($page && $page->featured_image)
                                <img src="{{ asset($page->featured_image) }}" alt="">
                            @else
                                <div class="img-placeholder"><i class="fas fa-image"></i></div>
                            @endif
                        </div>
                        <input type="file" name="featured_image" class="form-control" id="featuredInput" accept="image/*">
                    </div>
                </div>

                {{-- SEO --}}
                <div class="nx-card">
                    <div class="card-header"><h5 class="card-title"><i class="fas fa-search me-1 text-purple"></i> SEO</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">عنوان SEO</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title ?? '') }}" placeholder="عنوان محسّن لمحركات البحث">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">وصف SEO</label>
                            <textarea name="meta_description" class="form-control" rows="3" placeholder="وصف الصفحة لمحركات البحث...">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Add Section Modal --}}
    @if($page)
    <div class="modal fade" id="addSectionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">إضافة قسم جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">اختر نوع القسم:</p>
                    <div class="row g-3" id="sectionTypes">
                        @foreach([
                            ['type' => 'hero', 'icon' => 'fas fa-flag', 'label' => 'بانر رئيسي', 'desc' => 'قسم بارز مع عنوان وزر'],
                            ['type' => 'text', 'icon' => 'fas fa-align-right', 'label' => 'نص وصورة', 'desc' => 'محتوى نصي مع صورة جانبية'],
                            ['type' => 'features', 'icon' => 'fas fa-th-large', 'label' => 'مميزات', 'desc' => 'شبكة بطاقات مميزات'],
                            ['type' => 'gallery', 'icon' => 'fas fa-images', 'label' => 'معرض صور', 'desc' => 'مجموعة صور بشكل شبكي'],
                            ['type' => 'cta', 'icon' => 'fas fa-bullhorn', 'label' => 'دعوة للإجراء', 'desc' => 'قسم مع زر دعوة'],
                            ['type' => 'testimonials', 'icon' => 'fas fa-quote-right', 'label' => 'آراء العملاء', 'desc' => 'عرض تقييمات وآراء'],
                            ['type' => 'stats', 'icon' => 'fas fa-chart-bar', 'label' => 'إحصائيات', 'desc' => 'أرقام وإحصائيات بارزة'],
                            ['type' => 'custom_html', 'icon' => 'fas fa-code', 'label' => 'HTML مخصص', 'desc' => 'كود HTML حر'],
                        ] as $st)
                        <div class="col-md-3 col-6">
                            <div class="section-type-card" data-type="{{ $st['type'] }}">
                                <i class="{{ $st['icon'] }}"></i>
                                <div class="fw-semibold">{{ $st['label'] }}</div>
                                <small class="text-muted">{{ $st['desc'] }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Section Modal --}}
    <div class="modal fade" id="editSectionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="editSectionTitle">تعديل القسم</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editSectionId">
                    <div class="mb-3">
                        <label class="form-label">عنوان القسم</label>
                        <input type="text" class="form-control" id="editSectionTitleInput" placeholder="عنوان القسم...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">المحتوى</label>
                        <textarea class="form-control" id="editSectionContent" rows="10" placeholder="محتوى القسم... (يدعم HTML)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">إعدادات مخصصة (JSON)</label>
                        <textarea class="form-control" id="editSectionSettings" rows="3" style="font-family:monospace;direction:ltr;font-size:13px;" placeholder='{"bg_color":"#fff","text_color":"#333"}'></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-nx-primary" id="saveSectionBtn"><i class="fas fa-save me-1"></i> حفظ التعديلات</button>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection

@section('styles')
<style>
    .page-img-preview {
        width:100%;height:140px;border-radius:var(--nx-radius-sm);border:2px dashed var(--nx-border);
        display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--nx-body-bg,#f9fafb);
    }
    .page-img-preview img { max-width:100%;max-height:100%;object-fit:cover; }
    .img-placeholder { color:var(--nx-text-muted);font-size:32px; }
    .section-type-card {
        border:2px solid var(--nx-border);border-radius:var(--nx-radius);padding:16px 12px;
        text-align:center;cursor:pointer;transition:all 0.2s;
    }
    .section-type-card:hover { border-color:var(--nx-primary);background:var(--nx-primary-lighter,#f5f3ff); }
    .section-type-card i { font-size:28px;color:var(--nx-primary);margin-bottom:8px;display:block; }
    .section-type-card small { font-size:11px;display:block;margin-top:4px; }
    .section-item {
        border:1px solid var(--nx-border);border-radius:var(--nx-radius-sm);padding:14px 16px;
        margin-bottom:10px;display:flex;align-items:center;gap:12px;background:var(--nx-card-bg,#fff);
        transition:box-shadow 0.2s;
    }
    .section-item:hover { box-shadow:0 2px 8px rgba(0,0,0,0.06); }
    .section-item .drag-handle { cursor:grab;color:var(--nx-text-muted);font-size:16px; }
    .section-item .section-icon { width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:var(--nx-primary-lighter,#f5f3ff);color:var(--nx-primary);font-size:14px; }
    .section-item .section-info { flex:1; }
    .section-item .section-info .name { font-weight:600;font-size:14px; }
    .section-item .section-info .type-label { font-size:12px;color:var(--nx-text-muted); }
</style>
@endsection

@section('scripts')
{{-- TinyMCE for rich text --}}
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
$(document).ready(function() {
    // Init TinyMCE
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#mainContent',
            language: 'ar',
            directionality: 'rtl',
            height: 400,
            menubar: true,
            plugins: 'lists link image table code fullscreen media',
            toolbar: 'undo redo | blocks | bold italic underline | alignright aligncenter alignleft | bullist numlist | link image media | table | code fullscreen',
            content_style: "body { font-family: 'Cairo', sans-serif; direction: rtl; }",
            setup: function(editor) {
                editor.on('change', function() { editor.save(); });
            }
        });
    }

    // Featured image preview
    $('#featuredInput').on('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) { $('#featuredPreview').html('<img src="' + e.target.result + '">'); };
            reader.readAsDataURL(file);
        }
    });

    @if($page)
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    var pageId = {{ $page->id }};

    // Add Section
    $('.section-type-card').on('click', function() {
        var type = $(this).data('type');
        $.post('/admin/pages/' + pageId + '/sections', {
            _token: csrfToken, type: type, title: '', content: ''
        }, function(res) {
            if (res.success) {
                $('#noSectionsMsg').remove();
                $('#sectionsContainer').append(res.html);
                bootstrap.Modal.getInstance(document.getElementById('addSectionModal')).hide();
                if (typeof toastr !== 'undefined') toastr.success('تم إضافة القسم');
            }
        });
    });

    // Edit Section
    $(document).on('click', '.btn-edit-section', function() {
        var $item = $(this).closest('.section-item');
        $('#editSectionId').val($item.data('id'));
        $('#editSectionTitleInput').val($item.data('title'));
        $('#editSectionContent').val($item.data('content'));
        $('#editSectionSettings').val($item.data('settings'));
        $('#editSectionTitle').text('تعديل: ' + ($item.data('type-label') || 'القسم'));
        new bootstrap.Modal('#editSectionModal').show();
    });

    // Save Section Edit
    $('#saveSectionBtn').on('click', function() {
        var sectionId = $('#editSectionId').val();
        $.ajax({
            url: '/admin/pages/sections/' + sectionId,
            method: 'PUT',
            data: {
                _token: csrfToken,
                title: $('#editSectionTitleInput').val(),
                content: $('#editSectionContent').val(),
                settings: $('#editSectionSettings').val()
            },
            success: function(res) {
                if (res.success) {
                    var $item = $('.section-item[data-id="' + sectionId + '"]');
                    $item.data('title', res.section.title);
                    $item.data('content', res.section.content);
                    $item.data('settings', res.section.settings);
                    $item.find('.name').text(res.section.title || '(بدون عنوان)');
                    bootstrap.Modal.getInstance(document.getElementById('editSectionModal')).hide();
                    if (typeof toastr !== 'undefined') toastr.success('تم حفظ التعديلات');
                }
            }
        });
    });

    // Toggle Section
    $(document).on('click', '.btn-toggle-section', function() {
        var $item = $(this).closest('.section-item');
        var sectionId = $item.data('id');
        var newState = !$item.data('active');
        $.ajax({
            url: '/admin/pages/sections/' + sectionId,
            method: 'PUT',
            data: { _token: csrfToken, is_active: newState ? 1 : 0 },
            success: function(res) {
                $item.data('active', newState);
                $item.find('.btn-toggle-section i').toggleClass('fa-eye fa-eye-slash');
                $item.toggleClass('opacity-50', !newState);
            }
        });
    });

    // Delete Section
    $(document).on('click', '.btn-delete-section', function() {
        var $item = $(this).closest('.section-item');
        var sectionId = $item.data('id');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'حذف القسم؟', text: 'لن تتمكن من التراجع.', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#7c3aed', cancelButtonColor: '#ef4444',
                confirmButtonText: 'نعم، احذف', cancelButtonText: 'إلغاء'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/pages/sections/' + sectionId,
                        method: 'DELETE', data: { _token: csrfToken },
                        success: function() { $item.fadeOut(300, function() { $(this).remove(); }); }
                    });
                }
            });
        }
    });
    @endif
});
</script>
@endsection
