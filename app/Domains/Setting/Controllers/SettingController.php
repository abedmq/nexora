<?php

namespace App\Domains\Setting\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use ZipArchive;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->pluck('value', 'key');
        $demoPresets = $this->getDemoPresets();

        return view('admin.settings.index', compact('settings', 'demoPresets'));
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

    public function exportDemo()
    {
        $timestamp = now()->format('Ymd_His');
        $workDir = storage_path("app/demo-exports/{$timestamp}");
        File::ensureDirectoryExists($workDir);

        $tables = [
            'settings',
            'site_sections',
            'feature_items',
            'service_items',
            'stat_items',
            'testimonials',
            'partners',
            'faq_items',
            'slider_items',
        ];

        $data = [];
        $sqlDump = $this->buildSqlDump($tables, $data);
        $sqlPath = "{$workDir}/demo.sql";
        File::put($sqlPath, $sqlDump);

        $manifest = $this->buildDemoManifest($data);
        $manifestPath = "{$workDir}/manifest.json";
        File::put($manifestPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $dataPath = "{$workDir}/data.json";
        File::put($dataPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $zipPath = storage_path("app/demo-exports/demo_export_{$timestamp}.zip");
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile($sqlPath, 'demo.sql');
        $zip->addFile($manifestPath, 'manifest.json');
        $zip->addFile($dataPath, 'data.json');

        foreach ($manifest['images'] as $image) {
            $zipPathName = 'images/' . ltrim(str_replace('\\', '/', $image['path']), '/');
            $publicFile = public_path($image['path']);
            if (File::exists($publicFile)) {
                $zip->addFile($publicFile, $zipPathName);
            }
        }

        $zip->close();
        File::deleteDirectory($workDir);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function importDemo(Request $request)
    {
        $request->validate([
            'demo_zip' => 'nullable|file|mimes:zip|max:51200',
            'preset' => 'nullable|string',
        ], [
            'demo_zip.mimes' => 'يجب اختيار ملف مضغوط بصيغة ZIP.',
            'demo_zip.max' => 'حجم الملف يجب ألا يتجاوز 50 ميجابايت.',
        ]);

        $zipPath = null;
        if ($request->hasFile('demo_zip')) {
            $zipPath = $request->file('demo_zip')->storeAs('demo-imports', 'demo_' . time() . '.zip');
            $zipPath = storage_path('app/' . $zipPath);
        } elseif ($request->filled('preset')) {
            $presetPath = storage_path('app/demos/' . basename($request->preset));
            if (File::exists($presetPath)) {
                $zipPath = $presetPath;
            }
        }

        if (!$zipPath || !File::exists($zipPath)) {
            return back()->withErrors(['demo_zip' => 'يرجى اختيار ديمو للاستيراد.']);
        }

        $extractDir = storage_path('app/demo-imports/' . Str::uuid());
        File::ensureDirectoryExists($extractDir);

        $zip = new ZipArchive();
        $zip->open($zipPath);
        $zip->extractTo($extractDir);
        $zip->close();

        $sqlFile = $extractDir . '/demo.sql';
        if (!File::exists($sqlFile)) {
            File::deleteDirectory($extractDir);
            return back()->withErrors(['demo_zip' => 'ملف الديمو لا يحتوي على بيانات SQL.']);
        }

        DB::beginTransaction();
        try {
            DB::unprepared(File::get($sqlFile));
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            File::deleteDirectory($extractDir);

            return back()->withErrors(['demo_zip' => 'فشل استيراد بيانات الديمو.']);
        }

        $this->restoreDemoImages($extractDir);
        clear_settings_cache();

        File::deleteDirectory($extractDir);
        if ($request->hasFile('demo_zip') && $zipPath) {
            File::delete($zipPath);
        }

        return redirect()->route('admin.settings.index')->with('success', 'تم استيراد الديمو بنجاح.');
    }

    private function getDemoPresets(): array
    {
        $presetDir = storage_path('app/demos');
        if (!File::exists($presetDir)) {
            return [];
        }

        return collect(File::files($presetDir))
            ->filter(fn ($file) => strtolower($file->getExtension()) === 'zip')
            ->map(fn ($file) => $file->getFilename())
            ->values()
            ->all();
    }

    private function buildSqlDump(array $tables, array &$data): string
    {
        $pdo = DB::getPdo();
        $dump = [];

        foreach ($tables as $table) {
            $columns = Schema::getColumnListing($table);
            $rows = DB::table($table)->get();

            $data[$table] = $rows;
            $dump[] = "DELETE FROM `{$table}`;";

            if ($rows->isNotEmpty()) {
                $columnList = '`' . implode('`,`', $columns) . '`';
                $values = [];
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $rowValues = [];
                    foreach ($columns as $column) {
                        $value = $rowArray[$column] ?? null;
                        if (is_null($value)) {
                            $rowValues[] = 'NULL';
                        } elseif (is_bool($value)) {
                            $rowValues[] = $value ? '1' : '0';
                        } elseif (is_numeric($value)) {
                            $rowValues[] = $value;
                        } else {
                            $rowValues[] = $pdo->quote($value);
                        }
                    }
                    $values[] = '(' . implode(',', $rowValues) . ')';
                }
                $dump[] = "INSERT INTO `{$table}` ({$columnList}) VALUES\n" . implode(",\n", $values) . ';';
            }

            $dump[] = '';
        }

        return implode("\n", $dump);
    }

    private function buildDemoManifest(array $data): array
    {
        $images = [];

        $settings = $data['settings'] ?? [];
        foreach ($settings as $setting) {
            $path = $setting->value ?? null;
            $key = $setting->key ?? '';
            if ($this->isDemoImagePath($path, $key)) {
                $images[$path] = ['path' => $path, 'source' => 'settings'];
            }
        }

        $imageTables = [
            'slider_items' => ['image'],
            'feature_items' => ['image'],
            'service_items' => ['image'],
            'testimonials' => ['avatar'],
            'partners' => ['logo'],
        ];

        foreach ($imageTables as $table => $columns) {
            $rows = $data[$table] ?? [];
            foreach ($rows as $row) {
                foreach ($columns as $column) {
                    $path = $row->{$column} ?? null;
                    if ($this->isDemoImagePath($path)) {
                        $images[$path] = ['path' => $path, 'source' => $table];
                    }
                }
            }
        }

        $sections = $data['site_sections'] ?? [];
        foreach ($sections as $section) {
            $settings = $section->settings ? json_decode($section->settings, true) : [];
            if (!is_array($settings)) {
                continue;
            }
            foreach ($settings as $key => $value) {
                if (str_contains($key, 'image') || str_contains($key, 'img')) {
                    if ($this->isDemoImagePath($value, $key)) {
                        $images[$value] = ['path' => $value, 'source' => 'site_sections'];
                    }
                }
            }
        }

        return [
            'generated_at' => now()->toDateTimeString(),
            'images' => array_values($images),
        ];
    }

    private function isDemoImagePath(?string $path, string $key = ''): bool
    {
        if (!$path || !is_string($path)) {
            return false;
        }

        if (str_starts_with($path, 'http')) {
            return false;
        }

        $allowedKeys = ['company_logo', 'company_logo_dark', 'site_favicon'];
        if (in_array($key, $allowedKeys, true)) {
            return File::exists(public_path($path));
        }

        if (str_contains($path, 'uploads') || str_contains($path, 'images')) {
            return File::exists(public_path($path));
        }

        return false;
    }

    private function restoreDemoImages(string $extractDir): void
    {
        $manifestPath = $extractDir . '/manifest.json';
        $imagesDir = $extractDir . '/images';

        if (!File::exists($imagesDir)) {
            return;
        }

        $manifest = [];
        if (File::exists($manifestPath)) {
            $manifest = json_decode(File::get($manifestPath), true);
        }

        if (!empty($manifest['images'])) {
            foreach ($manifest['images'] as $image) {
                $path = $image['path'] ?? null;
                if (!$path) {
                    continue;
                }
                $source = $imagesDir . '/' . ltrim($path, '/');
                $destination = public_path($path);
                if (!File::exists($source)) {
                    continue;
                }
                File::ensureDirectoryExists(dirname($destination));
                File::copy($source, $destination);
            }

            return;
        }

        foreach (File::allFiles($imagesDir) as $file) {
            $relative = str_replace($imagesDir . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $destination = public_path($relative);
            File::ensureDirectoryExists(dirname($destination));
            File::copy($file->getPathname(), $destination);
        }
    }
}
