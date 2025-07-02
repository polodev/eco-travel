<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminDashboard\Http\Controllers\DashboardController;
use Modules\AdminDashboard\Http\Controllers\UserController;

Route::middleware(['auth', 'role.access:developer,admin,employee,accounts'])->group(function () {
    Route::prefix('admin')->name('admin-dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        
        Route::resource('users', UserController::class);
        Route::get('users-json', [UserController::class, 'indexJson'])->name('users.json');
    });
});
