@extends('admin.layouts.app')

@section('title', 'الشركاء')
@section('page-title', 'الشركاء')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>الشركاء</span>
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">الشركاء والعملاء</h5>
            <p class="text-muted mb-0" style="font-size:13px;">شعارات الشركاء تظهر في قسم الشركاء بالصفحة الرئيسية</p>
        </div>
        <button class="btn btn-nx-primary" data-bs-toggle="modal" data-bs-target="#addPartnerModal">
            <i class="fas fa-plus me-1"></i> إضافة شريك
        </button>
    </div>

    <div class="row g-3">
        @forelse($partners as $p)
        <div class="col-md-4 col-xl-3">
            <div class="nx-card h-100 text-center {{ !$p->is_active ? 'opacity-50' : '' }}">
                <div class="card-body">
                    @if($p->logo)
                    <img src="{{ asset($p->logo) }}" alt="{{ $p->name }}" style="max-height:60px;max-width:120px;object-fit:contain;margin-bottom:12px;">
                    @else
                    <div style="height:60px;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <i class="fas fa-building" style="font-size:32px;color:var(--nx-text-muted);"></i>
                    </div>
                    @endif
                    <h6 class="fw-bold mb-1">{{ $p->name }}</h6>
                    @if($p->url)<a href="{{ $p->url }}" class="small text-muted" target="_blank">{{ parse_url($p->url, PHP_URL_HOST) }}</a>@endif
                    <div class="mt-2 d-flex justify-content-center gap-1">
                        <button class="btn btn-sm btn-nx-secondary edit-partner"
                            data-id="{{ $p->id }}" data-name="{{ $p->name }}" data-url="{{ $p->url }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('admin.website.partners.destroy', $p->id) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-nx-secondary text-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="nx-card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-handshake" style="font-size:48px;color:var(--nx-text-muted);opacity:0.3;"></i>
                    <h6 class="mt-3 text-muted">لا يوجد شركاء بعد</h6>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addPartnerModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ route('admin.website.partners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header"><h5 class="modal-title">إضافة شريك</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">الاسم *</label><input type="text" name="name" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">الموقع</label><input type="url" name="url" class="form-control" dir="ltr" placeholder="https://"></div>
                        <div class="mb-3"><label class="form-label">الشعار</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-nx-primary"><i class="fas fa-plus me-1"></i> إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editPartnerModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="editPartnerForm" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-header"><h5 class="modal-title">تعديل الشريك</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">الاسم *</label><input type="text" name="name" id="editPartnerName" class="form-control" required></div>
                        <div class="mb-3"><label class="form-label">الموقع</label><input type="url" name="url" id="editPartnerUrl" class="form-control" dir="ltr"></div>
                        <div class="mb-3"><label class="form-label">شعار جديد</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $(document).on('click', '.edit-partner', function() {
        var d = $(this).data();
        $('#editPartnerForm').attr('action', '/admin/website/partners/' + d.id);
        $('#editPartnerName').val(d.name);
        $('#editPartnerUrl').val(d.url);
        new bootstrap.Modal('#editPartnerModal').show();
    });
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        Swal.fire({ title:'حذف الشريك؟', icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', confirmButtonText:'نعم، احذف', cancelButtonText:'إلغاء' })
        .then(function(r) { if (r.isConfirmed) $form[0].submit(); });
    });
</script>
@endsection
