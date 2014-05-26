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
    View::share('messages', Zbw\Repositories\MessagesRepository::newMessageCount($me->cid));

//filter all staff routes, additional filters in route groups
Route::when('staff/*', 'staff');

//auth routes
Route::get('login', 'SessionsController@getLogin');
Route::post('login', 'SessionsController@postLogin');
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

//route accessible only by logged in controllers
Route::group(
  array('before' => 'controller'), function () {
      $cid = is_null(Auth::user()) ? 0 : Auth::user()->cid;
      //routes for the logged in user
      Route::get('me', 'ControllerController@getMe');
      Route::post('/me/markallread', 'AjaxController@markInboxRead');
      Route::get('/u/' . $cid,array('as' => 'me', 'uses' => 'ControllersController@getMe'));
      Route::get('me/settings', 'ControllersController@getSettings');
      //training and exam routes
      Route::get('training/request/new', 'TrainingController@getRequest');
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
            Route::get('inbox', ['as' => 'inbox', 'uses' => 'MessengerController@index']);
            Route::get('new', ['as' => 'pm-compose', 'uses' => 'MessengerController@create']);
            Route::get('outbox',['as' => 'outbox', 'uses' => 'MessengerController@outbox']);
            Route::get('trash',['as' => 'pm-trash', 'uses' => 'MessengerController@trash']);

            Route::get('inbox/{mid}', 'MessengerController@view');
            Route::get('outbox/{mid}', 'MessengerController@view');
            Route::post('send', 'MessengerController@store');
            Route::post('inbox/{mid}', 'MessengerController@reply');
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
          Route::post('staff/exams/review/{eid}', 'ControllerExamsController@postComment');
          Route::get('staff/training', 'AdminController@getTrainingIndex');
          Route::get('staff/exams/review/{eid}','ControllerExamsController@getStaffReview');
          Route::get('staff/exams/questions', 'ControllerExamsController@getQuestions');
          Route::post('staff/exams/questions', 'ControllerExamsController@addQuestion');
          Route::get('staff/roster', 'AdminController@getRosterIndex');
          Route::get('staff/roster/results', 'AdminController@getSearchResults');
          Route::get('staff/u/{id}', 'AdminController@showUser');
          Route::get('staff/{id}/edit', 'RosterController@getEditUser');
          Route::post('staff/{id}/edit', 'RosterController@postEditUser');
          Route::get('staff/roster/add-controller', 'RosterController@getAddController');
          Route::post('staff/roster/add-controller','RosterController@postAddController');
          Route::get('staff/pages', 'PagesController@getIndex');
          Route::get('staff/forum', 'AdminController@getForumIndex');
          Route::get('staff/ts', 'AdminController@getTsIndex');

          Route::get('staff/news', 'AdminController@getNewsIndex');
          Route::get('staff/news/add', 'NewsController@getCreate');
          Route::post('staff/news/add', 'NewsController@postCreate');

          Route::get('staff/log', 'AdminController@getLog');

          Route::get('staff', 'AdminController@getAdminIndex');
          Route::get('staff/news/{id}/edit', 'NewsController@getEdit');
          Route::post('staff/news/edit', 'NewsController@postEdit');
      });
      Route::post('/a/complete/{aid}', 'AjaxController@actionCompleted');

      Route::get('pages/create', 'PagesController@getCreate');
      Route::get('pages/view', 'PagesController@getShow');
      Route::get('pages/menus', 'PagesController@getMenus');
      Route::get('pages/trash', 'PagesController@getTrash');

      Route::get('pages/menus/create', 'MenusController@postCreate');
      Route::get('pages/menus', 'MenusController@getIndex');
      Route::get('pages/menus/{mid}/update', 'MenusController@postUpdate');
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

