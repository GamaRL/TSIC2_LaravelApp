<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['glucosa', 'ta_sist', 'ta_diast', 'icc', 'imc']);
            $table->string('mensaje', '25');
            $table->foreignId('consulta_id');

            $table->foreign('consulta_id')
                ->references('id')
                ->on('consultas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alertas');
    }
}
