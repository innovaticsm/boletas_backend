<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class personas extends Model
{
    protected $table = "bol_personas";
    protected $fillable = [
        'id','idIdentificacion' ,'Identificacion', 'Nombres', 'Apellidos', 'Telefonos', 'FechaNacimiento',
        'Estado'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public function TipoIdentificacion()
    {
        return $this->belongsTo('App\Models\auxidentificacion', 'idIdentificacion', 'id');
    }

    public function Relations() {
        return ['TipoIdentificacion:id,Codigo,Nombre'];
    }
}
