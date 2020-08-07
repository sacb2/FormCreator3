<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveFormList extends Model
{
        protected $table = 'inclusive_form_lists';
	
    //primary key
  //public $primaryKey = 'id';

  

      protected $fillable = [
      'id','id_formulario','id_lista','id_tipo','id_status'
  ];	
  
    public $timestaps = true;
  
    public function list(){
      return $this-> hasMany('App\InclusiveRestrictionApplied','id_restriccion','id_lista');
  }
  
}
