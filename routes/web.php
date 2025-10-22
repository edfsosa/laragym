<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Volt::route('/users', 'users.index')->name('users.index');
    Volt::route('/dashboard', 'dashboard')->name('dashboard');
});

require __DIR__ . '/auth.php';