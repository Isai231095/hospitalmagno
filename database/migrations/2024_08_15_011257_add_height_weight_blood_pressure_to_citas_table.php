<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeightWeightBloodPressureToCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->decimal('height', 5, 2)->nullable(); // Altura en metros con dos decimales
            $table->decimal('weight', 5, 1)->nullable(); // Peso en kilogramos con un decimal
            $table->string('blood_pressure')->nullable(); // Presión arterial
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('blood_pressure');
        });
    }
}
