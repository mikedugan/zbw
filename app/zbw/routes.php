<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
View::share('me', Auth::user());

//login and logout
Route::get('login', 'SessionsController@getLogin');
Route::post('login', 'SessionsController@postLogin');
Route::get('logout', 'SessionsController@getLogout');
Route::controller('password', 'RemindersController');

//the main 3 pages
Route::get('/', array('as' => 'home', 'uses' => 'ZbwController@getIndex'));
Route::get('pilots', 'ZbwController@getPilotIndex');
Route::get('controllers', 'ZbwController@getControllerIndex');

//other top-levels
Route::get('forum', 'ForumController@getIndex');
Route::get('staff', 'StaffController@getIndex');
Route::get('training', 'TrainingController@getIndex');

//admin and staff routes
Route::get('admin', 'AdminController@getAdminIndex');
Route::get('admin/training', 'AdminController@getTrainingIndex');

/*Route::resource('controllers', 'ControllersController');

Route::resource('controllertrainings', 'ControllertrainingsController');

Route::resource('controllergroups', 'ControllergroupsController');

Route::resource('controllerexams', 'ControllerexamsController');

Route::resource('airportrunways', 'AirportrunwaysController');

Route::resource('airportroutes', 'AirportroutesController');

Route::resource('airportgeos', 'AirportgeosController');

Route::resource('airportfrequencies', 'AirportfrequenciesController');

Route::resource('airportcharts', 'AirportchartsController');

Route::resource('pokercards', 'PokercardsController');

Route::resource('pilotfeedbacks', 'PilotfeedbacksController');*/
