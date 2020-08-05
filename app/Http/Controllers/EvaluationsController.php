<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InclusiveForm;
use Illuminate\Support\Facades\Auth;
use App\InclusiveQuestion;
use App\InclusiveRubric;
use App\InclusiveAnswer;
 


class EvaluationsController extends Controller
    {
        

        public function evaluations(){
            $forms = InclusiveForm::paginate(10);


            return view('inclusive.evaluation.evaluate', ['forms' => $forms]);
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
            $rubric= InclusiveRubric::where('id_formulario',$form_id)->get();

          
            return view('inclusive.evaluation.rubricsForm', ['rubric'=>$rubric,'form' => $form,'questions'=> $questions]);


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




        //funcion que muestra las respuestas de un formulario agrupadas 
public function formStatus($id){

    $form=InclusiveForm::find($id);
    $answers = InclusiveAnswer::where('id_formulario', $id)->where('state_id','2')->orWhere('state_id',NULL)->groupBy('id_requerimiento')->pluck('id_requerimiento');
  
    foreach($answers as $answer){
        $answerById[$answer]=InclusiveAnswer::where('id_formulario', $id)->where('state_id','2')->orWhere('state_id',NULL)->where('id_requerimiento', $answer)->get();
    }

if(!isset($answerById))
return redirect()->back()->withErrors('No hay registros en el formulario con respuestas validas');

$storedAnswers = InclusiveAnswer::where('id_formulario', $id)->get();

//foreach($answerById as $answer)
//dd($answers);
//dd(key($answerById),$storedAnswers);
//dd($storedAnswers);
//'answersById'=>$answerById
return view('inclusive.evaluation.evaluateForm',['form'=>$form,'answersId'=> $answers,'answerById'=>$answerById, 'answers' => $storedAnswers]);
}

public function autoEvaluateForm($id){
   
    $form=InclusiveForm::find($id);
    //leer respuesta con alternativas
    $answers = InclusiveAnswer::where('id_formulario', $id)->where('tipo',2)->where('state_id','2')->orWhere('state_id',NULL)->get();
    $rubrics = InclusiveRubric::where('id_formulario', $id)->get();
    //dd($rubrics,$answers);
    foreach($answers as $answer){
        foreach($rubrics as $rubric){
            if($answer->answer_id==$rubric->id_respuesta){
                $answer->evaluacion=$rubric->id_evaluacion;
                $answer->save();
            }
                
        }

    }
    $form=InclusiveForm::find($id);
    $answers = InclusiveAnswer::where('id_formulario', $id)->where('state_id','2')->orWhere('state_id',NULL)->groupBy('id_requerimiento')->pluck('id_requerimiento');
  
    foreach($answers as $answer){
        $answerById[$answer]=InclusiveAnswer::where('id_formulario', $id)->where('state_id','2')->orWhere('state_id',NULL)->where('id_requerimiento', $answer)->get();
    }

if(!isset($answerById))
return redirect()->back()->withErrors('No hay registros en el formulario con respuestas validas');

$storedAnswers = InclusiveAnswer::where('id_formulario', $id)->get();

return view('inclusive.evaluation.evaluateForm',['form'=>$form,'answersId'=> $answers,'answerById'=>$answerById, 'answers' => $storedAnswers]);
}



}
