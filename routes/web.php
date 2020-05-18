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

/*
|
|----------------------------------------------------------------------------
| Cambio de Idiomas para Todos los Usuarios
|----------------------------------------------------------------------------
|
*/
Route::group(['middleware' => ['web']], function () {

    //Route::get('/', function () { return view('welcome');});
    
    Auth::routes();
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    //Route::get('/register', 'HomeController@register')->name('register');
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
    
    
    //opciones de visualización y respuesta de formularios
    Route::get('/SelectForms', 'InclusiveFormController@selectForms')->name('SelectForms');
    Route::get('/PersonalizedFormView/{id}', 'InclusiveFormController@useForm')->name('PersonalizedFormView');
    Route::post('/AnswerFormUseStore', 'InclusiveFormController@answerFormUseStore')->name('AnswerFormUseStore');
    Route::get('/UseFormAnswers/{id}', 'InclusiveFormController@useFormAnswers')->name('UseFormAnswers');
                            
    
    //Creación de Usuarios registrados en la plataforma
    Route::get('/NewUser', 'NewUserController@createuser')->name('NewUser');
    Route::post('/StoreNewUser', 'NewUserController@stornewuser')->name('StoreNewUser');
    Route::get('/ListNewUser', 'NewUserController@listnewuser')->name('ListNewUser'); 
    Route::get('/EditNewUser/{id}', 'NewUserController@editnewuser')->name('EditNewUser'); 
    Route::get('/ChangeStatusUser/{estado}/{id}', 'NewUserController@changestatususer')->name('ChangeStatusUser'); 
    Route::post('/EditUniqueNewUser', 'NewUserController@edituniqueuser')->name('EditUniqueNewUser');
    Route::get('/EditUniqueNewUserInd', 'NewUserController@edituniqueuserind')->name('EditUniqueNewUserInd');




    //Cambio de Idiomas con sesiones
    Route::get('lang/{lang}', function ($lang) {
        session(['lang' => $lang]);
        return \Redirect::back();
    })->where([
        'lang' => 'en|es'
    ]);

});















