<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveForm extends Model
{
    protected $table = 'inclusive_form';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','nombre','descripcion','tipo','estado'
  ];	
  
      public $timestaps = true;
      
      public function questions(){
                  return $this-> hasMany('App\InclusiveFormQuestion','id_formulario');
              }
}
