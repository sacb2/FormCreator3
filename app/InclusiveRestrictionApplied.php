<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveRestrictionApplied extends Model
{


    protected $table = 'inclusive_restrictions_applied';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
        'id','id_restriccion','id_status','id_persona'
  ];	
  
      public $timestaps = true;
      
    
}
