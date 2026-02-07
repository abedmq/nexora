@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>لوحة التحكم</span>
@endsection

@section('content')

    <!-- Stat Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ $todayBookings }}</h3>
                    <p>حجوزات اليوم</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ $subscribers }}</h3>
                    <p>المشتركين النشطين</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ $availableHalls }}<small style="font-size:14px;color:var(--nx-text-muted);">/{{ $totalHalls }}</small></h3>
                    <p>القاعات المتاحة</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon pink">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stat-details">
                    <h3>{{ number_format($monthlyRevenue) }} <small style="font-size:14px;">ر.س</small></h3>
                    <p>الإيرادات الشهرية</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Open Bookings -->
    @if($openBookings->count() > 0)
    <div class="nx-card mb-4">
        <div class="card-header">
            <h5 class="card-title"><i class="fas fa-unlock me-1 text-info"></i> الحجوزات المفتوحة <span class="nx-badge info ms-2">{{ $openBookings->count() }}</span></h5>
            <a href="{{ route('admin.bookings.index', ['status' => 'open']) }}" class="btn btn-sm btn-nx-secondary">عرض الكل</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table nx-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>القاعة</th>
                            <th>نوع الحساب</th>
                            <th>التاريخ</th>
                            <th>وقت البداية</th>
                            <th>سعر الوحدة</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($openBookings as $ob)
                        <tr>
                            <td class="fw-semibold">#BK-{{ $ob->id }}</td>
                            <td>
                                <div class="user-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($ob->customer->name) }}&background=7c3aed&color=fff&rounded=true&size=36" alt="">
                                    <span>{{ $ob->customer->name }}</span>
                                </div>
                            </td>
                            <td>{{ $ob->hall->name }}</td>
                            <td><span class="nx-badge info">{{ $ob->billing_type_label }}</span></td>
                            <td>{{ $ob->booking_date->format('Y-m-d') }}</td>
                            <td>{{ $ob->start_time }}</td>
                            <td class="fw-semibold">{{ number_format($ob->unit_price) }} ر.س</td>
                            <td>
                                <a href="{{ route('admin.bookings.show', $ob->id) }}" class="btn btn-sm btn-nx-secondary me-1"><i class="fas fa-eye"></i></a>
                                <form action="{{ route('admin.bookings.close', $ob->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="close_date" value="{{ now()->format('Y-m-d') }}">
                                    <input type="hidden" name="close_time" value="{{ now()->format('H:i') }}">
                                    <button class="btn btn-sm btn-nx-primary btn-close-open" type="button"><i class="fas fa-lock me-1"></i> إغلاق</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-8">
            <div class="nx-card">
                <div class="card-header">
                    <h5 class="card-title">نظرة عامة على الإيرادات</h5>
                </div>
                <div class="card-body">
                    <div id="revenueChart"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="nx-card">
                <div class="card-header">
                    <h5 class="card-title">توزيع الحجوزات</h5>
                </div>
                <div class="card-body">
                    <div id="bookingsChart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="row g-3">
        <div class="col-xl-7">
            <div class="nx-card">
                <div class="card-header">
                    <h5 class="card-title">آخر الحجوزات</h5>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-nx-secondary">عرض الكل</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table nx-table mb-0">
                            <thead>
                                <tr>
                                    <th>العميل</th>
                                    <th>القاعة</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestBookings as $booking)
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->customer->name) }}&background=7c3aed&color=fff&rounded=true&size=36" alt="">
                                            <span>{{ $booking->customer->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $booking->hall->name }}</td>
                                    <td class="text-muted">{{ $booking->booking_date->translatedFormat('j F Y') }}</td>
                                    <td><span class="nx-badge {{ $booking->status_color }}"><i class="fas fa-circle" style="font-size:6px;"></i> {{ $booking->status_label }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">لا توجد حجوزات حالياً</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="nx-card">
                <div class="card-header">
                    <h5 class="card-title">النشاطات الأخيرة</h5>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        @foreach($latestBookings->take(4) as $booking)
                        <div class="activity-item {{ $booking->status_color }}">
                            <div class="activity-title">
                                {{ $booking->status === 'confirmed' ? 'تأكيد' : ($booking->status === 'cancelled' ? 'إلغاء' : 'حجز جديد') }}
                                - <span class="text-purple">{{ $booking->hall->name }}</span>
                                <span class="fw-semibold">({{ $booking->customer->name }})</span>
                            </div>
                            <div class="activity-time">{{ $booking->booking_date->translatedFormat('j F Y') }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    var revenueOptions = {
        series: [{
            name: 'الإيرادات',
            data: [18000, 22000, 19500, 28000, 25000, 32000, 29000, 35000, 31000, 38000, 42000, {{ $monthlyRevenue }}]
        }],
        chart: { type: 'area', height: 320, fontFamily: 'Cairo, sans-serif', toolbar: { show: false }, zoom: { enabled: false } },
        colors: ['#7c3aed'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.05 } },
        xaxis: { categories: ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'] },
        yaxis: { labels: { formatter: function(v) { return v.toLocaleString('ar-SA') + ' ر.س'; } } },
        tooltip: { style: { fontFamily: 'Cairo, sans-serif' }, y: { formatter: function(v) { return v.toLocaleString('ar-SA') + ' ر.س'; } } },
        grid: { borderColor: 'var(--nx-border)' }
    };
    new ApexCharts(document.querySelector("#revenueChart"), revenueOptions).render();

    var bookingsOptions = {
        series: [40, 30, 20, 10],
        chart: { type: 'donut', height: 280, fontFamily: 'Cairo, sans-serif' },
        colors: ['#7c3aed', '#ec4899', '#3b82f6', '#f59e0b'],
        labels: ['قاعات اجتماعات', 'مكاتب خاصة', 'مساحات مشتركة', 'قاعات تدريب'],
        legend: { position: 'bottom', fontFamily: 'Cairo, sans-serif' },
        plotOptions: { pie: { donut: { size: '70%', labels: { show: true, name: { fontFamily: 'Cairo, sans-serif' }, value: { fontFamily: 'Cairo, sans-serif', formatter: function(v) { return v + '%'; } }, total: { show: true, label: 'الإجمالي', fontFamily: 'Cairo, sans-serif' } } } } },
        dataLabels: { enabled: false },
    };
    new ApexCharts(document.querySelector("#bookingsChart"), bookingsOptions).render();

    // Close open booking with confirmation
    $(document).on('click', '.btn-close-open', function(e) {
        e.preventDefault();
        var $form = $(this).closest('form');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'إغلاق الحجز؟',
                text: 'سيتم حساب المبلغ الإجمالي حتى الآن.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#7c3aed',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'نعم، أغلق',
                cancelButtonText: 'إلغاء'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $form.submit();
                }
            });
        } else {
            $form.submit();
        }
    });
</script>
@endsection
