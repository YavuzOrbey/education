<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('questions', 'QuestionController@apiIndex');
Route::get('questions/{subject}', 'QuestionController@apiIndex');
Route::get('quizzes/{quiz}', 'QuizController@getQuiz');
Route::get('subjects', 'SubjectController@index');
Route::get('content/{content}', 'QuestionController@apiContent');
Route::get('assignments/{assignment}', 'AssignmentController@all')->name('assignments.all');
Route::get('groupassignments', 'GroupController@assignments');
Route::get('groupassignments/{group}', 'GroupAssignmentController@getAssignments');