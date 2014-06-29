<?php

//auth routes
Route::get('login', 'SessionsController@oauthLogin');
Route::post('login', 'SessionsController@postLogin');
Route::get('auth', 'SessionsController@oauthLogin');
Route::get('logout', 'SessionsController@getLogout');
Route::controller('password', 'RemindersController');
Route::controller('forums', 'ForumsController');


//top level pages
Route::get('/', array('as' => 'home', 'uses' => 'ZbwController@getIndex'));
Route::get('pilots', 'ZbwController@getPilotIndex');
Route::get('controllers', 'ZbwController@getControllerIndex');
Route::get('forum', 'ForumController@getIndex');
Route::get('training', 'TrainingController@getIndex');
Route::get('controllers/{id}', 'ControllersController@getController');
Route::get('news/{id}', 'NewsController@show');
Route::get('pages/p/{id}', 'PagesController@getPage');
