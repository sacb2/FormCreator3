<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveEvaluation extends Model
{
    protected $table = 'inclusive_evaluation';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','evaluacion','observacion','id_evaluador','id_formulario','id_respuesta','id_pregunta','value_respuesta','id_requerimiento','id_rubric','observacion'
  ];	
  
    public $timestaps = true;
      
    public function answers(){
                  return $this-> hasMany('App\InclusiveAnswers','id_requerimiento','id_requerimiento');
              }
   
}
