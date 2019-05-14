<?php

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
Route::get('/math', function () {
    return view('math');
});
//Route::view('/{path?}', 'app');
Route::get("/", function(){
    return view('main');
});

Route::resources([
    'assignments' =>'AssignmentController',
    'questions' =>'QuestionController',
    'book_questions'=>'BookQuestionController'
    ]);


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
