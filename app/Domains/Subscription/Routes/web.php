<?php

use App\Domains\Subscription\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('subscriptions')->name('admin.subscriptions.')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('index');
    Route::post('/', [SubscriptionController::class, 'store'])->name('store');
    Route::get('/{id}', [SubscriptionController::class, 'show'])->name('show');
    Route::delete('/{id}', [SubscriptionController::class, 'destroy'])->name('destroy');
});
