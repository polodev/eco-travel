<?php

use Modules\StaticSite\Http\Controllers\StaticSiteController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Frontend Routes (With localization support)
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web']
], function() {
    
    Route::get('/home', [StaticSiteController::class, 'homepage'])->name('static-site::homepage');
    Route::get('/about', [StaticSiteController::class, 'about'])->name('static-site::about');
    Route::get('/flights', [StaticSiteController::class, 'flight'])->name('static-site::flight');
    Route::get('/hotels', [StaticSiteController::class, 'hotel'])->name('static-site::hotel');
    Route::get('/holiday-packages', [StaticSiteController::class, 'holidayPackage'])->name('static-site::holiday-package');
    Route::get('/hajj-packages', [StaticSiteController::class, 'hajjPackage'])->name('static-site::hajj-package');
    
});
