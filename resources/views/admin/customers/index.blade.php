@extends('admin.layouts.app')

@section('title', 'العملاء')
@section('page-title', 'إدارة العملاء')

@section('breadcrumb')
    <span class="separator"><i class="fas fa-chevron-left"></i></span>
    <span>العملاء</span>
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
                <div class="stat-icon purple"><i class="fas fa-users"></i></div>
                <div class="stat-details"><h3>{{ $stats['total'] }}</h3><p>إجمالي العملاء</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
                <div class="stat-details"><h3>{{ $stats['active'] }}</h3><p>لديهم اشتراك نشط</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-user-plus"></i></div>
                <div class="stat-details"><h3>{{ $stats['new_this_month'] }}</h3><p>جدد هذا الشهر</p></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-file-contract"></i></div>
                <div class="stat-details"><h3>{{ $stats['with_subscriptions'] }}</h3><p>لديهم اشتراكات</p></div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="nx-card">
        <div class="card-header">
            <h5 class="card-title">جميع العملاء</h5>
            <button class="btn btn-nx-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                <i class="fas fa-plus me-1"></i> إضافة عميل
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="customersTable" class="table nx-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>العميل</th>
                            <th>الهاتف</th>
                            <th>البريد</th>
                            <th>الحجوزات</th>
                            <th>الاشتراك</th>
                            <th>التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=7c3aed&color=fff&rounded=true&size=36" alt="">
                                    <div>
                                        <div class="fw-semibold">{{ $customer->name }}</div>
                                        <small class="text-muted">{{ $customer->type_label }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>{{ $customer->email }}</td>
                            <td><span class="fw-semibold">{{ $customer->bookings_count }}</span></td>
                            <td>
                                @if($customer->activeSubscription)
                                    <span class="nx-badge success">{{ $customer->activeSubscription->type_label }} - نشط</span>
                                @else
                                    <span class="nx-badge danger">لا يوجد</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $customer->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger btn-delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.customers.store') }}" method="POST" class="nx-form">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">إضافة عميل جديد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">الاسم الكامل</label>
                            <input type="text" name="name" class="form-control" placeholder="أدخل الاسم" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="tel" name="phone" class="form-control" placeholder="05XXXXXXXX">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">نوع العميل</label>
                            <select name="type" class="form-select">
                                <option value="regular">عميل عادي</option>
                                <option value="vip">عميل VIP</option>
                            </select>
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

@section('scripts')
<script>
    $(document).ready(function() {
        $('#customersTable').DataTable({
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json' },
            pageLength: 10, order: [[5, 'desc']]
        });
    });
</script>
@endsection
