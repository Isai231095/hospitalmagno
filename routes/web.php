<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\MedicamentoController;

Route::get('/', function () {
    return redirect()->route('login');
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

Route::get('/mis-citas', [CitaController::class, 'misCitas'])->name('mis-citas')->middleware('auth');
Route::get('/consulta/{cita}', [ConsultaController::class, 'show'])->name('consulta')->middleware('auth');
Route::post('/consulta/{cita}', [ConsultaController::class, 'store'])->name('consulta.store')->middleware('auth');
Route::resource('medicamentos', MedicamentoController::class);
Route::resource('medicamentos', MedicamentoController::class);
Route::get('/consulta/realizar/{id}', [ServiciosController::class, 'show'])->name('consulta.show');
Route::post('/consulta/{id}', [CitaController::class, 'store'])->name('consulta.store');
Route::get('consulta/{cita}/ticket', [ConsultaController::class, 'ticket'])->name('consulta.ticket');
Route::post('consulta/{cita}/finalizar', [ConsultaController::class, 'finalizar'])->name('consulta.finalizar');
Route::post('/consulta/{cita}/ticket', [ConsultaController::class, 'showTicket'])->name('consulta.ticket');

