<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\User;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    // Mostrar todas las citas
    public function index()
    {
        // Obtenemos todas las citas con la información del usuario y doctor relacionado
        $citas = Cita::with(['user', 'doctor'])->get();
        return view('citas.index', compact('citas'));
    }

    // Mostrar el formulario para crear una nueva cita
    public function create()
    {
        // Obtenemos todos los doctores para que puedan ser seleccionados en el formulario
        $doctors = User::whereHas('role', function ($query) {
            $query->where('name', 'Doctor');
        })->get();

        return view('citas.create', compact('doctors'));
    }

    // Guardar una nueva cita en la base de datos
    public function store(Request $request)
    {
        // Validamos los datos ingresados en el formulario
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Creamos la cita
        Cita::create([
            'user_id' => auth()->id(), // El usuario autenticado será el creador de la cita
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita creada exitosamente.');
    }

    // Mostrar el formulario para editar una cita existente
    public function edit(Cita $cita)
    {
        // Obtenemos todos los doctores para que puedan ser seleccionados en el formulario
        $doctors = User::whereHas('role', function ($query) {
            $query->where('name', 'Doctor');
        })->get();

        return view('citas.edit', compact('cita', 'doctors'));
    }

    // Actualizar una cita existente en la base de datos
    public function update(Request $request, Cita $cita)
    {
        // Validamos los datos ingresados en el formulario
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Actualizamos la cita con los nuevos datos
        $cita->update([
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita actualizada exitosamente.');
    }

    // Eliminar una cita de la base de datos
    public function destroy(Cita $cita)
    {
        // Eliminamos la cita
        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'Cita eliminada exitosamente.');
    }
}
