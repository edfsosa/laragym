<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Volt::route('/users', 'users.index')->name('users.index');
    Volt::route('/memberships', 'memberships.index')->name('memberships.index');
    Volt::route('/memberships/{membership}', 'memberships.show')->name('memberships.show');
    Volt::route('/dashboard', 'dashboard')->name('dashboard');
    Volt::route('/profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
