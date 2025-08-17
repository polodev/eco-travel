<?php

use Modules\Flight\Http\Controllers\AirlineController;
use Modules\Flight\Http\Controllers\FlightController;
use Modules\Flight\Http\Controllers\FlightScheduleController;
use Modules\Flight\Http\Controllers\DynamicFlightController;


Route::prefix('admin-dashboard')->name('flight::admin.')->middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->group(function () {
    
    // Airline Management Routes
    Route::prefix('airlines')->name('airlines.')->group(function () {
        Route::get('/', [AirlineController::class, 'index'])->name('index');
        Route::get('/create', [AirlineController::class, 'create'])->name('create');
        Route::post('/', [AirlineController::class, 'store'])->name('store');
        Route::post('/json', [AirlineController::class, 'indexJson'])->name('json');
        Route::get('/{airline}', [AirlineController::class, 'show'])->name('show');
        Route::get('/{airline}/edit', [AirlineController::class, 'edit'])->name('edit');
        Route::put('/{airline}', [AirlineController::class, 'update'])->name('update');
        Route::delete('/{airline}', [AirlineController::class, 'destroy'])->name('destroy');
        Route::patch('/{airline}/toggle-active', [AirlineController::class, 'toggleActive'])->name('toggle-active');
    });

    // Flight Management Routes
    Route::prefix('flights')->name('flights.')->group(function () {
        Route::get('/', [FlightController::class, 'index'])->name('index');
        Route::get('/create', [FlightController::class, 'create'])->name('create');
        Route::post('/', [FlightController::class, 'store'])->name('store');
        Route::post('/json', [FlightController::class, 'indexJson'])->name('json');
        Route::get('/{flight}', [FlightController::class, 'show'])->name('show');
        Route::get('/{flight}/edit', [FlightController::class, 'edit'])->name('edit');
        Route::put('/{flight}', [FlightController::class, 'update'])->name('update');
        Route::delete('/{flight}', [FlightController::class, 'destroy'])->name('destroy');
        Route::patch('/{flight}/toggle-active', [FlightController::class, 'toggleActive'])->name('toggle-active');
    });

    // Flight Schedule Management Routes
    Route::prefix('flight-schedules')->name('flight-schedules.')->group(function () {
        Route::get('/', [FlightScheduleController::class, 'index'])->name('index');
        Route::post('/json', [FlightScheduleController::class, 'indexJson'])->name('json');
        Route::get('/create', [FlightScheduleController::class, 'create'])->name('create');
        Route::post('/', [FlightScheduleController::class, 'store'])->name('store');
        Route::get('/{flightSchedule}', [FlightScheduleController::class, 'show'])->name('show');
        Route::get('/{flightSchedule}/edit', [FlightScheduleController::class, 'edit'])->name('edit');
        Route::put('/{flightSchedule}', [FlightScheduleController::class, 'update'])->name('update');
        Route::delete('/{flightSchedule}', [FlightScheduleController::class, 'destroy'])->name('destroy');
        Route::patch('/{flightSchedule}/status', [FlightScheduleController::class, 'updateStatus'])->name('update-status');
    });
});

// Dynamic Flight Routes (Customer Frontend - Localized)
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function() {
    Route::get('/dynamic-flight', [DynamicFlightController::class, 'index'])->name('flight::dynamic.index');
    Route::post('/dynamic-flight/search', [DynamicFlightController::class, 'search'])->name('flight::dynamic.search');
    Route::get('/dynamic-flight/{id}', [DynamicFlightController::class, 'show'])->name('flight::dynamic.show');
    Route::get('/api/airports/autocomplete', [DynamicFlightController::class, 'airportsAutocomplete'])->name('flight::api.airports.autocomplete');
});