<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Servicios;
use App\Models\Cita;
use App\Models\Medicamento;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicio = Servicios::all();
        return view('servicios.index', compact('servicio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() //CREAR
    {
        return view('servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //GUARDAR
    {
        $request->validate([

            'name'=> 'required|string|min:5|max:100',
            'price' => 'required|numeric|min:0|max:99999999.99'

        ]);

        Servicios::create($request->all());

        return redirect()->route('servicios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id) //MOSTRAR
    {
        $servicios = Servicios::all();
        $medicamentos = Medicamento::all();
        $cita = Cita::where('id', $id)->first();

        return view('consulta.show', compact('servicios', 'cita', 'medicamentos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) //EDITAR
    {
        $servicio = Servicios::findOrFail($id);
        return view('servicios.edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'name'=> 'required|string|min:5|max:100',
            'price' => 'required|numeric|min:1.1|max:100.000',

        ]);

        $servicio = Servicios::findOrFail($id);
        $servicio->update($request->all());

        return redirect()->route('servicios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //ELIMINAR
    {
        $servicio = Servicios::findOrFail($id);
        $servicio->delete();
        return redirect()->route('servicios.index');
    }
}
