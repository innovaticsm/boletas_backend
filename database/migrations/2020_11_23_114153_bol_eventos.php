<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BolEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bol_eventos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('Codigo',15)->unique();
            $table->string('Nombre',100);
            $table->date('FechaEvento');
            $table->unsignedTinyInteger('BoletasZona1');
            $table->unsignedTinyInteger('BoletasZona2');
            $table->unsignedTinyInteger('BoletasZona3');
            $table->unsignedTinyInteger('BoletasZona4');
            $table->string('NombreZona1',20);
            $table->string('NombreZona2',20);
            $table->string('NombreZona3',20);
            $table->string('NombreZona4',20);
            $table->decimal('ValorZona1', 10, 2);
            $table->decimal('ValorZona2', 10, 2);
            $table->decimal('ValorZona3', 10, 2);
            $table->decimal('ValorZona4', 10, 2);
            $table->string('Estado',100)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bol_eventos');
    }
}
