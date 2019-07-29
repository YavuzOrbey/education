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
Route::view('/exercises', 'app'); //{path?}

Route::group(['prefix'=>'admin', 'middleware'=>['role:administrator']], function(){
    Route::get("/", 'AdminController@index');
    Route::get("/dashboard", 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('assignments/insert', 'AssignmentController@insert')->name('assignments.insert');
    Route::resource("/users", 'UserController');
    Route::resource("/permissions", 'PermissionController');
    Route::resource("/roles", 'RoleController')->except('destroy');
});
Route::resources([
    'questions' =>'QuestionController',
    'book_questions'=>'BookQuestionController'
], ['middleware'=>'auth']);
Route::view('/questions/create', 'app')->name('questions.create');
Route::resource('assignments','AssignmentController');
Route::prefix('assignments')->group(function(){
Route::post('/confirm', 'AssignmentController@confirm')->name('assignments.confirm');
Route::post('/process', 'AssignmentController@process')->name('assignments.process');

Route::get('/results/{assignment}', 'AssignmentController@results')->name('assignments.results');
});

Auth::routes();
Route::get('/', function(){
    return view('home');
});
Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});
Route::get('/home', 'HomeController@index')->name('home');
