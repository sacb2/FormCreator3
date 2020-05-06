<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'HomeController@logout')->name('logout');

//Preguntas
Route::get('/CreateQuestions', 'InclusiveFormController@createQuestion')->name('CreateQuestion');
Route::post('/StoreQuestions', 'InclusiveFormController@storeQuestion')->name('StoreQuestion');
Route::get('/ListQuestions', 'InclusiveFormController@listQuestions')->name('ListQuestions');
Route::get('/ViewQuestions/{id}', 'InclusiveFormController@viewQuestions')->name('ViewQuestions');
Route::post('/UpdateQuestions', 'InclusiveFormController@updateQuestions')->name('UpdateQuestions');

//Respuestas
Route::get('/CreateAnswers', 'InclusiveFormController@createAnswer')->name('CreateAnswer');
Route::post('/StoreAnswers', 'InclusiveFormController@storeAnswer')->name('StoreAnswer');
Route::get('/ListAnswers', 'InclusiveFormController@listAnswers')->name('ListAnswers');
Route::get('/ViewAnswers/{id}', 'InclusiveFormController@viewAnswers')->name('ViewAnswers');
Route::post('/UpdateAnswers', 'InclusiveFormController@updateAnswers')->name('UpdateAnswers');

//Relacion entre Preguntas con selección multiple y respuestas
Route::get('/AnswersQuestionRelation/{id}', 'InclusiveFormController@answersQuestionRelation')->name('AnswersQuestionRelation');
Route::post('/AnswersQuestionStore', 'InclusiveFormController@answersQuestionStore')->name('AnswersQuestionStore');

//Formularios
Route::get('/CreateForms', 'InclusiveFormController@createForms')->name('CreateForms');
Route::post('/StoreForms', 'InclusiveFormController@storeForms')->name('StoreForms');
Route::get('/ListForms', 'InclusiveFormController@listForms')->name('ListForms');
Route::post('/UpdateForms', 'InclusiveFormController@updateForms')->name('UpdateForms');
Route::get('/ViewForms/{id}', 'InclusiveFormController@viewForms')->name('ViewForms');

//Relacion entre preguntas y fromularios
Route::get('/QuestionsFormRelation/{id}', 'InclusiveFormController@questionsFormRelation')->name('QuestionsFormRelation');
Route::post('/QuestionsFormStore', 'InclusiveFormController@questionsFormStore')->name('QuestionsFormStore');








