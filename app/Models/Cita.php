<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'appointment_date',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
