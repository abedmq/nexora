@extends('admin.layouts.app')

@section('title', 'التقارير')
@section('page-title', 'التقارير')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>التقارير</span>
@endsection

@section('content')

    <!-- Tabs -->
    <ul class="nav nx-tabs mb-4" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#revenueTab">الإيرادات</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#bookingsTab">الحجوزات</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#subsTab">الاشتراكات</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#customersTab">العملاء</a></li>
    </ul>

    <div class="tab-content">
        <!-- Revenue -->
        <div class="tab-pane fade show active" id="revenueTab">
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="fas fa-coins"></i></div>
                        <div class="stat-details"><h3>{{ number_format($monthlyRevenue) }} <small style="font-size:12px;">ر.س</small></h3><p>إيرادات الشهر</p></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="fas fa-receipt"></i></div>
                        <div class="stat-details"><h3>{{ $totalTransactions }}</h3><p>عدد المعاملات</p></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon pink"><i class="fas fa-calculator"></i></div>
                        <div class="stat-details"><h3>{{ number_format($avgTransaction) }} <small style="font-size:12px;">ر.س</small></h3><p>متوسط المعاملة</p></div>
                    </div>
                </div>
            </div>
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">مخطط الإيرادات</h5></div>
                <div class="card-body"><div id="reportRevenueChart"></div></div>
            </div>
        </div>

        <!-- Bookings -->
        <div class="tab-pane fade" id="bookingsTab">
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="fas fa-calendar-check"></i></div>
                        <div class="stat-details"><h3>{{ $totalBookings }}</h3><p>إجمالي الحجوزات</p></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="fas fa-check-double"></i></div>
                        <div class="stat-details"><h3>{{ $confirmedPercent }}%</h3><p>نسبة التأكيد</p></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
                        <div class="stat-details"><h3>{{ $pendingPercent }}%</h3><p>قيد الانتظار</p></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon red"><i class="fas fa-times"></i></div>
                        <div class="stat-details"><h3>{{ $cancelledPercent }}%</h3><p>نسبة الإلغاء</p></div>
                    </div>
                </div>
            </div>
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">توزيع حالات الحجوزات</h5></div>
                <div class="card-body"><div id="reportBookingsChart"></div></div>
            </div>
        </div>

        <!-- Subscriptions -->
        <div class="tab-pane fade" id="subsTab">
            <div class="row g-3 mb-4">
                <div class="col-xl-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="fas fa-sun"></i></div>
                        <div class="stat-details"><h3>{{ $dailySubs }}</h3><p>يومية</p></div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="fas fa-calendar-alt"></i></div>
                        <div class="stat-details"><h3>{{ $monthlySubs }}</h3><p>شهرية</p></div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="fas fa-star"></i></div>
                        <div class="stat-details"><h3>{{ $specialSubs }}</h3><p>خاصة</p></div>
                    </div>
                </div>
            </div>
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">توزيع الاشتراكات</h5></div>
                <div class="card-body"><div id="reportSubsChart"></div></div>
            </div>
        </div>

        <!-- Customers -->
        <div class="tab-pane fade" id="customersTab">
            <div class="row g-3 mb-4">
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="fas fa-users"></i></div>
                        <div class="stat-details"><h3>{{ $totalCustomers }}</h3><p>إجمالي العملاء</p></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="fas fa-user-plus"></i></div>
                        <div class="stat-details"><h3>{{ $newCustomers }}</h3><p>جدد هذا الشهر</p></div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon pink"><i class="fas fa-crown"></i></div>
                        <div class="stat-details"><h3>{{ $vipCustomers }}</h3><p>عملاء VIP</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    new ApexCharts(document.querySelector("#reportRevenueChart"), {
        series: [{ name: 'الإيرادات', data: [18000,22000,19500,28000,25000,32000,29000,35000,31000,38000,42000,{{ $monthlyRevenue }}] }],
        chart: { type: 'bar', height: 350, fontFamily: 'Cairo, sans-serif', toolbar: { show: false } },
        colors: ['#7c3aed'], plotOptions: { bar: { borderRadius: 6, columnWidth: '50%' } }, dataLabels: { enabled: false },
        xaxis: { categories: ['يناير','فبراير','مارس','أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'] },
        yaxis: { labels: { formatter: function(v) { return v.toLocaleString('ar-SA') + ' ر.س'; } } },
        grid: { borderColor: 'var(--nx-border)' }
    }).render();

    new ApexCharts(document.querySelector("#reportBookingsChart"), {
        series: [{{ $confirmedPercent }}, {{ $pendingPercent }}, {{ $cancelledPercent }}],
        chart: { type: 'pie', height: 350, fontFamily: 'Cairo, sans-serif' },
        colors: ['#10b981', '#f59e0b', '#ef4444'], labels: ['مؤكد', 'قيد الانتظار', 'ملغي'],
        legend: { position: 'bottom', fontFamily: 'Cairo, sans-serif' }
    }).render();

    new ApexCharts(document.querySelector("#reportSubsChart"), {
        series: [{{ $dailySubs }}, {{ $monthlySubs }}, {{ $specialSubs }}],
        chart: { type: 'donut', height: 350, fontFamily: 'Cairo, sans-serif' },
        colors: ['#10b981', '#7c3aed', '#f59e0b'], labels: ['يومي', 'شهري', 'خاص'],
        legend: { position: 'bottom', fontFamily: 'Cairo, sans-serif' }
    }).render();
</script>
@endsection
