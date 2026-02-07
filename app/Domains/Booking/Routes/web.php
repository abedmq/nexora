<?php

use App\Domains\Booking\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::prefix('bookings')->name('admin.bookings.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/create', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    Route::post('/hall-price', [BookingController::class, 'getHallPrice'])->name('hall-price');
    Route::post('/{id}/close', [BookingController::class, 'close'])->name('close');
    Route::get('/{id}', [BookingController::class, 'show'])->name('show');
    Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
});
