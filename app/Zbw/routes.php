<?php
/**
 * routes are pretty hardcoded - they will eventually be replaced largely by controller resources
 *
 * where a route is defined such as '/r/path/to/something', the 'r' is typically used to denote a route that
 * should not be hit in the browser. these might be routes for form submissionso or ajax calls
 * Generally speaking:
 * /r roster
 * /t training
 * /e exams
 * /u user
 * /m mail
 * Reserved for future use:
 * /b bostonjohn
 */

//we'll assign the current user to me
$me = Auth::user();
//share the logged in user with the view, if it exists
View::share('me', $me);
//allows us to display the current number of inbox messages
if ($me)
    View::share('messages', Zbw\Cms\MessagesRepository::newMessageCount($me->cid));

//filter all staff routes, additional filters in route groups
Route::when('staff/*', 'staff');

//auth routes
Route::get('login', 'SessionsController@oauthLogin');
Route::post('login', 'SessionsController@postLogin');
Route::get('auth', 'SessionsController@postLogin');
Route::get('logout', 'SessionsController@getLogout');
Route::controller('password', 'RemindersController');

//top level pages
Route::get('/', array('as' => 'home', 'uses' => 'ZbwController@getIndex'));
Route::get('pilots', 'ZbwController@getPilotIndex');
Route::get('controllers', 'ZbwController@getControllerIndex');
Route::get('forum', 'ForumController@getIndex');
Route::get('training', 'TrainingController@getIndex');
Route::get('controllers/{id}', 'ControllersController@getController');
Route::get('news/{id}', 'NewsController@show');
Route::get('pages/p/{id}', 'PagesController@getPage');

//route accessible only by logged in controllers
Route::group(
  array('before' => 'controller'), function () {
      $cid = is_null(Auth::user()) ? 0 : Auth::user()->cid;
      //routes for the logged in user
      Route::get('me', 'ControllersController@getMe');
      Route::post('/me/markallread', 'AjaxController@markInboxRead');
      Route::get('/u/' . $cid,array('as' => 'me', 'uses' => 'ControllersController@getMe'));
      Route::get('me/settings', 'ControllersController@getSettings');
      //training and exam routes
      Route::get('training/request/new', 'TrainingController@getRequest');
      Route::get('training/request/{id}', 'TrainingController@showRequest');
      Route::get('/training/review', 'TrainingController@getReview');
      Route::post('/training/review/{eid}', 'ControllerExamsController@postComment');
      Route::post('/e/request/{cid}/{eid}',array('uses' => 'AjaxController@requestExam'));
      Route::post('/t/request/new', 'AjaxController@postTrainingRequest');
      Route::get('/t/request/{tid}', 'TrainingController@showRequest');
      Route::post('/t/request/{tid}/cancel','AjaxController@cancelTrainingRequest');
      Route::post('/t/request/{tid}/accept','AjaxController@acceptTrainingRequest');
      Route::post('/f/upload/photos', 'AjaxController@photoUpload');
      //private messaging
      Route::group(
        ['prefix' => 'messages'], function () {
            Route::get('/', 'MessagesController@index');
            Route::get('m/{mid}', 'MessagesController@view');
            Route::get('m/{mid}', 'MessagesController@view');
            Route::post('send', 'MessagesController@store');
            Route::post('m/{mid}', 'MessagesController@reply');
        });
  });

//route accessible only by mentors and instructors
Route::group(
  array('before' => 'mentor'),
  function () {
      Route::post('/e/review/{eid}', 'AjaxController@postReviewComment');
      Route::get('staff/training/{id}', 'TrainingController@showAdmin');
  });

//routes accessible only by instructors
Route::group(
    array('before' => 'instructor'),
    function() {
        //TODO add routes
    });

//routes accessible by any staff member
Route::group(
  array('before' => 'staff'),
  function () {
      Route::group(['prefix' => 'staff'], function() {
          Route::get('/', 'AdminController@getAdminIndex');
          Route::post('exams/review/{eid}', 'ControllerExamsController@postComment');
          Route::get('training', 'AdminController@getTrainingIndex');
          Route::get('exams/review/{eid}','ControllerExamsController@getStaffReview');
          Route::get('exams/questions', 'ControllerExamsController@getQuestions');
          Route::post('exams/questions', 'ControllerExamsController@addQuestion');
          Route::get('roster', 'AdminController@getRosterIndex');
          Route::get('roster/results', 'AdminController@getSearchResults');
          Route::get('u/{id}', 'AdminController@showUser');
          Route::get('{id}/edit', 'RosterController@getEditUser');
          Route::post('{id}/edit', 'RosterController@postEditUser');
          Route::get('roster/add-controller', 'RosterController@getAddController');
          Route::post('roster/add-controller','RosterController@postAddController');
          Route::get('pages', 'PagesController@getIndex');
          Route::get('forum', 'AdminController@getForumIndex');
          Route::get('ts', 'AdminController@getTsIndex');

          Route::get('news', 'AdminController@getNewsIndex');
          Route::get('news/add', 'NewsController@getCreate');
          Route::post('news/add', 'NewsController@postCreate');

          Route::get('log', 'AdminController@getLog');

          Route::get('news/{id}/edit', 'NewsController@getEdit');
          Route::post('news/edit', 'NewsController@postEdit');
      });
      Route::post('/a/complete/{aid}', 'AjaxController@actionCompleted');

      Route::get('pages/create', 'PagesController@getCreate');
      Route::get('pages/view', 'PagesController@getShow');
      Route::get('pages/trash', 'PagesController@getTrash');

      Route::post('pages/menus/create', 'MenusController@postCreate');
      Route::get('pages/menus', 'MenusController@getIndex');
      Route::get('pages/menus{mid}/edit', 'MenusController@getUpdate');
      Route::post('pages/menus/{mid}/update', 'MenusController@postUpdate');
      Route::get('pages/menus/{mid}/delete', 'MenusController@postDelete');
  }
);

//routes accessible only by the ATM, DATM, and TA
Route::group(
  array('before' => 'executive'),
  function () {
      Route::post('/r/activate/{cid}', 'AjaxController@activateUser');
      Route::post('/r/suspend/{cid}', 'AjaxController@suspendUser');
      Route::post('/r/terminate/{cid}', 'AjaxController@terminateUser');
      Route::post('/m/staff-welcome/{cid}', 'AjaxController@sendStaffWelcome');
  }
);

