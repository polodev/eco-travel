<?php

use Illuminate\Support\Facades\Route;
use Modules\VisaProcessing\Http\Controllers\VisaProcessingAdminController;
use Modules\VisaProcessing\Http\Controllers\VisaProcessingFrontendController;
use Modules\VisaProcessing\Http\Controllers\VisaApplicationAdminController;

// Admin Routes (No localization - admin/dashboard only)
Route::prefix('admin-dashboard')->name('visa-processing::admin.')->middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->group(function () {
    
    // Visa Processing Management Routes
    Route::prefix('visa-processings')->name('visa-processings.')->group(function () {
        Route::get('/', [VisaProcessingAdminController::class, 'index'])->name('index');
        Route::match(['GET', 'POST'], '/json', [VisaProcessingAdminController::class, 'indexJson'])->name('json');
        Route::get('/create', [VisaProcessingAdminController::class, 'create'])->name('create');
        Route::post('/', [VisaProcessingAdminController::class, 'store'])->name('store');
        Route::get('/{visaProcessing}', [VisaProcessingAdminController::class, 'show'])->name('show');
        Route::get('/{visaProcessing}/edit', [VisaProcessingAdminController::class, 'edit'])->name('edit');
        Route::put('/{visaProcessing}', [VisaProcessingAdminController::class, 'update'])->name('update');
        Route::delete('/{visaProcessing}', [VisaProcessingAdminController::class, 'destroy'])->name('destroy');
    });

    // Visa Applications Management Routes
    Route::prefix('visa-applications')->name('visa-applications.')->group(function () {
        Route::get('/', [VisaApplicationAdminController::class, 'index'])->name('index');
        Route::match(['GET', 'POST'], '/json', [VisaApplicationAdminController::class, 'indexJson'])->name('json');
        Route::get('/filter-options', [VisaApplicationAdminController::class, 'getFilterOptions'])->name('filter-options');
        Route::post('/bulk-update', [VisaApplicationAdminController::class, 'bulkUpdate'])->name('bulk-update');
        Route::get('/{visaApplication}', [VisaApplicationAdminController::class, 'show'])->name('show');
        Route::get('/{visaApplication}/edit', [VisaApplicationAdminController::class, 'edit'])->name('edit');
        Route::put('/{visaApplication}', [VisaApplicationAdminController::class, 'update'])->name('update');
        Route::get('/{visaApplication}/download/{type}', [VisaApplicationAdminController::class, 'downloadDocument'])->name('download-document');
    });

});

// Frontend Routes (With localization support)
Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web'],
    'as' => 'visa-processing::'
], function() {
    
    // Visa Processing Frontend Routes
    Route::prefix('visa-processing')->name('visa-processings.')->group(function () {
        Route::get('/', [VisaProcessingFrontendController::class, 'index'])->name('index');
        Route::get('/featured', [VisaProcessingFrontendController::class, 'featured'])->name('featured');
        Route::get('/country/{countrySlug}', [VisaProcessingFrontendController::class, 'byCountry'])->name('by-country');
        Route::get('/type/{visaType}', [VisaProcessingFrontendController::class, 'byVisaType'])->name('by-visa-type');
        Route::get('/{visaProcessing}', [VisaProcessingFrontendController::class, 'show'])->name('show');
        Route::get('/{visaProcessing}/purchase', [VisaProcessingFrontendController::class, 'showPurchaseForm'])->name('purchase');
        Route::post('/{visaProcessing}/purchase', [VisaProcessingFrontendController::class, 'submitPurchase'])->name('purchase.submit');
    });
    
});