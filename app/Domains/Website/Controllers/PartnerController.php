<?php

namespace App\Domains\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('admin.website.partners', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:500',
            'logo' => 'nullable|image|max:1024',
        ]);

        $data = $request->only('name', 'url');
        $data['sort_order'] = (Partner::max('sort_order') ?? -1) + 1;

        if ($request->hasFile('logo')) {
            $path = 'uploads/partners';
            if (!File::isDirectory(public_path($path))) File::makeDirectory(public_path($path), 0755, true);
            $file = $request->file('logo');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $name);
            $data['logo'] = $path . '/' . $name;
        }

        Partner::create($data);

        return redirect()->route('admin.website.partners')->with('success', 'تم إضافة الشريك بنجاح.');
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:500',
            'logo' => 'nullable|image|max:1024',
        ]);

        $data = $request->only('name', 'url');

        if ($request->hasFile('logo')) {
            if ($partner->logo && File::exists(public_path($partner->logo))) {
                File::delete(public_path($partner->logo));
            }
            $path = 'uploads/partners';
            if (!File::isDirectory(public_path($path))) File::makeDirectory(public_path($path), 0755, true);
            $file = $request->file('logo');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $name);
            $data['logo'] = $path . '/' . $name;
        }

        $partner->update($data);

        return redirect()->route('admin.website.partners')->with('success', 'تم تحديث الشريك بنجاح.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo && File::exists(public_path($partner->logo))) {
            File::delete(public_path($partner->logo));
        }
        $partner->delete();

        return redirect()->route('admin.website.partners')->with('success', 'تم حذف الشريك بنجاح.');
    }

    public function toggle(Partner $partner)
    {
        $partner->update(['is_active' => !$partner->is_active]);
        return response()->json(['success' => true, 'is_active' => $partner->is_active]);
    }
}
