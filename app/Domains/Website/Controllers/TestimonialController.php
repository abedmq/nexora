<?php

namespace App\Domains\Website\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Website\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        return view('admin.website.testimonials', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'rating' => 'integer|min:1|max:5',
            'avatar' => 'nullable|image|max:1024',
        ]);

        $data = $request->only('name', 'content', 'position', 'company', 'rating');
        $data['sort_order'] = (Testimonial::max('sort_order') ?? -1) + 1;

        if ($request->hasFile('avatar')) {
            $path = 'uploads/testimonials';
            if (!File::isDirectory(public_path($path))) File::makeDirectory(public_path($path), 0755, true);
            $file = $request->file('avatar');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $name);
            $data['avatar'] = $path . '/' . $name;
        }

        Testimonial::create($data);

        return redirect()->route('admin.website.testimonials')->with('success', 'تم إضافة الرأي بنجاح.');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'rating' => 'integer|min:1|max:5',
            'avatar' => 'nullable|image|max:1024',
        ]);

        $data = $request->only('name', 'content', 'position', 'company', 'rating');

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar && File::exists(public_path($testimonial->avatar))) {
                File::delete(public_path($testimonial->avatar));
            }
            $path = 'uploads/testimonials';
            if (!File::isDirectory(public_path($path))) File::makeDirectory(public_path($path), 0755, true);
            $file = $request->file('avatar');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($path), $name);
            $data['avatar'] = $path . '/' . $name;
        }

        $testimonial->update($data);

        return redirect()->route('admin.website.testimonials')->with('success', 'تم تحديث الرأي بنجاح.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar && File::exists(public_path($testimonial->avatar))) {
            File::delete(public_path($testimonial->avatar));
        }
        $testimonial->delete();

        return redirect()->route('admin.website.testimonials')->with('success', 'تم حذف الرأي بنجاح.');
    }

    public function toggle(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => !$testimonial->is_active]);
        return response()->json(['success' => true, 'is_active' => $testimonial->is_active]);
    }
}
