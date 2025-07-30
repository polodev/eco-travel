<?php

use Illuminate\Support\Facades\Route;

// Admin Routes (No localization - admin/dashboard only)
Route::prefix('admin-dashboard')->name('admin-dashboard.')->middleware(['web', 'auth'])->group(function () {
    
    // Payment Management Routes
    Route::prefix('payments')->name('payment.payments.')->group(function () {
        // TODO: Add payment management routes when PaymentController is created
        // Route::get('/', [PaymentController::class, 'index'])->name('index');
        // Route::post('/json', [PaymentController::class, 'indexJson'])->name('json');
    });
});