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

Route::get('/', function()
{
	return View::make('hello');
});


Route::resource('controllers', 'ControllersController');

Route::resource('controllertrainings', 'ControllertrainingsController');

Route::resource('controllergroups', 'ControllergroupsController');

Route::resource('controllerexams', 'ControllerexamsController');

Route::resource('airportrunways', 'AirportrunwaysController');

Route::resource('airportroutes', 'AirportroutesController');

Route::resource('airportgeos', 'AirportgeosController');

Route::resource('airportfrequencies', 'AirportfrequenciesController');

Route::resource('airportcharts', 'AirportchartsController');

Route::resource('pokercards', 'PokercardsController');

Route::resource('pilotfeedbacks', 'PilotfeedbacksController');