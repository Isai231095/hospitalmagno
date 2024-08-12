<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() //CREAR
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //GUARDAR
    {
        $request->validate([

            'name'=> 'required|string|min:5|max:100',
            'age'=> 'required|integer|min:1',
            'special'=> 'required|string|min:5|max:100'
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) //MOSTRAR
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) //EDITAR
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'name'=> 'required|string|min:5|max:100',
            'age'=> 'required|integer|min:1',
            'special'=> 'required|string|min:5|max:100'
        ]);

        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());

        return redirect()->route('doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) //ELIMINAR
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctors.index');
    }
}
