<?php

namespace App\Domains\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Page\Models\Page;
use App\Domains\Page\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::withCount('sections')->orderBy('sort_order')->latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'template' => 'nullable|string',
            'show_in_nav' => 'nullable|boolean',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Page::generateSlug($validated['title']);
        $validated['show_in_nav'] = $request->boolean('show_in_nav');

        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = 'page_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $validated['featured_image'] = 'uploads/pages/' . $filename;
        }

        $page = Page::create($validated);

        return redirect()->route('admin.pages.edit', $page->id)
            ->with('success', 'تم إنشاء الصفحة بنجاح. يمكنك الآن إضافة الأقسام.');
    }

    public function edit($id)
    {
        $page = Page::with('sections')->findOrFail($id);
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'custom_css' => 'nullable|string',
            'custom_js' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'template' => 'nullable|string',
            'show_in_nav' => 'nullable|boolean',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $validated['show_in_nav'] = $request->boolean('show_in_nav');

        if ($request->hasFile('featured_image')) {
            if ($page->featured_image && File::exists(public_path($page->featured_image))) {
                File::delete(public_path($page->featured_image));
            }
            $file = $request->file('featured_image');
            $filename = 'page_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pages'), $filename);
            $validated['featured_image'] = 'uploads/pages/' . $filename;
        }

        if (empty($validated['slug'])) {
            unset($validated['slug']);
        }

        $page->update($validated);

        return redirect()->route('admin.pages.edit', $page->id)
            ->with('success', 'تم تحديث الصفحة بنجاح.');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        if ($page->featured_image && File::exists(public_path($page->featured_image))) {
            File::delete(public_path($page->featured_image));
        }
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'تم حذف الصفحة بنجاح.');
    }

    // ===== Sections AJAX =====

    public function storeSection(Request $request, $pageId)
    {
        $page = Page::findOrFail($pageId);

        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'settings' => 'nullable|string',
        ]);

        $validated['page_id'] = $page->id;
        $validated['sort_order'] = $page->sections()->max('sort_order') + 1;

        $section = PageSection::create($validated);

        return response()->json([
            'success' => true,
            'section' => $section->load('page'),
            'html' => view('admin.pages._section_card', compact('section'))->render(),
        ]);
    }

    public function updateSection(Request $request, $sectionId)
    {
        $section = PageSection::findOrFail($sectionId);

        $section->update($request->only(['title', 'content', 'settings', 'is_active']));

        return response()->json(['success' => true, 'section' => $section]);
    }

    public function deleteSection($sectionId)
    {
        PageSection::findOrFail($sectionId)->delete();
        return response()->json(['success' => true]);
    }

    public function reorderSections(Request $request, $pageId)
    {
        $order = $request->input('order', []);
        foreach ($order as $index => $id) {
            PageSection::where('id', $id)->where('page_id', $pageId)->update(['sort_order' => $index]);
        }
        return response()->json(['success' => true]);
    }
}
