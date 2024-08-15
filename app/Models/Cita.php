<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Servicios;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'appointment_date',
        'notes',
        'status',
        'diagnosis',
        'treatment',
        'height',
        'weight',
        'blood_pressure',
    ];

    // Relación con el modelo User para el Doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Relación con el modelo User para el Paciente
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // En el modelo Cita
    public function servicios()
    {
        return $this->belongsToMany(Servicios::class, 'cita_servicios', 'cita_id', 'servicios_id');
    }


    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'cita_medicamento', 'cita_id', 'medicamento_id');
    }


    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_servicios', 'servicios_id', 'cita_id');
    }
}
