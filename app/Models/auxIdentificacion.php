<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class auxIdentificacion extends Model
{
    protected $table = "aux_identificacion";
    protected $fillable = [
        'id','Codigo' ,'Nombre'
    ];
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
