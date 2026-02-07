<?php

namespace App\Domains\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\SliderItem;
use Illuminate\Http\Request;

class SliderItemController extends Controller
{
    public function index()
    {
        $items = SliderItem::orderBy('sort_order')->get();
        return view('admin.website.sliders', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('title', 'subtitle', 'button_text', 'button_url');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sliders', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $data['sort_order'] = (SliderItem::max('sort_order') ?? -1) + 1;
        SliderItem::create($data);

        return redirect()->route('admin.website.sliders')->with('success', 'تم إضافة الشريحة بنجاح.');
    }

    public function update(Request $request, SliderItem $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('title', 'subtitle', 'button_text', 'button_url');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('sliders', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $slider->update($data);

        return redirect()->route('admin.website.sliders')->with('success', 'تم تحديث الشريحة بنجاح.');
    }

    public function destroy(SliderItem $slider)
    {
        $slider->delete();
        return redirect()->route('admin.website.sliders')->with('success', 'تم حذف الشريحة بنجاح.');
    }

    public function toggle(SliderItem $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);
        return response()->json(['success' => true, 'is_active' => $slider->is_active]);
    }
}
