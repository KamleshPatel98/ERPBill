<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\Masters\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\SettingController;
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
        Route::resource('customers', CustomerController::class);

        // Product
        Route::resource('products', ProductController::class);

        // Sale
        Route::resource('sales', SaleController::class);
        Route::get('sales.invoice/{id}', [SaleController::class, 'invoice'])->name('sales.invoice');

        // Ledger
        Route::get('customer-ledger', [LedgerController::class, 'customer'])->name('ledgers.customer');
        Route::get('customer-ledger-print', [LedgerController::class, 'customerPrint'])->name('ledgers.customerPrint');

        // Report
        Route::get('sale-report', [ReportController::class, 'sale'])->name('reports.sale');
        Route::get('sale-report-print', [ReportController::class, 'salePrint'])->name('reports.salePrint');

        // Setting
        Route::get('web-data', [SettingController::class, 'webData'])->name('settings.web.data');
        Route::post('web-data-update', [SettingController::class, 'webDataUpdate'])->name('settings.web.data.update');
    });
});