<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveQuestionMultipleAnswer extends Model
{
    protected $table = 'inclusive_questions_multiple_answers';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','id_pregunta','id_respuesta','texto_respuesta','valor_respuesta','estado'
  ];	
  
  
      public $timestaps = true;
}
