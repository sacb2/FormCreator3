<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveMultipleAnswer extends Model
{
    protected $table = 'inclusive_multiple_answers';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','id_pregunta','respuesta_int','respuesta_text','estado','tipo'
  ];	
  
          public function question(){
                  return $this-> hasOne('App\InclusiveFormQuestion','id','id_pregunta');
              }
  
      public $timestaps = true;
}
