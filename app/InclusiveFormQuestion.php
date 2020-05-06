<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveFormQuestion extends Model
{
    protected $table = 'inclusive_questions';
    	
	  //primary key
    //public $primaryKey = 'id';

    protected $fillable = [
		'id','id_formulario','id_pregunta','estado'
	];	
	
		public $timestaps = true;
		
		public function question(){
					return $this-> belongsTo('App\InclusiveQuestion','id_pregunta');
				}
}
