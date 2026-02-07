<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Menu\Controllers\MenuController;

Route::prefix('menus')->name('admin.menus.')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('index');
    Route::get('/create', [MenuController::class, 'create'])->name('create');
    Route::post('/', [MenuController::class, 'store'])->name('store');
    Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
    Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
    Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');

    // Menu Items (AJAX)
    Route::post('/{menu}/items', [MenuController::class, 'storeItem'])->name('items.store');
    Route::post('/{menu}/reorder', [MenuController::class, 'reorderItems'])->name('items.reorder');
});

// Item-level routes (outside menu prefix for cleaner URLs)
Route::prefix('menu-items')->name('admin.menu-items.')->group(function () {
    Route::put('/{item}', [MenuController::class, 'updateItem'])->name('update');
    Route::delete('/{item}', [MenuController::class, 'deleteItem'])->name('destroy');
    Route::post('/{item}/toggle', [MenuController::class, 'toggleItem'])->name('toggle');
});
