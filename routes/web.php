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

Route::get('/index', function () {
    return view('welcome_generic');
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
Route::post('/AnswerFormUseStoreGroup', 'InclusiveFormController@answerFormUseStoreGroup')->name('AnswerFormUseStoreGroup');
Route::post('/AwesomerAnswersStoreGroup', 'InclusiveFormController@awesomerAnswersStoreGroup')->name('AwesomerAnswersStoreGroup');
Route::post('/ConfirmAnswersStoreGroup', 'InclusiveFormController@confirmAnswersStoreGroup')->name('ConfirmAnswersStoreGroup');

//Seleccion de Opciones
Route::get('/OptionsForm', 'InclusiveFormController@optionsForm')->name('OptionsForm');

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
Route::post('/BeneficiarieIndex', 'InclusiveFormController@beneficiarieIndex')->name('BeneficiarieIndex');

Route::get('/UseFormBeneficiarie/{id}', 'InclusiveFormController@useFormBeneficiarie')->name('UseFormBeneficiarie');

Route::get('/home/', 'InclusiveFormController@beneficiarieIndex')->name('home')->middleware('auth');
Route::post('/home/', 'InclusiveFormController@beneficiarieIndexPost')->name('home')->middleware('auth');

Route::get('/BeneficiarieIndexStyle/{style}', 'InclusiveFormController@beneficiarieIndexStyle')->name('BeneficiarieIndexStyle');
Route::get('/UseFormBeneficiarieStyle/{id}/{style}', 'InclusiveFormController@useFormBeneficiarieStyle')->name('UseFormBeneficiarieStyle');
Route::get('/home/{style}', 'InclusiveFormController@beneficiarieIndex')->name('home');
Route::post('/beneficiarieIndexPost', 'InclusiveFormController@beneficiarieIndexPost')->name('beneficiarieIndexPost');
Route::post('/UseFormBeneficiariePost', 'InclusiveFormController@useFormBeneficiariePost')->name('UseFormBeneficiariePost');
Route::get('/UseFormBeneficiariePost', 'InclusiveFormController@useFormBeneficiariePost')->name('UseFormBeneficiariePost');

//OPTIONS
Route::get('/UseFormBeneficiariePost', 'InclusiveFormController@useFormBeneficiariePost')->name('UseFormBeneficiariePost');
Route::get('/OptionsForm', 'InclusiveFormController@optionsForm')->name('OptionsForm');
//STATUS
Route::get('/BeneficiarieStatus/{rut}', 'InclusiveFormController@beneficirieStatus')->name('BeneficiarieStatus');
Route::post('/BeneficiarieStatusSearch', 'InclusiveFormController@beneficirieStatusSearch')->name('BeneficiarieStatusSearch');

//creación de profesionales

Route::post('webStoreUsers', 'HomeController@storeUsers')->name('webStoreUsers')->middleware('auth');
Route::get('/ContactCreateUser', 'HomeController@createUser')->name('ContactCreateUser')->middleware('auth');
Route::get('/ContactListUser', 'HomeController@listUser')->name('ContactListUser')->middleware('auth');
Route::get('/userView/{id}', 'HomeController@userView')->name('UserView')->middleware('auth');
Route::post('/updateUsers', 'HomeController@updateUsers')->name('updateUsers')->middleware('auth');
Route::get('/userCreate', 'HomeController@createUser')->name('UserCreate')->middleware('auth');
Route::post('/storeUsers', 'HomeController@storeUsers')->name('storeUsers')->middleware('auth');

//Evaluación
Route::get('/Evaluations', 'EvaluationsController@evaluations')->name('Evaluations')->middleware('auth');
Route::get('/Rubrics', 'EvaluationsController@rubrics')->name('Rubrics')->middleware('auth');
Route::get('/RubricsForm/{form_id}', 'EvaluationsController@rubricsForm')->name('RubricsForm')->middleware('auth');
Route::post('/RubricsFormStore','EvaluationsController@rubricsFormStore')->name('RubricsFormStore')->middleware('auth');
Route::get('/FormStatus/{id}','EvaluationsController@formStatus')->name('FormStatus')->middleware('auth');
Route::get('/AutoEvaluateForm/{id}','EvaluationsController@autoEvaluateForm')->name('AutoEvaluateForm')->middleware('auth');
Route::post('/UpdateEvaluation','EvaluationsController@updateEvaluation')->name('UpdateEvaluation')->middleware('auth');

//Listas de evaluación
Route::get('/CreateRestrictionList','EvaluationsController@createRestrictionList')->name('CreateRestrictionList')->middleware('auth');
Route::get('/ViewEvaluationList','EvaluationsController@viewEvaluationList')->name('ViewEvaluationList')->middleware('auth');
Route::get('/ViewRestrictionList/{id}','EvaluationsController@viewRestrictionList')->name('ViewRestrictionList')->middleware('auth');
Route::post('/StoreRestrictionList','EvaluationsController@storeRestrictionList')->name('StoreRestrictionList')->middleware('auth');
Route::get('/ActivateRestriction/{id}','EvaluationsController@activateRestriction')->name('ActivateRestriction')->middleware('auth');
Route::get('/DeactivateRestriction/{id}','EvaluationsController@deactivateRestriction')->name('DeactivateRestriction')->middleware('auth');
Route::get('/ViewRestrictionFormsList/{id}','EvaluationsController@viewRestrictionFormsList')->name('ViewRestrictionFormsList')->middleware('auth');
Route::post('/StoreRestrictionFormsList','EvaluationsController@storeRestrictionFormsList')->name('StoreRestrictionFormsList')->middleware('auth');

//GetFormView
Route::get('/UseFormBeneficiarieRUT/{id}/{rut}/{fecha}', 'InclusiveFormController@useFormBeneficiarieRUT')->name('UseFormBeneficiarieRUT');
Route::get('/Success', function () {
    return view('welcome');
})->name('Success');
Route::get('/BeneficiarieStatus/{rut}', 'InclusiveFormController@beneficirieStatus')->name('BeneficiarieStatus');












						







