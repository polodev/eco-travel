<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Payment\Http\Controllers\CustomPaymentController;

// Admin Routes (No localization - admin/dashboard only)
Route::prefix('admin-dashboard')->name('admin-dashboard.')->middleware(['web', 'auth'])->group(function () {
    
    // Payment Management Routes
    Route::prefix('payments')->name('payment.payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::post('/json', [PaymentController::class, 'indexJson'])->name('json');
        Route::get('/create', [PaymentController::class, 'create'])->name('create');
        Route::post('/', [PaymentController::class, 'store'])->name('store');
        Route::get('/{payment}', [PaymentController::class, 'show'])->name('show');
        Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->name('edit');
        Route::put('/{payment}', [PaymentController::class, 'update'])->name('update');
        Route::delete('/{payment}', [PaymentController::class, 'destroy'])->name('destroy');
    });

    // Custom Payment Management Routes
    Route::prefix('custom-payments')->name('payment.custom-payments.')->group(function () {
        Route::get('/', [CustomPaymentController::class, 'index'])->name('index');
        Route::post('/json', [CustomPaymentController::class, 'indexJson'])->name('json');
        Route::get('/create', [CustomPaymentController::class, 'create'])->name('create');
        Route::post('/', [CustomPaymentController::class, 'store'])->name('store');
        Route::get('/{customPayment}', [CustomPaymentController::class, 'show'])->name('show');
        Route::get('/{customPayment}/edit', [CustomPaymentController::class, 'edit'])->name('edit');
        Route::put('/{customPayment}', [CustomPaymentController::class, 'update'])->name('update');
        Route::delete('/{customPayment}', [CustomPaymentController::class, 'destroy'])->name('destroy');
    });
});