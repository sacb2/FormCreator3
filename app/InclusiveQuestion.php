<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveQuestion extends Model
{
    protected $table = 'inclusive_questions';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','nombre','pregunta','tipo','estado', 'size','orden'
  ];	
  
      public $timestaps = true;
      
      public function answers(){
                  return $this-> hasMany('App\InclusiveQuestionMultipleAnswer','id_pregunta');
              }
}
