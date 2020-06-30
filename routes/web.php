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

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'HomeController@logout')->name('logout');
Route::post('LoginStyle', 'HomeController@loginStyle')->name('LoginStyle');
Route::post('RegisterStyle', 'HomeController@registerStyle')->name('RegisterStyle');

//Preguntas
Route::get('/CreateQuestions', 'InclusiveFormController@createQuestion')->name('CreateQuestion');
Route::post('/StoreQuestions', 'InclusiveFormController@storeQuestion')->name('StoreQuestion');
Route::get('/ListQuestions', 'InclusiveFormController@listQuestions')->name('ListQuestions');
Route::get('/ViewQuestions/{id}', 'InclusiveFormController@viewQuestions')->name('ViewQuestions');
Route::post('/UpdateQuestions', 'InclusiveFormController@updateQuestions')->name('UpdateQuestions');

//RespuestasListAnswers
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


//opciones de visualización y respuesta de formularios
Route::get('/SelectForms', 'InclusiveFormController@selectForms')->name('SelectForms');
Route::get('/PersonalizedFormView/{id}', 'InclusiveFormController@useForm')->name('PersonalizedFormView');
Route::post('/AnswerFormUseStore', 'InclusiveFormController@answerFormUseStore')->name('AnswerFormUseStore');
Route::get('/UseFormAnswers/{id}', 'InclusiveFormController@useFormAnswers')->name('UseFormAnswers');
Route::get('/AnswersByDate/{id}', 'InclusiveFormController@answersByDate')->name('AnswersByDate');
Route::post('requestsExportAnswers','ExportsController@requestsExportAnswers')->name('requestExportGenerateAnswers')->middleware('auth');

//Respuesta
Route::get('/PersonalizedFormAnswer/{id}', 'InclusiveFormController@personalizedFormAnswers')->name('personalizedFormAnswers');
Route::get('/PersonalizedFormAnswerPage/{id}/{perPage}/{page}', 'InclusiveFormController@personalizedFormAnswers')->name('personalizedFormAnswersPage');
Route::post('/PersonalizedFormAnswerSearch', 'InclusiveFormController@personalizedFormAnswersSearch')->name('personalizedFormAnswersSearch');


//Route::get('/home', 'InclusiveFormController@selectForms')->name('home');
//Route::get('/home', 'InclusiveFormController@beneficiarieIndex')->name('home');

//beneficiarie
Route::get('/BeneficiarieIndex', 'InclusiveFormController@beneficiarieIndex')->name('BeneficiarieIndex');
Route::get('/UseFormBeneficiarie/{id}', 'InclusiveFormController@useFormBeneficiarie')->name('UseFormBeneficiarie');

Route::get('/home/', 'InclusiveFormController@beneficiarieIndex')->name('home')->middleware('auth');
Route::post('/home/', 'InclusiveFormController@beneficiarieIndexPost')->name('home')->middleware('auth');

Route::get('/BeneficiarieIndexStyle/{style}', 'InclusiveFormController@beneficiarieIndexStyle')->name('BeneficiarieIndexStyle');
Route::get('/UseFormBeneficiarieStyle/{id}/{style}', 'InclusiveFormController@useFormBeneficiarieStyle')->name('UseFormBeneficiarieStyle');
Route::get('/home/{style}', 'InclusiveFormController@beneficiarieIndex')->name('home');
Route::post('/beneficiarieIndexPost', 'InclusiveFormController@beneficiarieIndexPost')->name('beneficiarieIndexPost');
Route::post('/UseFormBeneficiariePost', 'InclusiveFormController@useFormBeneficiariePost')->name('UseFormBeneficiariePost');

//creación de profesionales

Route::post('webStoreUsers', 'HomeController@storeUsers')->name('webStoreUsers')->middleware('auth');
Route::get('/ContactCreateUser', 'HomeController@createUser')->name('ContactCreateUser');
Route::get('/ContactListUser', 'HomeController@listUser')->name('ContactListUser');
Route::get('/userView/{id}', 'HomeController@userView')->name('UserView');
Route::post('/updateUsers', 'HomeController@updateUsers')->name('updateUsers');
Route::get('/userCreate', 'HomeController@createUser')->name('UserCreate');
Route::post('/storeUsers', 'HomeController@storeUsers')->name('storeUsers');






						







