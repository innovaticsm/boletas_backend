<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BolEventoBoletas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bol_evento_boletas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('idEvento');
            $table->unsignedTinyInteger('Zona');
            $table->unsignedTinyInteger('Numero');
            $table->foreignId('idPersona')->nullValue();
            $table->timestamps();
            $table->foreign('idEvento')->references('id')->on('bol_eventos');
            $table->foreign('idPersona')->references('id')->on('bol_personas');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bol_evento_boletas');
    }
}
