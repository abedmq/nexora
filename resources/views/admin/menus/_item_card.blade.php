<li class="dd-item"
    data-id="{{ $item->id }}"
    data-title="{{ $item->title }}"
    data-type="{{ $item->type }}"
    data-page-id="{{ $item->page_id }}"
    data-url="{{ $item->url }}"
    data-target="{{ $item->target }}"
    data-icon="{{ $item->icon }}"
    data-css-class="{{ $item->css_class }}"
>
    <div class="dd3-content">
        <span class="dd-handle dd3-handle"><i class="fas fa-grip-vertical"></i></span>
        <span class="item-icon"><i class="{{ $item->icon ?: ($item->type === 'page' ? 'fas fa-file-alt' : 'fas fa-link') }}"></i></span>
        <span class="item-title">{{ $item->title }}</span>
        <span class="item-meta">
            <span class="type-label">{{ $item->type_label }}</span>
        </span>
        <span class="item-actions dd-nodrag">
            <button class="btn btn-sm btn-nx-secondary edit-item-btn" title="تعديل"><i class="fas fa-edit"></i></button>
            <button class="btn btn-sm btn-nx-secondary toggle-item-btn" title="تعطيل"><i class="fas fa-eye"></i></button>
            <button class="btn btn-sm btn-nx-secondary delete-item-btn text-danger" title="حذف"><i class="fas fa-trash"></i></button>
        </span>
    </div>
</li>
