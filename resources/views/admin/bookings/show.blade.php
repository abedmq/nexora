@extends('admin.layouts.app')

@section('title', 'تفاصيل الحجز')
@section('page-title', 'تفاصيل الحجز')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <a href="{{ route('admin.bookings.index') }}">الحجوزات</a>
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>حجز #BK-{{ $booking->id }}</span>
@endsection

@section('content')

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-success-light);color:var(--nx-success);">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="nx-card mb-3">
                <div class="card-header">
                    <h5 class="card-title">معلومات الحجز</h5>
                    <span class="nx-badge {{ $booking->status_color }}"><i class="fas fa-circle" style="font-size:6px;"></i> {{ $booking->status_label }}</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">رقم الحجز</label>
                            <div class="fw-semibold">#BK-{{ $booking->id }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">القاعة</label>
                            <div class="fw-semibold">{{ $booking->hall->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">نوع القاعة</label>
                            <div class="fw-semibold">{{ $booking->hall->type_label }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">نوع الحساب</label>
                            <div class="fw-semibold">{{ $booking->billing_type_label }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">التاريخ</label>
                            <div class="fw-semibold">{{ $booking->booking_date->format('Y-m-d') }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">الوقت</label>
                            <div class="fw-semibold">
                                {{ $booking->start_time }}
                                @if($booking->end_time)
                                    - {{ $booking->end_time }}
                                @else
                                    - <span class="text-info">مفتوح</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">المدة</label>
                            <div class="fw-semibold">{{ $booking->duration }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">سعر الوحدة</label>
                            <div class="fw-semibold">{{ number_format($booking->unit_price) }} ر.س / {{ $booking->billing_type_label }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">التكلفة الإجمالية</label>
                            <div class="fw-semibold text-purple" style="font-size:18px;">
                                @if($booking->status === 'open')
                                    <span class="text-info">قيد الحساب...</span>
                                @else
                                    {{ number_format($booking->total_price) }} ر.س
                                @endif
                            </div>
                        </div>
                        @if($booking->closed_at)
                        <div class="col-md-6">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">تاريخ الإغلاق</label>
                            <div class="fw-semibold">{{ $booking->closed_at->format('Y-m-d H:i') }}</div>
                        </div>
                        @endif
                        @if($booking->notes)
                        <div class="col-12">
                            <label class="text-muted d-block mb-1" style="font-size:12px;">ملاحظات</label>
                            <div>{{ $booking->notes }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="nx-card mb-3">
                <div class="card-header"><h5 class="card-title">معلومات العميل</h5></div>
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->customer->name) }}&background=7c3aed&color=fff&rounded=true&size=80" alt="" class="mb-3" style="border-radius:16px;">
                    <h6 class="fw-semibold mb-1">{{ $booking->customer->name }}</h6>
                    <p class="text-muted mb-2" style="font-size:13px;">{{ $booking->customer->email }}</p>
                    @if($booking->customer->phone)
                    <p class="text-muted mb-3" style="font-size:13px;"><i class="fas fa-phone me-1"></i> {{ $booking->customer->phone }}</p>
                    @endif
                </div>
            </div>
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">الإجراءات</h5></div>
                <div class="card-body d-flex flex-column gap-2">
                    @if($booking->status === 'open')
                    <form action="{{ route('admin.bookings.close', $booking->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-nx-primary w-100"><i class="fas fa-lock me-1"></i> إغلاق الحجز</button>
                    </form>
                    @endif
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-nx-secondary"><i class="fas fa-arrow-right me-1"></i> العودة للقائمة</a>
                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger w-100 btn-delete"><i class="fas fa-trash-alt me-1"></i> حذف الحجز</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
