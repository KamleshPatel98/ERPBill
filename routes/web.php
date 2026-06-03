<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('panel.masters.categories.index');
});

Route::view('auth', 'layouts.auth');