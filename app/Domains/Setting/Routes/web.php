<?php

use App\Domains\Setting\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->name('admin.settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::put('/', [SettingController::class, 'update'])->name('update');
    Route::post('/logo', [SettingController::class, 'updateLogo'])->name('update-logo');
    Route::get('/demo/export', [SettingController::class, 'exportDemo'])->name('demo.export')->middleware('theme.supports:demo');
    Route::post('/demo/import', [SettingController::class, 'importDemo'])->name('demo.import')->middleware('theme.supports:demo');
});
