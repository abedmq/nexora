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

class FrontendController extends Controller
{
    public function home()
    {
        $sections = SiteSection::where('is_active', true)->orderBy('sort_order')->get();
        $headerMenu = get_menu('header');
        $footerMenu = get_menu('footer');

        // Pre-load all data for data-driven sections
        $features = FeatureItem::where('is_active', true)->orderBy('sort_order')->get();
        $services = ServiceItem::where('is_active', true)->orderBy('sort_order')->get();
        $statItems = StatItem::where('is_active', true)->orderBy('sort_order')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        $partners = Partner::where('is_active', true)->orderBy('sort_order')->get();
        $faqItems = FaqItem::where('is_active', true)->orderBy('sort_order')->get();
        $sliderItems = SliderItem::where('is_active', true)->orderBy('sort_order')->get();

        $footerTemplate = setting('footer_template', '1');

        return view('frontend.home', compact(
            'sections', 'headerMenu', 'footerMenu',
            'features', 'services', 'statItems',
            'testimonials', 'partners', 'faqItems',
            'sliderItems', 'footerTemplate'
        ));
    }
}
