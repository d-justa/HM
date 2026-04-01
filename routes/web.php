<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});
