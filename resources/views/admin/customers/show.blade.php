@extends('admin.layouts.app')

@section('title', 'تفاصيل العميل')
@section('page-title', 'تفاصيل العميل')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <a href="{{ route('admin.customers.index') }}">العملاء</a>
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>{{ $customer->name }}</span>
@endsection

@section('content')
    <div class="row g-3">
        <!-- Profile -->
        <div class="col-lg-4">
            <div class="nx-card mb-3">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=7c3aed&color=fff&rounded=true&size=96" alt="" class="mb-3" style="border-radius:20px;">
                    <h5 class="fw-semibold mb-1">{{ $customer->name }}</h5>
                    <p class="text-muted mb-1" style="font-size:13px;">{{ $customer->email }}</p>
                    @if($customer->phone)
                    <p class="text-muted mb-2" style="font-size:13px;"><i class="fas fa-phone me-1"></i> {{ $customer->phone }}</p>
                    @endif
                    <span class="nx-badge {{ $customer->type === 'vip' ? 'warning' : 'info' }}">{{ $customer->type_label }}</span>
                </div>
            </div>
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">ملخص</h5></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">إجمالي الحجوزات</span>
                        <span class="fw-semibold">{{ $customer->bookings->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">الاشتراكات</span>
                        <span class="fw-semibold">{{ $customer->subscriptions->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">تاريخ التسجيل</span>
                        <span class="fw-semibold">{{ $customer->created_at->format('Y-m-d') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="col-lg-8">
            <!-- Bookings -->
            <div class="nx-card mb-3">
                <div class="card-header"><h5 class="card-title">الحجوزات</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table nx-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>القاعة</th>
                                    <th>التاريخ</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->bookings as $booking)
                                <tr>
                                    <td>#BK-{{ $booking->id }}</td>
                                    <td>{{ $booking->hall->name }}</td>
                                    <td>{{ $booking->booking_date->format('Y-m-d') }}</td>
                                    <td>{{ number_format($booking->total_price) }} ر.س</td>
                                    <td><span class="nx-badge {{ $booking->status_color }}">{{ $booking->status_label }}</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-muted">لا توجد حجوزات</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Subscriptions -->
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">الاشتراكات</h5></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table nx-table mb-0">
                            <thead>
                                <tr>
                                    <th>النوع</th>
                                    <th>البداية</th>
                                    <th>النهاية</th>
                                    <th>السعر</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->subscriptions as $sub)
                                <tr>
                                    <td>{{ $sub->type_label }}</td>
                                    <td>{{ $sub->start_date->format('Y-m-d') }}</td>
                                    <td>{{ $sub->end_date->format('Y-m-d') }}</td>
                                    <td>{{ number_format($sub->price) }} ر.س</td>
                                    <td><span class="nx-badge {{ $sub->status_color }}">{{ $sub->status_label }}</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-muted">لا توجد اشتراكات</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
