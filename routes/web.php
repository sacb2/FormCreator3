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







