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
//these still need filters in front of them
Route::get('staff', 'AdminController@getAdminIndex');
Route::get('staff/training', 'AdminController@getTrainingIndex');
Route::get('staff/exams/review/{eid}', 'ControllerExamsController@getStaffReview');

Route::get('staff/roster', 'AdminController@getRosterIndex');
Route::get('staff/roster/results', 'AdminController@getSearchResults');
Route::get('staff/u/{id}', 'AdminController@showUser');
Route::get('staff/{id}/edit', 'RosterController@getEditUser');
Route::post('staff/{id}/edit', 'RosterController@postEditUser');

Route::get('staff/roster/add-controller', 'RosterController@getAddController');
Route::post('staff/roster/add-controller', 'RosterController@postAddController');

Route::get('staff/cms', 'AdminController@getCmsIndex');
Route::get('staff/forum', 'AdminController@getForumIndex');
Route::get('staff/ts', 'AdminController@getTsIndex');
Route::get('staff/news', 'AdminController@getNewsIndex');

Route::get('staff/log', 'AdminController@getLog');

//ajax routes
Route::post('/e/request/{cid}/{eid}', array('uses' => 'AjaxController@requestExam'));
Route::post('/a/complete/{aid}', 'AjaxController@actionCompleted');
Route::post('/m/staff-welcome/{cid}', 'AjaxController@sendStaffWelcome');

//training sessions
Route::get('staff/training/{id}', 'TrainingController@showAdmin');
