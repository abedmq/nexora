<?php

namespace App\Domains\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\FaqItem;
use Illuminate\Http\Request;

class FaqItemController extends Controller
{
    public function index()
    {
        $items = FaqItem::orderBy('sort_order')->get();
        return view('admin.website.faq', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate(['question' => 'required|string|max:500', 'answer' => 'required|string']);
        $data = $request->only('question', 'answer');
        $data['sort_order'] = (FaqItem::max('sort_order') ?? -1) + 1;
        FaqItem::create($data);
        return redirect()->route('admin.website.faq')->with('success', 'تم إضافة السؤال بنجاح.');
    }

    public function update(Request $request, FaqItem $faq)
    {
        $request->validate(['question' => 'required|string|max:500', 'answer' => 'required|string']);
        $faq->update($request->only('question', 'answer'));
        return redirect()->route('admin.website.faq')->with('success', 'تم تحديث السؤال بنجاح.');
    }

    public function destroy(FaqItem $faq)
    {
        $faq->delete();
        return redirect()->route('admin.website.faq')->with('success', 'تم حذف السؤال بنجاح.');
    }

    public function toggle(FaqItem $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);
        return response()->json(['success' => true, 'is_active' => $faq->is_active]);
    }
}
