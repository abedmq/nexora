/* ============================================
   Nexora Admin Dashboard - Main JavaScript
   ============================================ */

$(document).ready(function () {
    // ---- Preloader ----
    $(window).on('load', function () {
        setTimeout(function () {
            $('#preloader').addClass('loaded');
        }, 400);
    });

    // Fallback: hide preloader after 2s
    setTimeout(function () {
        $('#preloader').addClass('loaded');
    }, 2000);

    // ---- Sidebar Toggle ----
    var $sidebar = $('.nx-sidebar');
    var $overlay = $('.sidebar-overlay');

    $('.sidebar-toggle').on('click', function () {
        $sidebar.toggleClass('show');
        $overlay.toggleClass('show');
    });

    $('.sidebar-close, .sidebar-overlay').on('click', function () {
        $sidebar.removeClass('show');
        $overlay.removeClass('show');
    });

    // ---- Sidebar Submenu ----
    $('.menu-link[data-bs-toggle="collapse"]').on('click', function (e) {
        e.preventDefault();
    });

    // ---- Tooltips ----
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el);
    });

    // ---- Popovers ----
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (el) {
        return new bootstrap.Popover(el);
    });

    // ---- Active Menu Highlight ----
    var currentPage = window.location.pathname.split('/').pop() || 'index.html';
    $('.sidebar-menu .menu-link').each(function () {
        var href = $(this).attr('href');
        if (href) {
            var linkPage = href.split('/').pop();
            if (linkPage === currentPage) {
                $(this).addClass('active');
                // Open parent collapse if in submenu
                var $parent = $(this).closest('.collapse');
                if ($parent.length) {
                    $parent.addClass('show');
                    $parent.prev('.menu-link').attr('aria-expanded', 'true');
                }
            }
        }
    });

    // ---- Toastr Default Config ----
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000,
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
    }

    // ---- Back to Top (if exists) ----
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });

    $('.back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 500);
    });
});
