<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'stock',
    ];

    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_medicamento', 'medicamento_id', 'cita_id');
    }

}
