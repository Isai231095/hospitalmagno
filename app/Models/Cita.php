<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = ['diagnosis', 'treatment', 'status', 'appointment_date', 'user_id', 'doctor_id'];

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
}
