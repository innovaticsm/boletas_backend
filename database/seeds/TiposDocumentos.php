<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDocumentos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('aux_identificacion')->delete();
        DB::table('aux_identificacion')->insert([
                'id' => 1,
                'Codigo' => 'CC',
                'Nombre' => 'Cédula de Ciudadanía',
                'created_at' => date("Y-m-d H:i:s")
        ]);
       
        DB::table('aux_identificacion')->insert([
            'id' => 2,
            'Codigo' => 'CE',
            'Nombre' => 'Cédula Extrangería',
            'created_at' => date("Y-m-d H:i:s")
           ]);
        DB::table('aux_identificacion')->insert([
                'id' => 3,
                'Codigo' => 'TI',
                'Nombre' => 'Tarjeta de Identidad',
                'created_at' => date("Y-m-d H:i:s")
        ]);
    }
}
