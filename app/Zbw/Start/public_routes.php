<?php

use Zbw\Http\Controllers\AirportsController;

//auth routes
Route::get('login',['as' => 'login', 'uses' => 'SessionsController@oauthLogin']);
Route::post('login',['as' => 'login', 'uses' => 'SessionsController@postLogin']);
Route::get('auth', ['as' => 'auth', 'uses' => 'SessionsController@oauthLogin']);
Route::get('logout',['as' => 'logout', 'uses' => 'SessionsController@getLogout']);


//top level pages
Route::get('/', ['as' => 'home', 'uses' => 'ZbwController@getIndex']);

Route::get('controllers/resources', ['as' => 'controllers.resources', 'uses' => 'StaticController@getControllersResources']);
Route::get('controllers/documents', ['as' => 'controllers.documents', 'uses' => 'StaticController@getDocumentLibrary']);
Route::get('controllers/beacon-codes', ['as' => 'controllers.beacon_codes', 'uses' => 'StaticController@getControllersBeaconCodes']);
Route::get('join', ['as' => 'join', 'uses' => 'ZbwController@getJoin']);
Route::get('visit', ['as' => 'visit', 'uses' => 'ZbwController@getVisit']);
Route::post('visit', ['as' => 'visit', 'uses' => 'ZbwController@postVisit']);
//used by staff contact on roster page
Route::post('contact', ['as' => 'contact', 'uses' => 'ZbwController@postContact']);

Route::get('statistics', ['as' => 'statistics', 'uses' => 'ZbwController@getStatistics']);

Route::get('tsviewer', ['as' => 'tsviewer', 'uses' => 'StaticController@getTsDisplay']);

//static pages for pilots
Route::get('pilots', ['as' => 'pilots', 'uses' => 'StaticController@getPilots']);
Route::get('pilots/getting-started', ['as' => 'pilots/getting-started','before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => 'StaticController@getPilotsGettingStarted']);
Route::get('pilots/airports', ['as' => 'pilots/airports', 'uses' => AirportsController::class.'@getIndex']);
Route::get('pilots/vfr-tutorial', ['as' => 'pilots/vfr-tutorial','before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => 'StaticController@getPilotsVfrTutorial']);
//static pages for controllers
Route::get('controllers/training-outline', ['as' => 'training-outline','before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => 'StaticController@getControllersTrainingOutline']);
Route::get('controllers/policies', ['as' => 'controllers/policies','before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => 'StaticController@getControllersPolicies']);
Route::get('controllers/policies/sign-on-off', ['as' => 'policies/sign-on-off','before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => 'StaticController@getControllersSignonPolicy']);
Route::get('controllers/policies/position-restrictions', ['as' => 'policies/position-restrictions','before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => 'StaticController@getControllersPositionRestrictions']);
Route::get('controllers/policies/visiting-transfer', ['as' => 'policies/visiting-transfer','before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => 'StaticController@getControllersVisitingTransfer']);
Route::get('controllers/policies/roster-removal', ['as' => 'policies/roster-removal','before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => 'StaticController@getControllersRosterRemoval']);

Route::get('pilots/news', ['as' => 'pilot-news', 'uses' => 'NewsController@getPilotNews']);
Route::get('controllers',['as' => 'controllers', 'uses' => 'ZbwController@getControllerIndex']);
Route::get('training',['as' => 'training', 'uses' => 'TrainingController@getIndex']);
Route::get('controllers/{id}',['as' => 'controllers/{id}', 'uses' => 'UsersController@getController']);
Route::get('roster/results',['roster/search', 'uses' => 'UsersController@getSearchResults']);
Route::get('news/{id}', ['as' => 'news/{id}', 'uses' => 'NewsController@show']);
Route::get('pages/p/{id}',['as' => 'p/{id}', 'uses' => 'PagesController@getPage']);

Route::get('traffic', ['as' => 'traffic', 'uses' => 'ZbwController@getFlights']);

Route::get('mochahagotdi', function() { return Redirect::route('feedback'); });
Route::get('feedback', ['as' => 'feedback', 'uses' => 'FeedbackController@getFeedback']);
Route::post('feedback', ['as' => 'feedback', 'uses' => 'FeedbackController@postFeedback']);
Route::post('feedback-all', ['as' => 'feedback-all', 'uses' => 'ZbwController@postFeedback']);
Route::post('error', ['as' => 'error', 'uses' => 'ZbwController@postError']);

Route::get('pages/{slug}', ['as' => 'pages/{slug}', 'uses' => 'PagesController@getPage']);
Route::get('roster', ['as' => 'roster', 'uses' => 'RosterController@getPublicRoster']);

Route::get('/status/{id}', 'UsersController@getStatus');
