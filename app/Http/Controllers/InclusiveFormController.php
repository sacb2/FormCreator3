<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InclusiveQuestion;
use App\InclusiveMultipleAnswer;
use App\InclusiveQuestionMultipleAnswer;
use App\InclusiveForm;
use App\InclusiveFormQuestion;
use App\InclusiveAnswer;
use App\InclusiveDocument;
use Redirect;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Route;
use Session;
use Auth;
//mail
use Illuminate\Support\Facades\Mail;
use App\Mail\FormSendMail;
use PharIo\Manifest\Requirement;
use App\User;
use App\InclusiveRestrictionApplied;
use App\InclusiveFormList;

class InclusiveFormController extends Controller
{



	//Valida RUT
	function valida_rut($rut)
	{
		$rut = preg_replace('/[^k0-9]/i', '', $rut);
		$dv  = substr($rut, -1);
		$numero = substr($rut, 0, strlen($rut) - 1);
		$i = 2;
		$suma = 0;
		foreach (array_reverse(str_split($numero)) as $v) {
			if ($i == 8)
				$i = 2;
			$suma += $v * $i;
			++$i;
		}
		$dvr = 11 - ($suma % 11);

		if ($dvr == 11)
			$dvr = 0;
		if ($dvr == 10)
			$dvr = 'K';
		if ($dvr == strtoupper($dv))
			return true;
		else
			return false;
	}

	//Formulario creacion de preguntas
	public function createQuestion()
	{
		//validar usuario
		$type= Auth::user()->type_id;
	if( $type>1||is_null($type)){
			Auth::logout();
			return view('welcome');
		}
		return view('inclusive.forms.create');
	}


	//Guardar pregunta 
	//input $request datos de configuración de pregunta
	public function storeQuestion(Request $request)
	{

		
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}
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
		if ($request->type == '6') {
			$validate_response = $request->validate(
				[
					'attachment' => 'required',
					
				],
				[
					
					'attachment.required' => 'Debes seleccionar un arhivo a adjuntar'
				]
			);

		}

		//Crear objeto
		$question = new InclusiveQuestion;
		$question->nombre = $request->name;
		$question->pregunta = $request->question;
		$question->estado = $request->state;
		$question->tipo = $request->type;
		$question->orden = $request->orden;
		$question->size= $request->size;
		$question->group= $request->group;
		$question->edad_max= $request->edad_max;
		$question->edad_min= $request->edad_min;
		$question->required= $request->required;

