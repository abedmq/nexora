<?php

namespace App\Domains\Report\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Booking\Models\Booking;
use App\Domains\Subscription\Models\Subscription;
use App\Domains\Customer\Models\Customer;

class ReportController extends Controller
{
    public function index()
    {
        // Revenue stats
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->whereMonth('booking_date', now()->month)
            ->sum('total_price');

        $totalTransactions = Booking::where('status', 'confirmed')
            ->whereMonth('booking_date', now()->month)
            ->count();

        $avgTransaction = $totalTransactions > 0
            ? round($monthlyRevenue / $totalTransactions, 0)
            : 0;

        // Bookings stats
        $totalBookings = Booking::count();
        $confirmedPercent = $totalBookings > 0 ? round(Booking::where('status', 'confirmed')->count() / $totalBookings * 100) : 0;
        $pendingPercent = $totalBookings > 0 ? round(Booking::where('status', 'pending')->count() / $totalBookings * 100) : 0;
        $cancelledPercent = $totalBookings > 0 ? round(Booking::where('status', 'cancelled')->count() / $totalBookings * 100) : 0;

        // Subscriptions stats
        $dailySubs = Subscription::where('type', 'daily')->count();
        $monthlySubs = Subscription::where('type', 'monthly')->count();
        $specialSubs = Subscription::where('type', 'special')->count();

        // Customer stats
        $totalCustomers = Customer::count();
        $newCustomers = Customer::whereMonth('created_at', now()->month)->count();
        $vipCustomers = Customer::where('type', 'vip')->count();

        return view('admin.reports.index', compact(
            'monthlyRevenue', 'totalTransactions', 'avgTransaction',
            'totalBookings', 'confirmedPercent', 'pendingPercent', 'cancelledPercent',
            'dailySubs', 'monthlySubs', 'specialSubs',
            'totalCustomers', 'newCustomers', 'vipCustomers'
        ));
    }
}
