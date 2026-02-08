<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureThemeSupports
{
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        if (!theme_supports($feature)) {
            return redirect()->route('admin.themes.index')
                ->withErrors(['theme' => 'الثيم الحالي لا يدعم هذه الصفحة.']);
        }

        return $next($request);
    }
}
