<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50);
            $table->string('apPat', 25);
            $table->string('apMat', 25);
            $table->date('fecha_nacimiento');
            $table->enum('sexo', ['M', 'F']);
            $table->string("curp", 18)->unique();
            $table->string('tel', 10);
            $table->foreignId('asentamiento_id');
            $table->enum('tipo_sangre', ['A+', 'B+', 'AB+', 'O+', 'A-', 'B-', 'AB-', 'O-']);
            $table->boolean('diab_mill');
            $table->boolean('hiper_t');
            $table->boolean('obesidad');
            $table->boolean('sobrepeso');
            $table->string('otro', 50)->nullable();
            $table->unsignedTinyInteger('talla');

            $table->foreign('asentamiento_id')
                ->references('id')
                ->on('asentamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
}
