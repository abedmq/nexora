@extends('admin.layouts.app')

@section('title', 'الثيمات')
@section('page-title', 'الثيمات')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>الثيمات</span>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-success-light);color:var(--nx-success);">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-danger-light);color:var(--nx-danger);">
            <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        $features = [
            'theme_settings' => 'إعدادات الثيم',
            'demo' => 'الديمو',
            'homepage_builder' => 'محرر الصفحة الرئيسية',
        ];
    @endphp

    <div class="row g-4">
        @foreach($themes as $slug => $theme)
            @php
                $isActive = $activeTheme === $slug;
                $colors = $theme['colors'] ?? [];
            @endphp
            <div class="col-lg-4 col-md-6">
                <div class="nx-card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">{{ $theme['name'] ?? $slug }}</h5>
                        @if($isActive)
                            <span class="badge bg-success">مفعل</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="text-muted" style="font-size:13px;">{{ $theme['description'] ?? '' }}</p>

                        @if($colors)
                            <div class="d-flex align-items-center gap-2 mb-3">
                                @foreach($colors as $color)
                                    <span style="width:22px;height:22px;border-radius:50%;background:{{ $color }};border:1px solid rgba(0,0,0,0.08);"></span>
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-3">
                            <div class="text-muted mb-2" style="font-size:12px;font-weight:600;">الصفحات المدعومة</div>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($features as $key => $label)
                                    @php $supported = data_get($theme, 'supports.' . $key, false); @endphp
                                    <span class="badge {{ $supported ? 'bg-primary' : 'bg-light text-muted border' }}">{{ $label }}</span>
                                @endforeach
                            </div>
                        </div>

                        @if(!$isActive)
                            <form action="{{ route('admin.themes.activate', $slug) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-nx-primary w-100">
                                    <i class="fas fa-bolt me-1"></i> تفعيل الثيم
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-nx-secondary w-100" disabled>
                                <i class="fas fa-check me-1"></i> الثيم مفعل حالياً
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
