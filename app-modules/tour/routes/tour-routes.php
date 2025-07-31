<?php

use Modules\Tour\Http\Controllers\TourController;
use Modules\Tour\Http\Controllers\TourItineraryController;

Route::prefix('admin-dashboard')->name('admin-dashboard.')->middleware(['web', 'auth'])->group(function () {
    
    // Tour Management Routes
    Route::prefix('tours')->name('tour.tours.')->group(function () {
        Route::get('/', [TourController::class, 'index'])->name('index');
        Route::post('/json', [TourController::class, 'indexJson'])->name('json');
        Route::get('/create', [TourController::class, 'create'])->name('create');
        Route::post('/', [TourController::class, 'store'])->name('store');
        Route::get('/{tour}', [TourController::class, 'show'])->name('show');
        Route::get('/{tour}/edit', [TourController::class, 'edit'])->name('edit');
        Route::put('/{tour}', [TourController::class, 'update'])->name('update');
        Route::delete('/{tour}', [TourController::class, 'destroy'])->name('destroy');
        Route::patch('/{tour}/toggle-featured', [TourController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::patch('/{tour}/toggle-active', [TourController::class, 'toggleActive'])->name('toggle-active');
        Route::post('/{tour}/duplicate', [TourController::class, 'duplicate'])->name('duplicate');
        
        // AJAX Routes
        Route::get('/ajax/cities-by-country', [TourController::class, 'getCitiesByCountry'])->name('cities-by-country');
    });

    // Tour Itinerary Management Routes
    Route::prefix('itineraries')->name('tour.itineraries.')->group(function () {
        Route::get('/', [TourItineraryController::class, 'index'])->name('index');
        Route::post('/json', [TourItineraryController::class, 'indexJson'])->name('json');
        Route::get('/create', [TourItineraryController::class, 'create'])->name('create');
        Route::post('/', [TourItineraryController::class, 'store'])->name('store');
        Route::get('/{itinerary}', [TourItineraryController::class, 'show'])->name('show');
        Route::get('/{itinerary}/edit', [TourItineraryController::class, 'edit'])->name('edit');
        Route::put('/{itinerary}', [TourItineraryController::class, 'update'])->name('update');
        Route::delete('/{itinerary}', [TourItineraryController::class, 'destroy'])->name('destroy');
        Route::post('/{itinerary}/duplicate', [TourItineraryController::class, 'duplicate'])->name('duplicate');
        
        // AJAX Routes
        Route::get('/ajax/itineraries-by-tour/{tour}', [TourItineraryController::class, 'getItinerariesByTour'])->name('itineraries-by-tour');
    });
});
