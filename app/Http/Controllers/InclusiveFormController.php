<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InclusiveQuestion;
use App\InclusiveMultipleAnswer;
use Illuminate\Support\Facades\Route;
use Session;


class InclusiveFormController extends Controller
{

	//Formulario creacion de preguntas
	public function createQuestion()
	{
		return view('inclusive.forms.create');
	}

	//Guardar pregunta 
	//input $request datos de configuración de pregunta
	public function storeQuestion(Request $request)
	{
		//validar formulario

		$validate_response = $request->validate(
			[
				'question' => 'required',
				'state' => 'required',
			],
			[
				'question.required' => 'Debes elegir una pregunta',
				'state.required' => 'Debes elegir un estado'
			]
		);

		//Crear objeto
		$question = new InclusiveQuestion;
		$question->nombre = $request->name;
		$question->pregunta = $request->question;
		$question->estado = $request->state;
		$question->tipo = $request->type;
		try {
			$question->save();
			//Session::flash('alertSent', 'Derived');
			//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
		} catch (\Exception $e) {
			// do task when error
			//Session::flash('alert', 'error');
			echo $e->getMessage();   // insert query

		}

		return view('inclusive.forms.create');
	}
	//listar preguntas en el sistema 
	public function listQuestions(){
		$questions = InclusiveQuestion::paginate(10);
		return view('inclusive.forms.questionsList', ['questions'=>$questions]);
	}
	//ver y editar pregunta 
	//$id identificador de la pregunta
	public function viewQuestions($id){
			
		$question = InclusiveQuestion::find($id);
		return view('inclusive.forms.questionsView', ['question'=>$question]);
	}
	//actualizar pregunta
	//$request datos nuevos a actualizar
	public function updateQuestions(Request $request){
		
		//validación de los datos
				$validate_response=$request->validate([
				'question'=>'required',
				'state'=>'required',
			
				],
				[
				'question.required' => 'Debes elegir un nombre',
				'state.required' => 'Debes elegir un estado'
				]		
			);
					
				$question = InclusiveQuestion::find($request->id);

				$question->nombre=$request->name;
				$question->estado=$request->state;
				$question->pregunta=$request->question;
				$question->tipo=$request->type;
		
						
				try{
			   $question->save();
				Session::flash('alertSent', 'Derived');
				Session::flash('message', "Pregunta actualizada " .$question->nombre."  exitosamente" );
				}
				catch(\Exception $e){
			   // do task when error
				Session::flash('alert', 'error');
				echo $e->getMessage();   // insert query
				
				}
				
				return redirect()->route('ListQuestions');
		
				
		
			}
			//vista de creación de respuestas posibles a las preguntas de seleccion multiple
			public function createAnswer(){
		
				return view('inclusive.forms.createAnswer');
				
			}

			//Guardar respuesta a seleccion multiple
			//$request datos relacionado con la respuesta posible
			public function storeAnswer(Request $request){
		
		
		
				$answer= New InclusiveMultipleAnswer;
				$answer->id_respuesta=$request->answervalue;
				$answer->texto_respuesta=$request->answertext;
				$answer->estado=$request->state;
				
					try{
			   $answer->save();
				Session::flash('alertSent', 'Derived');
				Session::flash('message', "Respuesta creada  exitosamente" );
				}
				catch(\Exception $e){
			   // do task when error
				Session::flash('alert', 'error');
				echo $e->getMessage();   // insert query
				
				}
				
				return redirect()->route('ListAnswers');
				
			}

			//lista de respuestas posibles a preguntas de selección multiple
			public function listAnswers(){
				$answers= InclusiveMultipleAnswer::all();
				

		return view('inclusive.forms.answersList', ['answers'=>$answers]);
		
	}

}
