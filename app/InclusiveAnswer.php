<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveAnswer extends Model
{
   
    
        protected $table = 'inclusive_answers';
  
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','id_pregunta','id_formulario','id_requerimiento','id_persona','texto_respuesta','valor_respuesta','tipo','rut_persona'
  ];	
  
      public function question(){
                  return $this-> hasOne('App\InclusiveFormQuestion','id','id_pregunta');
              }
              //solucoinar problema en asignacion de respuestas a preguntas
      public function answer_number(){
                              return $this-> hasOne('App\InclusiveQuestionMultipleAnswer','id_pregunta','id_pregunta','valor_respuesta','valor_respuesta');

      }
  
      public $timestaps = true;


}
