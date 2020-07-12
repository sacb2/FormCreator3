<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveFormQuestion extends Model
{
    protected $table = 'inclusive_form_questions';
    	
	  //primary key
    //public $primaryKey = 'id';

    protected $fillable = [
		'id','id_formulario','id_pregunta','estado', 'orden' , 'group'
	];	
	
		public $timestaps = true;
		
		public function question(){
					return $this-> belongsTo('App\InclusiveQuestion','id_pregunta');
				}
		
		public function form(){
					return $this-> belongsTo('App\InclusiveForm','id_formulario');
				}
}
