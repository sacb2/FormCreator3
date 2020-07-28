<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveAnswer extends Model
{
   
    
        protected $table = 'inclusive_answers';
  
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','id_pregunta','id_formulario','id_requerimiento','id_persona','texto_respuesta','valor_respuesta','tipo','rut_persona','answer_id','state_id'
  ];	
  //pregutnas
      public function question(){
                  return $this-> hasOne('App\InclusiveFormQuestion','id','id_pregunta');
              }
              //solucionar problema en asignacion de respuestas a preguntas
      public function answer_number(){
                              return $this-> hasOne('App\InclusiveQuestionMultipleAnswer','id','answer_id');

      }
      public function document(){
        return $this-> hasOne('App\InclusiveDocument','id','valor_respuesta');
    }
    public function persona(){
      return $this-> hasOne('App\User','id','id_persona');
  }
  
      public $timestaps = true;


}
