<?php

namespace App\Domains\Hall\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Hall\Models\Hall;
use App\Domains\Booking\Models\Booking;
use Illuminate\Http\Request;

class HallController extends Controller
{
    public function index(Request $request)
    {
        $query = Hall::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $halls = $query->get();

        $stats = [
            'total' => Hall::count(),
            'available' => Hall::where('status', 'available')->count(),
            'booked' => Hall::where('status', 'booked')->count(),
            'revenue' => Booking::where('status', 'confirmed')
                ->whereMonth('booking_date', now()->month)
                ->sum('total_price'),
        ];

        return view('admin.halls.index', compact('halls', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:meeting_room,private_office,coworking,training_room',
            'capacity' => 'required|integer|min:1',
            'price_per_hour' => 'required|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'price_per_week' => 'nullable|numeric|min:0',
            'price_per_month' => 'nullable|numeric|min:0',
            'amenities' => 'nullable|string',
        ]);

        $validated['status'] = 'available';
        Hall::create($validated);

        return redirect()->route('admin.halls.index')
            ->with('success', 'تم إضافة القاعة بنجاح.');
    }

    public function destroy($id)
    {
        Hall::findOrFail($id)->delete();
        return redirect()->route('admin.halls.index')
            ->with('success', 'تم حذف القاعة بنجاح.');
    }
}
