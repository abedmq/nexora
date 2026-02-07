@extends('admin.layouts.app')

@section('title', 'إنشاء قائمة')
@section('page-title', 'إنشاء قائمة جديدة')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <a href="{{ route('admin.menus.index') }}">القوائم</a>
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>إنشاء قائمة</span>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="nx-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-plus me-2"></i> إنشاء قائمة جديدة</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.menus.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">اسم القائمة <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="مثال: القائمة الرئيسية" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">موقع القائمة <span class="text-danger">*</span></label>
                            @if(count($locations) > 0)
                            <div class="row g-3">
                                @foreach($locations as $key => $label)
                                <div class="col-md-6">
                                    <label class="location-card {{ old('location') === $key ? 'selected' : '' }}">
                                        <input type="radio" name="location" value="{{ $key }}" {{ old('location') === $key ? 'checked' : '' }} required>
                                        <div class="location-card-inner">
                                            <i class="fas fa-{{ $key === 'header' ? 'window-maximize' : 'window-minimize' }}"></i>
                                            <div class="fw-semibold">{{ $label }}</div>
                                            <small class="text-muted">{{ $key === 'header' ? 'تظهر في أعلى الموقع' : 'تظهر في أسفل الموقع' }}</small>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('location') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                جميع المواقع المتاحة تم استخدامها. لا يمكن إنشاء قائمة جديدة.
                            </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">وصف (اختياري)</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="وصف مختصر للقائمة...">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-nx-primary" @if(count($locations) === 0) disabled @endif>
                                <i class="fas fa-check me-1"></i> إنشاء القائمة
                            </button>
                            <a href="{{ route('admin.menus.index') }}" class="btn btn-nx-secondary">
                                <i class="fas fa-arrow-right me-1"></i> رجوع
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
<style>
    .location-card { display:block; cursor:pointer; }
    .location-card input { display:none; }
    .location-card-inner {
        border:2px solid var(--nx-border);
        border-radius:12px;
        padding:20px;
        text-align:center;
        transition:all 0.2s;
    }
    .location-card-inner i { font-size:28px; color:var(--nx-text-muted); margin-bottom:8px; display:block; }
    .location-card:hover .location-card-inner { border-color:var(--nx-primary); }
    .location-card.selected .location-card-inner,
    .location-card input:checked + .location-card-inner {
        border-color:var(--nx-primary);
        background:rgba(124,58,237,0.05);
    }
    .location-card input:checked + .location-card-inner i { color:var(--nx-primary); }
</style>
@endsection

@section('scripts')
<script>
    $('input[name="location"]').on('change', function() {
        $('.location-card').removeClass('selected');
        $(this).closest('.location-card').addClass('selected');
    });
</script>
@endsection
