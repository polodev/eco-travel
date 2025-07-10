<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomerDashboard\Http\Controllers\AccountController;
use Modules\CustomerDashboard\Http\Controllers\AddressController;
use Modules\CustomerDashboard\Http\Controllers\Settings\ProfileController;
use Modules\CustomerDashboard\Http\Controllers\Settings\PasswordController;
use Modules\CustomerDashboard\Http\Controllers\Settings\AppearanceController;

// Settings routes (non-localized, customer-dashboard module)
Route::middleware(['web', 'auth', 'verified.email_or_mobile'])->group(function () {
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
        Route::get('/appearance', [AppearanceController::class, 'edit'])->name('appearance.edit');
    });
    
    // Address routes (non-localized, authenticated users only)
    Route::resource('addresses', AddressController::class);
    Route::post('addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');
});

// Customer Dashboard routes (localized)
Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::middleware(['auth', 'verified.email_or_mobile'])->group(function () {
        Route::prefix('dashboard')->name('customer-dashboard.')->group(function () {
            Route::get('/', [AccountController::class, 'index'])->name('index');
            Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
            Route::get('/orders', [AccountController::class, 'orders'])->name('orders');
            Route::get('/wishlist', [AccountController::class, 'wishlist'])->name('wishlist');
            Route::get('/support', [AccountController::class, 'support'])->name('support');
        });
    });
});
