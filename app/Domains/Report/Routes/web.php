<?php

use App\Domains\Report\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->name('admin.reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
});
