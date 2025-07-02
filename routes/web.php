<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Localized routes (Frontend - English and Bengali)
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
    
    // Auth routes are now handled by Auth module
    // Customer Dashboard routes are now handled by CustomerDashboard module
});
