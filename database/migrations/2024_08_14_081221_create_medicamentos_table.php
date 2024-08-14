<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicamentosTable extends Migration
{
    public function up()
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->decimal('precio', 8, 2);
            $table->integer('stock');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicamentos');
    }
}
