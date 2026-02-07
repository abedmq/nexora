<?php

namespace App\Domains\Page\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Page\Models\Page;

class FrontendPageController extends Controller
{
    public function show($slug)
    {
        $page = Page::with('activeSections')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $headerMenu = get_menu('header');
        $footerMenu = get_menu('footer');

        // Fallback to navPages if no header menu exists
        $navPages = Page::where('show_in_nav', true)
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->get(['title', 'slug']);

        return view('frontend.page', compact('page', 'navPages', 'headerMenu', 'footerMenu'));
    }
}
