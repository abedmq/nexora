@extends('admin.layouts.app')

@section('title', 'القاعات والمكاتب')
@section('page-title', 'إدارة القاعات والمكاتب')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>القاعات / المكاتب</span>
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
                <div class="stat-icon purple"><i class="fas fa-building"></i></div>
                <div class="stat-details"><h3>{{ $stats['total'] }}</h3><p>إجمالي القاعات</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-door-open"></i></div>
                <div class="stat-details"><h3>{{ $stats['available'] }}</h3><p>متاحة</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-door-closed"></i></div>
                <div class="stat-details"><h3>{{ $stats['booked'] }}</h3><p>محجوزة</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon pink"><i class="fas fa-coins"></i></div>
                <div class="stat-details"><h3>{{ number_format($stats['revenue']) }} <small style="font-size:12px;">ر.س</small></h3><p>إيرادات الشهر</p></div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold mb-0">جميع القاعات والمكاتب</h5>
        <button class="btn btn-nx-primary" data-bs-toggle="modal" data-bs-target="#addHallModal">
            <i class="fas fa-plus me-1"></i> إضافة قاعة
        </button>
    </div>

    <!-- Cards Grid -->
    <div class="row g-3">
        @foreach($halls as $hall)
        <div class="col-xl-4 col-md-6">
            <div class="hall-card">
                <div class="hall-image">
                    @php
                        $icon = match($hall->type) {
                            'meeting_room' => 'fas fa-users',
                            'private_office' => 'fas fa-laptop-house',
                            'coworking' => 'fas fa-couch',
                            'training_room' => 'fas fa-graduation-cap',
                            default => 'fas fa-building',
                        };
                    @endphp
                    <i class="{{ $icon }}"></i>
                </div>
                <div class="hall-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="hall-name">{{ $hall->name }}</div>
                        <span class="nx-badge {{ $hall->status_color }}">{{ $hall->status_label }}</span>
                    </div>
                    <div class="hall-info">
                        <div><i class="fas fa-users"></i> السعة: {{ $hall->capacity }} شخص</div>
                        <div><i class="fas fa-coins"></i> السعر: {{ number_format($hall->price_per_hour) }} ر.س / ساعة</div>
                        @if($hall->amenities)
                        <div><i class="fas fa-tv"></i> {{ $hall->amenities }}</div>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        @if($hall->status === 'available')
                        <a href="{{ route('admin.bookings.create', ['hall_id' => $hall->id]) }}" class="btn btn-sm btn-nx-primary flex-fill">حجز</a>
                        @else
                        <button class="btn btn-sm btn-nx-secondary flex-fill" disabled>محجوزة</button>
                        @endif
                        <form action="{{ route('admin.halls.destroy', $hall->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addHallModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.halls.store') }}" method="POST" class="nx-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">إضافة قاعة / مكتب</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">اسم القاعة</label>
                            <input type="text" name="name" class="form-control" placeholder="أدخل اسم القاعة" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">النوع</label>
                            <select name="type" class="form-select" required>
                                <option value="meeting_room">قاعة اجتماعات</option>
                                <option value="private_office">مكتب خاص</option>
                                <option value="coworking">مساحة عمل مشتركة</option>
                                <option value="training_room">قاعة تدريب</option>
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">السعة</label>
                                <input type="number" name="capacity" class="form-control" placeholder="عدد الأشخاص" required min="1">
                            </div>
                            <div class="col-6">
                                <label class="form-label">السعر / ساعة</label>
                                <input type="number" name="price_per_hour" class="form-control" placeholder="0.00" step="0.01" required>
                            </div>
                        </div>
                        <div class="row g-3 mt-0">
                            <div class="col-4">
                                <label class="form-label" style="font-size:12px;">السعر / يوم</label>
                                <input type="number" name="price_per_day" class="form-control" placeholder="0.00" step="0.01">
                            </div>
                            <div class="col-4">
                                <label class="form-label" style="font-size:12px;">السعر / أسبوع</label>
                                <input type="number" name="price_per_week" class="form-control" placeholder="0.00" step="0.01">
                            </div>
                            <div class="col-4">
                                <label class="form-label" style="font-size:12px;">السعر / شهر</label>
                                <input type="number" name="price_per_month" class="form-control" placeholder="0.00" step="0.01">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">المرافق</label>
                            <textarea name="amenities" class="form-control" rows="2" placeholder="جهاز عرض، واي فاي..."></textarea>
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
