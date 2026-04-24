<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Language switch
Route::post('/language', [LanguageController::class, 'switch'])->name('language.switch');

// Public redirect
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authenticated routes
Route::middleware(['auth', 'verified', \App\Http\Middleware\SetLocale::class])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Appointments CRUD
    Route::resource('appointments', AppointmentController::class);

    // Doctors
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
