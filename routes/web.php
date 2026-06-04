<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Masters\CategoryController;
use App\Http\Controllers\Masters\FinancialYearController;
use App\Http\Controllers\Masters\GstController;
use App\Http\Controllers\Masters\StateController;
use App\Http\Controllers\Masters\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('login');
});

Route::prefix('panel')->group(function(){
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login-submit', [AuthController::class, 'loginSubmit'])->name('auth.login.submit');

    Route::middleware('auth')->group(function(){
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

        // Masters
        Route::resource('financial-years', FinancialYearController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('units', UnitController::class);
        Route::resource('gsts', GstController::class);
        Route::resource('states', StateController::class);
    });
});