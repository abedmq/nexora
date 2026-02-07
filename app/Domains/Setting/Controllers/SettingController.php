<?php

namespace App\Domains\Setting\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if ($request->has('settings')) {
            foreach ($request->settings as $key => $value) {
                DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value, 'updated_at' => now()]
                );
            }

            // Handle theme file uploads
            $fileFields = [
                'site_logo'      => 'company_logo',
                'site_logo_dark' => 'company_logo_dark',
                'site_favicon'   => 'site_favicon',
            ];

            foreach ($fileFields as $inputName => $settingKey) {
                if ($request->hasFile($inputName)) {
                    $request->validate([
                        $inputName => 'image|mimes:png,jpg,jpeg,svg,webp,ico|max:2048',
                    ]);

                    // Delete old file
                    $old = DB::table('settings')->where('key', $settingKey)->value('value');
                    if ($old && File::exists(public_path($old))) {
                        File::delete(public_path($old));
                    }

                    $file = $request->file($inputName);
                    $filename = $settingKey . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/logos'), $filename);

                    DB::table('settings')->updateOrInsert(
                        ['key' => $settingKey],
                        ['value' => 'uploads/logos/' . $filename, 'updated_at' => now()]
                    );
                }
            }

            clear_settings_cache();

            return redirect()->route('admin.settings.index')
                ->with('success', 'تم حفظ الإعدادات بنجاح.');
        }

        // Update profile
        if ($request->has('name')) {
            $user = auth()->user();
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return redirect()->route('admin.settings.index')
                ->with('success', 'تم تحديث الملف الشخصي بنجاح.');
        }

        // Update password
        if ($request->has('current_password')) {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ], [
                'current_password.required' => 'كلمة المرور الحالية مطلوبة.',
                'new_password.required' => 'كلمة المرور الجديدة مطلوبة.',
                'new_password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل.',
                'new_password.confirmed' => 'كلمة المرور غير متطابقة.',
            ]);

            if (!Hash::check($request->current_password, auth()->user()->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
            }

            auth()->user()->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('admin.settings.index')
                ->with('success', 'تم تحديث كلمة المرور بنجاح.');
        }

        return redirect()->route('admin.settings.index');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ], [
            'logo.required' => 'يرجى اختيار صورة الشعار.',
            'logo.image' => 'الملف يجب أن يكون صورة.',
            'logo.mimes' => 'الصيغ المسموحة: png, jpg, jpeg, svg, webp.',
            'logo.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',
        ]);

        // Delete old logo if exists
        $oldLogo = DB::table('settings')->where('key', 'company_logo')->value('value');
        if ($oldLogo && File::exists(public_path($oldLogo))) {
            File::delete(public_path($oldLogo));
        }

        $file = $request->file('logo');
        $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/logos'), $filename);

        $path = 'uploads/logos/' . $filename;

        DB::table('settings')->updateOrInsert(
            ['key' => 'company_logo'],
            ['value' => $path, 'updated_at' => now()]
        );

        clear_settings_cache();

        return redirect()->route('admin.settings.index')
            ->with('success', 'تم تحديث الشعار بنجاح.');
    }
}
