@extends('admin.layouts.app')

@section('title', 'الاشتراكات')
@section('page-title', 'إدارة الاشتراكات')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>الاشتراكات</span>
@endsection

@section('content')

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-success-light);color:var(--nx-success);">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-file-contract"></i></div>
                <div class="stat-details"><h3>{{ $stats['total'] }}</h3><p>إجمالي الاشتراكات</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                <div class="stat-details"><h3>{{ $stats['active'] }}</h3><p>نشط</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-exclamation-circle"></i></div>
                <div class="stat-details"><h3>{{ $stats['expiring_soon'] }}</h3><p>قريب الانتهاء</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
                <div class="stat-details"><h3>{{ $stats['expired'] }}</h3><p>منتهي</p></div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold mb-0">جميع الاشتراكات</h5>
        <button class="btn btn-nx-primary" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal">
            <i class="fas fa-plus me-1"></i> اشتراك جديد
        </button>
    </div>

    <!-- Cards Grid -->
    <div class="row g-3">
        @foreach($subscriptions as $sub)
        <div class="col-xl-4 col-md-6">
            <div class="subscription-card">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="sub-icon" style="background:var(--nx-{{ $sub->type_color == 'primary' ? 'primary-lighter' : $sub->type_color . '-light' }});color:var(--nx-{{ $sub->type_color == 'primary' ? 'primary' : $sub->type_color }});">
                        <i class="{{ $sub->type_icon }}"></i>
                    </div>
                    <span class="nx-badge {{ $sub->status_color }}"><i class="fas fa-circle" style="font-size:6px;"></i> {{ $sub->status_label }}</span>
                </div>
                <div class="sub-type">اشتراك {{ $sub->type_label }}</div>
                <div class="sub-client"><i class="fas fa-user me-1"></i> {{ $sub->customer->name }}</div>
                <div class="sub-dates">
                    <span><i class="fas fa-calendar-plus me-1 text-purple"></i> البداية: {{ $sub->start_date->format('Y-m-d') }}</span>
                    <span><i class="fas fa-calendar-minus me-1 text-danger"></i> النهاية: {{ $sub->end_date->format('Y-m-d') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-purple">{{ number_format($sub->price) }} ر.س</span>
                    <form action="{{ route('admin.subscriptions.destroy', $sub->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addSubscriptionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="nx-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">اشتراك جديد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">العميل</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">اختر العميل...</option>
                                @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">نوع الاشتراك</label>
                            <select name="type" class="form-select" required>
                                <option value="daily">يومي</option>
                                <option value="monthly">شهري</option>
                                <option value="special">خاص</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">تاريخ البداية</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">تاريخ النهاية</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">السعر (ر.س)</label>
                            <input type="number" name="price" class="form-control" step="0.01" required placeholder="0.00">
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
