<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveRestriction extends Model
{
    protected $table = 'inclusive_restrictions';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','id_type','is_status', 'nombre'
  ];	
  
      public $timestaps = true;
      
     
              
}
