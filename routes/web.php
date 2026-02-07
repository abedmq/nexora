<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Domains\Website\Controllers\FrontendController::class, 'home'])->name('home');

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
|
| All admin routes are organized by domain. Each domain has its own
| routes file in app/Domains/{Domain}/Routes/web.php.
| To remove a domain, simply comment out or delete its require line.
|
*/

Route::prefix('admin')->group(function () {

    // Auth (تسجيل الدخول) - بدون حماية
    require app_path('Domains/Auth/Routes/web.php');

    // Protected Admin Routes (تحتاج تسجيل دخول)
    Route::middleware('admin')->group(function () {

        // Dashboard (لوحة التحكم)
        require app_path('Domains/Dashboard/Routes/web.php');

        // Bookings (الحجوزات)
        require app_path('Domains/Booking/Routes/web.php');

        // Subscriptions (الاشتراكات)
        require app_path('Domains/Subscription/Routes/web.php');

        // Customers (العملاء)
        require app_path('Domains/Customer/Routes/web.php');

        // Halls (القاعات / المكاتب)
        require app_path('Domains/Hall/Routes/web.php');

        // Reports (التقارير)
        require app_path('Domains/Report/Routes/web.php');

        // Settings (الإعدادات)
        require app_path('Domains/Setting/Routes/web.php');

        // Pages (الصفحات)
        require app_path('Domains/Page/Routes/web.php');

        // Menus (القوائم)
        require app_path('Domains/Menu/Routes/web.php');

        // Website (تصميم الموقع)
        require app_path('Domains/Website/Routes/web.php');

    });
});

/*
|--------------------------------------------------------------------------
| Frontend Page Routes
|--------------------------------------------------------------------------
*/
Route::get('/page/{slug}', [\App\Domains\Page\Controllers\FrontendPageController::class, 'show'])->name('page.show');
