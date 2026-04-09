<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::view('/properties', 'pages::properties.index')->name('properties.index');
    Route::livewire('/properties/create', 'pages::properties.create')->name('properties.create');

    Route::view('/room-categories', 'pages::room-categories.index')->name('room-categories.index');
    Route::livewire('/room-categories/create', 'pages::room-categories.form')->name('room-categories.form');
    Route::livewire('/room-categories/{roomCategory}/edit', 'pages::room-categories.form')->name('room-categories.form');

    Route::view('/rooms', 'pages::rooms.index')->name('rooms.index');
    Route::livewire('/rooms/create', 'pages::rooms.form')->name('rooms.form');
    Route::livewire('/rooms/{roomCategory}/edit', 'pages::rooms.form')->name('rooms.form');

    Route::view('/bookings', 'pages::bookings.index')->name('bookings.index');
    Route::livewire('/bookings/create', 'pages::bookings.create')->name('bookings.create');

    Route::view('/guests', 'pages::guests.index')->name('guests.index');

    Route::livewire('/rooms/availability-calendar', 'pages::rooms.availability-calendar')->name('rooms.availability-calendar');
});
