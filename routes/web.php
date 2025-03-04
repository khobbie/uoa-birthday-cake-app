<?php

use App\Http\Controllers\BirthDayCakeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [BirthDayCakeController::class, 'home'])->name('home');



Route::middleware(['auth'])->group(function () {

    Route::get('dashboard/{upload?}', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('uploads', [DashboardController::class, 'uploads'])->name('uploads');


    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
