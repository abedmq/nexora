<?php

namespace App\Domains\Customer\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Customer\Models\Customer;
use App\Domains\Subscription\Models\Subscription;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('bookings')
            ->with('activeSubscription')
            ->latest()
            ->get();

        $stats = [
            'total' => Customer::count(),
            'active' => Customer::whereHas('subscriptions', fn($q) => $q->where('status', 'active'))->count(),
            'new_this_month' => Customer::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'with_subscriptions' => Customer::has('subscriptions')->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'type' => 'required|in:regular,vip',
        ], [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
        ]);

        Customer::create($validated);

        return redirect()->route('admin.customers.index')
            ->with('success', 'تم إضافة العميل بنجاح.');
    }

    public function show($id)
    {
        $customer = Customer::with(['bookings.hall', 'subscriptions'])->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * AJAX: Search customers by name
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $customers = Customer::where('name', 'like', '%' . $query . '%')
            ->orWhere('phone', 'like', '%' . $query . '%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'phone']);

        return response()->json($customers);
    }

    /**
     * AJAX: Quick-add customer by name only
     */
    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => 'temp_' . uniqid() . '@placeholder.com',
            'type' => 'regular',
        ]);

        return response()->json([
            'success' => true,
            'customer' => $customer,
        ]);
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('admin.customers.index')
            ->with('success', 'تم حذف العميل بنجاح.');
    }
}
