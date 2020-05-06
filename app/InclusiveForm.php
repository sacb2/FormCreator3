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
      
      public function products(){
                  return $this-> hasMany('App\InclusiveFormsQuestions','id_formulario');
              }
}
