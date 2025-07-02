<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminDashboard\Http\Controllers\UserController;

Route::middleware(['web', 'auth', 'role.access:developer,admin,employee,accounts'])->group(function () {
    Route::prefix('admin')->name('admin-dashboard.')->group(function () {
        Route::get('/', function () {
            return view('admin-dashboard::index');
        })->name('index');
        
        Route::resource('users', UserController::class);
        Route::post('users-json', [UserController::class, 'indexJson'])->name('users.json');
    });
});
