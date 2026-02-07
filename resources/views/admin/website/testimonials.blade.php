@extends('admin.layouts.app')

@section('title', 'آراء العملاء')
@section('page-title', 'آراء العملاء')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>آراء العملاء</span>
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">آراء العملاء</h5>
            <p class="text-muted mb-0" style="font-size:13px;">تظهر تلقائياً في قسم آراء العملاء بالصفحة الرئيسية</p>
        </div>
        <button class="btn btn-nx-primary" data-bs-toggle="modal" data-bs-target="#addTestimonialModal">
            <i class="fas fa-plus me-1"></i> إضافة رأي
        </button>
    </div>

    <div class="row g-3">
        @forelse($testimonials as $t)
        <div class="col-md-6 col-xl-4">
            <div class="nx-card h-100 {{ !$t->is_active ? 'opacity-50' : '' }}">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if($t->avatar)
                        <img src="{{ asset($t->avatar) }}" alt="" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                        @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($t->name) }}&background=7c3aed&color=fff&rounded=true&size=48" alt="">
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ $t->name }}</h6>
                            @if($t->position || $t->company)
                            <small class="text-muted">{{ $t->position }}{{ $t->company ? ' - ' . $t->company : '' }}</small>
                            @endif
                        </div>
                    </div>
                    <p class="text-muted mb-2" style="font-size:13px;">{{ Str::limit($t->content, 120) }}</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $t->rating ? 'text-warning' : 'text-muted' }}" style="font-size:12px;"></i>
                            @endfor
                        </div>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-nx-secondary edit-testimonial"
                                data-id="{{ $t->id }}" data-name="{{ $t->name }}"
                                data-position="{{ $t->position }}" data-company="{{ $t->company }}"
                                data-content="{{ $t->content }}" data-rating="{{ $t->rating }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.website.testimonials.destroy', $t->id) }}" method="POST" class="d-inline delete-form">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-nx-secondary text-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="nx-card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-quote-right" style="font-size:48px;color:var(--nx-text-muted);opacity:0.3;"></i>
                    <h6 class="mt-3 text-muted">لا توجد آراء بعد</h6>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addTestimonialModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.website.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة رأي عميل</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">الاسم *</label><input type="text" name="name" class="form-control" required></div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6"><label class="form-label">المنصب</label><input type="text" name="position" class="form-control"></div>
                            <div class="col-md-6"><label class="form-label">الشركة</label><input type="text" name="company" class="form-control"></div>
                        </div>
                        <div class="mb-3"><label class="form-label">الرأي *</label><textarea name="content" class="form-control" rows="3" required></textarea></div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6"><label class="form-label">التقييم</label><select name="rating" class="form-select"><option value="5">5 نجوم</option><option value="4">4 نجوم</option><option value="3">3 نجوم</option></select></div>
                            <div class="col-md-6"><label class="form-label">الصورة</label><input type="file" name="avatar" class="form-control" accept="image/*"></div>
                        </div>
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
    <div class="modal fade" id="editTestimonialModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editTestimonialForm" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل رأي العميل</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label">الاسم *</label><input type="text" name="name" id="editName" class="form-control" required></div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6"><label class="form-label">المنصب</label><input type="text" name="position" id="editPosition" class="form-control"></div>
                            <div class="col-md-6"><label class="form-label">الشركة</label><input type="text" name="company" id="editCompany" class="form-control"></div>
                        </div>
                        <div class="mb-3"><label class="form-label">الرأي *</label><textarea name="content" id="editContent" class="form-control" rows="3" required></textarea></div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6"><label class="form-label">التقييم</label><select name="rating" id="editRating" class="form-select"><option value="5">5 نجوم</option><option value="4">4 نجوم</option><option value="3">3 نجوم</option></select></div>
                            <div class="col-md-6"><label class="form-label">صورة جديدة</label><input type="file" name="avatar" class="form-control" accept="image/*"></div>
                        </div>
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
    $(document).on('click', '.edit-testimonial', function() {
        var d = $(this).data();
        $('#editTestimonialForm').attr('action', '/admin/website/testimonials/' + d.id);
        $('#editName').val(d.name);
        $('#editPosition').val(d.position);
        $('#editCompany').val(d.company);
        $('#editContent').val(d.content);
        $('#editRating').val(d.rating);
        new bootstrap.Modal('#editTestimonialModal').show();
    });

    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        Swal.fire({ title:'حذف الرأي؟', icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', confirmButtonText:'نعم، احذف', cancelButtonText:'إلغاء' })
        .then(function(r) { if (r.isConfirmed) $form[0].submit(); });
    });
</script>
@endsection
