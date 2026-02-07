<?php

use App\Domains\Customer\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')->name('admin.customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/search', [CustomerController::class, 'search'])->name('search');
    Route::post('/quick-store', [CustomerController::class, 'quickStore'])->name('quick-store');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('show');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
});
