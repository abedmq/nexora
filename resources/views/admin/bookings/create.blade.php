@extends('admin.layouts.app')

@section('title', 'حجز جديد')
@section('page-title', 'إضافة حجز جديد')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <a href="{{ route('admin.bookings.index') }}">الحجوزات</a>
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>حجز جديد</span>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="nx-card">
                <div class="card-header"><h5 class="card-title">معلومات الحجز</h5></div>
                <div class="card-body">
                    <form class="nx-form" action="{{ route('admin.bookings.store') }}" method="POST" id="bookingForm">
                        @csrf

                        {{-- Customer Search --}}
                        <div class="mb-3">
                            <label class="form-label">العميل</label>
                            <div class="customer-search-wrapper position-relative">
                                <input type="hidden" name="customer_id" id="customer_id" value="{{ old('customer_id') }}">
                                <input type="text" class="form-control" id="customerSearch"
                                       placeholder="ابحث بالاسم أو رقم الهاتف..." autocomplete="off"
                                       style="padding-right:40px;">
                                <i class="fas fa-search" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:var(--nx-text-muted);pointer-events:none;"></i>
                                <div class="customer-results" id="customerResults"></div>
                            </div>
                            <div id="selectedCustomer" class="selected-customer-badge d-none">
                                <span id="selectedCustomerName"></span>
                                <button type="button" class="btn-remove-customer" id="removeCustomer">&times;</button>
                            </div>
                            @error('customer_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Hall & Billing Type --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">القاعة / المكتب</label>
                                <select name="hall_id" id="hallSelect" class="form-select" required>
                                    <option value="">اختر المكان...</option>
                                    @foreach($halls as $hall)
                                    <option value="{{ $hall->id }}"
                                            data-price-hourly="{{ $hall->price_per_hour }}"
                                            data-price-daily="{{ $hall->price_per_day ?: $settings['default_price_per_day'] ?? 300 }}"
                                            data-price-weekly="{{ $hall->price_per_week ?: $settings['default_price_per_week'] ?? 1500 }}"
                                            data-price-monthly="{{ $hall->price_per_month ?: $settings['default_price_per_month'] ?? 4000 }}"
                                            {{ (old('hall_id') ?? request('hall_id')) == $hall->id ? 'selected' : '' }}>
                                        {{ $hall->name }} ({{ $hall->type_label }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('hall_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">نوع الحساب</label>
                                <select name="billing_type" id="billingType" class="form-select" required>
                                    <option value="hourly" {{ old('billing_type') == 'hourly' ? 'selected' : '' }}>بالساعة</option>
                                    <option value="daily" {{ old('billing_type') == 'daily' ? 'selected' : '' }}>يومي</option>
                                    <option value="weekly" {{ old('billing_type') == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                                    <option value="monthly" {{ old('billing_type') == 'monthly' ? 'selected' : '' }}>شهري</option>
                                </select>
                                @error('billing_type') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Unit Price --}}
                        <div class="row g-3 mt-0">
                            <div class="col-md-6">
                                <label class="form-label">
                                    سعر الوحدة (ر.س)
                                    <small class="text-muted" id="priceHint">/ ساعة</small>
                                </label>
                                <input type="number" name="unit_price" id="unitPrice" class="form-control"
                                       step="0.01" min="0" value="{{ old('unit_price') }}" required>
                                @error('unit_price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">التاريخ</label>
                                <input type="date" name="booking_date" class="form-control"
                                       value="{{ old('booking_date', date('Y-m-d')) }}" required>
                                @error('booking_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- Time & Open Booking --}}
                        <div class="row g-3 mt-0">
                            <div class="col-md-4">
                                <label class="form-label">وقت البداية</label>
                                <input type="time" name="start_time" class="form-control"
                                       value="{{ old('start_time') }}" required>
                                @error('start_time') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4" id="endTimeWrapper">
                                <label class="form-label">وقت النهاية</label>
                                <input type="time" name="end_time" id="endTimeInput" class="form-control"
                                       value="{{ old('end_time') }}">
                                @error('end_time') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check" style="padding-bottom:8px;">
                                    <input class="form-check-input" type="checkbox" name="is_open" value="1"
                                           id="isOpenCheck" {{ old('is_open') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isOpenCheck" style="font-size:13px;">
                                        <i class="fas fa-unlock me-1 text-purple"></i> حجز مفتوح (بدون وقت نهاية)
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="mt-3">
                            <label class="form-label">ملاحظات</label>
                            <textarea name="notes" class="form-control" rows="3"
                                      placeholder="أضف ملاحظات حول الحجز...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-nx-primary"><i class="fas fa-save me-1"></i> حفظ الحجز</button>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-nx-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Price Summary Sidebar --}}
        <div class="col-lg-4">
            <div class="nx-card" id="priceSummary">
                <div class="card-header"><h5 class="card-title"><i class="fas fa-calculator me-1"></i> ملخص السعر</h5></div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">نوع الحساب</span>
                        <span class="fw-semibold" id="summaryBillingType">بالساعة</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">سعر الوحدة</span>
                        <span class="fw-semibold" id="summaryUnitPrice">0 ر.س</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">الحالة</span>
                        <span class="fw-semibold" id="summaryStatus">-</span>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">سيتم حساب المبلغ النهائي</small>
                        <div class="display-6 text-purple fw-bold mt-2" id="summaryTotal">-</div>
                        <small class="text-muted" id="summaryNote">عند إغلاق الحجز أو بعد تحديد وقت النهاية</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .customer-search-wrapper { position: relative; }
    .customer-results {
        position: absolute; top: 100%; right: 0; left: 0; z-index: 100;
        background: var(--nx-card-bg, #fff); border: 1px solid var(--nx-border);
        border-radius: var(--nx-radius-sm); box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        max-height: 280px; overflow-y: auto; display: none;
    }
    .customer-results.show { display: block; }
    .customer-result-item {
        padding: 10px 14px; cursor: pointer; display: flex; align-items: center;
        justify-content: space-between; border-bottom: 1px solid var(--nx-border);
        font-size: 13px; transition: background 0.15s;
    }
    .customer-result-item:hover { background: var(--nx-primary-lighter, #f5f3ff); }
    .customer-result-item:last-child { border-bottom: none; }
    .customer-result-item .info { display: flex; flex-direction: column; }
    .customer-result-item .name { font-weight: 600; }
    .customer-result-item .phone { color: var(--nx-text-muted); font-size: 12px; }
    .customer-add-btn {
        padding: 10px 14px; cursor: pointer; display: flex; align-items: center; gap: 8px;
        background: var(--nx-primary-lighter, #f5f3ff); color: var(--nx-primary);
        font-weight: 600; font-size: 13px; border-bottom: 1px solid var(--nx-border);
    }
    .customer-add-btn:hover { background: var(--nx-primary-light); color: #fff; }
    .selected-customer-badge {
        margin-top: 8px; padding: 8px 14px; background: var(--nx-primary-lighter, #f5f3ff);
        border-radius: var(--nx-radius-sm); display: inline-flex; align-items: center; gap: 10px;
        font-size: 13px; font-weight: 600; color: var(--nx-primary);
    }
    .btn-remove-customer {
        background: none; border: none; font-size: 18px; color: var(--nx-danger);
        cursor: pointer; line-height: 1; padding: 0;
    }
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var searchTimer;
    var $search = $('#customerSearch');
    var $results = $('#customerResults');
    var $customerId = $('#customer_id');
    var $selectedBox = $('#selectedCustomer');
    var $selectedName = $('#selectedCustomerName');
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // ---- Customer Search ----
    $search.on('input', function() {
        clearTimeout(searchTimer);
        var q = $(this).val().trim();
        if (q.length < 1) { $results.removeClass('show').html(''); return; }

        searchTimer = setTimeout(function() {
            $.get("{{ route('admin.customers.search') }}", { q: q }, function(data) {
                var html = '';

                // Quick add button always on top
                html += '<div class="customer-add-btn" data-name="' + q + '">';
                html += '<i class="fas fa-plus-circle"></i> إضافة "' + q + '" كعميل جديد';
                html += '</div>';

                if (data.length > 0) {
                    data.forEach(function(c) {
                        html += '<div class="customer-result-item" data-id="' + c.id + '" data-name="' + c.name + '">';
                        html += '<div class="info"><span class="name">' + c.name + '</span>';
                        if (c.phone) html += '<span class="phone"><i class="fas fa-phone me-1"></i>' + c.phone + '</span>';
                        html += '</div></div>';
                    });
                }

                $results.html(html).addClass('show');
            });
        }, 300);
    });

    // Select existing customer
    $(document).on('click', '.customer-result-item', function() {
        selectCustomer($(this).data('id'), $(this).data('name'));
    });

    // Quick add new customer
    $(document).on('click', '.customer-add-btn', function() {
        var name = $(this).data('name');
        $.post("{{ route('admin.customers.quick-store') }}", {
            _token: csrfToken, name: name
        }, function(res) {
            if (res.success) {
                selectCustomer(res.customer.id, res.customer.name);
            }
        });
    });

    function selectCustomer(id, name) {
        $customerId.val(id);
        $selectedName.text(name);
        $selectedBox.removeClass('d-none');
        $search.val('').prop('disabled', true);
        $results.removeClass('show').html('');
    }

    $('#removeCustomer').on('click', function() {
        $customerId.val('');
        $selectedBox.addClass('d-none');
        $search.prop('disabled', false).val('').focus();
    });

    // Close results on click outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.customer-search-wrapper').length) {
            $results.removeClass('show');
        }
    });

    // ---- Open Booking Toggle ----
    $('#isOpenCheck').on('change', function() {
        if ($(this).is(':checked')) {
            $('#endTimeWrapper').slideUp(200);
            $('#endTimeInput').prop('required', false).val('');
            updateSummary();
        } else {
            $('#endTimeWrapper').slideDown(200);
            $('#endTimeInput').prop('required', true);
            updateSummary();
        }
    });
    // Init state
    if ($('#isOpenCheck').is(':checked')) {
        $('#endTimeWrapper').hide();
        $('#endTimeInput').prop('required', false);
    }

    // ---- Billing Type & Price Sync ----
    function updateUnitPrice() {
        var $hall = $('#hallSelect option:selected');
        var type = $('#billingType').val();
        if (!$hall.val()) return;

        var price = $hall.data('price-' + type) || 0;
        $('#unitPrice').val(price);
        updateSummary();
    }

    $('#hallSelect, #billingType').on('change', function() {
        updateUnitPrice();
    });

    var priceHints = { hourly: '/ ساعة', daily: '/ يوم', weekly: '/ أسبوع', monthly: '/ شهر' };
    var billingLabels = { hourly: 'بالساعة', daily: 'يومي', weekly: 'أسبوعي', monthly: 'شهري' };

    function updateSummary() {
        var type = $('#billingType').val();
        var price = parseFloat($('#unitPrice').val()) || 0;
        var isOpen = $('#isOpenCheck').is(':checked');

        $('#priceHint').text(priceHints[type] || '');
        $('#summaryBillingType').text(billingLabels[type] || '');
        $('#summaryUnitPrice').text(price.toLocaleString('ar-SA') + ' ر.س');
        $('#summaryStatus').html(isOpen
            ? '<span class="nx-badge info"><i class="fas fa-unlock" style="font-size:10px;"></i> مفتوح</span>'
            : '<span class="nx-badge success"><i class="fas fa-lock" style="font-size:10px;"></i> محدد</span>');

        if (isOpen) {
            $('#summaryTotal').text('-');
            $('#summaryNote').text('سيتم الحساب عند إغلاق الحجز');
        } else {
            // Try to calculate
            var start = $('input[name="start_time"]').val();
            var end = $('#endTimeInput').val();
            if (start && end && price > 0 && type === 'hourly') {
                var s = start.split(':'), e = end.split(':');
                var hours = (parseInt(e[0]) - parseInt(s[0])) + (parseInt(e[1]) - parseInt(s[1])) / 60;
                if (hours > 0) {
                    var total = Math.round(hours * price);
                    $('#summaryTotal').text(total.toLocaleString('ar-SA') + ' ر.س');
                    $('#summaryNote').text(hours + ' ساعة × ' + price + ' ر.س');
                    return;
                }
            }
            if (price > 0 && type !== 'hourly') {
                $('#summaryTotal').text(price.toLocaleString('ar-SA') + ' ر.س');
                $('#summaryNote').text('وحدة واحدة');
            } else {
                $('#summaryTotal').text('-');
                $('#summaryNote').text('حدد الأوقات لحساب المبلغ');
            }
        }
    }

    $('#unitPrice, input[name="start_time"], #endTimeInput').on('input change', updateSummary);
    $('#billingType').on('change', updateSummary);

    // Init: if hall pre-selected (from halls page), auto-set price
    if ($('#hallSelect').val()) {
        updateUnitPrice();
    }
    updateSummary();
});
</script>
@endsection
