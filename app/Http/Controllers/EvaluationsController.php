<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InclusiveForm;
use Illuminate\Support\Facades\Auth;
use App\InclusiveQuestion;
use App\InclusiveRubric;


class EvaluationsController extends Controller
{
    

    public function evaluations(){
        dd("evaluations");
    }

    public function rubrics(){

        	//validar usuario
				$type= Auth::user()->type_id;

				
				
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}
		$forms = InclusiveForm::paginate(10);


		return view('inclusive.evaluation.rubrics', ['forms' => $forms]);
      
    }

    //define las rubricas relacionado las preguntas de los formularios con patrones de evaluación
    public function rubricsForm($form_id){

        $form = InclusiveForm::find($form_id);
        $questions = InclusiveQuestion::where('estado', '1')->get();

        foreach($form->questions as $question){
        //    dd($question->rubric);
        }
        return view('inclusive.evaluation.rubricsForm', ['form' => $form,'questions'=> $questions]);


    }

    public function rubricsFormStore(Request $request){
        
        foreach($request->rubricDep as $key => $value ){


        //dd($key, $value, $request);
         $oldRubric= InclusiveRubric::where('id_formulario',$request->id_form)->where('id_respuesta',$key)->first();
         if(!isset($oldRubric)){
        $rubric= New InclusiveRubric;
        $rubric->id_formulario=$request->id_form;
        $rubric->id_pregunta=1;
        $rubric->id_respuesta=$key;
        $rubric->id_tipo=2;
        $rubric->id_evaluacion=$value;
        $rubric->ponderacion=100;
        $rubric->save();
    }else{
    
        $oldRubric->id_formulario=$request->id_form;
        $oldRubric->id_pregunta=1;
        $oldRubric->id_respuesta=$key;
        $oldRubric->id_tipo=2;
        $oldRubric->id_evaluacion=$value;
        $oldRubric->ponderacion=100;
        $oldRubric->save();

    }
    }
    return redirect()->back();
    }

}
