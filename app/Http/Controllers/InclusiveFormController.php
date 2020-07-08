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

		//Crear objeto
		$question = new InclusiveQuestion;
		$question->nombre = $request->name;
		$question->pregunta = $request->question;
		$question->estado = $request->state;
		$question->tipo = $request->type;
		$question->orden = $request->orden;
		$question->size= $request->size;
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
	public function  viewAnswers($id)
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

		//dd($request);
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
			Session::flash('message', "Pregunta actualizada exitosamente");
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
					//	dd($respuestaDatos);
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
				}
		} else //conrespuestas relacionadas
		{
			foreach ($request->pickedDep as $respuesta) {
				$respuestaGuardada = InclusiveQuestionMultipleAnswer::where('id_pregunta', $request->id)->where('id_respuesta', $respuesta)->first();
				if (!isset($respuestaGuardada)) {

					$respuestaDatos = InclusiveMultipleAnswer::where('id', $respuesta)->first();
					//	dd($respuestaDatos);
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
		$form->qanswer = $request->qanswer;
		try {
			$form->save();
			Session::flash('alertSent', 'Derived');
			Session::flash('message', "Formulario creado" . $form->nombre . " exitosamente");
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
						$newFormQuestions->orden = $pregunta->orden;
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

					//Session::flash('alertSent', 'Derived');
					//Session::flash('message', "Departamento creado" .$department->nombre." exitosamente" );
				} catch (\Exception $e) {
					// do task when error
					Session::flash('alert', 'error');
					echo $e->getMessage();   // insert query

				}
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
	public function beneficiarieIndex($style=null)
	{
		
		
		$forms = InclusiveForm::all();
		//$style=1;
	
		return view('inclusive.beneficiarie.list', ['style'=>$style,'forms' => $forms]);
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

		//dd($request);
		$formulario = InclusiveForm::find($request->id);
		
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
		
		return view('inclusive.beneficiarie.answer', ['style_color'=>$request->style_color,'style_font'=>$request->style_font,'formulario' => $formulario]);
	}

	//Visualización de formulario personalizado creado y respuestas 
	//$id identificador de formulario
	public function useFormBeneficiarie($id)
	{
		$formulario = InclusiveForm::find($id);
		//		dd($formulario->products);
		return view('inclusive.beneficiarie.answer', ['formulario' => $formulario]);
	}


	//guardar respuestas en el caso de responder un formulario personalizado
	//$request si el formlario fue creado con utilizacion de RUT de otra forma solo las respuesta
	public function AnswerFormUseStore(Request $request)
	{
			

		

		$imageName = "imagen";
		$path = request()->answers_img;
		//	dd($request,$path);
		//	\Log::channel('decomlog')->info($request);
		//si requiere rut
		if ($request->type_form == '1') {
			

			$validate_response = $request->validate([
				'rut' => ['required', 'regex:/^[0-9]+[-|‐]{1}[0-9kK]{1}$/'],
			]);

			$formsq= InclusiveAnswer::where('id_formulario',$request->id_form)->where('rut_persona',$request->rut)->distinct('id_requerimiento')->count('id_requerimiento');
			$form=InclusiveForm::find($request->id_form);
				
			
			
			if((int)$form->qanswer<(int)$formsq && $form->qanswer!='0'){
			
				Session::flash('alertSent', 'Alert');
				Session::flash('message', 'RUT ' . $request->rut . ' Ha respondido '.$formsq.' veces');
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
		if (isset($request->answers_img))


			foreach ($request->answers_img as $key => $value) {


				$img_id = $this->fileStore($value, '3', $request->id_form, $id);
				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->valor_respuesta = $img_id;
				$storeAnswer->tipo = '3';
				if ($request->type_form = 1)
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
				if ($request->type_form = 1)
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
		if (isset($request->answers_int))
			foreach ($request->answers_int as $key => $value) {


				$storeAnswer = new InclusiveAnswer;
				$storeAnswer->id_pregunta = $key;
				$storeAnswer->id_formulario = $request->id_form;
				$storeAnswer->id_requerimiento = $id;
				if(Auth::user())
				$storeAnswer->id_persona=Auth::user()->id;
				$storeAnswer->valor_respuesta = $value;
				$storeAnswer->tipo = '0';
				if ($request->type_form = 1)
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

			Session::flash('alertSent', 'Alert');
			Session::flash('message', "Formulario respondido exitosamente con ID: ".$id);
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


		if ($id_type == 3) {
			$imageName = 'Adjunto_' . $id_form . time() . 'ID' . $id_request . '.' . $attachment->getClientOriginalExtension();
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
}
