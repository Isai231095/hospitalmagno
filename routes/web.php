<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ServiciosController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('doctors', DoctorController::class);
    Route::resource('users', UserController::class);
    Route::resource('citas', CitaController::class);
    Route::resource('servicios', ServiciosController::class);


});

Route::get('/agenda', function () {
    return view('agenda');
})->name('agenda');
