<?php

namespace App\Domains\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\SiteSection;
use App\Domains\Website\Models\Testimonial;
use App\Domains\Website\Models\Partner;
use App\Domains\Website\Models\FeatureItem;
use App\Domains\Website\Models\ServiceItem;
use App\Domains\Website\Models\StatItem;
use App\Domains\Website\Models\FaqItem;
use App\Domains\Website\Models\SliderItem;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    /**
     * Get all data collections needed by section templates.
     */
    private function getSectionViewData(): array
    {
        return [
            'features'     => FeatureItem::where('is_active', true)->orderBy('sort_order')->get(),
            'services'     => ServiceItem::where('is_active', true)->orderBy('sort_order')->get(),
            'statItems'    => StatItem::where('is_active', true)->orderBy('sort_order')->get(),
            'testimonials' => Testimonial::where('is_active', true)->orderBy('sort_order')->get(),
            'partners'     => Partner::where('is_active', true)->orderBy('sort_order')->get(),
            'faqItems'     => FaqItem::where('is_active', true)->orderBy('sort_order')->get(),
            'sliderItems'  => SliderItem::where('is_active', true)->orderBy('sort_order')->get(),
        ];
    }

    /**
     * Render a single section's full wrapper HTML (overlay + content) for AJAX.
     */
    private function renderSectionHtml(SiteSection $section): string
    {
        $data = array_merge(['section' => $section], $this->getSectionViewData());

        return view('admin.website._section_wrap', $data)->render();
    }

    public function index()
    {
        $sections = SiteSection::orderBy('sort_order')->get();
        $sectionTypes = SiteSection::sectionTypes();

        $viewData = $this->getSectionViewData();
        $headerMenu = get_menu('header');
        $footerMenu = get_menu('footer');
        $footerTemplate = setting('footer_template', '1');

        return view('admin.website.homepage', array_merge(
            compact('sections', 'sectionTypes', 'headerMenu', 'footerMenu', 'footerTemplate'),
            $viewData
        ));
    }

    /**
     * Render the homepage preview for the iframe.
     */
    public function preview()
    {
        $sections = SiteSection::where('is_active', true)->orderBy('sort_order')->get();
        $headerMenu = get_menu('header');
        $footerMenu = get_menu('footer');
        $footerTemplate = setting('footer_template', '1');

        $viewData = $this->getSectionViewData();

        return view('frontend.home', array_merge(
            compact('sections', 'headerMenu', 'footerMenu', 'footerTemplate'),
            $viewData
        ));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'template' => 'required|string',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
        ]);

        $maxOrder = SiteSection::max('sort_order') ?? -1;

        $section = SiteSection::create([
            'type' => $request->type,
            'template' => $request->template,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'content' => $request->content,
            'settings' => $request->settings ? json_decode($request->settings, true) : [],
            'sort_order' => $maxOrder + 1,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة القسم بنجاح.',
                'section' => $section,
                'html' => $this->renderSectionHtml($section),
            ]);
        }

        return redirect()->route('admin.website.homepage')->with('success', 'تم إضافة القسم بنجاح.');
    }

    /**
     * Get section data for the edit modal (AJAX).
     */
    public function getSectionData(SiteSection $section)
    {
        return response()->json(['success' => true, 'section' => $section]);
    }

    public function updateSection(Request $request, SiteSection $section)
    {
        $request->validate([
            'template' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
        ]);

        $data = $request->only('title', 'subtitle', 'content');
        if ($request->has('template')) $data['template'] = $request->template;
        if ($request->has('settings')) {
            $data['settings'] = is_string($request->settings) ? json_decode($request->settings, true) : $request->settings;
        }

        $section->update($data);
        $section->refresh();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث القسم بنجاح.',
                'section' => $section,
                'html' => $this->renderSectionHtml($section),
            ]);
        }

        return redirect()->route('admin.website.homepage')->with('success', 'تم تحديث القسم بنجاح.');
    }

    public function deleteSection(SiteSection $section)
    {
        $section->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم حذف القسم بنجاح.']);
        }

        return redirect()->route('admin.website.homepage')->with('success', 'تم حذف القسم بنجاح.');
    }

    public function toggleSection(SiteSection $section)
    {
        $section->update(['is_active' => !$section->is_active]);
        return response()->json([
            'success' => true,
            'is_active' => $section->is_active,
            'message' => $section->is_active ? 'تم تفعيل القسم.' : 'تم تعطيل القسم.',
        ]);
    }

    public function reorderSections(Request $request)
    {
        $request->validate(['items' => 'required|array']);

        foreach ($request->items as $i => $id) {
            SiteSection::where('id', $id)->update(['sort_order' => $i]);
        }

        return response()->json(['success' => true, 'message' => 'تم تحديث الترتيب.']);
    }
}
