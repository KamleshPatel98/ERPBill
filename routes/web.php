<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('login');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login-submit', [AuthController::class, 'loginSubmit'])->name('auth.login.submit');

Route::middleware('auth')->group(function(){
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('auth.dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});