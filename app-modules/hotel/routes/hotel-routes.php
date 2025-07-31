<?php

use Modules\Hotel\Http\Controllers\HotelController;
use Modules\Hotel\Http\Controllers\HotelRoomController;
use Modules\Hotel\Http\Controllers\RoomInventoryController;

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

    // Hotel Room Management Routes
    Route::prefix('hotel-rooms')->name('hotel.rooms.')->group(function () {
        Route::get('/', [HotelRoomController::class, 'index'])->name('index');
        Route::post('/json', [HotelRoomController::class, 'indexJson'])->name('json');
        Route::get('/create', [HotelRoomController::class, 'create'])->name('create');
        Route::post('/', [HotelRoomController::class, 'store'])->name('store');
        Route::get('/{room}', [HotelRoomController::class, 'show'])->name('show');
        Route::get('/{room}/edit', [HotelRoomController::class, 'edit'])->name('edit');
        Route::put('/{room}', [HotelRoomController::class, 'update'])->name('update');
        Route::delete('/{room}', [HotelRoomController::class, 'destroy'])->name('destroy');
    });

    // Room Inventory Management Routes
    Route::prefix('room-inventories')->name('hotel.room-inventories.')->group(function () {
        Route::get('/', [RoomInventoryController::class, 'index'])->name('index');
        Route::post('/json', [RoomInventoryController::class, 'indexJson'])->name('json');
        Route::get('/create', [RoomInventoryController::class, 'create'])->name('create');
        Route::post('/', [RoomInventoryController::class, 'store'])->name('store');
        Route::get('/{roomInventory}', [RoomInventoryController::class, 'show'])->name('show');
        Route::get('/{roomInventory}/edit', [RoomInventoryController::class, 'edit'])->name('edit');
        Route::put('/{roomInventory}', [RoomInventoryController::class, 'update'])->name('update');
        Route::delete('/{roomInventory}', [RoomInventoryController::class, 'destroy'])->name('destroy');
    });
});