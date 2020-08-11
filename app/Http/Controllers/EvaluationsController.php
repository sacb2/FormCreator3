<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InclusiveForm;
use Illuminate\Support\Facades\Auth;
use App\InclusiveQuestion;
use App\InclusiveRubric;
use App\InclusiveAnswer;
use App\InclusiveEvaluation;
use App\InclusiveFormRestriction;
use App\InclusiveRestriction;
use App\InclusiveRestrictionApplied;
use App\InclusiveFormList;

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
//actualizar manualmente evaluacion
public function updateEvaluation (Request $request){

    $answers = InclusiveAnswer::where('id_requerimiento', $request->id_requirement)->get();

//actualizar datos
$points=0;

    foreach($request->EvaluateDep as $key => $value ){

   //     dd($key, $value, $request);
        foreach($answers as $answer){
            if($answer->id==$key){
                $points=$points+$value;
                $answer->evaluacion=$value;
                $answer->save();
            }


        }

    }

    //Aceptar datos
    if($request->estado == 'aceptar')
    {
        
        $evaluation=InclusiveEvaluation::where('id_requerimiento',$request->id_requirement)->firstOrNew();
      //  if(!isset($evaluation)){
       //     $evaluation =New InclusiveEvaluation;
       // }
       //constructed by Sebastián Acevedo ac@akasha.ink 
       $evaluation->evaluacion=$points;
            $evaluation->id_requerimiento=$request->id_requirement;
            $evaluation->observacion="Aceptado";
            $evaluation->save();
  }
  if($request->estado == 'rechazar')
  {
      
      $evaluation=InclusiveEvaluation::where('id_requerimiento',$request->id_requirement)->firstOrNew();
    //  if(!isset($evaluation)){
     //     $evaluation =New InclusiveEvaluation;
     // }
          $evaluation->evaluacion=$points;
          $evaluation->id_requerimiento=$request->id_requirement;
          $evaluation->observacion="Rechazado";
          $evaluation->save();
}
if($request->estado == 'actualizar')
{
    
    $evaluation=InclusiveEvaluation::where('id_requerimiento',$request->id_requirement)->firstOrNew();
  //  if(!isset($evaluation)){
   //     $evaluation =New InclusiveEvaluation;
   // }
        $evaluation->evaluacion=$points;
        $evaluation->id_requerimiento=$request->id_requirement;
        $evaluation->observacion="Actualizado";
        $evaluation->save();
}
    


    return redirect()->back();
}

public function viewEvaluationList(){

    $lists= InclusiveRestriction::paginate(10);

return view('inclusive.evaluation.list',['lists'=>$lists]);
}


public function createRestrictionList(Request $request){


    
    //$lists= InclusiveRestriction::paginate(10);

return view('inclusive.evaluation.listForm');
}

public function viewRestrictionList($id){
    $lists= InclusiveRestrictionApplied::where('id_restriccion',$id)->paginate(10);
    return view('inclusive.evaluation.listRestriction',['lists'=>$lists]);

   

}

public function storeRestrictionList(Request $request){


    $list= new InclusiveRestriction;
    $list->nombre= $request->name;
    $list->id_status= $request->id_status;
    $list->id_type= $request->id_type;
    $list->save();


 /*   request()->validate([
        'csv_file' => 'required'
    ]);*/

    //get file from upload
    $path = request()->file('csv_file')->getRealPath();
    //turn into array
    $file = file($path);
    //extraer datos sin cabecera
    $data = array_slice($file, 1);
    $header=$file[0];
    $body = array_map('str_getcsv', $data);
    //dd($csv);
    //$datos = fgetcsv($header, 1000, ",");
    //dd($datos);
    //dd($body);
    foreach($body as $line){
        //dd($line);
        
        $publicaionData= New InclusiveRestrictionApplied;
        $publicaionData->id_persona=$line[0];
        $publicaionData->id_restriccion=$list->id;
        $publicaionData->id_status=$line[1];
        $publicaionData->save();
       
    }


 return redirect()->back();

}

public function activateRestriction($id){
    $restriction= InclusiveRestrictionApplied::find($id);
    $restriction->id_status=1;
    $restriction->save();

    
    return redirect()->back();
   

}
public function deactivateRestriction($id){
    $restriction= InclusiveRestrictionApplied::find($id);
    $restriction->id_status=2;
    $restriction->save();

    
    return redirect()->back();
   

}

public function viewRestrictionFormsList($id){

    $form=InclusiveForm::find($id);
    $lists= InclusiveRestriction::all();
    $restrictions= InclusiveFormList::where('id_formulario',$id)->get();
    

    return view('inclusive.evaluation.listRelationForm',['restrictions'=>$restrictions,'lists'=>$lists,'form'=>$form ]);


}

public function storeRestrictionFormsList(Request $request){

    
    if(isset($request->pickedDep)){
        foreach($request->pickedDep as $key => $value)
       // dd($key, $value);
            foreach($request->groupDep as $key2 => $value2)
            if($key==$key2){
                

                $restriction= InclusiveFormList::where('id_formulario',$request->id_form)->where('id_lista',$key)->where('id_tipo',$value2)->first();
                if(!isset($restriction)){
                    $restriction=new InclusiveFormList;
                }
                $restriction->id_formulario=$request->id_form;
                $restriction->id_lista=$key;
                $restriction->id_tipo=$value2;
                $restriction->save();


            }

                

    }else
    return redirect()->back()->withErrors('No ha seleccionado una lista');
    
    return redirect()->back();
    //dd($request);
}



}
