<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BolPersonas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bol_personas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->integer('idIdentificacion')->unsigned();
            $table->string('Identificacion',15)->unique()->default('');
            $table->string('Nombres',50)->default('');
            $table->string('Apellidos',50)->default('');
            $table->string('Telefonos',50)->default('');
            $table->string('email',100)->unique()->default('');
            $table->enum('Estado', ['Activo ', 'Inactivo'])->default('Activo');
            $table->timestamps();
            $table->foreign('idIdentificacion')->references('id')->on('aux_identificacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bol_personas');
    }
}
