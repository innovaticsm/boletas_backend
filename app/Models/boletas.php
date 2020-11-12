<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class boletas extends Model
{
    protected $table = "bol_evento_boletas";
    protected $fillable = [
        'id','idEvento' ,'Zona','Numero', 'idPersona',
        'Estado'
    ];
    public $timestamps = false;
    protected $hidden = [
        'created_at', 'updated_at'
    ];

}
