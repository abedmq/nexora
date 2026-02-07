@extends('admin.layouts.app')

@section('title', 'الحجوزات')
@section('page-title', 'إدارة الحجوزات')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>الحجوزات</span>
@endsection

@section('content')

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-success-light);color:var(--nx-success);">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" style="border-radius:var(--nx-radius-sm);border:none;background:var(--nx-danger-light);color:var(--nx-danger);">
        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-details"><h3>{{ $stats['total'] }}</h3><p>إجمالي الحجوزات</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-unlock"></i></div>
                <div class="stat-details"><h3>{{ $stats['open'] }}</h3><p>مفتوحة</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                <div class="stat-details"><h3>{{ $stats['confirmed'] }}</h3><p>مؤكدة</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
                <div class="stat-details"><h3>{{ $stats['pending'] }}</h3><p>قيد الانتظار</p></div>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="nx-card">
        <div class="card-header">
            <h5 class="card-title">جميع الحجوزات</h5>
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-nx-primary">
                <i class="fas fa-plus me-1"></i> حجز جديد
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="bookingsTable" class="table nx-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العميل</th>
                            <th>القاعة</th>
                            <th>نوع الحساب</th>
                            <th>التاريخ</th>
                            <th>المدة</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td class="fw-semibold">#BK-{{ $booking->id }}</td>
                            <td>
                                <div class="user-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->customer->name) }}&background=7c3aed&color=fff&rounded=true&size=36" alt="">
                                    <div>
                                        <div class="fw-semibold">{{ $booking->customer->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $booking->hall->name }}</td>
                            <td><span class="nx-badge info">{{ $booking->billing_type_label }}</span></td>
                            <td>{{ $booking->booking_date->format('Y-m-d') }}</td>
                            <td>{{ $booking->duration }}</td>
                            <td class="fw-semibold">
                                @if($booking->status === 'open')
                                    <span class="text-muted">قيد الحساب</span>
                                @else
                                    {{ number_format($booking->total_price) }} ر.س
                                @endif
                            </td>
                            <td><span class="nx-badge {{ $booking->status_color }}"><i class="fas fa-circle" style="font-size:6px;"></i> {{ $booking->status_label }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if($booking->status === 'open')
                                    <button class="btn btn-sm btn-nx-primary btn-close-booking"
                                            data-id="{{ $booking->id }}"
                                            data-customer="{{ $booking->customer->name }}"
                                            data-hall="{{ $booking->hall->name }}"
                                            data-billing="{{ $booking->billing_type_label }}"
                                            data-price="{{ $booking->unit_price }}"
                                            data-start="{{ $booking->start_time }}"
                                            data-date="{{ $booking->booking_date->format('Y-m-d') }}">
                                        <i class="fas fa-lock me-1"></i> إغلاق
                                    </button>
                                    @endif
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-nx-secondary"><i class="fas fa-eye"></i></a>
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Close Booking Modal --}}
    <div class="modal fade" id="closeBookingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold"><i class="fas fa-lock me-1 text-purple"></i> إغلاق الحجز</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">العميل</span>
                            <span class="fw-semibold" id="closeCustomer"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">القاعة</span>
                            <span class="fw-semibold" id="closeHall"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">نوع الحساب</span>
                            <span class="fw-semibold" id="closeBilling"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">سعر الوحدة</span>
                            <span class="fw-semibold" id="closePrice"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">بداية الحجز</span>
                            <span class="fw-semibold" id="closeStart"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="nx-form">
                        <p class="text-muted mb-3" style="font-size:13px;"><i class="fas fa-clock me-1 text-purple"></i> تحديد وقت وتاريخ الإغلاق:</p>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label" style="font-size:12px;">تاريخ الإغلاق</label>
                                <input type="date" id="closeDateInput" class="form-control" form="closeBookingForm">
                            </div>
                            <div class="col-6">
                                <label class="form-label" style="font-size:12px;">وقت الإغلاق</label>
                                <input type="time" id="closeTimeInput" class="form-control" form="closeBookingForm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form id="closeBookingForm" method="POST">
                        @csrf
                        <input type="hidden" name="close_date" id="closeDateHidden">
                        <input type="hidden" name="close_time" id="closeTimeHidden">
                        <button type="submit" class="btn btn-nx-primary"><i class="fas fa-lock me-1"></i> إغلاق وحساب الفاتورة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Invoice Result Modal --}}
    <div class="modal fade" id="invoiceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background:var(--nx-primary-lighter);border:none;">
                    <h5 class="modal-title fw-semibold text-purple"><i class="fas fa-receipt me-1"></i> الفاتورة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-check-circle text-success" style="font-size:48px;"></i>
                    <h5 class="fw-bold mt-3 mb-1">تم إغلاق الحجز بنجاح</h5>
                    <p class="text-muted mb-3" id="invoiceDuration"></p>
                    <div class="display-4 fw-bold text-purple" id="invoiceTotal"></div>
                    <small class="text-muted">ريال سعودي</small>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-nx-secondary" data-bs-dismiss="modal" onclick="location.reload()">حسناً</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#bookingsTable').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json' },
        pageLength: 10, order: [[0, 'desc']]
    });

    // Close booking button
    $('.btn-close-booking').on('click', function() {
        var $btn = $(this);
        $('#closeCustomer').text($btn.data('customer'));
        $('#closeHall').text($btn.data('hall'));
        $('#closeBilling').text($btn.data('billing'));
        $('#closePrice').text(parseFloat($btn.data('price')).toLocaleString('ar-SA') + ' ر.س');
        $('#closeStart').text($btn.data('date') + ' ' + $btn.data('start'));
        $('#closeBookingForm').attr('action', '/admin/bookings/' + $btn.data('id') + '/close');

        // Set default close date = today, time = now
        var now = new Date();
        var dateStr = now.getFullYear() + '-' + String(now.getMonth()+1).padStart(2,'0') + '-' + String(now.getDate()).padStart(2,'0');
        var timeStr = String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0');
        $('#closeDateInput').val(dateStr);
        $('#closeTimeInput').val(timeStr);

        new bootstrap.Modal('#closeBookingModal').show();
    });

    // Sync visible inputs to hidden form inputs before submit
    function syncCloseInputs() {
        $('#closeDateHidden').val($('#closeDateInput').val());
        $('#closeTimeHidden').val($('#closeTimeInput').val());
    }

    // Handle close form submission via AJAX
    $('#closeBookingForm').on('submit', function(e) {
        e.preventDefault();
        syncCloseInputs();
        var $form = $(this);
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            success: function(res) {
                bootstrap.Modal.getInstance(document.getElementById('closeBookingModal')).hide();
                $('#invoiceTotal').text(res.total_price);
                $('#invoiceDuration').text('المدة: ' + res.duration);
                new bootstrap.Modal('#invoiceModal').show();
            },
            error: function() {
                bootstrap.Modal.getInstance(document.getElementById('closeBookingModal')).hide();
                $form.off('submit').submit();
            }
        });
    });
});
</script>
@endsection
