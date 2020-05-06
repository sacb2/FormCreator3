<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InclusiveQuestion;
use App\InclusiveMultipleAnswer;
use App\InclusiveQuestionMultipleAnswer;
use App\InclusiveForm;
use App\InclusiveFormQuestion;
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
	public function listQuestions()
	{
		$questions = InclusiveQuestion::paginate(10);
		return view('inclusive.forms.questionsList', ['questions' => $questions]);
	}
	//ver y editar pregunta 
	//$id identificador de la pregunta
	public function viewQuestions($id)
	{

		$question = InclusiveQuestion::find($id);
		return view('inclusive.forms.questionsView', ['question' => $question]);
	}
	//actualizar pregunta
	//$request datos nuevos a actualizar
	public function updateQuestions(Request $request)
	{

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

		return view('inclusive.forms.createAnswer');
	}

	//Guardar respuesta a seleccion multiple
	//$request datos relacionado con la respuesta posible
	public function storeAnswer(Request $request)
	{



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
		$answers = InclusiveMultipleAnswer::all();


		return view('inclusive.forms.answersList', ['answers' => $answers]);
	}

	//vista de edición respuestas que pueden utilizadas en respuestas multiples
	//$id identificador de la respuesta
	public function  viewAnswers($id)
	{

		$answer = InclusiveMultipleAnswer::find($id);

		//dd($department);
		return view('inclusive.forms.answersView', ['answer' => $answer]);
	}


	//funcion que actualiza los datos de una respuesta que puede ser seleccionada en preguntas multiples
	//$request contiene la informacion de la actualización y el id de la respuesta
	public function updateAnswers(Request $request)
	{

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
		$pregunta = InclusiveQuestion::find($id);
		$respuestas = InclusiveMultipleAnswer::where('estado', '1')->get();
		return view('inclusive.forms.answersQuestionRelation', ['pregunta' => $pregunta, 'respuestas' => $respuestas]);
	}

	//guardar selección de respuestas a preguntas multiples
	//$request en donde viene el id de la pregunta y un arreglo pickedDep con los id de respuestas seleccionadas
	public function answersQuestionStore(Request $request)
	{

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

		return view('inclusive.forms.formsCreate');
	}


	//Funcion que guarda  formularios
	//$request  contiene la informacion relacionada con el formuarop
	public function storeForms(Request $request)
	{

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
		$forms = InclusiveForm::paginate(10);


		return view('inclusive.forms.formsList', ['forms' => $forms]);
	}

	//mostrar formulario y datos de edición
	//$id identificado de formulario
	public function viewForms($id)
	{

		$form = InclusiveForm::find($id);
		return view('inclusive.forms.formsView', ['form' => $form]);
	}

	//Actualizar información de formularios
	//$request información de actualización del formularios
	public function updateForms(Request $request)
	{


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

		$form = InclusiveForm::find($id);
		//estado activos
		$questions = InclusiveQuestion::where('estado', '1')->get();
		return view('inclusive.forms.questionsFormRelation', ['form' => $form, 'questions' => $questions]);
	}


	//funcion que guarda la relaciona entre las preguntas y los formularios
	//$request información de los formularios y  en el arreglo pickedDep[] id de preguntas seleccionadas 
	public function questionsFormStore(Request $request)
	{
		//dd($request);
		//validar formulario



		//Si el formulario ya se encontraba en creado dentro de la relacion entre formulario y pregunta

		$formQuestions = InclusiveFormQuestion::where('id_formulario', $request->id_form)->get();



		if ($formQuestions->isempty()) {


			if (isset($request->pickedDep))
				foreach ($request->pickedDep as $product) {


					//Crear objeto
					$newFormQuestions = new InclusiveFormQuestion;
					$newFormQuestions->id_formulario = $request->id_form;
					$newFormQuestions->id_pregunta = $product;
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
		} else //con productos
		{
			if (isset($request->pickedDep)) {
				//activar y crear los productos seleccionados
				foreach ($request->pickedDep as $product) {
					$newFormQuestions = InclusiveFormQuestion::where('id_formulario', $request->id_form)->where('id_pregunta', $product)->first();
					if (!isset($newFormQuestions)) {


						$newFormQuestions = new InclusiveFormQuestion;
						$newFormQuestions->id_formulario = $request->id_form;
						$newFormQuestions->id_pregunta = $product;
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
}
