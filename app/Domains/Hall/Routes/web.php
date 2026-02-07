<?php

use App\Domains\Hall\Controllers\HallController;
use Illuminate\Support\Facades\Route;

Route::prefix('halls')->name('admin.halls.')->group(function () {
    Route::get('/', [HallController::class, 'index'])->name('index');
    Route::post('/', [HallController::class, 'store'])->name('store');
    Route::get('/{id}', [HallController::class, 'show'])->name('show');
    Route::delete('/{id}', [HallController::class, 'destroy'])->name('destroy');
});
