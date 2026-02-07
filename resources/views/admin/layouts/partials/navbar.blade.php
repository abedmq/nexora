<!-- ============ NAVBAR ============ -->
<nav class="nx-navbar">
    <div class="navbar-left">
        <button class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h4 class="page-title mb-0 d-none d-md-block">@yield('page-title', 'لوحة التحكم')</h4>
    </div>

    <div class="navbar-search d-none d-lg-block">
        <div class="position-relative">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="form-control" placeholder="بحث...">
        </div>
    </div>

    <div class="navbar-right">
        <!-- Dark Mode Toggle -->
        <button class="dark-mode-toggle" id="darkModeToggle" data-bs-toggle="tooltip" title="الوضع الليلي">
            <i class="fas fa-moon"></i>
        </button>

        <!-- Notifications -->
        <div class="dropdown">
            <button class="nav-icon-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="far fa-bell"></i>
                <span class="badge-dot"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-start" style="width: 320px;">
                <h6 class="dropdown-header">الإشعارات <span class="badge bg-primary rounded-pill ms-2">3</span></h6>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item notification-item">
                    <div class="item-icon bg-purple-light text-purple" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">حجز جديد - قاعة المؤتمرات</div>
                        <small class="text-muted">منذ 5 دقائق</small>
                    </div>
                </a>
                <a href="#" class="dropdown-item notification-item">
                    <div class="item-icon" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;background:#d1fae5;color:#10b981;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">عميل جديد مسجل</div>
                        <small class="text-muted">منذ 15 دقيقة</small>
                    </div>
                </a>
                <a href="#" class="dropdown-item notification-item">
                    <div class="item-icon" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:8px;background:#fee2e2;color:#ef4444;">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">اشتراك قارب على الانتهاء</div>
                        <small class="text-muted">منذ ساعة</small>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item text-center text-purple fw-semibold">عرض جميع الإشعارات</a>
            </div>
        </div>

        <!-- Fullscreen -->
        <button class="nav-icon-btn d-none d-md-flex" id="fullscreenBtn">
            <i class="fas fa-expand"></i>
        </button>

        <!-- User Dropdown -->
        <div class="dropdown">
            <div class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=7c3aed&color=fff&rounded=true&size=36" alt="User">
                <div class="user-info-text d-none d-md-block">
                    <div class="user-name">{{ auth()->user()->name ?? 'مدير النظام' }}</div>
                    <div class="user-role">مسؤول</div>
                </div>
                <i class="fas fa-chevron-down me-1" style="font-size:10px;color:var(--nx-text-muted);"></i>
            </div>
            <div class="dropdown-menu dropdown-menu-start">
                <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                    <i class="fas fa-user text-purple"></i> الملف الشخصي
                </a>
                <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                    <i class="fas fa-cog text-purple"></i> الإعدادات
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
