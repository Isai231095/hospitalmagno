<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicios;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultaController extends Controller
{
    public function show(Cita $cita)
    {
        // Devuelve la vista con los detalles de la cita
        return view('consulta.show', compact('cita'));
    }

    public function store(Request $request, Cita $cita)
    {
        $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'blood_pressure' => 'required|string',
        ]);

        // Actualizar los detalles de la consulta en la cita
        $cita->update([
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'height' => $request->height,
            'weight' => $request->weight,
            'blood_pressure' => $request->blood_pressure,
        ]);

        // Calcular los totales
        $totalServicios = $cita->servicios->sum('price');
        $totalMedicamentos = $cita->medicamentos->sum('precio');
        $totalPagar = 600 + $totalServicios + $totalMedicamentos;

        // Guardar los detalles del ticket en la base de datos
        $ticketDetails = [
            'diagnosis' => $cita->diagnosis,
            'treatment' => $cita->treatment,
            'height' => $cita->height,
            'weight' => $cita->weight,
            'blood_pressure' => $cita->blood_pressure,
            'total_servicios' => $totalServicios,
            'total_medicamentos' => $totalMedicamentos,
            'total_pagar' => $totalPagar,
            'servicios' => $cita->servicios->map(fn($s) => ['name' => $s->name, 'price' => $s->price])->toArray(),
            'medicamentos' => $cita->medicamentos->map(fn($m) => ['name' => $m->nombre, 'price' => $m->precio])->toArray(),
        ];

        $cita->update(['ticket_details' => json_encode($ticketDetails)]);

        // Redirigir al ticket
        return redirect()->route('consulta.ticket', $cita->id);
    }

    public function ticket(Cita $cita)
    {
        // Cargar servicios y medicamentos asociados con la cita
        $cita->load('servicios', 'medicamentos');

        // Calcular los costos
        $totalServicios = $cita->servicios->sum('price');
        $totalMedicamentos = $cita->medicamentos->sum('precio');
        $totalPagar = 600 + $totalServicios + $totalMedicamentos;

        // Mostrar la vista del ticket con los detalles
        return view('consulta.ticket', [
            'cita' => $cita,
            'totalServicios' => $totalServicios,
            'totalMedicamentos' => $totalMedicamentos,
            'totalPagar' => $totalPagar,
        ]);
    }


    public function finalizar(Cita $cita)
    {
        $cita->update(['status' => 'finalizado']);

        return redirect()->route('mis-citas')->with('success', 'Consulta finalizada y ticket guardado exitosamente.');
    }





}
