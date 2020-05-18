<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveDocument extends Model
{
    protected $table = 'inclusive_documents';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','nombre','route','tipo','estado'
  ];	
  
      public $timestaps = true;
}
