<!-- ============ SIDEBAR ============ -->
<aside class="nx-sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            @if(setting('company_logo'))
                <img src="{{ asset(setting('company_logo')) }}" alt="{{ setting('company_name', 'نكسورا') }}" style="height:34px;width:auto;object-fit:contain;">
            @else
                <span class="logo-icon"><i class="fas fa-bolt"></i></span>
            @endif
            <span>{{ setting('company_name', 'نكسورا') }}</span>
        </a>
        <button class="sidebar-close"><i class="fas fa-times"></i></button>
    </div>

    <!-- Sidebar Search -->
    <div class="sidebar-search">
        <div class="position-relative">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="form-control" placeholder="بحث في القائمة...">
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="sidebar-menu">
        <ul class="list-unstyled">
            <li class="menu-label">الرئيسية</li>

            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span>لوحة التحكم</span>
                </a>
            </li>

            <li class="menu-label">الإدارة</li>

            <li class="menu-item">
                <a href="{{ route('admin.bookings.index') }}" class="menu-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-calendar-check"></i></span>
                    <span>الحجوزات</span>
                    <span class="badge bg-primary rounded-pill">12</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.subscriptions.index') }}" class="menu-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-file-contract"></i></span>
                    <span>الاشتراكات</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.customers.index') }}" class="menu-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-users"></i></span>
                    <span>العملاء</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.halls.index') }}" class="menu-link {{ request()->routeIs('admin.halls.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-building"></i></span>
                    <span>القاعات / المكاتب</span>
                </a>
            </li>

            <li class="menu-label">الموقع</li>

            <li class="menu-item">
                <a href="{{ route('admin.pages.index') }}" class="menu-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-file-alt"></i></span>
                    <span>الصفحات</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.menus.index') }}" class="menu-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-bars"></i></span>
                    <span>القوائم</span>
                </a>
            </li>

            @if(theme_supports('homepage_builder'))
                <li class="menu-item">
                    <a href="{{ route('admin.website.homepage') }}" class="menu-link {{ request()->routeIs('admin.website.homepage*') ? 'active' : '' }}">
                        <span class="menu-icon"><i class="fas fa-home"></i></span>
                        <span>الصفحة الرئيسية</span>
                    </a>
                </li>
            @endif

            <li class="menu-item">
                <a href="{{ route('admin.themes.index') }}" class="menu-link {{ request()->routeIs('admin.themes.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-palette"></i></span>
                    <span>الثيمات</span>
                </a>
            </li>

            <li class="menu-label">ثوابت الموقع</li>

            <li class="menu-item">
                <a href="{{ route('admin.website.features') }}" class="menu-link {{ request()->routeIs('admin.website.features*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-star"></i></span>
                    <span>المميزات</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.website.services') }}" class="menu-link {{ request()->routeIs('admin.website.services*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-concierge-bell"></i></span>
                    <span>الخدمات</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.website.stats') }}" class="menu-link {{ request()->routeIs('admin.website.stats*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-chart-bar"></i></span>
                    <span>الإحصائيات</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.website.testimonials') }}" class="menu-link {{ request()->routeIs('admin.website.testimonials*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-quote-right"></i></span>
                    <span>آراء العملاء</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.website.partners') }}" class="menu-link {{ request()->routeIs('admin.website.partners*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-handshake"></i></span>
                    <span>الشركاء</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.website.faq') }}" class="menu-link {{ request()->routeIs('admin.website.faq*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-question-circle"></i></span>
                    <span>الأسئلة الشائعة</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.website.sliders') }}" class="menu-link {{ request()->routeIs('admin.website.sliders*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-images"></i></span>
                    <span>السلايدر</span>
                </a>
            </li>

            <li class="menu-label">المتابعة</li>

            <li class="menu-item">
                <a href="{{ route('admin.reports.index') }}" class="menu-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-chart-line"></i></span>
                    <span>التقارير</span>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('admin.settings.index') }}" class="menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <span class="menu-icon"><i class="fas fa-cog"></i></span>
                    <span>الإعدادات</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=7c3aed&color=fff&rounded=true&size=38" alt="User" class="user-avatar">
            <div>
                <div class="user-name">{{ auth()->user()->name ?? 'مدير النظام' }}</div>
                <div class="user-role">مسؤول</div>
            </div>
        </div>
    </div>
</aside>
