@extends('admin.layouts.app')
@section('title', 'السلايدر')
@section('page-title', 'السلايدر')
@section('breadcrumb')<span class="separator"><i class="fas fa-chevron-left"></i></span><span>ثوابت الموقع</span><span class="separator"><i class="fas fa-chevron-left"></i></span><span>السلايدر</span>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:13px;">شرائح السلايدر تظهر في قسم "السلايدر" بالصفحة الرئيسية</p>
    <button class="btn btn-nx-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus me-1"></i> إضافة شريحة</button>
</div>
<div class="row g-3">
    @forelse($items as $item)
    <div class="col-md-6 col-lg-4">
        <div class="nx-card {{ !$item->is_active ? 'opacity-50' : '' }}">
            <div class="card-body p-0">
                @if($item->image)
                <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" style="width:100%;height:160px;object-fit:cover;border-radius:12px 12px 0 0;">
                @else
                <div style="width:100%;height:160px;background:linear-gradient(135deg,#7c3aed,#6d28d9);border-radius:12px 12px 0 0;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-image" style="font-size:36px;color:rgba(255,255,255,0.3);"></i>
                </div>
                @endif
                <div class="p-3">
                    <h6 class="fw-bold mb-1">{{ $item->title }}</h6>
                    @if($item->subtitle)<p class="text-muted small mb-2">{{ Str::limit($item->subtitle, 60) }}</p>@endif
                    @if($item->button_text)<span class="nx-badge primary" style="font-size:10px;">{{ $item->button_text }}</span>@endif
                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2" style="border-top:1px solid var(--nx-border);">
                        <span class="nx-badge {{ $item->is_active ? 'success' : 'secondary' }}">{{ $item->is_active ? 'مفعل' : 'معطل' }}</span>
                        <div>
                            <button class="btn btn-sm btn-nx-secondary edit-btn"
                                data-id="{{ $item->id }}"
                                data-title="{{ $item->title }}"
                                data-subtitle="{{ $item->subtitle }}"
                                data-button_text="{{ $item->button_text }}"
                                data-button_url="{{ $item->button_url }}"
                                data-image="{{ $item->image }}"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('admin.website.sliders.destroy', $item->id) }}" method="POST" class="d-inline del-form">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-nx-secondary text-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="nx-card">
            <div class="card-body text-center py-5 text-muted">
                <i class="fas fa-images mb-3" style="font-size:36px;opacity:0.3;"></i>
                <h6>لا توجد شرائح بعد</h6>
                <p class="small">أضف شريحة لتظهر في السلايدر بالصفحة الرئيسية</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form action="{{ route('admin.website.sliders.store') }}" method="POST" enctype="multipart/form-data">@csrf
<div class="modal-header"><h5 class="modal-title">إضافة شريحة</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
    <div class="mb-3"><label class="form-label">العنوان *</label><input type="text" name="title" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">العنوان الفرعي</label><input type="text" name="subtitle" class="form-control"></div>
    <div class="mb-3"><label class="form-label">الصورة</label><input type="file" name="image" class="form-control" accept="image/*"></div>
    <div class="row g-2">
        <div class="col-md-6"><label class="form-label">نص الزر</label><input type="text" name="button_text" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">رابط الزر</label><input type="text" name="button_url" class="form-control" dir="ltr"></div>
    </div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button><button type="submit" class="btn btn-nx-primary"><i class="fas fa-plus me-1"></i> إضافة</button></div>
</form></div></div></div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form id="editForm" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
<div class="modal-header"><h5 class="modal-title">تعديل الشريحة</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
    <div class="mb-3"><label class="form-label">العنوان *</label><input type="text" name="title" id="eTitle" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">العنوان الفرعي</label><input type="text" name="subtitle" id="eSubtitle" class="form-control"></div>
    <div class="mb-3">
        <label class="form-label">الصورة</label>
        <div id="eImagePreview" class="mb-2" style="display:none;"><img src="" style="max-height:100px;border-radius:8px;"></div>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>
    <div class="row g-2">
        <div class="col-md-6"><label class="form-label">نص الزر</label><input type="text" name="button_text" id="eBtnText" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">رابط الزر</label><input type="text" name="button_url" id="eBtnUrl" class="form-control" dir="ltr"></div>
    </div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button><button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> حفظ</button></div>
</form></div></div></div>
@endsection

@section('scripts')
<script>
$(document).on('click', '.edit-btn', function() {
    var d = $(this).data();
    $('#editForm').attr('action', '/admin/website/sliders/' + d.id);
    $('#eTitle').val(d.title);
    $('#eSubtitle').val(d.subtitle);
    $('#eBtnText').val(d.button_text);
    $('#eBtnUrl').val(d.button_url);
    if (d.image) {
        $('#eImagePreview').show().find('img').attr('src', '/' + d.image);
    } else {
        $('#eImagePreview').hide();
    }
    new bootstrap.Modal('#editModal').show();
});
$(document).on('submit', '.del-form', function(e) {
    e.preventDefault();
    var f = this;
    Swal.fire({ title: 'حذف الشريحة؟', icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'نعم', cancelButtonText: 'إلغاء' })
    .then(function(r) { if (r.isConfirmed) f.submit(); });
});
</script>
@endsection
