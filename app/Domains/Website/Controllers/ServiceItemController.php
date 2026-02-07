<?php

namespace App\Domains\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\ServiceItem;
use Illuminate\Http\Request;

class ServiceItemController extends Controller
{
    public function index()
    {
        $items = ServiceItem::orderBy('sort_order')->get();
        return view('admin.website.services', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255']);
        $data = $request->only('icon', 'title', 'description');
        $data['icon'] = $data['icon'] ?: 'fas fa-concierge-bell';
        $data['sort_order'] = (ServiceItem::max('sort_order') ?? -1) + 1;
        ServiceItem::create($data);
        return redirect()->route('admin.website.services')->with('success', 'تم إضافة الخدمة بنجاح.');
    }

    public function update(Request $request, ServiceItem $service)
    {
        $request->validate(['title' => 'required|string|max:255']);
        $service->update($request->only('icon', 'title', 'description'));
        return redirect()->route('admin.website.services')->with('success', 'تم تحديث الخدمة بنجاح.');
    }

    public function destroy(ServiceItem $service)
    {
        $service->delete();
        return redirect()->route('admin.website.services')->with('success', 'تم حذف الخدمة بنجاح.');
    }

    public function toggle(ServiceItem $service)
    {
        $service->update(['is_active' => !$service->is_active]);
        return response()->json(['success' => true, 'is_active' => $service->is_active]);
    }
}
