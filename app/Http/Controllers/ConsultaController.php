<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function show(Cita $cita)
    {
        // Devuelve la vista con los detalles de la cita
        return view('consulta.show', compact('cita'));
    }

    public function store(Request $request, Cita $cita)
    {
        // Validar y guardar la consulta
        $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
        ]);

        // Actualizar el diagnóstico y tratamiento en la base de datos (si aplica)
        // $cita->update(['diagnosis' => $request->diagnosis, 'treatment' => $request->treatment]);

        // Actualizar el estado de la cita a 'finalizado'
        $cita->update(['status' => 'finalizado']);

        // Redirigir a la vista "Mis Citas" con un mensaje de éxito
        return redirect()->route('mis-citas')->with('success', 'Consulta finalizada exitosamente.');
    }


}
