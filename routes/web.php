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

Route::get('/', function() {

  return view('welcome');
});

Route::resource('projects', 'ProjectsController');


/*
Apperantly theres a one liner that gives us all this


Route::get('/projects', 'ProjectsController@index');
Route::get('/projects/create', 'ProjectsController@create');
//the following line contains a wildcard {project} that can be anything
Route::get('/project/{project}', 'ProjectsController@show');
//saves input from form
Route::post('/projects', 'ProjectsController@store');
Route::get('/projects/{project}/edit', 'ProjectsController@edit');
Route::get('/project/{project}', 'ProjectsController@update');
Route::get('/project/{project}', 'ProjectsController@destroy');
*/

Route::post('/projects/{project}/tasks', 'ProjectTasksController@store');
//Route::patch('/tasks/{task}', 'ProjectTasksController@update');
Route::post('/completed-tasks/{task}', 'CompletedTasksController@store');
Route::delete('/completed-tasks/{task}', 'CompletedTasksController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
