<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Masters\CategoryController;
use App\Http\Controllers\Masters\CustomerController;
use App\Http\Controllers\Masters\FinancialYearController;
use App\Http\Controllers\Masters\GstController;
use App\Http\Controllers\Masters\StateController;
use App\Http\Controllers\Masters\SupplierController;
use App\Http\Controllers\Masters\UnitController;
use App\Http\Controllers\Masters\PaymentModeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\SettingController;
use App\Models\Product;
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
        Route::resource('payment-modes', PaymentModeController::class);
        Route::resource('states', StateController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('customers', CustomerController::class);

        // Product
        Route::resource('products', ProductController::class);

        // Purchase
        Route::resource('purchases', PurchaseController::class);
        Route::get('purchases.invoice/{id}', [PurchaseController::class, 'invoice'])->name('purchases.invoice');
        Route::resource('purchase-returns', PurchaseReturnController::class);
        Route::get('purchase-returns.invoice/{id}', [PurchaseReturnController::class, 'invoice'])->name('purchase-returns.invoice');

        // Sale
        Route::resource('sales', SaleController::class);
        Route::get('sales.invoice/{id}', [SaleController::class, 'invoice'])->name('sales.invoice');
        Route::resource('sale-returns', SaleReturnController::class);
        Route::get('sale-returns.invoice/{id}', [SaleReturnController::class, 'invoice'])->name('sale-returns.invoice');

        // Setting
        Route::get('web-data', [SettingController::class, 'webData'])->name('settings.web.data');
        Route::post('web-data-update', [SettingController::class, 'webDataUpdate'])->name('settings.web.data.update');
    });
});