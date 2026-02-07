<?php

use App\Domains\Page\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('pages')->name('admin.pages.')->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('index');
    Route::get('/create', [PageController::class, 'create'])->name('create');
    Route::post('/', [PageController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PageController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PageController::class, 'update'])->name('update');
    Route::delete('/{id}', [PageController::class, 'destroy'])->name('destroy');

    // Sections AJAX
    Route::post('/{pageId}/sections', [PageController::class, 'storeSection'])->name('sections.store');
    Route::put('/sections/{sectionId}', [PageController::class, 'updateSection'])->name('sections.update');
    Route::delete('/sections/{sectionId}', [PageController::class, 'deleteSection'])->name('sections.destroy');
    Route::post('/{pageId}/sections/reorder', [PageController::class, 'reorderSections'])->name('sections.reorder');
});
