<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::view('/properties', 'pages::properties.index')->name('properties.index');
    Route::livewire('/properties/create', 'pages::properties.create')->name('properties.create');

    Route::view('/room-categories', 'pages::room-categories.index')->name('room-categories.index');
    Route::livewire('/room-categories/create', 'pages::room-categories.form')->name('room-categories.form');
});
