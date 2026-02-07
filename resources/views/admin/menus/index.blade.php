@extends('admin.layouts.app')

@section('title', 'القوائم')
@section('page-title', 'إدارة القوائم')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>القوائم</span>
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">القوائم</h5>
            <p class="text-muted mb-0">إدارة قوائم التنقل في الموقع (الهيدر والفوتر)</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-nx-primary">
            <i class="fas fa-plus me-1"></i> إنشاء قائمة جديدة
        </a>
    </div>

    <div class="row g-4">
        @forelse($menus as $menu)
        <div class="col-md-6">
            <div class="nx-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold mb-1">
                                <i class="fas fa-{{ $menu->location === 'header' ? 'window-maximize' : 'window-minimize' }} text-purple me-2"></i>
                                {{ $menu->name }}
                            </h5>
                            <span class="nx-badge {{ $menu->is_active ? 'success' : 'warning' }}">
                                {{ $menu->is_active ? 'مفعّلة' : 'معطّلة' }}
                            </span>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-nx-secondary" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.menus.edit', $menu->id) }}"><i class="fas fa-edit me-2"></i> تعديل</a></li>
                                <li>
                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit"><i class="fas fa-trash me-2"></i> حذف</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-3 text-muted" style="font-size:13px;">
                            <span><i class="fas fa-map-marker-alt me-1"></i> {{ $menu->location_label }}</span>
                            <span><i class="fas fa-list me-1"></i> {{ $menu->items_count }} عنصر</span>
                        </div>
                    </div>

                    @if($menu->description)
                    <p class="text-muted small mb-3">{{ $menu->description }}</p>
                    @endif

                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-sm btn-nx-primary w-100">
                        <i class="fas fa-edit me-1"></i> تعديل العناصر
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="nx-card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-bars" style="font-size:48px;color:var(--nx-text-muted);opacity:0.3;"></i>
                    <h5 class="mt-3 text-muted">لا توجد قوائم بعد</h5>
                    <p class="text-muted mb-3">أنشئ قائمة جديدة للهيدر أو الفوتر</p>
                    <a href="{{ route('admin.menus.create') }}" class="btn btn-nx-primary">
                        <i class="fas fa-plus me-1"></i> إنشاء قائمة
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

@endsection

@section('scripts')
<script>
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var $form = $(this);
        Swal.fire({
            title: 'حذف القائمة؟',
            text: 'سيتم حذف القائمة وجميع عناصرها نهائياً.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء'
        }).then(function(result) {
            if (result.isConfirmed) $form[0].submit();
        });
    });
</script>
@endsection