		if ($request->type == '6') {
			$imageName = 'Adjunto_'. time() . 'ID' . $request->attachment->getClientOriginalName(). '.' . $request->attachment->getClientOriginalExtension();
			$path = $request->attachment->move(public_path('images/' .'questions'), $imageName);
			$image = new InclusiveDocument;
			$image->nombre = $imageName;
			$image->tipo = $request->type;
			$image->route = $path->getRealPath();
			$image->save();
			$question->document_name=$imageName;
			$question->document_id=$image->id;
			
		}
		

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
	public function listQuestions()
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}
		$questions = InclusiveQuestion::paginate(10);
		return view('inclusive.forms.questionsList', ['questions' => $questions]);
	}
	//ver y editar pregunta 
	//$id identificador de la pregunta
	public function viewQuestions($id)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		$question = InclusiveQuestion::find($id);
		return view('inclusive.forms.questionsView', ['question' => $question]);
	}
	//actualizar pregunta
	//$request datos nuevos a actualizar
	public function updateQuestions(Request $request)
	{

				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}
		//validación de los datos


		$validate_response = $request->validate(
			[
				'question' => 'required',
				'state' => 'required',

			],
			[
				'question.required' => 'Debes elegir un nombre',
				'state.required' => 'Debes elegir un estado'
			]
		);

		$question = InclusiveQuestion::find($request->id);

		$question->nombre = $request->name;
		$question->estado = $request->state;
		$question->pregunta = $request->question;
		$question->tipo = $request->type;
		$question->size= $request->size;
		$question->orden= $request->orden;
		$question->group= $request->group;
		$question->edad_max= $request->edad_max;
		$question->edad_min= $request->edad_min;
		$question->required= $request->required;
		if ($request->type == '6') {
			$imageName = 'Adjunto_'. time() . 'ID' . $request->attachment->getClientOriginalName(). '.' . $request->attachment->getClientOriginalExtension();
			$path = $request->attachment->move(public_path('images/' .'questions'), $imageName);
			$image = new InclusiveDocument;
			$image->nombre = $imageName;
			$image->tipo = $request->type;
			$image->route = $path->getRealPath();
			$image->save();
			$question->document_name=$imageName;
		$question->document_id=$image->id;
			
		}
		


		try {
			$question->save();
			Session::flash('alertSent', 'Derived');
			Session::flash('message', "Pregunta actualizada " . $question->nombre . "  exitosamente");
		} catch (\Exception $e) {
			// do task when error
			Session::flash('alert', 'error');
			echo $e->getMessage();   // insert query

		}

		return redirect()->route('ListQuestions');
	}
	//vista de creación de respuestas posibles a las preguntas de seleccion multiple
	public function createAnswer()
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		return view('inclusive.forms.createAnswer');
	}

	//Guardar respuesta a seleccion multiple
	//$request datos relacionado con la respuesta posible
	public function storeAnswer(Request $request)
	{

				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}


		$answer = new InclusiveMultipleAnswer;
		$answer->id_respuesta = $request->answervalue;
		$answer->texto_respuesta = $request->answertext;
		$answer->estado = $request->state;

		try {
			$answer->save();
			Session::flash('alertSent', 'Derived');
			Session::flash('message', "Respuesta creada  exitosamente");
		} catch (\Exception $e) {
			// do task when error
			Session::flash('alert', 'error');
			echo $e->getMessage();   // insert query

		}

		return redirect()->route('ListAnswers');
	}

	//lista de respuestas posibles a preguntas de selección multiple
	public function listAnswers()
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}
		$answers = InclusiveMultipleAnswer::all();


		return view('inclusive.forms.answersList', ['answers' => $answers]);
	}

	//vista de edición respuestas que pueden utilizadas en respuestas multiples
	//$id identificador de la respuesta
	public function viewAnswers($id)
	{

				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}
		$answer = InclusiveMultipleAnswer::find($id);

		//dd($department);
		return view('inclusive.forms.answersView', ['answer' => $answer]);
	}


	//funcion que actualiza los datos de una respuesta que puede ser seleccionada en preguntas multiples
	//$request contiene la informacion de la actualización y el id de la respuesta
	public function updateAnswers(Request $request)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		$validate_response = $request->validate(
			[
				'answertext' => 'required',
				'state' => 'required',
				'answervalue' => 'required',

			],
			[
				'answertext.required' => 'Debes elegir un nombre',
				'state.required' => 'Debes elegir un estado',
				'state.answervalue' => 'Debes elegir un valor de la pregunta'
			]
		);

		$answer = InclusiveMultipleAnswer::find($request->id);

		//dd($department,$request->name,$request->state);
		//$department=Departments::where('id', '=', $request->id)->firstOrFail();

		$answer->estado = $request->state;
		$answer->texto_respuesta = $request->answertext;
		$answer->id_respuesta = $request->answervalue;



		//	dd($department,$request->name,$request->state);

		try {
			$answer->save();
			Session::flash('alertSent', 'Derived');
			Session::flash('message', "Respuesta actualizada exitosamente: ".$answer->texto_respuesta);
		} catch (\Exception $e) {
			// do task when error
			Session::flash('alert', 'error');
			echo $e->getMessage();   // insert query

		}

		return redirect()->route('ListAnswers');
	}

	//relacionar respuestas con preguntas que tengan la opción de selección multiple
	//$id identificador de la pregunta
	public function answersQuestionRelation($id)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}
		$pregunta = InclusiveQuestion::find($id);
		$respuestas = InclusiveMultipleAnswer::where('estado', '1')->get();
		return view('inclusive.forms.answersQuestionRelation', ['pregunta' => $pregunta, 'respuestas' => $respuestas]);
	}

	//guardar selección de respuestas a preguntas multiples
	//$request en donde viene el id de la pregunta y un arreglo pickedDep con los id de respuestas seleccionadas
	public function answersQuestionStore(Request $request)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		$respuestas = InclusiveQuestionMultipleAnswer::where('id_pregunta', $request->id)->get();
		if ($respuestas->isempty()) {
			if (isset($request->pickedDep))
				foreach ($request->pickedDep as $respuesta) {
					$respuestaDatos = InclusiveMultipleAnswer::where('id', $respuesta)->first();
					$respuestasMultiples = new InclusiveQuestionMultipleAnswer;
					$respuestasMultiples->id_pregunta = $request->id;
					$respuestasMultiples->id_respuesta = $respuesta;
					$respuestasMultiples->valor_respuesta = $respuestaDatos->id_respuesta;
					$respuestasMultiples->texto_respuesta = $respuestaDatos->texto_respuesta;

					$respuestasMultiples->estado = 1;
					try {
						$respuestasMultiples->save();
						//Session::flash('alertSent', 'Derived');
						//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
					} catch (\Exception $e) {
						// do task when error
						Session::flash('alert', 'error');
						echo $e->getMessage();   // insert query

					}
				}
		} else //conrespuestas relacionadas
		{
			foreach ($request->pickedDep as $respuesta) {
				$respuestaGuardada = InclusiveQuestionMultipleAnswer::where('id_pregunta', $request->id)->where('id_respuesta', $respuesta)->first();
				if (!isset($respuestaGuardada)) {

					$respuestaDatos = InclusiveMultipleAnswer::where('id', $respuesta)->first();
					$respuestasMultiples = new InclusiveQuestionMultipleAnswer;
					$respuestasMultiples->id_pregunta = $request->id;
					$respuestasMultiples->id_respuesta = $respuesta;
					$respuestasMultiples->valor_respuesta = $respuestaDatos->id_respuesta;
					$respuestasMultiples->texto_respuesta = $respuestaDatos->texto_respuesta;

					$respuestasMultiples->estado = 1;
					//dd($respuesta);
					try {
						$respuestasMultiples->save();
						//Session::flash('alertSent', 'Derived');
						//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
					} catch (\Exception $e) {
						// do task when error
						Session::flash('alert', 'error');
						echo $e->getMessage();   // insert query
					}
				} else {

					$respuestaDatos = InclusiveMultipleAnswer::where('id', $respuesta)->first();
					$old_answer = InclusiveQuestionMultipleAnswer::find($respuestaGuardada->id);
					$old_answer->estado = 1;
					$old_answer->valor_respuesta = $respuestaDatos->id_respuesta;
					$old_answer->texto_respuesta = $respuestaDatos->texto_respuesta;

					try {
						$old_answer->save();

						//Session::flash('alertSent', 'Derived');
						//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
					} catch (\Exception $e) {
						// do task when error
						Session::flash('alert', 'error');
						echo $e->getMessage();   // insert query

					}
				}
			}

			//desactivar producto que no esta en la lista
			if (!isset($request->pickedDep)) {
				$not_selecteds = InclusiveQuestionMultipleAnswer::where('id_pregunta', $request->id)->get();
			} else
				$not_selecteds = InclusiveQuestionMultipleAnswer::where('id_pregunta', $request->id)->whereNotIn('id_respuesta', $request->pickedDep)->get();
			foreach ($not_selecteds as $not_selected) {
				$oldFormQuestions = InclusiveQuestionMultipleAnswer::find($not_selected->id);
				$oldFormQuestions->estado = 2;

				try {
					$oldFormQuestions->save();

					//Session::flash('alertSent', 'Derived');
					//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
			}
		}

		return redirect()->route('ListQuestions');
	}

	//Formulario creacion formularios
	public function createForms()
	{

				//validar usuario
				$type= Auth::user()->type_id;
			
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		return view('inclusive.forms.formsCreate');
	}


	//Funcion que guarda  formularios
	//$request  contiene la informacion relacionada con el formuarop
	public function storeForms(Request $request)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		//validar formulario

		//dd($request);
		$validate_response = $request->validate(
			[
				'name' => 'required',
				'state' => 'required',

			],
			[
				'name.required' => 'Debes elegir un nombre',
				'state.required' => 'Debes elegir un estado'
			]
		);

		if ($request->state == "") {
			Session::flash('alertSent', 'SelectDepartment');
			Session::flash('message', "Estado");
			return redirect()->route('CreateForms');
		}

		//Crear objeto
		$form = new InclusiveForm;
		$form->nombre = $request->name;
		$form->estado = $request->state;
		$form->tipo = $request->type;
		$form->description = $request->description;
		$form->grouped = $request->grouped;
		$form->qanswer = $request->qanswer;
		$form->evaluacion = $request->evaluacion;
		$form->visibilidad = $request->visibilidad;
		$form->id_restriccion = $request->list;
		try {
			$form->save();
			Session::flash('alertSent', 'Derived');
			Session::flash('message', "Formulario creado " . $form->nombre . " exitosamente");
		} catch (\Exception $e) {
			// do task when error
			Session::flash('alert', 'error');
			echo $e->getMessage();   // insert query

		}

		return redirect()->route('ListForms');
		//return view('beneficiaries.create')->with('success', 'Usuario Creado');
	}

	//Listar formularios
	public function listForms()
	{
				//validar usuario
				$type= Auth::user()->type_id;

				
				
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}
		$forms = InclusiveForm::paginate(10);


		return view('inclusive.forms.formsList', ['forms' => $forms]);
	}

	//mostrar formulario y datos de edición
	//$id identificado de formulario
	public function viewForms($id)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		$form = InclusiveForm::find($id);
		return view('inclusive.forms.formsView', ['form' => $form]);
	}

	//Actualizar información de formularios
	//$request información de actualización del formularios
	public function updateForms(Request $request)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}


		$validate_response = $request->validate(
			[
				'name' => 'required',
				'state' => 'required',

			],
			[
				'name.required' => 'Debes elegir un nombre',
				'state.required' => 'Debes elegir un estado'
			]
		);

		$form = InclusiveForm::find($request->id);

		$form->nombre = $request->name;
		$form->estado = $request->state;
		$form->tipo = $request->type;
		$form->qanswer = $request->qanswer;
		$form->grouped = $request->grouped;
		$form->description = $request->description;
		$form->evaluacion = $request->evaluacion;
		$form->visibilidad = $request->visibilidad;
		$form->id_restriccion = $request->list;





		try {
			$form->save();
			Session::flash('alertSent', 'Derived');
			Session::flash('message', "Formulario actualizado " . $form->nombre . "  exitosamente");
		} catch (\Exception $e) {
			// do task when error
			Session::flash('alert', 'error');
			echo $e->getMessage();   // insert query

		}

		return redirect()->route('ListForms');
	}



	//Funcion que muestra las diferentes preguntas que serán utilizadas en la construcción de los formularios
	//$id identificador unico del  formulario
	public function questionsFormRelation($id)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

	//constructed by Sebastián Acevedo ac@akasha.ink
					$form = InclusiveForm::find($id);
		//estado activos
		$questions = InclusiveQuestion::where('estado', '1')->get();
		return view('inclusive.forms.questionsFormRelation', ['form' => $form, 'questions' => $questions]);
	}


	//funcion que guarda la relaciona entre las preguntas y los formularios
	//$request información de los formularios y  en el arreglo pickedDep[] id de preguntas seleccionadas 
	public function questionsFormStore(Request $request)
	{


				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>1||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		//agregar validar formulario



		//Si el formulario ya se encontraba en creado dentro de la relacion entre formulario y pregunta

		$formQuestions = InclusiveFormQuestion::where('id_formulario', $request->id_form)->get();


		//en el caso que no haya creado antes (tambien se podria utilizar first or new en la sentencia anterior)
		if ($formQuestions->isempty()) {


			if (isset($request->pickedDep))
				foreach ($request->pickedDep as $product) {

				

					//Crear objeto
					$newFormQuestions = new InclusiveFormQuestion;
					$newFormQuestions->id_formulario = $request->id_form;
					$newFormQuestions->id_pregunta = $product;
					$pregunta=InclusiveQuestion::find($product);
					$newFormQuestions->orden = $pregunta->orden;
					$newFormQuestions->estado = 1;
					try {

						$newFormQuestions->save();
						//Session::flash('alertSent', 'Derived');
						//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
					} catch (\Exception $e) {
						// do task when error
						Session::flash('alert', 'error');
						echo $e->getMessage();   // insert query

					}
				}
		} else //con preguntas
		{
			if (isset($request->pickedDep)) {
				//activar y crear la relacion con las preguntas seleccionados
				foreach ($request->pickedDep as $product) {
					$newFormQuestions = InclusiveFormQuestion::where('id_formulario', $request->id_form)->where('id_pregunta', $product)->first();
					if (!isset($newFormQuestions)) {


						$newFormQuestions = new InclusiveFormQuestion;
						$newFormQuestions->id_formulario = $request->id_form;
						$newFormQuestions->id_pregunta = $product;
						$pregunta=InclusiveQuestion::find($product);
						$newFormQuestions->orden = $pregunta->orden;
						$newFormQuestions->estado = 1;
						//guardar nuevo
						try {

							$newFormQuestions->save();
							//Session::flash('alertSent', 'Derived');
							//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
						} catch (\Exception $e) {
							// do task when error
							Session::flash('alert', 'error');
							echo $e->getMessage();   // insert query

						}
					} else {
						$oldFormQuestions = InclusiveFormQuestion::find($newFormQuestions->id);
						$oldFormQuestions->estado = 1;
						$pregunta=InclusiveQuestion::find($product);
						$oldFormQuestions->orden = $pregunta->orden;
						try {
							$oldFormQuestions->save();
						} catch (\Exception $e) {
							// do task when error
							Session::flash('alert', 'error');
							echo $e->getMessage();   // insert query

						}
					}
				}
			}

			//desactivar preguntas que no esta en la lista de seleccioón
			if (!isset($request->pickedDep)) {
				$not_selecteds = InclusiveFormQuestion::where('id_formulario', $request->id_form)->get();
			} else
				$not_selecteds = InclusiveFormQuestion::where('id_formulario', $request->id_form)->whereNotIn('id_pregunta', $request->pickedDep)->get();
			foreach ($not_selecteds as $not_selected) {
				$oldFormQuestions = InclusiveFormQuestion::find($not_selected->id);
				$oldFormQuestions->estado = 2;
				try {
					$oldFormQuestions->save();
//constructed by Sebastián Acevedo ac@akasha.ink
					//Session::flash('alertSent', 'Derived');
					//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
			}
		}


		//actualizar grupo de las preguntas

		$formQuestions = InclusiveFormQuestion::where('id_formulario', $request->id_form)->first();
		if ($formQuestions->form->grouped==1)
		foreach ($request->groupDep as $key => $value) {
			$questionRelated=null;
			$questionRelated= InclusiveFormQuestion::where('id_formulario', $request->id_form)->where('id_pregunta', $key)->first();
			if($questionRelated!=null){
				$questionRelated->group= $value;
			$questionRelated->save();
			}
			
			
		
		}

		return redirect()->route('ListForms');
		//return view('beneficiaries.create')->with('success', 'Usuario Creado');

	}

		//
	//listar formularios creados en el sistema y mostrarlos a los beneficiarios logeados
	public function beneficiarieIndexPost(Request $request)
	{
		
		
		$forms = InclusiveForm::where('estado','1')->get();
	
		if(isset($request->style_color))
		Session::put('color', $request->style_color);
		else 
		$request->style_color=Session::get('color');
		if(isset($request->style_font))
		Session::put('font', $request->style_font);
		else
		$request->style_font=Session::get('font');
	
		return view('inclusive.beneficiarie.list', ['style_color'=>$request->style_color,'style_font'=>$request->style_font,'forms' => $forms]);
	}
	//
	//listar formularios creados en el sistema y mostrarlos a los beneficiarios logeados
	public function beneficiarieIndex(Request $request)
	{
		$forms = InclusiveForm::where('estado','1')->get();
	
		if(isset($request->style_color))
		Session::put('color', $request->style_color);
		else 
		$request->style_color=Session::get('color');
		if(isset($request->style_font))
		Session::put('font', $request->style_font);
		else
		$request->style_font=Session::get('font');
		
		//$forms = InclusiveForm::all();
		//$style=1;
	
		return view('inclusive.beneficiarie.list', ['style_color'=>$request->style_color,'style_font'=>$request->style_font,'forms' => $forms]);
	}
		//listar formularios creados en el sistema y mostrarlos a los beneficiarios logeados
		public function beneficiarieIndexStyle($style)
		{
			//dd($style);
			$forms = InclusiveForm::all();
			$style=1;
		
			return view('inclusive.beneficiarie.list', ['style'=>$style,'forms' => $forms]);
		}

	//listar formularios creados en el sistema
	public function selectForms()
	{
		$forms = InclusiveForm::all();
		
		return view('inclusive.forms.formsSelect', ['forms' => $forms]);
	}

	//Visualización de formulario personalizado creado y respuestas 
	//$id identificador de formulario
	public function useForm($id)
	{
		$formulario = InclusiveForm::find($id);
		//		dd($formulario->products);
		return view('inclusive.forms.formsUse', ['formulario' => $formulario]);
	}
	//Visualización de formulario personalizado creado y respuestas 
	//$id identificador de formulario
	public function useFormBeneficiariePost(Request $request)
	{
		
		
//edad de la persona registrada
		$edad=null;
		if(Auth::user() &&Auth::user()->birth_date!=null){
			$user=Auth::user()->birth_date;
 			$date = new DateTime($user);
 			$now = new DateTime();
 			$interval = $now->diff($date);
 			$edad=$interval->y;
 
		}

	

		//dd($request);
		$formulario = InclusiveForm::find($request->id);
		//ver formulario


			//validacion de listas de restricción
			$found=null;
			if($formulario->id_restriccion && isset(Auth::user()->rut)){
				$found=$this->evaluationList(Auth::user()->rut,$request->id);
				if($found==2)
					return redirect()->back()->withErrors('El usuario se encuentra restringido de postular.');
				
			}


		if(isset($formulario))
		Session::put('formulario', $formulario);
		else
		$formulario=Session::get('formulario');

		if(isset($request->style_color))
		Session::put('color', $request->style_color);
		else 
		$request->style_color=Session::get('color');
		if(isset($request->style_font))
		Session::put('font', $request->style_font);
		else
		$request->style_font=Session::get('font');
		
		
		//formulario agrupado
		if($formulario->grouped==1){

			$answers=1;
			//grupo inicial
			$group=$formulario->questions->min('group');
			//dd("aqui");

			$answer_id = time();
		

			return view('inclusive.beneficiarie.answer_group', ['answer_id'=>$answer_id,'answers'=>$answers,'group'=>$group,'edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario]);
		}
				
		
		return view('inclusive.beneficiarie.answer', ['edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario]);
	}

////////////////////////////////////////////////////////////////////////////////
	//Store form grouped form
	public function answerFormUseStoreGroup(Request $request){

		//dd($request);
		$group=$request->group;

		$edad=null;
		if(Auth::user() &&Auth::user()->birth_date!=null){
			$user=Auth::user()->birth_date;
			$date = new DateTime($user);
			$now = new DateTime();
			$interval = $now->diff($date);
			$edad=$interval->y;

		}
	//recuperar preguntas de formulario
	$formulario = InclusiveForm::find($request->id_form);


		if ($request->type_form == '1'&& $group==$formulario->questions->min('group')) 
		{
			

			$validate_response = $request->validate([
				'rut' => ['required', 'regex:/^[0-9]+[-|‐]{1}[0-9kK]{1}$/'],
			

			]);

			$rut = $request->rut;
			$rut_validation = $this->valida_rut($request->rut);
			if (!$rut_validation) {
				Session::flash('alertSent', 'Alert');
				Session::flash('message', 'RUT ' . $request->rut . ' formato no corresponde');

				return redirect()->back();
			}
		}
		



		
	//ver formulario
	if(isset($formulario))
	Session::put('formulario', $formulario);
	else
	$formulario=Session::get('formulario');

	if(isset($request->style_color))
	Session::put('color', $request->style_color);
	else 
	$request->style_color=Session::get('color');
	if(isset($request->style_font))
	Session::put('font', $request->style_font);
	else
	$request->style_font=Session::get('font');


$error=null;	

		///Realizar guardado y verificación de requeridos
	
		if (isset($request->text_req)){
			$error.=$this->validate_answer_text($request->answers_text,$request->text_req);
		}
		if (isset($request->img_req)){
			$error.=$this->validate_answer_img($request->answers_img,$request->img_req);
		}
		if (isset($request->answers_req)){
			$error.=$this->validate_answer_int($request->answers_req,$request->answers_int);
		}
		if (isset($request->box_req)){
			$error.=$this->validate_answer_box($request->box_req,$request->answers_box);
		}
			
		if (isset($request->answers_text)&&$error==null){
			$storeAnswer=$this->store_answer_text($request->answer_id,$request->answers_text,$request->id_form,$request->type_form,$request->rut);
		}
		if (isset($request->answers_box)&&$error==null){
			$storeAnswer=$this->store_answer_box($request->answer_id,$request->answers_box,$request->id_form,$request->type_form,$request->rut);
		}
			
		
		
		
			
		if (isset($request->answers_img)&&$error==null){
			$storeAnswer=$this->store_answer_img($request->answer_id,$request->answers_img,$request->id_form,$request->type_form,$request->rut);
		}
			
		
		
	
			
		if (isset($request->answers_int)&&$error==null){
			$storeAnswer=$this->store_answer_int($request->answer_id,$request->answers_int,$request->id_form,$request->type_form,$request->rut);
		}
			
		


// revision de errores

$a['rut']=$request->rut;
//foreach($request->answers_text as $key => $value)
if(isset($request->answers_text))
foreach($request->answers_text as $key => $value)
	$a['old'.$key]=$value;
$old=null;
	//foreach($request->answers_text as $key => $value)
if(isset($request->answers_text))
foreach($request->answers_text as $key => $value)
$old[$key]=$value;


if($error!=null){
	//return back()->withInput($a)->withErrors($error);

	//cargar nuevamente los datos 

	//edad de la persona registrada
$edad=null;
if(Auth::user() &&Auth::user()->birth_date!=null){
	$user=Auth::user()->birth_date;
$date = new DateTime($user);
$now = new DateTime();
$interval = $now->diff($date);
$edad=$interval->y;

}


//dd($request);
$formulario = InclusiveForm::find($request->id_form);

//ver formulario
if(isset($formulario))
Session::put('formulario', $formulario);
else
$formulario=Session::get('formulario');

if(isset($request->style_color))
Session::put('color', $request->style_color);
else 
$request->style_color=Session::get('color');
if(isset($request->style_font))
Session::put('font', $request->style_font);
else
$request->style_font=Session::get('font');


		//dd($request->style_color,$request->style_font);

return view('inclusive.beneficiarie.answer_group', ['answer_id'=>$request->answer_id,'group'=>$group,'errors'=>$error,'old'=>$old,'rut'=>$request->rut,'edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario])->withErrors($error);

//			return redirect()->back()->withErrors($error);
}


			
		
		///Realizar guardado

//presionar boton enviar
if($request->send==1){
	$answers=InclusiveAnswer::where('id_requerimiento',$request->answer_id)->get();
	return view('inclusive.beneficiarie.awesomeConfirmPage', ['answers'=>$answers,'answer_id'=>$request->answer_id,'group'=>$group,'edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario]);
}


		//recorrer el fomulario  si es la ultima pregunta
		if($request->next==1&&$group==$formulario->questions->max('group')){

		return view('inclusive.beneficiarie.awesomeConfirmPage', ['answer_id'=>$request->answer_id,'group'=>$group,'edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario]);

		}
		elseif($request->next==1&&$group<$formulario->questions->max('group')){
			$group=$group+1;
		}
		if($request->previous==1&&$group>=$formulario->questions->min('group'))
				$group=$group-1;

		elseif($request->prevous==1&&$group>=$formulario->questions->min('group'))
				return redirect()->route('BeneficiarieIndex');
			
	
	
		return view('inclusive.beneficiarie.answer_group', ['answer_id'=>$request->answer_id,'group'=>$group,'edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario]);

	}


	public function confirmAnswersStoreGroup(Request $request){
$answers=InclusiveAnswer::where('id_requerimiento',$request->answer_id)->get();
foreach($answers as $answer)
{
	$answer->state_id=2; //confirmado
	$answer->save();
}

		
		Session::flash('alertSent', 'Alert');
		Session::flash('message', "Formulario respondido exitosamente con ID: ".$request->answer_id);
		//return redirect()->back()->withErrors(["Formulario respondido exitosamente con ID: ".$id]);
		if(Auth::user()){
			$mail=Auth::user()->email;
			$this->sendMailToTeam("Reporte automatico a mail",'Sistema de postulacion',$mail,'Reporte de envío de formulario con ID: '.$request->answer_id,$request->id_form);
		}

	return redirect()->route('BeneficiarieIndex');

}

public function store_answer_int($id,$answers_int, $id_form, $type_form,$rut=null){
				//responde pregunta alternativas
				if (isset($answers_int))
				foreach ($answers_int as $key => $value) {
//	dd($request->answers_int,$key,json_decode($value),json_decode($value)->value, json_decode($value)->id);
				if($value){
					$storeAnswer = new InclusiveAnswer;
					$storeAnswer->id_pregunta = $key;
					$storeAnswer->id_formulario = $id_form;
					$storeAnswer->id_requerimiento = $id;
					if(Auth::user())
						$storeAnswer->id_persona=Auth::user()->id;
					$storeAnswer->valor_respuesta = json_decode($value)->value; //identificador unico de la respuesta
					$storeAnswer->answer_id= json_decode($value)->id; //valor de respuesta asignado en configuracion
				
				
						
					
					$storeAnswer->tipo = '2';
					if ($type_form == 1)
						$storeAnswer->rut_persona = strtoupper($rut);
	
					
	
	
					try {
						$storeAnswer->save();
	
						//	Session::flash('alertSent', 'Derived');
						//	Session::flash('message', "Respuestas guardadas exitosamente" );
					} catch (\Exception $e) {
						// do task when error
						Session::flash('alert', 'error');
						echo $e->getMessage();   // insert query
	
					}
				}
			}
			//return $storeAnswer->id;
}



//guardar respuestas box
public function store_answer_box($id,$answers_int, $id_form, $type_form,$rut=null){
	//responde pregunta alternativas
	if (isset($answers_int))
	foreach ($answers_int as $key => $value) {
//	dd($request->answers_int,$key,json_decode($value),json_decode($value)->value, json_decode($value)->id);
	if($value){
		$storeAnswer = new InclusiveAnswer;
		$storeAnswer->id_pregunta = $key;
		$storeAnswer->id_formulario = $id_form;
		$storeAnswer->id_requerimiento = $id;
		$storeAnswer->texto_respuesta=implode($value);
		if(Auth::user())
			$storeAnswer->id_persona=Auth::user()->id;
		//$storeAnswer->valor_respuesta = json_decode($value)->value; //identificador unico de la respuesta
		//$storeAnswer->answer_id= json_decode($value)->id; //valor de respuesta asignado en configuracion
	
	
			
		
		$storeAnswer->tipo = '0';
		if ($type_form == 1)
			$storeAnswer->rut_persona = strtoupper($rut);

		


		try {
			$storeAnswer->save();

			//	Session::flash('alertSent', 'Derived');
			//	Session::flash('message', "Respuestas guardadas exitosamente" );
		} catch (\Exception $e) {
			// do task when error
			Session::flash('alert', 'error');
			echo $e->getMessage();   // insert query

		}
	}
}
//return $storeAnswer->id;
}





//guardar repuesta de texto
//$answer_text= arreglo con respuesta de texto
//$id_form= identificador fromulario 
//$rut =
//$id= identificador unico de requerimiento
//type_form= tipo de formulario (si requiere run o no)
public function store_answer_text($id,$answers_text, $id_form, $type_form,$rut=null){

	if (isset($answers_text))
	foreach ($answers_text as $key => $value) {

		//			'id','id_pregunta','id_formulario','id_requerimiento','id_persona','respuesta_text','respuesta_number','tipo','estado'
//validar si la pregunta fue respondida $key y $id, si no el null actualizar
		$storeAnswer = new InclusiveAnswer;
		$storeAnswer->id_pregunta = $key;
		$storeAnswer->id_formulario = $id_form;
		$storeAnswer->id_requerimiento = $id;
		$storeAnswer->state_id = 1;//creada
		$storeAnswer->texto_respuesta = $value;
		if(Auth::user())
		$storeAnswer->id_persona=Auth::user()->id;
		$storeAnswer->tipo = '0';
		if ($type_form ==1)
			$storeAnswer->rut_persona = strtoupper($rut);
		try {
			$storeAnswer->save();
			//guardar en session respuesta
			Session::put($key, $value);

			//	Session::flash('alertSent', 'Derived');
			//	Session::flash('message', "Respuestas guardadas exitosamente" );
		} catch (\Exception $e) {
			// do task when error
			Session::flash('alert', 'error');
			echo $e->getMessage();   // insert query

		}
	}

	//return $storeAnswer->id;
}

//guardar repuesta de texto
//$answer_text= arreglo con respuesta de texto
//$id_form= identificador fromulario 
//$rut =
//$id= identificador unico de requerimiento
//type_form= tipo de formulario (si requiere run o no)
//$img_req= lista de requeridos
public function store_answer_img($id,$answers_img, $id_form, $type_form,$rut=null){
//dd("aquí");
	//archivo adjunto
	if (isset($answers_img)){
		foreach ($answers_img as $key => $value) {

			//dd($request->answers_img,$key,$value);
			$img_id = $this->fileStore($value, '3', $id_form, $id);
			$storeAnswer = new InclusiveAnswer;
			$storeAnswer->id_pregunta = $key;
			$storeAnswer->id_formulario = $id_form;
			$storeAnswer->id_requerimiento = $id;
			$storeAnswer->state_id = 1;//creada
			if(Auth::user())
			$storeAnswer->id_persona=Auth::user()->id;
			$storeAnswer->valor_respuesta = $img_id;
			$storeAnswer->tipo = '3';
			if ($type_form == 1)
				$storeAnswer->rut_persona = strtoupper($rut);




			try {
				$storeAnswer->save();

				//	Session::flash('alertSent', 'Derived');
				//	Session::flash('message', "Respuestas guardadas exitosamente" );
			} catch (\Exception $e) {
				// do task when error
				Session::flash('alert', 'error');
				echo $e->getMessage();   // insert query

			}
		}

	}

	//return $storeAnswer->id;	

}

//validar textos requeridos


//Revisar si la pregunta requerida fue respondida
public function validate_answer_text($answers_text,$tex_req ){
	$error=null;
if (isset($tex_req))
foreach($tex_req as $tex_reqs){
	$key_answer=0;
	if (isset($answers_text)){

	
		foreach ($answers_text as $key => $value) {
			if($key==$tex_reqs)
				$key_answer=1;
		
			if($key==$tex_reqs&&$value==null){
				
				$error.="Responder preguntas de text ".$key.".\n";
				

			}
				

		}
		if($key_answer==0){
			$error.="Responder preguntas de text ".$tex_reqs.".\n";
			
		}
			
		$key_answer=0;
	}
		else{
			$error.="Responder preguntas de text ".$tex_reqs.".\n";
			
		}
		

	
}
return $error;
}



//revisar preguntas con alternativas
//Revisar si la pregunta requerida fue respondida
public function validate_answer_box($answers_req,$answers_int ){
	$error=null;
if (isset($answers_req))
foreach($answers_req as $answers_reqs){
	$key_answer=0;
	if (isset($answers_int)){

	
		foreach ($answers_int as $key => $value) {
			if($key==$answers_reqs)
				$key_answer=1;
		
			if($key==$answers_reqs&&$value==null){
				
				//dd($key,$img_reqs,$value);
				$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
				//dd("aqui");
				//return redirect()->route('BeneficiarieIndex');

			}
				

		}
		if($key_answer==0){
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
			
		$key_answer=0;
	}
		else{
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
		

	
}
return $error;
}





//revisar preguntas con alternativas
//Revisar si la pregunta requerida fue respondida
public function validate_answer_int($answers_req,$answers_int ){
	$error=null;
if (isset($answers_req))
foreach($answers_req as $answers_reqs){
	$key_answer=0;
	if (isset($answers_int)){

	
		foreach ($answers_int as $key => $value) {
			if($key==$answers_reqs)
				$key_answer=1;
		
			if($key==$answers_reqs&&$value==null){
				
				//dd($key,$img_reqs,$value);
				$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
				//dd("aqui");
				//return redirect()->route('BeneficiarieIndex');

			}
				

		}
		if($key_answer==0){
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
			
		$key_answer=0;
	}
		else{
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
		

	
}
return $error;
}

//revisar imagenes requeridas
public function validate_answer_img($answers_img,$img_req ){
	$error=null;
	//Revisar si la pregunta requerida fue respondida

		if (isset($img_req))
			foreach($img_req as $img_reqs){
				$key_answer=0;
				if (isset($answers_img)){
	
				
					foreach ($answers_img as $key => $value) {
						if($key==$img_reqs)
							$key_answer=1;
					
						if($key==$img_reqs&&$value==null){
							
							$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
						}
					}
					if($key_answer==0){
						$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
					}
						
					$key_answer=0;
				}
				else{
						$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
						
					}
					
	
				
			}
	return $error;

}




	//Visualización de formulario personalizado creado y respuestas 
	//$id identificador de formulario
	public function useFormBeneficiarieRUT($id,$rut,$fecha=null)
	{

	$edad=0;
		//dd($id,$rut);
		$formulario = InclusiveForm::find($id);
		//		dd($formulario->products);

		if($formulario->id_restriccion && isset(Auth::user()->rut))
			$found=$this->evaluationList($id,Auth::user()->rut);
		


		return view('inclusive.get.answerGet', ['edad'=>$edad,'rut'=>$rut,'formulario' => $formulario]);
	}


	//Visualización de formulario personalizado creado y respuestas 
	//$id identificador de formulario
	public function useFormBeneficiarie($id)
	{
	
		$formulario = InclusiveForm::find($id);
		//		dd($formulario->products);

		if($formulario->id_restriccion && isset(Auth::user()->rut))
			$found=$this->evaluationList($id,Auth::user()->rut);
		


		return view('inclusive.beneficiarie.answer', ['formulario' => $formulario]);
	}

	//Visualización de formulario directamente con RUT de usuario
	//$id identificador de formulario
	public function useFormBeneficiarieData($id,$rut)
	{
	
		$formulario = InclusiveForm::find($id);
		//		dd($formulario->products);
		if($formulario->id_restriccion && isset($rut))
			$found=$this->evaluationList($id,$rut);
		


		return view('inclusive.beneficiarie.answer', ['formulario' => $formulario,'rut'=>$rut]);
	}


	public function AwesomerAnswersStoreGroup(Request $request)
	//guardar respuestas en el caso de responder un formulario personalizado
	//$request si el formlario fue creado con utilizacion de RUT de otra forma solo las respuesta
	{

		


	

		//foreach($request->answers_text as $key => $value)
		//$a["old".$key]=$value;
		//dd($a);
	//	dd(json_decode($request->questions));
			
	//foreach($request->answers_text as $key => $value)
	
	$error=null;
//Revisar si la pregunta requerida fue respondida
	if (isset($request->img_req))
		foreach($request->img_req as $img_reqs){
			$key_answer=0;
			if (isset($request->answers_img)){

			
				foreach ($request->answers_img as $key => $value) {
					if($key==$img_reqs)
						$key_answer=1;
				
					if($key==$img_reqs&&$value==null){
						
						//dd($key,$img_reqs,$value);
						$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
					//	dd("aqui");
					//	return redirect()->route('BeneficiarieIndex');

					}
						

				}
				if($key_answer==0){
					$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
					//dd("aca");
					//return redirect()->route('BeneficiarieIndex');
				}
					
				$key_answer=0;
			}
				else{
					$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
					//dd("ahí");
					//return redirect()->route('BeneficiarieIndex');
				}
				

			
		}
//		dd("despues de validación",$key,$img_reqs,$value);	


//Revisar si la pregunta requerida fue respondida
if (isset($request->answers_req))
foreach($request->answers_req as $answers_reqs){
	$key_answer=0;
	if (isset($request->answers_int)){

	
		foreach ($request->answers_int as $key => $value) {
			if($key==$answers_reqs)
				$key_answer=1;
		
			if($key==$answers_reqs&&$value==null){
				
				//dd($key,$img_reqs,$value);
				$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
				//dd("aqui");
				//return redirect()->route('BeneficiarieIndex');

			}
				

		}
		if($key_answer==0){
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
			
		$key_answer=0;
	}
		else{
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
		

	
}


//Revisar si la pregunta requerida fue respondida


if (isset($request->tex_req))
foreach($request->tex_req as $tex_reqs){
	$key_answer=0;
	if (isset($request->answers_text)){

	
		foreach ($request->answers_text as $key => $value) {
			if($key==$tex_reqs)
				$key_answer=1;
		
			if($key==$tex_reqs&&$value==null){
				
				$error.="Responder preguntas de text ".$key.".\n";
				//dd($key,$img_reqs,$value);
				//dd("aqui");
				//return redirect()->route('BeneficiarieIndex');

			}
				

		}
		if($key_answer==0){
			$error.="Responder preguntas de text ".$tex_reqs.".\n";
			//dd("aca");
			//return redirect()->route('BeneficiarieIndex');
		}
			
		$key_answer=0;
	}
		else{
			$error.="Responder preguntas de text ".$tex_reqs.".\n";
			//dd("ahí");
			//return redirect()->route('BeneficiarieIndex');
		}
		

	
}

//$a[0]=['rut' => $request->rut];
$a['rut']=$request->rut;
//foreach($request->answers_text as $key => $value)
if(isset($request->answers_text))
foreach($request->answers_text as $key => $value)
	$a['old'.$key]=$value;

	//foreach($request->answers_text as $key => $value)
if(isset($request->answers_text))
foreach($request->answers_text as $key => $value)
$old[$key]=$value;
//dd($a);

//$a[1]=['rut' => $request->rut];
//foreach( $request->img_req)
if($error!=null){
	//return back()->withInput($a)->withErrors($error);

	//cargar nuevamente los datos 

	//edad de la persona registrada
$edad=null;
if(Auth::user() &&Auth::user()->birth_date!=null){
	$user=Auth::user()->birth_date;
$date = new DateTime($user);
$now = new DateTime();
$interval = $now->diff($date);
$edad=$interval->y;

}


//dd($request);
$formulario = InclusiveForm::find($request->id_form);

//ver formulario
if(isset($formulario))
Session::put('formulario', $formulario);
else
$formulario=Session::get('formulario');

if(isset($request->style_color))
Session::put('color', $request->style_color);
else 
$request->style_color=Session::get('color');
if(isset($request->style_font))
Session::put('font', $request->style_font);
else
$request->style_font=Session::get('font');


		//dd($request->style_color,$request->style_font);

return view('inclusive.beneficiarie.answer', ['errors'=>$error,'old'=>$old,'rut'=>$request->rut,'edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario])->withErrors($error);

//			return redirect()->back()->withErrors($error);
}


		$imageName = "imagen";
		$path = request()->answers_img;
		//	dd($request,$path);
		//	\Log::channel('decomlog')->info($request);
		//si requiere rut
		if ($request->type_form == '1') {
			

			$validate_response = $request->validate([
				'rut' => ['required', 'regex:/^[0-9]+[-|‐]{1}[0-9kK]{1}$/'],
			

			]);


			$formsq_rut= InclusiveAnswer::where('id_formulario',$request->id_form)->where('rut_persona',$request->rut)->distinct('id_requerimiento')->count('id_requerimiento');
			$formsq_id= InclusiveAnswer::where('id_formulario',$request->id_form)->where('id_persona',Auth::user()->id)->distinct('id_requerimiento')->count('id_requerimiento');
		
			$form=InclusiveForm::find($request->id_form);
			//if((int)$form->qanswer<(int)$formsq_rut && $form->qanswer!='0')
		//	if((int)$form->qanswer<(int)$formsq_id && $form->qanswer!='0')
			
		//		dd($form->qanswer,$request->id_form,$request->id_form,$formsq_id,$formsq_rut,$form,Auth::user()->id,$request->rut);
			
			
			if((int)$form->qanswer<(int)$formsq_rut && $form->qanswer!='0'){
				
			
				//['errors'=>$error
				Session::flash('alertSent', 'Alert');
				Session::flash('message', 'RUT ' . $request->rut . ' ya ha respondido '.$form->qanswer.' la cantidad máxima de respuestas');
				$forms=InclusiveForm::all();
				//return view('inclusive.beneficiarie.list', ['style_color'=>$request->style_color,'style_font'=>$request->style_font,'forms' => $forms]);
				return redirect('home/');
				//->route('home');

			}
			if((int)$form->qanswer<(int)$formsq_id && $form->qanswer!='0'){
				$user=find(Auth::user()->id);
				//['errors'=>$error
				Session::flash('alertSent', 'Alert');
				Session::flash('message', 'El usuario logeado con RUT ' . $user->rut . ' ya ha respondido '.$form->qanswer.' la cantidad máxima de respuestas');
				$forms=InclusiveForm::all();
				//return view('inclusive.beneficiarie.list', ['style_color'=>$request->style_color,'style_font'=>$request->style_font,'forms' => $forms]);
				return redirect('home/');
				//->route('home');
			}
				

			$rut = $request->rut;
			$rut_validation = $this->valida_rut($request->rut);
			if (!$rut_validation) {
				Session::flash('alertSent', 'Alert');
				Session::flash('message', 'RUT ' . $request->rut . ' formato no corresponde');

				return redirect('home/');
			}
		}

		$id = time();
		//archivo adjunto
		if (isset($request->answers_img)){
			foreach ($request->answers_img as $key => $value) {

				//dd($request->answers_img,$key,$value);
				$img_id = $this->fileStore($value, '3', $request->id_form, $id);
				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->valor_respuesta = $img_id;
				$storeAnswer->tipo = '3';
				if ($request->type_form == 1)
					$storeAnswer->rut_persona = strtoupper($request->rut);




				try {
					$storeAnswer->save();

					//	Session::flash('alertSent', 'Derived');
					//	Session::flash('message', "Respuestas guardadas exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
			}

		}


		if (isset($request->answers_text))
			foreach ($request->answers_text as $key => $value) {

				//			'id','id_pregunta','id_formulario','id_requerimiento','id_persona','respuesta_text','respuesta_number','tipo','estado'

				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				$storeAnswer->texto_respuesta = $value;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->tipo = '0';
				if ($request->type_form ==1)
					$storeAnswer->rut_persona = strtoupper($request->rut);




				try {
					$storeAnswer->save();

					//	Session::flash('alertSent', 'Derived');
					//	Session::flash('message', "Respuestas guardadas exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
			}

			//responde pregunta alternativas
		if (isset($request->answers_int))
			foreach ($request->answers_int as $key => $value) {
//dd($request->answers_int,$key,json_decode($value),json_decode($value)->value, json_decode($value)->id);
if($value){
				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->valor_respuesta = json_decode($value)->value; //identificador unico de la respuesta
				$storeAnswer->answer_id= json_decode($value)->id; //valor de respuesta asignado en configuracion
			
			
					
				
				$storeAnswer->tipo = '2';
				if ($request->type_form == 1)
					$storeAnswer->rut_persona = strtoupper($request->rut);

				


				try {
					$storeAnswer->save();

					//	Session::flash('alertSent', 'Derived');
					//	Session::flash('message', "Respuestas guardadas exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
}
			}

			Session::flash('alertSent', 'Alert');
			Session::flash('message', "Formulario respondido exitosamente con ID: ".$id);
			//return redirect()->back()->withErrors(["Formulario respondido exitosamente con ID: ".$id]);
			if(Auth::user()){
				$mail=Auth::user()->email;
				$this->sendMailToTeam("Reporte automatico a mail",'Sistema de postulacion',$mail,'Reporte de envío de formulario con ID: '.$id,$request->id_form);
			}
	
		return redirect()->route('BeneficiarieIndex');
	}





	//guardar respuestas en el caso de responder un formulario personalizado
	//$request si el formlario fue creado con utilizacion de RUT de otra forma solo las respuesta
	public function AnswerFormUseStore(Request $request)
	{
		
		
		//foreach($request->answers_text as $key => $value)
		//$a["old".$key]=$value;
		//dd($a);
	//	dd(json_decode($request->questions));
			
	//foreach($request->answers_text as $key => $value)
	
	$error=null;
//Revisar si la pregunta requerida fue respondida
	if (isset($request->img_req))
		foreach($request->img_req as $img_reqs){
			$key_answer=0;
			if (isset($request->answers_img)){

			
				foreach ($request->answers_img as $key => $value) {
					if($key==$img_reqs)
						$key_answer=1;
				
					if($key==$img_reqs&&$value==null){
						
						//dd($key,$img_reqs,$value);
						$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
					//	dd("aqui");
					//	return redirect()->route('BeneficiarieIndex');

					}
						

				}
				if($key_answer==0){
					$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
					//dd("aca");
					//return redirect()->route('BeneficiarieIndex');
				}
					
				$key_answer=0;
			}
				else{
					$error.="Cargar las imagenes requeridas ".$img_reqs.".\n";
					//dd("ahí");
					//return redirect()->route('BeneficiarieIndex');
				}
				

			
		}
//		dd("despues de validación",$key,$img_reqs,$value);	

//Revisar si la pregunta checkbox fue respondida
if (isset($request->box_req))
foreach($request->box_req as $answers_reqs){
	$key_answer=0;
	if (isset($request->answers_box)){

	
		foreach ($request->answers_box as $key => $value) {
			//dd($request->answers_box,$key,$value,$answers_reqs);		
			if($key==$answers_reqs){
				$key_answer=1;
		}
			if($key==$answers_reqs&&$value==null){
				
				//dd($key,$img_reqs,$value);
				$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
				//dd("aqui");
				//return redirect()->route('BeneficiarieIndex');

			}
				

		}
		
		if($key_answer==0){
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
			
		$key_answer=0;
	}
		else{
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
		

	
}



//Revisar si la pregunta requerida fue respondida
if (isset($request->answers_req))
foreach($request->answers_req as $answers_reqs){
	$key_answer=0;
	if (isset($request->answers_int)){

	
		foreach ($request->answers_int as $key => $value) {
			if($key==$answers_reqs)
				$key_answer=1;
		
			if($key==$answers_reqs&&$value==null){
				
				//dd($key,$img_reqs,$value);
				$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
				//dd("aqui");
				//return redirect()->route('BeneficiarieIndex');

			}
				

		}
		if($key_answer==0){
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
			
		$key_answer=0;
	}
		else{
			$error.="Responder preguntas con alternativa ".$answers_reqs.".\n";
			
		}
		

	
}

//dd($request,$request->tex_req,$request->answers_text);
//Revisar si la pregunta requerida fue respondida
if (isset($request->text_req))
foreach($request->text_req as $tex_reqs){
	
	$key_answer=0;
	if (isset($request->answers_text)){

	
		foreach ($request->answers_text as $key => $value) {
			if($key==$tex_reqs)
				$key_answer=1;
		
			if($key==$tex_reqs&&$value==null){
				
				$error.="Responder preguntas de text ".$key.".\n";
				//dd($key,$img_reqs,$value);
				//dd("aqui");
				//return redirect()->route('BeneficiarieIndex');

			}
				

		}
		if($key_answer==0){
			$error.="Responder preguntas de text ".$tex_reqs.".\n";
			//dd("aca");
			//return redirect()->route('BeneficiarieIndex');
		}
			
		$key_answer=0;
	}
		else{
			$error.="Responder preguntas de text ".$tex_reqs.".\n";
			//dd("ahí");
			//return redirect()->route('BeneficiarieIndex');
		}
		

	
}

//$a[0]=['rut' => $request->rut];
$a['rut']=$request->rut;
//foreach($request->answers_text as $key => $value)
if(isset($request->answers_text))
foreach($request->answers_text as $key => $value)
	$a['old'.$key]=$value;
$old=null;
	//foreach($request->answers_text as $key => $value)
if(isset($request->answers_text))
foreach($request->answers_text as $key => $value)
$old[$key]=$value;
//dd($a);

//$a[1]=['rut' => $request->rut];
//foreach( $request->img_req)
if($error!=null){
	//return back()->withInput($a)->withErrors($error);

	//cargar nuevamente los datos 

	//edad de la persona registrada
$edad=null;
if(Auth::user() &&Auth::user()->birth_date!=null){
	$user=Auth::user()->birth_date;
$date = new DateTime($user);
$now = new DateTime();
$interval = $now->diff($date);
$edad=$interval->y;

}


//dd($request);
$formulario = InclusiveForm::find($request->id_form);

//ver formulario
if(isset($formulario))
Session::put('formulario', $formulario);
else
$formulario=Session::get('formulario');

if(isset($request->style_color))
Session::put('color', $request->style_color);
else 
$request->style_color=Session::get('color');
if(isset($request->style_font))
Session::put('font', $request->style_font);
else
$request->style_font=Session::get('font');


		//desde formulario embebido
		if($request->embebed)
		return view('inclusive.get.answerGet', ['errors'=>$error,'old'=>$old,'rut'=>$request->rut,'edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario])->withErrors($error);
			
return view('inclusive.beneficiarie.answer', ['errors'=>$error,'old'=>$old,'rut'=>$request->rut,'edad'=>$edad,'style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario])->withErrors($error);

//			return redirect()->back()->withErrors($error);
}


		$imageName = "imagen";
		$path = request()->answers_img;
		//	dd($request,$path);
		//	\Log::channel('decomlog')->info($request);
		//si requiere rut
		if ($request->type_form == '1') {
			

			$validate_response = $request->validate([
				'rut' => ['required', 'regex:/^[0-9]+[-|‐]{1}[0-9kK]{1}$/'],
			

			]);


			$formsq_rut= InclusiveAnswer::where('id_formulario',$request->id_form)->where('rut_persona',$request->rut)->distinct('id_requerimiento')->count('id_requerimiento');
			$formsq_id= InclusiveAnswer::where('id_formulario',$request->id_form)->where('id_persona',Auth::user()->id)->distinct('id_requerimiento')->count('id_requerimiento');
		
			$form=InclusiveForm::find($request->id_form);
			//if((int)$form->qanswer<(int)$formsq_rut && $form->qanswer!='0')
		//	if((int)$form->qanswer<(int)$formsq_id && $form->qanswer!='0')
			
		//		dd($form->qanswer,$request->id_form,$request->id_form,$formsq_id,$formsq_rut,$form,Auth::user()->id,$request->rut);
			
			
			if((int)$form->qanswer<(int)$formsq_rut && $form->qanswer!='0'){
				
			
				//['errors'=>$error
				Session::flash('alertSent', 'Alert');
				Session::flash('message', 'RUT ' . $request->rut . ' ya ha respondido '.$form->qanswer.' la cantidad máxima de respuestas');
				$forms=InclusiveForm::all();
				//return view('inclusive.beneficiarie.list', ['style_color'=>$request->style_color,'style_font'=>$request->style_font,'forms' => $forms]);
				if($request->embebed)
					return redirect()->back();
				return redirect('home/');
				//->route('home');

			}
			if((int)$form->qanswer<(int)$formsq_id && $form->qanswer!='0'){
				$user=find(Auth::user()->id);
				//['errors'=>$error
				Session::flash('alertSent', 'Alert');
				Session::flash('message', 'El usuario logeado con RUT ' . $user->rut . ' ya ha respondido '.$form->qanswer.' la cantidad máxima de respuestas');
				$forms=InclusiveForm::all();
				//return view('inclusive.beneficiarie.list', ['style_color'=>$request->style_color,'style_font'=>$request->style_font,'forms' => $forms]);
				//en el caso de que venga de solicitud por get
				if($request->embebed)
					return redirect()->back();
				return redirect('home/');
				//->route('home');
			}
				

			$rut = $request->rut;
			$rut_validation = $this->valida_rut($request->rut);
			if (!$rut_validation) {
				Session::flash('alertSent', 'Alert');
				Session::flash('message', 'RUT ' . $request->rut . ' formato no corresponde');
				//en el caso de que venga de solicitud por get
				if($request->embebed)
					return redirect()->back();
				return redirect('home/');
			}
		}

		$id = time();
		//archivo adjunto
		if (isset($request->answers_img)){
			foreach ($request->answers_img as $key => $value) {

				//dd($request->answers_img,$key,$value);
				$img_id = $this->fileStore($value, '3', $request->id_form, $id);
				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->valor_respuesta = $img_id;
				$storeAnswer->tipo = '3';
				if ($request->type_form == 1)
					$storeAnswer->rut_persona = strtoupper($request->rut);




				try {
					$storeAnswer->save();

					//	Session::flash('alertSent', 'Derived');
					//	Session::flash('message', "Respuestas guardadas exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
			}

		}


		if (isset($request->answers_text))
			foreach ($request->answers_text as $key => $value) {

				//			'id','id_pregunta','id_formulario','id_requerimiento','id_persona','respuesta_text','respuesta_number','tipo','estado'

				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				$storeAnswer->texto_respuesta = $value;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->tipo = '0';
				if ($request->type_form ==1)
					$storeAnswer->rut_persona = strtoupper($request->rut);




				try {
					$storeAnswer->save();

					//	Session::flash('alertSent', 'Derived');
					//	Session::flash('message', "Respuestas guardadas exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
			}
			//respuesta con alternativa
		if (isset($request->answers_int))
			foreach ($request->answers_int as $key => $value) {
//dd($request->answers_int,$key,json_decode($value),json_decode($value)->value, json_decode($value)->id);
if($value){
				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->valor_respuesta = json_decode($value)->value; //identificador unico de la respuesta
				$storeAnswer->answer_id= json_decode($value)->id; //valor de respuesta asignado en configuracion
			
			
					
				
				$storeAnswer->tipo = '2';
				if ($request->type_form == 1)
					$storeAnswer->rut_persona = strtoupper($request->rut);

				


				try {
					$storeAnswer->save();

					//	Session::flash('alertSent', 'Derived');
					//	Session::flash('message', "Respuestas guardadas exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
}
			}

//Respuesta box

			//respuesta con alternativa
			if (isset($request->answers_box))
			foreach ($request->answers_box as $key => $value) {
			//	dd($request->answers_box,$key, $value,implode($value));
//dd($request->answers_int,$key,json_decode($value),json_decode($value)->value, json_decode($value)->id);
			if($value){
				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->texto_respuesta=implode($value);
			//	$storeAnswer->valor_respuesta = json_decode($value)->value; //identificador unico de la respuesta
			//	$storeAnswer->answer_id= json_decode($value)->id; //valor de respuesta asignado en configuracion
			
			
					
				//cambiar tipo a 7 
				$storeAnswer->tipo = '0';
				if ($request->type_form == 1)
					$storeAnswer->rut_persona = strtoupper($request->rut);

				


				try {
					$storeAnswer->save();

					//	Session::flash('alertSent', 'Derived');
					//	Session::flash('message', "Respuestas guardadas exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
			}
		}


			Session::flash('alertSent', 'Alert');
			Session::flash('message', "Formulario respondido exitosamente con ID: ".$id);
			//return redirect()->back()->withErrors(["Formulario respondido exitosamente con ID: ".$id]);
			if(Auth::user()){
				$mail=Auth::user()->email;
				$this->sendMailToTeam("Reporte automatico a mail",'Sistema de postulacion',$mail,'Reporte de envío de formulario con ID: '.$id,$request->id_form);
			}
			//en el caso de que venga de solicitud por get
			if($request->embebed)
				return redirect()->route('Success');
		return redirect()->route('BeneficiarieIndex');
	}

		//muestra todas las respuestas ingresadas a un formulario
	//$id identificador del formulario
	public function useFormBeneficiarie_($id)
	{
		
		$answerById = null;
		$answers = InclusiveAnswer::where('id_formulario', $id)->groupBy('id_requerimiento')->pluck('id_requerimiento');
		foreach ($answers as $answer) {
			$answerById[$answer] = InclusiveAnswer::where('id_requerimiento', $answer)->get();
		}
		//dd($answerById);


		$storedAnswers = InclusiveAnswer::where('id_formulario', $id)->groupBy('id_requerimiento')->get();
		/*		foreach($storedAnswers as $storeAnswer)
			dd($storeAnswer->question->question->nombre);//pregunta nombre
			dd($storeAnswer->question->question->pregunta);//pregunta pregunta*/

			


		return view('inclusive.beneficiarie.answer', ['answers' => $storedAnswers, 'answersById' => $answerById]);

		//dd($storedAnswers);
	}

	//muestra todas las respuestas ingresadas a un formulario
	//$id identificador del formulario
	public function useFormAnswers($id)
	{
		$answerById = null;
		$answers = InclusiveAnswer::where('id_formulario', $id)->groupBy('id_requerimiento')->pluck('id_requerimiento');
		foreach ($answers as $answer) {
			$answerById[$answer] = InclusiveAnswer::where('id_requerimiento', $answer)->get();
		}
		//dd($answerById);

		$storedAnswers = InclusiveAnswer::where('id_formulario', $id)->groupBy('id_requerimiento')->get();
		/*		foreach($storedAnswers as $storeAnswer)
			dd($storeAnswer->question->question->nombre);//pregunta nombre
			dd($storeAnswer->question->question->pregunta);//pregunta pregunta*/
		return view('inclusive.forms.answersUse', ['answers' => $storedAnswers, 'answersById' => $answerById]);

		//dd($storedAnswers);
	}


	//guarda el adjunto
	//$attachment documento adjunto $id_type tipo de adjunto $id_form identificador de formulario $id_request identificador unico de respuesta
	public function fileStore($attachment, $id_type, $id_form, $id_request)
	{
//dd($attachment, $id_type, $id_form, $id_request,$attachment->getClientOriginalName());

		if ($id_type == '3') {
			$imageName = 'Adjunto_' . $id_form . time() . 'ID' . $id_request .$attachment->getClientOriginalName(). '.' . $attachment->getClientOriginalExtension();
			$path = $attachment->move(public_path('images/' . $id_form), $imageName);
			$image = new InclusiveDocument;
			$image->nombre = $imageName;
			$image->tipo = $id_type;
			$image->route = $path->getRealPath();
			$image->save();
			return $image->id;
		}
	}



	//mostrar respuestas realizadas en el formulario
	public function personalizedFormAnswers($id, $perPage = 10, $page = 1)
	{
				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>3||is_null($type)){
						Auth::logout();
						return view('welcome');
					}


		$answerById = null;
		$answers = InclusiveAnswer::where('id_formulario', $id)->groupBy('id_requerimiento')->pluck('id_requerimiento');
		foreach ($answers as $answer) {
			$answerById[$answer] = InclusiveAnswer::where('id_requerimiento', $answer)->get();
		}



		$storedAnswers = InclusiveAnswer::where('id_formulario', $id)->groupBy('id_requerimiento')->get();

if($answerById==null)
return redirect()->back()->withErrors(["Sin respuestas en el formulario"]);
		//paginador se le entrega el arreglo que hay que pagina, cuantos por pagina y la pagina
		$answerById_paginate = $this->paginate($answerById, $perPage, $page, $options = []);
		//obtener la ultima pagina
		if (count($answerById) > $perPage)
			$lastPage = count($answerById) / $perPage;
		else
			$lastPage = 1;

		$search = 0;

		return view('inclusive.forms.responses', ['search' => $search, 'lastPage' => ceil($lastPage), 'page' => $page, 'perPage' => $perPage, 'id' => $id, 'page' => $page, 'answerById_paginate' => $answerById_paginate, 'answers' => $storedAnswers]);
	}

	//funcion que busca por rut entre los resultados
	public function personalizedFormAnswersSearch(Request $request){

				//validar usuario
				$type= Auth::user()->type_id;
				if( $type>3||is_null($type)){
						Auth::logout();
						return view('welcome');
					}

		$id= $request->id;
		$perPage=100;
		$page = 1;
		$answerById=null;
		$answers = InclusiveAnswer::where('rut_persona', $request->Search)->where('id_formulario', $id)->groupBy('id_requerimiento')->pluck('id_requerimiento');
		foreach($answers as $answer){
			$answerById[$answer]=InclusiveAnswer::where('rut_persona', $request->Search)->where('id_requerimiento', $answer)->get();
		}
		
	
		$storedAnswers = InclusiveAnswer::where('rut_persona', $request->Search)->where('id_formulario', $id)->groupBy('id_requerimiento')->get();
		
		//no se contraron resultados
		if(count($storedAnswers)==0){
			$search='-1';
			$lastPage=0;
			$answerById_paginate=0;
			return view('inclusive.forms.responses',['search'=>$search, 'lastPage'=>ceil($lastPage),'page'=>$page,'perPage'=>$perPage,'id'=>$id,'page'=>$page,'answerById_paginate'=>$answerById_paginate, 'answers' => $storedAnswers]);
		}
		
	
		if($answerById==null)
		return redirect()->back()->withErrors(["Sin respuestas en el formulario"]);
		//paginador se le entrega el arreglo que hay que pagina, cuantos por pagina y la pagina
		$answerById_paginate= $this->paginate($answerById,$perPage, $page, $options = []);
		//obtener la ultima pagina
		if(count($answerById)>$perPage)
			$lastPage=count($answerById)/$perPage;
		else
			$lastPage=1;
	
			
	
			$search=1;
			
		//'answersById'=>$answerById
		return view('inclusive.forms.responses',['search'=>$search, 'lastPage'=>ceil($lastPage),'page'=>$page,'perPage'=>$perPage,'id'=>$id,'page'=>$page,'answerById_paginate'=>$answerById_paginate, 'answers' => $storedAnswers]);
	}


		//obrtener fecha inicial y final de una semana
function get_dates($year = 0, $week = 0)
{
    // Se crea objeto DateTime del 1/enero del año ingresado
    $fecha = DateTime::createFromFormat('Y-m-d', $year . '-1-2');
    $w = $fecha->format('W'); // Número de la semana
    // Se agrega semanas hasta igualar
    while ($week >= $w) {
        $fecha->add(DateInterval::createfromdatestring('+1 week'));
        $w = $fecha->format('W');
    }
    // Ahora $fecha pertenece a la semana buscada
    // Se debe obtener el primer y el último día

    // Si $fecha no es el primer día de la semana, se restan días
    if ($fecha->format('N') > 1) {
        $format = '-' . ($fecha->format('N') - 1) . ' day';
        $fecha->add(DateInterval::createfromdatestring($format));
    }
    // Ahora $fecha es el primer día de esa semana

    // Se clona la fecha en $fecha2 y se le agrega 6 días
    $fecha2 = clone($fecha);
    $fecha2->add(DateInterval::createfromdatestring('+6 day'));

    // Devuelve un array con ambas fechas
    return [$fecha, $fecha2];   
}


	//obtener reporte de respuestas por fecha
	public function answersByDate($id){
			
        //$semanas= strtotime(date("W"));
		$year= date("Y");
		$semana_actual= date("W");
		for($i=0;$i<=$semana_actual;$i++){
		$semanas[$i] = $this->get_dates($year,$i );	
		}
		//foreach($semanas as $semana)
		//dd($semana[0]->format('D d/m/Y') ,$semana[1]->format('D d/m/Y')
		return view('inclusive.forms.reportByDate',['id'=>$id,'semanas'=>$semanas]);

	}

	//funcion encargada de paginar los resultados, $item = componentes a pagunas; $perPAge, cuantos elementos por pagina,
	//$page pagina inicial
	public function paginate($items, $perPage = 15, $page = 0, $options = [])
	{
		//crear indices 
		$i = 0;
		foreach ($items as $key => $value) {

			$item = $value;
			$order_item[$i][$key] = $item;
			$i++;
		}



		//ultimo valor que cargar en la pagina
		if ($page <= 0)
			$page = $perPage;
		else
			$page = $page * $perPage;
		//cargar items en pagina
		if ($i < $page) {
			$page = $i;
			//dd('aqui');
		}
		if ($i <= $perPage) {
			$perPage = $i;
		}
		//cargar elementos en la pagina tomando el ultimo valor menos el tamaño de la pagina
		for ($j = ($page - $perPage); $j < $page; $j++) {


			$forPage[] = $order_item[$j];
		}

		return $forPage;
	}


	 //funcion que encolará mails para ser enviados
	 public function sendMailToTeam($receiver,$id_program, $mail, $observation, $id_requirement)
	 {
 
	 //enviar mail  a usuarios relacionados con el  programa
 
	 $objDemo = new \stdClass();
	 $objDemo->program =$id_program;
	 $objDemo->demo_one = $observation;
	 $objDemo->requirement_id = $id_requirement;
	 $objDemo->derivator_name = "Plataforma DECOM";
	 $objDemo->responsable = "Envio de mail DECOM";
	 $objDemo->demo_two = "Complementar información";
	 $objDemo->receiver = $receiver;
	 $objDemo->sender = 'Plataforma de Postulaciones Decom';
  
	  Mail::to($mail)->send(new FormSendMail($objDemo));
//	 \Log::channel('decomlog')->info(json_encode($objDemo));
 

	 }

public function optionsForm(){

	return view('inclusive.beneficiarie.index');
}

//funcion que busca por rut entre los resultados
public function beneficirieStatus($rut){
	
	
		//validar usuario
		/*$type= Auth::user()->type_id;
		if( $type>3||is_null($type)){
				Auth::logout();
				return view('welcome');
			}*/

			$persona=User::where('id',Auth::user()->id)->first(['name','lastname','rut']);
			
$answers = InclusiveAnswer::where('rut_persona', $rut)->orWhere('id_persona',Auth::user()->id)->where('state_id','2')->orWhere('state_id',NULL)->groupBy('id_requerimiento')->pluck('id_requerimiento');

foreach($answers as $answer){
	$answerById[$answer]=InclusiveAnswer::where('rut_persona', $rut)->orWhere('id_persona',Auth::user()->id)->where('state_id','2')->orWhere('state_id',NULL)->where('id_requerimiento', $answer)->get();
}

if(!isset($answerById))
	return redirect()->back()->withErrors('No hay registros en el formulario con respuestas validas');

$storedAnswers = InclusiveAnswer::where('rut_persona', $rut)->orWhere('id_persona',Auth::user()->id)->get();

//foreach($answerById as $answer)
	//dd($answers);
//dd(key($answerById),$storedAnswers);
//dd($storedAnswers);
//'answersById'=>$answerById
return view('inclusive.beneficiarie.status',['answersId'=> $answers,'persona'=>$persona,'answerById'=>$answerById, 'answers' => $storedAnswers]);
}

//funcion que busca por rut entre los resultados //cargar con rut de la persoan logeada
public function beneficirieStatusSearch(Request $request){
	

	//validar usuario
	/*$type= Auth::user()->type_id;
	if( $type>3||is_null($type)){
			Auth::logout();
			return view('welcome');
		}*/

$id= $request->id;
$perPage=100;
$page = 1;
$answerById=null;
$answers = InclusiveAnswer::where('rut_persona', $request->Search)->groupBy('id_requerimiento')->pluck('id_requerimiento');
foreach($answers as $answer){
$answerById[$answer]=InclusiveAnswer::where('rut_persona', $request->Search)->where('id_requerimiento', $answer)->get();
}


$storedAnswers = InclusiveAnswer::where('rut_persona', $request->Search)->groupBy('id_requerimiento')->get();

//no se contraron resultados
if(count($storedAnswers)==0){
$search='-1';
$lastPage=0;
$answerById_paginate=0;
return view('inclusive.forms.responses',['search'=>$search, 'lastPage'=>ceil($lastPage),'page'=>$page,'perPage'=>$perPage,'id'=>$id,'page'=>$page,'answerById_paginate'=>$answerById_paginate, 'answers' => $storedAnswers]);
}



//paginador se le entrega el arreglo que hay que pagina, cuantos por pagina y la pagina
$answerById_paginate= $this->paginate($answerById,$perPage, $page, $options = []);
//obtener la ultima pagina
if(count($answerById)>$perPage)
$lastPage=count($answerById)/$perPage;
else
$lastPage=1;



$search=1;

//'answersById'=>$answerById
return view('inclusive.beneficiarie.status',['search'=>$search, 'lastPage'=>ceil($lastPage),'page'=>$page,'perPage'=>$perPage,'id'=>$id,'page'=>$page,'answerById_paginate'=>$answerById_paginate, 'answers' => $storedAnswers]);
}

//Evaluar beneficiario en postulacion
public function evaluationList($id_persona, $id_form){
$found =0;
//dd($id_persona, $id_form);
	//verificar que se encuentre activado
	$restrictions= InclusiveFormList::where('id_formulario',$id_form)->get();
//	return $restrictions;
 	foreach($restrictions as $restriction){
		//dd($restrictions,$restriction);
		$list=null;
		$list=InclusiveRestrictionApplied::where('id_restriccion',$restriction->id_lista)->where('id_persona',$id_persona)->where('id_status','1')->first();
		if($list!=null&&$restriction->id_tipo==1){
			if($found ==2)
				return 3;
			//encontrado en lista requerida
			$found =1;
		}
		if($list!=null&&$restriction->id_tipo==2){
			//encontrado en lista restringida
			if($found ==1)
				return 3;
			$found =2;
		}
	}
	return $found;
}


}
