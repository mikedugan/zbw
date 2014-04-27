<?php

//share the logged in user with the view, if it exists
View::share('me', Auth::user());
View::share('messages', Zbw\Repositories\MessagesRepository::newMessageCount(Auth::user()->cid));

//filter all staff routes, additional filters in route groups
Route::when('staff/*', 'staff');

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

Route::get('training/request/new', 'TrainingController@getRequest');

Route::get('news/{id}', 'NewsController@show');

Route::get('staff/training', 'AdminController@getTrainingIndex');
Route::get('staff/exams/review/{eid}', 'ControllerExamsController@getStaffReview');
Route::get('staff/exams/questions', 'ControllerExamsController@getQuestions');
Route::post('staff/exams/questions', 'ControllerExamsController@addQuestion');
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
Route::get('staff/news/add', 'NewsController@getCreate');
Route::post('staff/news/add', 'NewsController@postCreate');

Route::get('staff/log', 'AdminController@getLog');

//route accessible only by logged in controllers
Route::group(array('before' => 'controller'), function() {
    //private messaging
    Route::get('/u/{cid}/inbox', 'MessengerController@index');
    Route::get('/u/{cid}/inbox/{mid}', 'MessengerController@view');
    Route::get('/u/{cid}/outbox/new', 'MessengerController@create');
    Route::post('/u/{cid}/outbox/new', 'MessengerController@store');
    Route::post('/u/{cid}/inbox/{mid}', 'MessengerController@reply');

    //training requests
    Route::post('/e/request/{cid}/{eid}', array('uses' => 'AjaxController@requestExam'));
    Route::post('/t/request/new', 'AjaxController@postTrainingRequest');
    Route::get('/t/request/{tid}', 'TrainingController@showRequest');
    Route::post('/t/request/{tid}/cancel', 'AjaxController@cancelTrainingRequest');
    Route::post('/t/request/{tid}/accept', 'AjaxController@acceptTrainingRequest');
    Route::post('/f/upload/photos', 'AjaxController@photoUpload');
});

//route accessible only by mentors and instructors
Route::group(array('before' => 'mentor'), function() {
    Route::post('/e/review/{eid}', 'AjaxController@postReviewComment');
    Route::get('staff/training/{id}', 'TrainingController@showAdmin');
});

//routes accessible by any staff member
Route::group(array('before' => 'staff'), function() {
    Route::get('staff', 'AdminController@getAdminIndex');
    Route::post('/a/complete/{aid}', 'AjaxController@actionCompleted');
});

//routes accessible only by the ATM, DATM, and TA
Route::group(array('before' => 'executive'), function() {
    Route::post('/r/activate/{cid}', 'AjaxController@activateUser');
    Route::post('/r/suspend/{cid}', 'AjaxController@suspendUser');
    Route::post('/r/terminate/{cid}', 'AjaxController@terminateUser');
    Route::post('/m/staff-welcome/{cid}', 'AjaxController@sendStaffWelcome');
});

