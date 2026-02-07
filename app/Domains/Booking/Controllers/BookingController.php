<?php

namespace App\Domains\Booking\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Booking\Models\Booking;
use App\Domains\Customer\Models\Customer;
use App\Domains\Hall\Models\Hall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'hall'])->latest('booking_date');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->whereHas('hall', fn($q) => $q->where('type', $request->type));
        }
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        $bookings = $query->get();

        $stats = [
            'total' => Booking::count(),
            'open' => Booking::where('status', 'open')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    public function show($id)
    {
        $booking = Booking::with(['customer', 'hall'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $halls = Hall::orderBy('name')->get();
        $settings = DB::table('settings')->pluck('value', 'key');
        return view('admin.bookings.create', compact('customers', 'halls', 'settings'));
    }

    public function store(Request $request)
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'hall_id' => 'required|exists:halls,id',
            'billing_type' => 'required|in:hourly,daily,weekly,monthly',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'unit_price' => 'required|numeric|min:0',
            'is_open' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ];

        $messages = [
            'customer_id.required' => 'يرجى اختيار العميل.',
            'hall_id.required' => 'يرجى اختيار القاعة.',
            'booking_date.required' => 'يرجى تحديد التاريخ.',
            'start_time.required' => 'يرجى تحديد وقت البداية.',
            'billing_type.required' => 'يرجى اختيار نوع الحساب.',
            'unit_price.required' => 'يرجى تحديد سعر الوحدة.',
        ];

        $isOpen = $request->boolean('is_open');

        if (!$isOpen) {
            $rules['end_time'] = 'required|after:start_time';
            $messages['end_time.required'] = 'يرجى تحديد وقت النهاية.';
            $messages['end_time.after'] = 'وقت النهاية يجب أن يكون بعد وقت البداية.';
        }

        $validated = $request->validate($rules, $messages);

        $validated['is_open'] = $isOpen;
        $validated['end_time'] = $isOpen ? null : $validated['end_time'];
        $validated['status'] = $isOpen ? 'open' : 'pending';
        $validated['total_price'] = 0;

        // If not open, calculate total now
        $booking = Booking::create($validated);
        if (!$isOpen) {
            $booking->total_price = $booking->calculateTotal();
            $booking->save();
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'تم إنشاء الحجز بنجاح.');
    }

    /**
     * Close an open booking - calculate the bill
     */
    public function close(Request $request, $id)
    {
        $booking = Booking::with(['customer', 'hall'])->findOrFail($id);

        if ($booking->status !== 'open') {
            return back()->with('error', 'هذا الحجز ليس مفتوحاً.');
        }

        // Use provided date/time or default to now
        $closeDate = $request->input('close_date', now()->format('Y-m-d'));
        $closeTime = $request->input('close_time', now()->format('H:i'));

        $closedAt = \Carbon\Carbon::parse($closeDate . ' ' . $closeTime);

        $booking->closed_at = $closedAt;
        $booking->end_time = $closedAt->format('H:i:s');
        $booking->is_open = false;
        $booking->total_price = $booking->calculateTotal();
        $booking->status = 'closed';
        $booking->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'booking' => $booking->load(['customer', 'hall']),
                'total_price' => number_format($booking->total_price, 2),
                'duration' => $booking->duration,
            ]);
        }

        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'تم إغلاق الحجز. المبلغ الإجمالي: ' . number_format($booking->total_price) . ' ر.س');
    }

    /**
     * Get hall price for a billing type (AJAX)
     */
    public function getHallPrice(Request $request)
    {
        $hall = Hall::find($request->hall_id);
        if (!$hall) {
            return response()->json(['price' => 0]);
        }
        $price = $hall->getPriceFor($request->billing_type ?? 'hourly');
        return response()->json(['price' => $price]);
    }

    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', 'تم حذف الحجز بنجاح.');
    }
}
