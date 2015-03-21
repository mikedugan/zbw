<?php

use \Route;

//auth routes
Route::get('login', ['as' => 'login', 'uses' => SessionsController::class.'@oauthLogin']);
Route::post('login', ['as' => 'login', 'uses' => SessionsController::class.'@postLogin']);
Route::get('auth', ['as' => 'auth', 'uses' => SessionsController::class.'@oauthLogin']);
Route::get('logout', ['as' => 'logout', 'uses' => SessionsController::class.'@getLogout']);


//top level pages
Route::get('/', ['as' => 'home', 'uses' => ZbwController::class.'@getIndex']);

Route::get('controllers/resources', ['as' => 'controllers.resources', 'uses' => StaticController::class.'@getControllersResources']);
Route::get('controllers/documents', ['as' => 'controllers.documents', 'uses' => StaticController::class.'@getDocumentLibrary']);
Route::get('controllers/beacon-codes', ['as' => 'controllers.beacon_codes', 'uses' => StaticController::class.'@getControllersBeaconCodes']);
Route::get('join', ['as' => 'join', 'uses' => ZbwController::class.'@getJoin']);
Route::get('visit', ['as' => 'visit', 'uses' => ZbwController::class.'@getVisit']);
Route::post('visit', ['as' => 'visit', 'uses' => ZbwController::class.'@postVisit']);
//used by staff contact on roster page
Route::post('contact', ['as' => 'contact', 'uses' => ZbwController::class.'@postContact']);

Route::get('statistics', ['as' => 'statistics', 'uses' => ZbwController::class.'@getStatistics']);

Route::get('tsviewer', ['as' => 'tsviewer', 'uses' => StaticController::class.'@getTsDisplay']);

//static pages for pilots
Route::get('pilots', ['as' => 'pilots', 'uses' => StaticController::class.'@getPilots']);
Route::get('pilots/getting-started', ['as' => 'pilots/getting-started', 'before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => StaticController::class.'@getPilotsGettingStarted']);
Route::get('pilots/airports', ['as' => 'pilots/airports', 'uses' => AirportsController::class.'@getIndex']);
Route::get('pilots/vfr-tutorial', ['as' => 'pilots/vfr-tutorial', 'before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => StaticController::class.'@getPilotsVfrTutorial']);
//static pages for controllers
Route::get('controllers/training-outline', ['as' => 'training-outline', 'before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => StaticController::class.'@getControllersTrainingOutline']);
Route::get('controllers/policies', ['as' => 'controllers/policies', 'before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => StaticController::class.'@getControllersPolicies']);
Route::get('controllers/policies/sign-on-off', ['as' => 'policies/sign-on-off', 'before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => StaticController::class.'@getControllersSignonPolicy']);
Route::get('controllers/policies/position-restrictions', ['as' => 'policies/position-restrictions', 'before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => StaticController::class.'@getControllersPositionRestrictions']);
Route::get('controllers/policies/visiting-transfer', ['as' => 'policies/visiting-transfer', 'before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => StaticController::class.'@getControllersVisitingTransfer']);
Route::get('controllers/policies/roster-removal', ['as' => 'policies/roster-removal', 'before' => 'cache.fetch', 'after' => 'cache.put', 'uses' => StaticController::class.'@getControllersRosterRemoval']);

Route::get('pilots/news', ['as' => 'pilot-news', 'uses' => NewsController::class.'@getPilotNews']);
Route::get('controllers', ['as' => 'controllers', 'uses' => ZbwController::class.'@getControllerIndex']);
Route::get('training', ['as' => 'training', 'uses' => TrainingController::class.'@getIndex']);
Route::get('controllers/{id}', ['as' => 'controllers/{id}', 'uses' => UsersController::class.'@getController']);
Route::get('roster/results', ['roster/search', 'uses' => UsersController::class.'@getSearchResults']);
Route::get('news/{id}', ['as' => 'news/{id}', 'uses' => NewsController::class.'@show']);
Route::get('pages/p/{id}', ['as' => 'p/{id}', 'uses' => PagesController::class.'@getPage']);

Route::get('traffic', ['as' => 'traffic', 'uses' => ZbwController::class.'@getFlights']);

Route::get('mochahagotdi', FeedbackController::class.'@getFeedback');
Route::get('feedback', ['as' => 'feedback', 'uses' => FeedbackController::class.'@getFeedback']);
Route::post('feedback', ['as' => 'feedback', 'uses' => FeedbackController::class.'@postFeedback']);
Route::post('feedback-all', ['as' => 'feedback-all', 'uses' => ZbwController::class.'@postFeedback']);
Route::post('error', ['as' => 'error', 'uses' => ZbwController::class.'@postError']);

Route::get('pages/{slug}', ['as' => 'pages/{slug}', 'uses' => PagesController::class.'@getPage']);
Route::get('roster', ['as' => 'roster', 'uses' => RosterController::class.'@getPublicRoster']);

Route::get('/status/{id}', UsersController::class.'@getStatus');
