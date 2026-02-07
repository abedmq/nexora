<?php

namespace App\Domains\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\StatItem;
use Illuminate\Http\Request;

class StatItemController extends Controller
{
    public function index()
    {
        $items = StatItem::orderBy('sort_order')->get();
        return view('admin.website.stats', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate(['value' => 'required|string|max:50', 'label' => 'required|string|max:255']);
        $data = $request->only('icon', 'value', 'label');
        $data['icon'] = $data['icon'] ?: 'fas fa-chart-bar';
        $data['sort_order'] = (StatItem::max('sort_order') ?? -1) + 1;
        StatItem::create($data);
        return redirect()->route('admin.website.stats')->with('success', 'تم إضافة الإحصائية بنجاح.');
    }

    public function update(Request $request, StatItem $stat)
    {
        $request->validate(['value' => 'required|string|max:50', 'label' => 'required|string|max:255']);
        $stat->update($request->only('icon', 'value', 'label'));
        return redirect()->route('admin.website.stats')->with('success', 'تم تحديث الإحصائية بنجاح.');
    }

    public function destroy(StatItem $stat)
    {
        $stat->delete();
        return redirect()->route('admin.website.stats')->with('success', 'تم حذف الإحصائية بنجاح.');
    }

    public function toggle(StatItem $stat)
    {
        $stat->update(['is_active' => !$stat->is_active]);
        return response()->json(['success' => true, 'is_active' => $stat->is_active]);
    }
}
