<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConsultasMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulta_mensaje', function (Blueprint $table) {
            $table->foreignId('consulta_id');
            $table->foreignId('mensaje_id');

            $table->foreign('consulta_id')
                ->references('id')
                ->on('consultas');
            $table->foreign('mensaje_id')
                ->references('id')
                ->on('mensajes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulta_mensaje');
    }
}
