<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\RegistrationController;
use Modules\Auth\Http\Controllers\ConfirmationController;
use Modules\Auth\Http\Controllers\VerificationController;

Route::middleware(['web', 'guest'])->group(function () {
    Route::get('register', [RegistrationController::class, 'create'])->name('register');
    Route::post('register', [RegistrationController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('verify-email', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [VerificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    
    Route::get('verify-mobile', [VerificationController::class, 'showMobile'])->name('verification.mobile.notice');
    
    Route::get('verification-choice', [VerificationController::class, 'showChoice'])->name('verification.choice');
    Route::post('add-contact', [VerificationController::class, 'addContact'])->name('verification.add-contact');

    Route::get('confirm-password', [ConfirmationController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmationController::class, 'store']);
});