<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveRubric extends Model
{
    protected $table = 'inclusive_rubrics';

    protected $fillable = [
        'id', 'id_formulario','id_pregunta','id_respuesta','id_tipo','id_evaluacion','ponderacion','rango_minimo','rango_final'
    ];
}
