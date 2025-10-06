<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReceiptController;
use App\Livewire\Equipments;
use App\Livewire\ExercisesCatalog;
use App\Livewire\Memberships;
use App\Livewire\Trainers;
use App\Livewire\Routines;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/routines', Routines::class)->name('routines.index');
    Route::get('/exercises-catalog', ExercisesCatalog::class)->name('exercises.catalog');
    Route::get('/memberships', Memberships::class)->name('memberships.index');
    Route::get('/trainers', Trainers::class)->name('trainers.index');
    Route::get('/equipments', Equipments::class)->name('equipments.index');

    Route::get('/receipts/{reference}/download', [ReceiptController::class, 'download'])->name('receipts.download');
});

require __DIR__ . '/auth.php';
