<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class eventos extends Model
{
    protected $table = "bol_eventos";
    protected $fillable = [
        'id','Codigo' ,'Nombre', 'FechaEvento', 'BoletasZona1', 'BoletasZona2', 'BoletasZona3', 'BoletasZona4',
        'NombreZona1', 'NombreZona2', 'NombreZona3', 'NombreZona4', 
        'ValorZona1', 'ValorZona2', 'ValorZona3', 'ValorZona4',
        'Estado'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public function Relations() {
        return [];
    }
}
