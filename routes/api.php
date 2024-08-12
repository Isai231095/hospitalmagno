<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Cita;


Route::get('/citas', function (Request $request) {
    $citas = Cita::with(['user', 'doctor'])->get();

    $events = [];

    foreach ($citas as $cita) {
        $events[] = [
            'title' => $cita->user->name . ' con ' . $cita->doctor->name, // Título con el nombre del usuario y el doctor
            'start' => $cita->appointment_date, // Fecha y hora de inicio
            'end' => $cita->appointment_date,   // Fecha y hora de fin (puede ser la misma que la de inicio)
            'extendedProps' => [
                'user' => $cita->user->name,  // Nombre del usuario
                'doctor' => $cita->doctor->name,  // Nombre del doctor
            ]
        ];
    }

    return response()->json($events);
});
