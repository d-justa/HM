<?php

use App\Actions\Auth\Logout;
use Illuminate\Support\Facades\Route;

Route::any('/logout', function () {
    app(Logout::class)->execute();
    return to_route('login');
})->name('logout')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::livewire('/login', 'pages::auth.login')->name('login');
});
