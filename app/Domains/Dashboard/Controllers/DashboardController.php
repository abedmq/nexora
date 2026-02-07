<?php

namespace App\Domains\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Booking\Models\Booking;
use App\Domains\Subscription\Models\Subscription;
use App\Domains\Customer\Models\Customer;
use App\Domains\Hall\Models\Hall;

class DashboardController extends Controller
{
    public function index()
    {
        $todayBookings = Booking::whereDate('booking_date', today())->count();
        $subscribers = Subscription::where('status', 'active')->count();
        $availableHalls = Hall::where('status', 'available')->count();
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->whereMonth('booking_date', now()->month)
            ->whereYear('booking_date', now()->year)
            ->sum('total_price');

        $latestBookings = Booking::with(['customer', 'hall'])
            ->latest('booking_date')
            ->take(5)
            ->get();

        $openBookings = Booking::with(['customer', 'hall'])
            ->where('status', 'open')
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();

        $totalHalls = Hall::count();

        return view('admin.dashboard.index', compact(
            'todayBookings',
            'subscribers',
            'availableHalls',
            'monthlyRevenue',
            'latestBookings',
            'openBookings',
            'totalHalls'
        ));
    }
}
