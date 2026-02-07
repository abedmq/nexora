<?php

use App\Domains\Setting\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->name('admin.settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::put('/', [SettingController::class, 'update'])->name('update');
    Route::post('/logo', [SettingController::class, 'updateLogo'])->name('update-logo');
});
