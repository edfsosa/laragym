<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [App\Http\Controllers\LandingPageController::class, '__invoke'])->name('landing');

Route::middleware(['auth'])->group(function () {
    Volt::route('/users', 'users.index')->name('users.index');

    // Rutas de membresías
    Volt::route('/memberships', 'memberships.index')->name('memberships.index');
    Volt::route('/memberships/{membership}/show', 'memberships.show')->name('memberships.show');
    Volt::route('/memberships/{membership}/payments', 'memberships.payments')->name('memberships.payments');

    // Rutas de rutinas
    Volt::route('/routines', 'routines.index')->name('routines.index');
    Volt::route('/routines/{routine}/show', 'routines.show')->name('routines.show');
    Volt::route('/routines/completed', 'routines.completed.index')->name('routines.completed');
    Volt::route('/routines/completed/{routine}/show', 'routines.completed.show')->name('routines.completed.show');

    // Rutas de dashboard y perfil
    Volt::route('/dashboard', 'dashboard')->name('dashboard');
    Volt::route('/profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
