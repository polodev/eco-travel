<?php

use Modules\Booking\Http\Controllers\BookingController;

Route::prefix('admin-dashboard')->name('admin-dashboard.')->middleware(['web', 'auth'])->group(function () {
    
    // Booking Management Routes
    Route::prefix('bookings')->name('booking.bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::post('/json', [BookingController::class, 'indexJson'])->name('json');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [BookingController::class, 'update'])->name('update');
    });
});
