<?php

namespace App\Domains\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\FeatureItem;
use Illuminate\Http\Request;

class FeatureItemController extends Controller
{
    public function index()
    {
        $items = FeatureItem::orderBy('sort_order')->get();
        return view('admin.website.features', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255', 'icon' => 'nullable|string|max:100']);
        $data = $request->only('icon', 'title', 'description');
        $data['icon'] = $data['icon'] ?: 'fas fa-star';
        $data['sort_order'] = (FeatureItem::max('sort_order') ?? -1) + 1;
        FeatureItem::create($data);
        return redirect()->route('admin.website.features')->with('success', 'تم إضافة الميزة بنجاح.');
    }

    public function update(Request $request, FeatureItem $feature)
    {
        $request->validate(['title' => 'required|string|max:255']);
        $feature->update($request->only('icon', 'title', 'description'));
        return redirect()->route('admin.website.features')->with('success', 'تم تحديث الميزة بنجاح.');
    }

    public function destroy(FeatureItem $feature)
    {
        $feature->delete();
        return redirect()->route('admin.website.features')->with('success', 'تم حذف الميزة بنجاح.');
    }

    public function toggle(FeatureItem $feature)
    {
        $feature->update(['is_active' => !$feature->is_active]);
        return response()->json(['success' => true, 'is_active' => $feature->is_active]);
    }
}
