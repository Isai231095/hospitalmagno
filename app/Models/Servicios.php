<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price',];

    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_servicios', 'servicios_id', 'cita_id');
    }

}

