<?php
$me = Auth::user();
//share the logged in user with the view, if it exists
View::share('me', $me);
if ($me) {
    View::share(
      'messages',
      Zbw\Repositories\MessagesRepository::newMessageCount($me->cid)
    );
}

//filter all staff routes, additional filters in route groups
Route::when('staff/*', 'staff');

//login and logout
Route::get('login', 'SessionsController@getLogin');
Route::post('login', 'SessionsController@postLogin');
Route::get('logout', 'SessionsController@getLogout');
Route::controller('password', 'RemindersController');

//top level pages
Route::get('/', array('as' => 'home', 'uses' => 'ZbwController@getIndex'));
Route::get('pilots', 'ZbwController@getPilotIndex');
Route::get('controllers', 'ZbwController@getControllerIndex');
Route::get('forum', 'ForumController@getIndex');
Route::get('staff', 'StaffController@getIndex');
Route::get('training', 'TrainingController@getIndex');

Route::get('controllers/{id}', 'ControllersController@getController');

Route::get('training/request/new', 'TrainingController@getRequest');

Route::get('news/{id}', 'NewsController@show');

Route::get('staff/training', 'AdminController@getTrainingIndex');
Route::get(
  'staff/exams/review/{eid}',
  'ControllerExamsController@getStaffReview'
);
Route::get('staff/exams/questions', 'ControllerExamsController@getQuestions');
Route::post('staff/exams/questions', 'ControllerExamsController@addQuestion');
Route::get('staff/roster', 'AdminController@getRosterIndex');
Route::get('staff/roster/results', 'AdminController@getSearchResults');
Route::get('staff/u/{id}', 'AdminController@showUser');
Route::get('staff/{id}/edit', 'RosterController@getEditUser');
Route::post('staff/{id}/edit', 'RosterController@postEditUser');
Route::get('staff/roster/add-controller', 'RosterController@getAddController');
Route::post(
  'staff/roster/add-controller',
  'RosterController@postAddController'
);
Route::get('staff/cms', 'AdminController@getCmsIndex');
Route::get('staff/forum', 'AdminController@getForumIndex');
Route::get('staff/ts', 'AdminController@getTsIndex');

Route::get('staff/news', 'AdminController@getNewsIndex');
Route::get('staff/news/add', 'NewsController@getCreate');
Route::post('staff/news/add', 'NewsController@postCreate');

Route::get('staff/log', 'AdminController@getLog');

//route accessible only by logged in controllers
Route::group(
  array('before' => 'controller'),
  function () {
      $cid = is_null(Auth::user()) ? 0 : Auth::user()->cid;

      Route::get('me', 'ControllerController@getMe');
      Route::post('/me/markallread', 'AjaxController@markInboxRead');
      Route::get(
        '/u/' . $cid,
        array('as' => 'me', 'uses' => 'ControllersController@getMe')
      );
      Route::get('me/settings', 'ControllersController@getSettings');
      //private messaging
      Route::group(
        ['prefix' => 'messages'],
        function () {
            //@inbox
            Route::get(
              'inbox',
              ['as' => 'inbox', 'uses' => 'MessengerController@index']
            );
            //@pm-compose
            Route::get(
              'new',
              ['as' => 'pm-compose', 'uses' => 'MessengerController@create']
            );
            //@outbox
            Route::get(
              'outbox',
              ['as' => 'outbox', 'uses' => 'MessengerController@outbox']
            );
            //@trash
            Route::get(
              'trash',
              ['as' => 'pm-trash', 'uses' => 'MessengerController@trash']
            );

            Route::get('inbox/{mid}', 'MessengerController@view');
            Route::get('inbox/{mid}', 'MessengerController@view');
            Route::post('send', 'MessengerController@store');
            Route::post('inbox/{mid}', 'MessengerController@reply');
        }
      );
      //training requests
      Route::get('/training/review', 'TrainingController@getReview');
      Route::post('/staff/exams/review/{eid}', 'ControllerExamsController@postComment');
      Route::post('/training/review/{eid}', 'ControllerExamsController@postComment');
      Route::post(
        '/e/request/{cid}/{eid}',
        array('uses' => 'AjaxController@requestExam')
      );
      Route::post('/t/request/new', 'AjaxController@postTrainingRequest');
      Route::get('/t/request/{tid}', 'TrainingController@showRequest');
      Route::post(
        '/t/request/{tid}/cancel',
        'AjaxController@cancelTrainingRequest'
      );
      Route::post(
        '/t/request/{tid}/accept',
        'AjaxController@acceptTrainingRequest'
      );
      Route::post('/f/upload/photos', 'AjaxController@photoUpload');
  }
);

//route accessible only by mentors and instructors
Route::group(
  array('before' => 'mentor'),
  function () {
      Route::post('/e/review/{eid}', 'AjaxController@postReviewComment');
      Route::get('staff/training/{id}', 'TrainingController@showAdmin');
  }
);

//routes accessible by any staff member
Route::group(
  array('before' => 'staff'),
  function () {
      Route::get('staff', 'AdminController@getAdminIndex');
      Route::post('/a/complete/{aid}', 'AjaxController@actionCompleted');
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

