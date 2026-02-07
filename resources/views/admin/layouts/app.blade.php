<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>نكسورا - @yield('title', 'لوحة التحكم')</title>

    <!-- Google Fonts - Cairo -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- ApexCharts CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/apexcharts/css/apexcharts.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/datatables/css/dataTables.bootstrap5.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/sweetalert2/css/sweetalert2.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/toastr/css/toastr.min.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/select2/css/select2-bootstrap-5-theme.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/dark-mode.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/responsive.css') }}">

    @yield('styles')
</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div class="preloader-spinner"></div>
</div>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay"></div>

<!-- Sidebar -->
@include('admin.layouts.partials.sidebar')

<!-- Main Content -->
<main class="nx-main">
    <!-- Navbar -->
    @include('admin.layouts.partials.navbar')

    <!-- Page Content -->
    <div class="nx-content">
        <!-- Breadcrumb -->
        <div class="nx-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a>
            @yield('breadcrumb')
        </div>

        @yield('content')
    </div>

    <!-- Footer -->
    @include('admin.layouts.partials.footer')
</main>

<!-- jQuery -->
<script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ApexCharts -->
<script src="{{ asset('admin-assets/plugins/apexcharts/js/apexcharts.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('admin-assets/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('admin-assets/plugins/sweetalert2/js/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('admin-assets/plugins/toastr/js/toastr.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Dark Mode (before main.js) -->
<script src="{{ asset('admin-assets/js/dark-mode.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('admin-assets/js/main.js') }}"></script>

<!-- Fullscreen Toggle -->
<script>
    var fullscreenBtn = document.getElementById('fullscreenBtn');
    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                this.innerHTML = '<i class="fas fa-compress"></i>';
            } else {
                document.exitFullscreen();
                this.innerHTML = '<i class="fas fa-expand"></i>';
            }
        });
    }
</script>

@yield('scripts')

</body>
</html>
