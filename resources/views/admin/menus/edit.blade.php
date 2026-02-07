@extends('admin.layouts.app')

@section('title', 'تعديل القائمة: ' . $menu->name)
@section('page-title', 'تعديل القائمة')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <a href="{{ route('admin.menus.index') }}">القوائم</a>
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>{{ $menu->name }}</span>
@endsection

@section('styles')
<style>
    /* Menu Builder Layout */
    .menu-builder { display:flex; gap:20px; }
    .menu-builder .builder-sidebar { width:360px; flex-shrink:0; }
    .menu-builder .builder-main { flex:1; min-width:0; }

    /* Add Item Panel */
    .add-panel { border:1px solid var(--nx-border); border-radius:12px; overflow:hidden; margin-bottom:16px; }
    .add-panel-header {
        padding:14px 18px; background:var(--nx-bg-alt); border-bottom:1px solid var(--nx-border);
        cursor:pointer; display:flex; align-items:center; justify-content:space-between;
        font-weight:600; font-size:14px; transition:all 0.2s;
    }
    .add-panel-header:hover { background:rgba(124,58,237,0.05); }
    .add-panel-header i.toggle { transition:transform 0.2s; }
    .add-panel-header.collapsed i.toggle { transform:rotate(-90deg); }
    .add-panel-body { padding:16px 18px; display:none; }
    .add-panel-body.show { display:block; }

    /* Nestable Menu Items */
    .dd { position:relative; display:block; margin:0; padding:0; list-style:none; }
    .dd-list { display:block; position:relative; margin:0; padding:0; list-style:none; }
    .dd-list .dd-list { padding-right:28px; }
    .dd-item { display:block; position:relative; margin:8px 0; padding:0; min-height:20px; }

    /* dd3 pattern: content is the visible bar, handle is just the grip */
    .dd3-content {
        display:flex; align-items:center; gap:10px;
        padding:12px 16px 12px 16px; background:var(--nx-card-bg, #fff);
        border:1px solid var(--nx-border); border-radius:10px;
        transition:all 0.2s; font-size:14px; position:relative;
    }
    .dd3-content:hover { border-color:var(--nx-primary); box-shadow:0 2px 8px rgba(124,58,237,0.1); }
    .dd3-content .item-icon { color:var(--nx-primary); width:18px; text-align:center; }
    .dd3-content .item-title { font-weight:600; flex:1; }
    .dd3-content .item-meta { font-size:11px; color:var(--nx-text-muted); }
    .dd3-content .item-actions { display:flex; gap:4px; }
    .dd3-content .item-actions .btn { padding:4px 8px; font-size:11px; border-radius:6px; cursor:pointer; position:relative; z-index:10; }

    /* The drag handle - only the grip icon */
    .dd3-handle {
        cursor:grab; color:var(--nx-text-muted); opacity:0.5;
        display:inline-flex; align-items:center; padding:4px;
        flex-shrink:0;
    }
    .dd3-handle:hover { opacity:1; color:var(--nx-primary); }
    .dd3-handle:active { cursor:grabbing; }

    .dd-placeholder {
        margin:8px 0; padding:0; min-height:48px;
        background:rgba(124,58,237,0.08); border:2px dashed var(--nx-primary);
        border-radius:10px;
    }
    .dd-empty { margin:8px 0; padding:20px; min-height:60px; background:var(--nx-bg-alt);
        border:2px dashed var(--nx-border); border-radius:10px; text-align:center;
        color:var(--nx-text-muted); font-size:13px;
    }
    .dd-dragel .dd3-content { border-color:var(--nx-primary); box-shadow:0 4px 16px rgba(124,58,237,0.2); }
    .dd-collapsed .dd-list { display:none; }
    .dd-toggle {
        display:inline-flex; align-items:center; justify-content:center;
        width:24px; height:24px; border-radius:6px;
        background:var(--nx-bg-alt); border:1px solid var(--nx-border);
        cursor:pointer; font-size:10px; margin-left:4px; flex-shrink:0;
    }
    .dd-collapsed > .dd3-content .dd-toggle i::before { content:"\f105"; }
    .item-disabled { opacity:0.5; }

    /* Edit Item Modal */
    .edit-fields .form-label { font-size:13px; font-weight:600; margin-bottom:4px; }
    .edit-fields .form-control, .edit-fields .form-select { font-size:13px; }

    /* Pages List */
    .pages-list { max-height:200px; overflow-y:auto; border:1px solid var(--nx-border); border-radius:8px; }
    .pages-list .page-item {
        display:flex; align-items:center; justify-content:space-between;
        padding:8px 12px; border-bottom:1px solid var(--nx-border); font-size:13px;
    }
    .pages-list .page-item:last-child { border-bottom:none; }
    .pages-list .page-item:hover { background:var(--nx-bg-alt); }

    /* Menu Settings */
    .menu-settings-card { border:1px solid var(--nx-border); border-radius:12px; padding:16px 18px; }
    .menu-settings-card .form-label { font-size:13px; font-weight:600; margin-bottom:4px; }

    @media (max-width:992px) {
        .menu-builder { flex-direction:column; }
        .menu-builder .builder-sidebar { width:100%; }
    }
</style>
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">{{ $menu->name }}</h5>
            <span class="text-muted" style="font-size:13px;">
                <i class="fas fa-map-marker-alt me-1"></i> {{ $menu->location_label }}
            </span>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="btn btn-sm btn-nx-secondary">
            <i class="fas fa-arrow-right me-1"></i> رجوع للقوائم
        </a>
    </div>

    <div class="menu-builder">
        {{-- Sidebar: Add Items --}}
        <div class="builder-sidebar">

            {{-- Add Page Link --}}
            <div class="add-panel">
                <div class="add-panel-header" data-toggle-panel>
                    <span><i class="fas fa-file-alt me-2 text-purple"></i> صفحات الموقع</span>
                    <i class="fas fa-chevron-down toggle"></i>
                </div>
                <div class="add-panel-body show">
                    @if($pages->count() > 0)
                    <div class="pages-list mb-2">
                        @foreach($pages as $p)
                        <div class="page-item">
                            <label class="d-flex align-items-center gap-2 mb-0" style="cursor:pointer;">
                                <input type="checkbox" class="form-check-input page-checkbox" value="{{ $p->id }}" data-title="{{ $p->title }}">
                                <span>{{ $p->title }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-nx-primary flex-fill" id="addPagesBtn" disabled>
                            <i class="fas fa-plus me-1"></i> إضافة للقائمة
                        </button>
                        <button class="btn btn-sm btn-nx-secondary" id="selectAllPages">الكل</button>
                    </div>
                    @else
                    <p class="text-muted small mb-0">لا توجد صفحات منشورة.</p>
                    @endif
                </div>
            </div>

            {{-- Add Custom Link --}}
            <div class="add-panel">
                <div class="add-panel-header" data-toggle-panel>
                    <span><i class="fas fa-link me-2 text-info"></i> رابط مخصص</span>
                    <i class="fas fa-chevron-down toggle"></i>
                </div>
                <div class="add-panel-body show">
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">العنوان</label>
                        <input type="text" class="form-control form-control-sm" id="customLinkTitle" placeholder="اسم الرابط">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">الرابط (URL)</label>
                        <input type="url" class="form-control form-control-sm" id="customLinkUrl" placeholder="https://" dir="ltr">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">فتح في</label>
                        <select class="form-select form-select-sm" id="customLinkTarget">
                            <option value="_self">نفس النافذة</option>
                            <option value="_blank">نافذة جديدة</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">أيقونة (اختياري)</label>
                        <input type="text" class="form-control form-control-sm" id="customLinkIcon" placeholder="fas fa-home" dir="ltr">
                    </div>
                    <button class="btn btn-sm btn-nx-primary w-100" id="addCustomLinkBtn">
                        <i class="fas fa-plus me-1"></i> إضافة للقائمة
                    </button>
                </div>
            </div>

            {{-- Menu Settings --}}
            <div class="add-panel">
                <div class="add-panel-header" data-toggle-panel>
                    <span><i class="fas fa-cog me-2 text-muted"></i> إعدادات القائمة</span>
                    <i class="fas fa-chevron-down toggle"></i>
                </div>
                <div class="add-panel-body">
                    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">اسم القائمة</label>
                            <input type="text" name="name" class="form-control form-control-sm" value="{{ $menu->name }}" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">الموقع</label>
                            <select name="location" class="form-select form-select-sm">
                                <option value="header" {{ $menu->location === 'header' ? 'selected' : '' }}>الهيدر (القائمة العلوية)</option>
                                <option value="footer" {{ $menu->location === 'footer' ? 'selected' : '' }}>الفوتر (القائمة السفلية)</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">الوصف</label>
                            <textarea name="description" class="form-control form-control-sm" rows="2">{{ $menu->description }}</textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="menuActive" {{ $menu->is_active ? 'checked' : '' }}>
                            <label class="form-check-label small" for="menuActive">تفعيل القائمة</label>
                        </div>
                        <button type="submit" class="btn btn-sm btn-nx-primary w-100">
                            <i class="fas fa-save me-1"></i> حفظ الإعدادات
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- Main: Menu Tree --}}
        <div class="builder-main">
            <div class="nx-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-list me-2"></i> عناصر القائمة</h5>
                    <button class="btn btn-sm btn-nx-primary" id="saveOrderBtn" style="display:none;">
                        <i class="fas fa-save me-1"></i> حفظ الترتيب
                    </button>
                </div>
                <div class="card-body">
                    <div class="dd" id="menuNestable">
                        <ol class="dd-list">
                            @forelse($menuTree as $item)
                                @include('admin.menus._item_nested', ['item' => $item, 'depth' => 0])
                            @empty
                            @endforelse
                        </ol>
                    </div>
                    @if($menuTree->isEmpty())
                    <div class="text-center py-4" id="emptyMenuMsg">
                        <i class="fas fa-mouse-pointer" style="font-size:36px;color:var(--nx-text-muted);opacity:0.3;"></i>
                        <p class="text-muted mt-2 mb-0">اختر صفحات أو أضف روابط مخصصة من القائمة الجانبية</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Item Modal --}}
    <div class="modal fade" id="editItemModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i> تعديل عنصر القائمة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body edit-fields">
                    <input type="hidden" id="editItemId">
                    <div class="mb-3">
                        <label class="form-label">العنوان <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editTitle">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">النوع</label>
                        <select class="form-select" id="editType">
                            <option value="custom">رابط مخصص</option>
                            <option value="page">صفحة</option>
                        </select>
                    </div>
                    <div class="mb-3" id="editPageGroup" style="display:none;">
                        <label class="form-label">الصفحة</label>
                        <select class="form-select" id="editPageId">
                            <option value="">-- اختر صفحة --</option>
                            @foreach($pages as $p)
                            <option value="{{ $p->id }}">{{ $p->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="editUrlGroup">
                        <label class="form-label">الرابط (URL)</label>
                        <input type="url" class="form-control" id="editUrl" dir="ltr">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">فتح في</label>
                            <select class="form-select" id="editTarget">
                                <option value="_self">نفس النافذة</option>
                                <option value="_blank">نافذة جديدة</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">أيقونة</label>
                            <input type="text" class="form-control" id="editIcon" placeholder="fas fa-home" dir="ltr">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">CSS Class (اختياري)</label>
                        <input type="text" class="form-control" id="editCssClass" dir="ltr">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-nx-primary" id="saveEditBtn">
                        <i class="fas fa-save me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
{{-- Nestable2 --}}
<script src="{{ asset('admin-assets/plugins/nestable2/js/jquery.nestable.min.js') }}"></script>

<script>
$(function() {
    var menuId = {{ $menu->id }};
    var csrf = $('meta[name="csrf-token"]').attr('content');
    var orderChanged = false;

    // ===== Initialize Nestable =====
    $('#menuNestable').nestable({
        maxDepth: 3,
        group: 1,
        handleClass: 'dd3-handle',
        collapseBtnHTML: '',
        expandBtnHTML: '',
        callback: function(l, e) {
            orderChanged = true;
            $('#saveOrderBtn').fadeIn();
        }
    });

    // ===== Toggle collapse =====
    $(document).on('click', '.dd-toggle', function(e) {
        e.stopPropagation();
        var $item = $(this).closest('.dd-item');
        $item.toggleClass('dd-collapsed');
        $(this).find('i').toggleClass('fa-chevron-down fa-chevron-left');
    });

    // ===== Panel Toggles =====
    $('[data-toggle-panel]').on('click', function() {
        var $body = $(this).next('.add-panel-body');
        $body.toggleClass('show');
        $(this).find('.toggle').toggleClass('collapsed');
        $(this).toggleClass('collapsed');
    });

    // ===== Select All Pages =====
    var allChecked = false;
    $('#selectAllPages').on('click', function() {
        allChecked = !allChecked;
        $('.page-checkbox').prop('checked', allChecked);
        $(this).text(allChecked ? 'إلغاء' : 'الكل');
        updateAddPagesBtn();
    });

    $(document).on('change', '.page-checkbox', function() {
        updateAddPagesBtn();
    });

    function updateAddPagesBtn() {
        var checked = $('.page-checkbox:checked').length;
        $('#addPagesBtn').prop('disabled', checked === 0);
    }

    // ===== Add Pages to Menu =====
    $('#addPagesBtn').on('click', function() {
        var $btn = $(this);
        var pages = [];
        $('.page-checkbox:checked').each(function() {
            pages.push({ id: $(this).val(), title: $(this).data('title') });
        });

        if (pages.length === 0) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> جاري الإضافة...');

        var added = 0;
        pages.forEach(function(page) {
            $.ajax({
                url: "{{ route('admin.menus.items.store', $menu->id) }}",
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf },
                data: { title: page.title, type: 'page', page_id: page.id },
                success: function(res) {
                    if (res.success) {
                        appendItemToList(res.html);
                    }
                },
                complete: function() {
                    added++;
                    if (added >= pages.length) {
                        $btn.prop('disabled', false).html('<i class="fas fa-plus me-1"></i> إضافة للقائمة');
                        $('.page-checkbox').prop('checked', false);
                        updateAddPagesBtn();
                        toastr.success('تم إضافة ' + pages.length + ' عنصر للقائمة.');
                        reinitNestable();
                    }
                }
            });
        });
    });

    // ===== Add Custom Link =====
    $('#addCustomLinkBtn').on('click', function() {
        var title = $('#customLinkTitle').val().trim();
        var url = $('#customLinkUrl').val().trim();

        if (!title) { toastr.error('يرجى إدخال عنوان الرابط.'); return; }
        if (!url) { toastr.error('يرجى إدخال الرابط.'); return; }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> جاري الإضافة...');

        $.ajax({
            url: "{{ route('admin.menus.items.store', $menu->id) }}",
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf },
            data: {
                title: title,
                type: 'custom',
                url: url,
                target: $('#customLinkTarget').val(),
                icon: $('#customLinkIcon').val()
            },
            success: function(res) {
                if (res.success) {
                    appendItemToList(res.html);
                    $('#customLinkTitle, #customLinkUrl, #customLinkIcon').val('');
                    $('#customLinkTarget').val('_self');
                    toastr.success(res.message);
                    reinitNestable();
                }
            },
            error: function(xhr) {
                toastr.error('حدث خطأ أثناء الإضافة.');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-plus me-1"></i> إضافة للقائمة');
            }
        });
    });

    // ===== Save Order =====
    $('#saveOrderBtn').on('click', function() {
        var $btn = $(this);
        var data = $('#menuNestable').nestable('serialize');

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> جاري الحفظ...');

        $.ajax({
            url: "{{ route('admin.menus.items.reorder', $menu->id) }}",
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf },
            contentType: 'application/json',
            data: JSON.stringify({ items: data }),
            success: function(res) {
                if (res.success) {
                    toastr.success(res.message);
                    orderChanged = false;
                    $btn.fadeOut();
                }
            },
            error: function() {
                toastr.error('حدث خطأ أثناء حفظ الترتيب.');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> حفظ الترتيب');
            }
        });
    });

    // ===== Edit Item =====
    $(document).on('click', '.edit-item-btn', function(e) {
        e.stopPropagation();
        var $item = $(this).closest('.dd-item');
        var id = $item.data('id');

        $('#editItemId').val(id);
        $('#editTitle').val($item.data('title'));
        $('#editType').val($item.data('type'));
        $('#editUrl').val($item.data('url') || '');
        $('#editPageId').val($item.data('page-id') || '');
        $('#editTarget').val($item.data('target') || '_self');
        $('#editIcon').val($item.data('icon') || '');
        $('#editCssClass').val($item.data('css-class') || '');

        toggleEditTypeFields($item.data('type'));

        new bootstrap.Modal('#editItemModal').show();
    });

    $('#editType').on('change', function() {
        toggleEditTypeFields($(this).val());
    });

    function toggleEditTypeFields(type) {
        if (type === 'page') {
            $('#editPageGroup').show();
            $('#editUrlGroup').hide();
        } else {
            $('#editPageGroup').hide();
            $('#editUrlGroup').show();
        }
    }

    // ===== Save Edit =====
    $('#saveEditBtn').on('click', function() {
        var id = $('#editItemId').val();
        var $btn = $(this);

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> جاري الحفظ...');

        $.ajax({
            url: '/admin/menu-items/' + id,
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': csrf },
            data: {
                title: $('#editTitle').val(),
                type: $('#editType').val(),
                page_id: $('#editPageId').val(),
                url: $('#editUrl').val(),
                target: $('#editTarget').val(),
                icon: $('#editIcon').val(),
                css_class: $('#editCssClass').val(),
            },
            success: function(res) {
                if (res.success) {
                    // Update item in DOM
                    var $item = $('[data-id="' + id + '"]');
                    $item.data('title', $('#editTitle').val());
                    $item.data('type', $('#editType').val());
                    $item.data('url', $('#editUrl').val());
                    $item.data('page-id', $('#editPageId').val());
                    $item.data('target', $('#editTarget').val());
                    $item.data('icon', $('#editIcon').val());
                    $item.data('css-class', $('#editCssClass').val());

                    $item.find('> .dd3-content .item-title').first().text($('#editTitle').val());
                    var typeLabel = $('#editType').val() === 'page' ? 'صفحة' : 'رابط مخصص';
                    $item.find('> .dd3-content .item-meta .type-label').first().text(typeLabel);

                    if ($('#editIcon').val()) {
                        $item.find('> .dd3-content .item-icon i').first().attr('class', $('#editIcon').val());
                    }

                    bootstrap.Modal.getInstance(document.getElementById('editItemModal')).hide();
                    toastr.success(res.message);
                }
            },
            error: function() {
                toastr.error('حدث خطأ أثناء التحديث.');
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> حفظ التعديلات');
            }
        });
    });

    // ===== Toggle Active =====
    $(document).on('click', '.toggle-item-btn', function(e) {
        e.stopPropagation();
        var $item = $(this).closest('.dd-item');
        var id = $item.data('id');
        var $btn = $(this);

        $.ajax({
            url: '/admin/menu-items/' + id + '/toggle',
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function(res) {
                if (res.success) {
                    $item.find('> .dd3-content').first().toggleClass('item-disabled', !res.is_active);
                    $btn.find('i').toggleClass('fa-eye fa-eye-slash');
                    $btn.attr('title', res.is_active ? 'تعطيل' : 'تفعيل');
                    toastr.success(res.message);
                }
            }
        });
    });

    // ===== Delete Item =====
    $(document).on('click', '.delete-item-btn', function(e) {
        e.stopPropagation();
        var $item = $(this).closest('.dd-item');
        var id = $item.data('id');

        Swal.fire({
            title: 'حذف العنصر؟',
            text: 'سيتم حذف العنصر وجميع عناصره الفرعية.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/menu-items/' + id,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrf },
                    success: function(res) {
                        if (res.success) {
                            $item.fadeOut(300, function() {
                                $(this).remove();
                                if ($('#menuNestable .dd-item').length === 0) {
                                    $('#menuNestable .dd-list').after('<div class="text-center py-4" id="emptyMenuMsg"><i class="fas fa-mouse-pointer" style="font-size:36px;color:var(--nx-text-muted);opacity:0.3;"></i><p class="text-muted mt-2 mb-0">اختر صفحات أو أضف روابط مخصصة من القائمة الجانبية</p></div>');
                                }
                            });
                            toastr.success(res.message);
                        }
                    }
                });
            }
        });
    });

    // ===== Helpers =====
    function appendItemToList(html) {
        $('#emptyMenuMsg').remove();
        $('#menuNestable > .dd-list').append(html);
    }

    function reinitNestable() {
        $('#menuNestable').nestable('destroy');
        $('#menuNestable').nestable({
            maxDepth: 3,
            group: 1,
            handleClass: 'dd3-handle',
            collapseBtnHTML: '',
            expandBtnHTML: '',
            callback: function() {
                orderChanged = true;
                $('#saveOrderBtn').fadeIn();
            }
        });
    }

    // ===== Warn on unsaved order change =====
    $(window).on('beforeunload', function() {
        if (orderChanged) return 'هل أنت متأكد؟ يوجد تغييرات في الترتيب لم يتم حفظها.';
    });
});
</script>
@endsection
