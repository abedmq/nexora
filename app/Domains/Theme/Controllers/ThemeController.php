<?php

namespace App\Domains\Theme\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = available_themes();
        $activeTheme = active_theme();

        return view('admin.themes.index', compact('themes', 'activeTheme'));
    }

    public function activate(Request $request, string $theme)
    {
        $themes = available_themes();

        if (!array_key_exists($theme, $themes)) {
            abort(404);
        }

        DB::table('settings')->updateOrInsert(
            ['key' => 'active_theme'],
            ['value' => $theme, 'updated_at' => now()]
        );

        clear_settings_cache();

        return redirect()->route('admin.themes.index')
            ->with('success', 'تم تفعيل الثيم بنجاح.');
    }
}
