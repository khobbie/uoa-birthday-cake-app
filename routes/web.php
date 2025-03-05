<?php

use App\Http\Controllers\BirthDayCakeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [BirthDayCakeController::class, 'home'])->name('home');



Route::middleware(['auth'])->group(function () {

    Route::get('notfound/', [DashboardController::class, 'notfound'])->name('notfound');
    Route::get('dashboard/{upload?}', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('uploads', [DashboardController::class, 'uploads'])->name('uploads');
    Route::post('update-upload-status', [DashboardController::class, 'update_upload_status'])->name('update-upload-status');


    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


Route::post('upload', [BirthDayCakeController::class, 'upload'])->name('upload');
Route::get('/show-cake/{upload_id}', [BirthDayCakeController::class, 'getUploadById'])->name('show-cake');

require __DIR__.'/auth.php';
