<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // El usuario que crea la cita
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade'); // El doctor asignado a la cita
            $table->dateTime('appointment_date'); // Fecha y hora de la cita
            $table->text('notes')->nullable(); // Notas adicionales
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('citas');
    }
}

