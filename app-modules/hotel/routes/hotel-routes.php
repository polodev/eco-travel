<?php

use Modules\Hotel\Http\Controllers\HotelController;

Route::prefix('admin-dashboard')->name('admin-dashboard.')->middleware(['web', 'auth'])->group(function () {
    
    // Hotel Management Routes
    Route::prefix('hotels')->name('hotel.hotels.')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
        Route::post('/json', [HotelController::class, 'indexJson'])->name('json');
        Route::get('/create', [HotelController::class, 'create'])->name('create');
        Route::post('/', [HotelController::class, 'store'])->name('store');
        Route::get('/{hotel}', [HotelController::class, 'show'])->name('show');
        Route::get('/{hotel}/edit', [HotelController::class, 'edit'])->name('edit');
        Route::put('/{hotel}', [HotelController::class, 'update'])->name('update');
        Route::delete('/{hotel}', [HotelController::class, 'destroy'])->name('destroy');
    });
});