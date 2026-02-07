<?php

namespace App\Domains\Subscription\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Subscription\Models\Subscription;
use App\Domains\Customer\Models\Customer;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with('customer')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subscriptions = $query->get();
        $customers = Customer::orderBy('name')->get();

        $stats = [
            'total' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'expiring_soon' => Subscription::where('status', 'expiring_soon')->count(),
            'expired' => Subscription::where('status', 'expired')->count(),
        ];

        return view('admin.subscriptions.index', compact('subscriptions', 'customers', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'type' => 'required|in:daily,monthly,special',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
        ]);

        $validated['status'] = 'active';
        Subscription::create($validated);

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'تم إنشاء الاشتراك بنجاح.');
    }

    public function destroy($id)
    {
        Subscription::findOrFail($id)->delete();
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'تم حذف الاشتراك بنجاح.');
    }
}
