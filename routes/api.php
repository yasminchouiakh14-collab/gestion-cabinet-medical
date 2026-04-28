<?php

use App\Http\Controllers\Api\AppointmentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('appointments')->group(function () {
    Route::get('/search',        [AppointmentApiController::class, 'search'])->name('api.appointments.search');
    Route::get('/',              [AppointmentApiController::class, 'index'])->name('api.appointments.index');
    Route::post('/',             [AppointmentApiController::class, 'store'])->name('api.appointments.store');
    Route::get('/{appointment}', [AppointmentApiController::class, 'show'])->name('api.appointments.show');
});

Route::get('/doctors', [AppointmentApiController::class, 'doctors'])->name('api.doctors');