@extends('admin.layouts.app')
@section('title', 'الخدمات')
@section('page-title', 'الخدمات')
@section('breadcrumb')<span class="separator"><i class="fas fa-chevron-left"></i></span><span>ثوابت الموقع</span><span class="separator"><i class="fas fa-chevron-left"></i></span><span>الخدمات</span>@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:13px;">العناصر تظهر في قسم "الخدمات" بالصفحة الرئيسية</p>
    <button class="btn btn-nx-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus me-1"></i> إضافة خدمة</button>
</div>
<div class="nx-card">
    <div class="card-body p-0">
        <table class="table nx-table mb-0">
            <thead><tr><th style="width:50px">#</th><th style="width:50px">أيقونة</th><th>العنوان</th><th>الوصف</th><th style="width:80px">الحالة</th><th style="width:100px">إجراءات</th></tr></thead>
            <tbody>
                @forelse($items as $item)
                <tr class="{{ !$item->is_active ? 'opacity-50' : '' }}">
                    <td>{{ $item->id }}</td>
                    <td><i class="{{ $item->icon }}" style="font-size:18px;color:var(--nx-primary);"></i></td>
                    <td class="fw-semibold">{{ $item->title }}</td>
                    <td class="text-muted" style="font-size:12px;">{{ Str::limit($item->description, 60) }}</td>
                    <td><span class="nx-badge {{ $item->is_active ? 'success' : 'secondary' }}">{{ $item->is_active ? 'مفعل' : 'معطل' }}</span></td>
                    <td>
                        <button class="btn btn-sm btn-nx-secondary edit-btn" data-id="{{ $item->id }}" data-icon="{{ $item->icon }}" data-title="{{ $item->title }}" data-description="{{ $item->description }}"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('admin.website.services.destroy', $item->id) }}" method="POST" class="d-inline del-form">@csrf @method('DELETE')<button class="btn btn-sm btn-nx-secondary text-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">لا توجد عناصر</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form action="{{ route('admin.website.services.store') }}" method="POST">@csrf
<div class="modal-header"><h5 class="modal-title">إضافة خدمة</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
    <div class="mb-3"><label class="form-label">الأيقونة</label><input type="text" name="icon" class="form-control" value="fas fa-concierge-bell" dir="ltr"></div>
    <div class="mb-3"><label class="form-label">العنوان *</label><input type="text" name="title" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الوصف</label><textarea name="description" class="form-control" rows="2"></textarea></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button><button type="submit" class="btn btn-nx-primary"><i class="fas fa-plus me-1"></i> إضافة</button></div>
</form></div></div></div>

<div class="modal fade" id="editModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form id="editForm" method="POST">@csrf @method('PUT')
<div class="modal-header"><h5 class="modal-title">تعديل الخدمة</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
    <div class="mb-3"><label class="form-label">الأيقونة</label><input type="text" name="icon" id="eIcon" class="form-control" dir="ltr"></div>
    <div class="mb-3"><label class="form-label">العنوان *</label><input type="text" name="title" id="eTitle" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">الوصف</label><textarea name="description" id="eDesc" class="form-control" rows="2"></textarea></div>
</div>
<div class="modal-footer"><button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button><button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> حفظ</button></div>
</form></div></div></div>
@endsection

@section('scripts')
<script>
$(document).on('click','.edit-btn',function(){var d=$(this).data();$('#editForm').attr('action','/admin/website/services/'+d.id);$('#eIcon').val(d.icon);$('#eTitle').val(d.title);$('#eDesc').val(d.description);new bootstrap.Modal('#editModal').show();});
$(document).on('submit','.del-form',function(e){e.preventDefault();var f=this;Swal.fire({title:'حذف العنصر؟',icon:'warning',showCancelButton:true,confirmButtonColor:'#ef4444',confirmButtonText:'نعم',cancelButtonText:'إلغاء'}).then(function(r){if(r.isConfirmed)f.submit();});});
</script>
@endsection
