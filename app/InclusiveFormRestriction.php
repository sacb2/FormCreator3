<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveFormRestriction extends Model
{

    protected $table = 'inclusive_form_restrictions';
    protected $fillable = [
		'id','id_formulario','id_lista','id_tipo', 'id_status' 
	];	
	
		public $timestaps = true;
		

}
