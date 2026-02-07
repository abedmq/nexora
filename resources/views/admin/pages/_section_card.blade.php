<div class="section-item {{ !$section->is_active ? 'opacity-50' : '' }}"
     data-id="{{ $section->id }}"
     data-title="{{ $section->title }}"
     data-content="{{ e($section->content) }}"
     data-settings="{{ $section->settings }}"
     data-type-label="{{ $section->type_label }}"
     data-active="{{ $section->is_active ? 1 : 0 }}">
    <div class="drag-handle"><i class="fas fa-grip-vertical"></i></div>
    <div class="section-icon"><i class="{{ $section->type_icon }}"></i></div>
    <div class="section-info">
        <div class="name">{{ $section->title ?: '(بدون عنوان)' }}</div>
        <div class="type-label">{{ $section->type_label }}</div>
    </div>
    <div class="d-flex gap-1">
        <button type="button" class="btn btn-sm btn-nx-secondary btn-edit-section" title="تعديل"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-sm btn-nx-secondary btn-toggle-section" title="إظهار/إخفاء"><i class="fas {{ $section->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i></button>
        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-section" title="حذف"><i class="fas fa-trash-alt"></i></button>
    </div>
</div>
