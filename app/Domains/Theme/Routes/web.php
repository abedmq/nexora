<?php

use App\Domains\Theme\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

Route::prefix('themes')->name('admin.themes.')->group(function () {
    Route::get('/', [ThemeController::class, 'index'])->name('index');
    Route::put('/{theme}', [ThemeController::class, 'activate'])->name('activate');
});
