<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InclusiveForm extends Model
{
    protected $table = 'inclusive_form';
	
    //primary key
  //public $primaryKey = 'id';

      protected $fillable = [
      'id','nombre','descripcion','tipo','estado','qanswer','grouped','document_id','description','id_restriccion','evaluacion'
  ];	
  
    public $timestaps = true;
      
    public function questions(){
                  return $this-> hasMany('App\InclusiveFormQuestion','id_formulario');
              }
    public function document(){
                return $this-> hasOne('App\InclusiveDocument','id','document_id');
            }
    public function restrictions(){
                return $this-> hasMany('App\InclusiveFormRestriction','id_formulario');
            }


}
