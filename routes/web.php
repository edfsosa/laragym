<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [App\Http\Controllers\LandingPageController::class, '__invoke'])->name('landing');

Route::middleware(['auth'])->group(function () {
    Volt::route('/users', 'users.index')->name('users.index');

    // Rutas de membresías
    Volt::route('/memberships', 'memberships.index')->name('memberships.index');
    Volt::route('/memberships/{membership}', 'memberships.show')->name('memberships.show');

    // Rutas de rutinas
    Volt::route('/routines', 'routines.index')->name('routines.index');
    Volt::route('/routines/{routine}', 'routines.show')->name('routines.show');

    // Rutas de dashboard y perfil
    Volt::route('/dashboard', 'dashboard')->name('dashboard');
    Volt::route('/profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
