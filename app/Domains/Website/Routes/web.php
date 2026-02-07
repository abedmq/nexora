<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Website\Controllers\HomepageController;
use App\Domains\Website\Controllers\TestimonialController;
use App\Domains\Website\Controllers\PartnerController;
use App\Domains\Website\Controllers\FeatureItemController;
use App\Domains\Website\Controllers\ServiceItemController;
use App\Domains\Website\Controllers\StatItemController;
use App\Domains\Website\Controllers\FaqItemController;
use App\Domains\Website\Controllers\SliderItemController;

Route::prefix('website')->name('admin.website.')->group(function () {

    // Homepage Builder
    Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');
    Route::get('/homepage/preview', [HomepageController::class, 'preview'])->name('homepage.preview');
    Route::post('/homepage/sections', [HomepageController::class, 'storeSection'])->name('sections.store');
    Route::post('/homepage/sections/reorder', [HomepageController::class, 'reorderSections'])->name('sections.reorder');
    Route::get('/homepage/sections/{section}/data', [HomepageController::class, 'getSectionData'])->name('sections.data');
    Route::put('/homepage/sections/{section}', [HomepageController::class, 'updateSection'])->name('sections.update');
    Route::delete('/homepage/sections/{section}', [HomepageController::class, 'deleteSection'])->name('sections.destroy');
    Route::post('/homepage/sections/{section}/toggle', [HomepageController::class, 'toggleSection'])->name('sections.toggle');

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials');
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    Route::post('/testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggle'])->name('testimonials.toggle');

    // Partners
    Route::get('/partners', [PartnerController::class, 'index'])->name('partners');
    Route::post('/partners', [PartnerController::class, 'store'])->name('partners.store');
    Route::put('/partners/{partner}', [PartnerController::class, 'update'])->name('partners.update');
    Route::delete('/partners/{partner}', [PartnerController::class, 'destroy'])->name('partners.destroy');
    Route::post('/partners/{partner}/toggle', [PartnerController::class, 'toggle'])->name('partners.toggle');

    // Features (المميزات)
    Route::get('/features', [FeatureItemController::class, 'index'])->name('features');
    Route::post('/features', [FeatureItemController::class, 'store'])->name('features.store');
    Route::put('/features/{feature}', [FeatureItemController::class, 'update'])->name('features.update');
    Route::delete('/features/{feature}', [FeatureItemController::class, 'destroy'])->name('features.destroy');
    Route::post('/features/{feature}/toggle', [FeatureItemController::class, 'toggle'])->name('features.toggle');

    // Services (الخدمات)
    Route::get('/services', [ServiceItemController::class, 'index'])->name('services');
    Route::post('/services', [ServiceItemController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceItemController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceItemController::class, 'destroy'])->name('services.destroy');
    Route::post('/services/{service}/toggle', [ServiceItemController::class, 'toggle'])->name('services.toggle');

    // Stats (الإحصائيات)
    Route::get('/stats', [StatItemController::class, 'index'])->name('stats');
    Route::post('/stats', [StatItemController::class, 'store'])->name('stats.store');
    Route::put('/stats/{stat}', [StatItemController::class, 'update'])->name('stats.update');
    Route::delete('/stats/{stat}', [StatItemController::class, 'destroy'])->name('stats.destroy');
    Route::post('/stats/{stat}/toggle', [StatItemController::class, 'toggle'])->name('stats.toggle');

    // FAQ (الأسئلة الشائعة)
    Route::get('/faq', [FaqItemController::class, 'index'])->name('faq');
    Route::post('/faq', [FaqItemController::class, 'store'])->name('faq.store');
    Route::put('/faq/{faq}', [FaqItemController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{faq}', [FaqItemController::class, 'destroy'])->name('faq.destroy');
    Route::post('/faq/{faq}/toggle', [FaqItemController::class, 'toggle'])->name('faq.toggle');

    // Slider (السلايدر)
    Route::get('/sliders', [SliderItemController::class, 'index'])->name('sliders');
    Route::post('/sliders', [SliderItemController::class, 'store'])->name('sliders.store');
    Route::put('/sliders/{slider}', [SliderItemController::class, 'update'])->name('sliders.update');
    Route::delete('/sliders/{slider}', [SliderItemController::class, 'destroy'])->name('sliders.destroy');
    Route::post('/sliders/{slider}/toggle', [SliderItemController::class, 'toggle'])->name('sliders.toggle');
});
