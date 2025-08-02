<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Payment\Http\Controllers\CustomPaymentController;
use Modules\Payment\Http\Controllers\FrontendPaymentController;
use Modules\Payment\Http\Controllers\SslCommerzController;

// Admin Routes (No localization - admin/dashboard only)
Route::prefix('admin-dashboard')->name('payment::admin.')->middleware(['web', 'auth'])->group(function () {
    
    // Payment Management Routes
    Route::prefix('payments')->name('payments.')->group(function () {
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
    Route::prefix('custom-payments')->name('custom-payments.')->group(function () {
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

// Frontend Routes (With localization support)
Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web'],
    'as' => 'payment::'
], function() {
    
    // Custom Payment Form Routes
    Route::get('/custom-payment', [FrontendPaymentController::class, 'showCustomPaymentForm'])->name('custom-payment.form');
    Route::post('/custom-payment', [FrontendPaymentController::class, 'submitCustomPaymentForm'])->name('custom-payment.submit');
    
    // Payment Processing Routes
    Route::get('/payments/{payment}', [FrontendPaymentController::class, 'showPayment'])->name('payments.show');
    Route::post('/payments/{payment}/process', [FrontendPaymentController::class, 'processPayment'])->name('payments.process');
    
    // Payment Confirmation Route
    Route::get('/payment-confirmation/{payment}', [FrontendPaymentController::class, 'showPaymentConfirmation'])->name('payment-confirmation');
});

// SSL Commerz Callback Routes (No localization - these are called by SSL Commerz gateway)
Route::middleware(['web'])->name('payment::')->group(function () {
    Route::post('/sslcommerz/success/{store?}', [SslCommerzController::class, 'success'])->name('sslcommerz.success');
    Route::post('/sslcommerz/fail/{store?}', [SslCommerzController::class, 'fail'])->name('sslcommerz.fail');
    Route::post('/sslcommerz/cancel/{store?}', [SslCommerzController::class, 'cancel'])->name('sslcommerz.cancel');
    Route::post('/sslcommerz/ipn/{store?}', [SslCommerzController::class, 'ipn'])->name('sslcommerz.ipn');
});