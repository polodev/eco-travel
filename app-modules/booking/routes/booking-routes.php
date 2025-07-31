<?php

use Modules\Booking\Controllers\Admin\BookingController;
use Modules\Booking\Controllers\Admin\BookingFlightController;
use Modules\Booking\Controllers\Admin\BookingHotelController;
use Modules\Booking\Controllers\Admin\BookingTourController;

Route::prefix('admin-dashboard')->name('admin-dashboard.')->middleware(['web', 'auth'])->group(function () {
    
    // Booking Management Routes
    Route::prefix('bookings')->name('booking.bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::post('/json', [BookingController::class, 'indexJson'])->name('json');
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [BookingController::class, 'update'])->name('update');
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
    });

    // Flight Booking Management Routes
    Route::prefix('booking-flights')->name('booking.booking-flights.')->group(function () {
        Route::get('/', [BookingFlightController::class, 'index'])->name('index');
        Route::post('/json', [BookingFlightController::class, 'indexJson'])->name('json');
        Route::get('/create', [BookingFlightController::class, 'create'])->name('create');
        Route::post('/', [BookingFlightController::class, 'store'])->name('store');
        Route::get('/{bookingFlight}', [BookingFlightController::class, 'show'])->name('show');
        Route::get('/{bookingFlight}/edit', [BookingFlightController::class, 'edit'])->name('edit');
        Route::put('/{bookingFlight}', [BookingFlightController::class, 'update'])->name('update');
        Route::delete('/{bookingFlight}', [BookingFlightController::class, 'destroy'])->name('destroy');
    });

    // Hotel Booking Management Routes  
    Route::prefix('booking-hotels')->name('booking.booking-hotels.')->group(function () {
        Route::get('/', [BookingHotelController::class, 'index'])->name('index');
        Route::post('/json', [BookingHotelController::class, 'indexJson'])->name('json');
        Route::get('/create', [BookingHotelController::class, 'create'])->name('create');
        Route::post('/', [BookingHotelController::class, 'store'])->name('store');
        Route::get('/{bookingHotel}', [BookingHotelController::class, 'show'])->name('show');
        Route::get('/{bookingHotel}/edit', [BookingHotelController::class, 'edit'])->name('edit');
        Route::put('/{bookingHotel}', [BookingHotelController::class, 'update'])->name('update');
        Route::delete('/{bookingHotel}', [BookingHotelController::class, 'destroy'])->name('destroy');
    });

    // Tour Booking Management Routes
    Route::prefix('booking-tours')->name('booking.booking-tours.')->group(function () {
        Route::get('/', [BookingTourController::class, 'index'])->name('index');
        Route::post('/json', [BookingTourController::class, 'indexJson'])->name('json');
        Route::get('/create', [BookingTourController::class, 'create'])->name('create');
        Route::post('/', [BookingTourController::class, 'store'])->name('store');
        Route::get('/{bookingTour}', [BookingTourController::class, 'show'])->name('show');
        Route::get('/{bookingTour}/edit', [BookingTourController::class, 'edit'])->name('edit');
        Route::put('/{bookingTour}', [BookingTourController::class, 'update'])->name('update');
        Route::delete('/{bookingTour}', [BookingTourController::class, 'destroy'])->name('destroy');
    });
});
