<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->integer('paciente')->unsigned();
            $table->unsignedTinyInteger('sesion');
            $table->unsignedFloat('peso')->nullable();
            $table->unsignedSmallInteger('pulso')->nullable();
            $table->unsignedFloat('cuello')->nullable();
            $table->unsignedFloat('cintura')->nullable();
            $table->unsignedFloat('cadera')->nullable();
            $table->unsignedFloat('muslo')->nullable();
            $table->unsignedFloat('masa_grasa')->nullable();
            $table->unsignedFloat('masa_muscular')->nullable();
            $table->unsignedFloat('total_agua')->nullable();
            $table->unsignedFloat('cant_glucosa');
            $table->boolean('diab_mill');
            $table->boolean('ayuno');
            $table->unsignedFloat('ta_sist');
            $table->unsignedFloat('ta_diast');
            $table->unsignedFloat('oximetria');
            $table->timestamps();

            $table->foreign('paciente')
                ->references('id')
                ->on('pacientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}
