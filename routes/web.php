<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.panel');
});

Route::view('auth', 'layouts.auth');