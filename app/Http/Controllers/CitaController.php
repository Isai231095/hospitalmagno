<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\User;
use App\Models\Servicios;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $cita = Cita::create([
            'user_id' => auth()->id(),
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

    // Mostrar las citas del doctor autenticado
    public function misCitas()
    {
        $user = Auth::user();

        if ($user->role->name === 'Doctor') {
            // Filtrar las citas por el doctor autenticado
            $citas = Cita::where('doctor_id', $user->id)->get();
        } else {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }

        return view('citas.mis-citas', compact('citas'));
    }

    // Mostrar el formulario de consulta médica
    public function show($id)
    {
        $cita = Cita::findOrFail($id);
        $servicios = Servicios::all();
        $medicamentos = Medicamento::all();

        return view('consulta.show', compact('cita', 'servicios', 'medicamentos'));
    }

    // Guardar los datos de la consulta médica
    public function storeConsulta(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        // Guardar los datos de la consulta
        $cita->update([
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'height' => $request->height,
            'weight' => $request->weight,
            'blood_pressure' => $request->blood_pressure,
            'status' => 'finalizado',
        ]);

        // Guardar servicios y medicamentos relacionados
        $cita->servicios()->sync($request->servicios);
        $cita->medicamentos()->sync($request->medicamentos);

        // Calcular los costos
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

    // Mostrar el ticket de la consulta
    public function ticket($id)
    {
        $cita = Cita::findOrFail($id);
        $ticketDetails = json_decode($cita->ticket_details, true);

        $totalServicios = $ticketDetails['total_servicios'];
        $totalMedicamentos = $ticketDetails['total_medicamentos'];
        $totalPagar = $ticketDetails['total_pagar'];

        return view('consulta.ticket', compact('cita', 'totalServicios', 'totalMedicamentos', 'totalPagar'));
    }

    public function showTicket(Cita $cita)
    {
    $totalServicios = $cita->servicios->sum('price');
    $totalMedicamentos = $cita->medicamentos->sum('precio');
    $totalPagar = 600 + $totalServicios + $totalMedicamentos;

    return view('consulta.ticket', [
        'cita' => $cita,
        'totalServicios' => $totalServicios,
        'totalMedicamentos' => $totalMedicamentos,
        'totalPagar' => $totalPagar,
    ]);
}
}
