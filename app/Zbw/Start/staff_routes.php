<?php
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
            Route::get('roster/create-controller', 'RosterController@getAddController');
            Route::post('roster/create-controller','RosterController@postAddController');
            Route::get('pages', 'PagesController@getIndex');
            Route::get('forum', 'AdminController@getForumIndex');
            Route::get('ts', 'AdminController@getTsIndex');

            Route::get('news', 'AdminController@getNewsIndex');
            Route::get('news/create', 'NewsController@getCreate');
            Route::post('news/create', 'NewsController@postCreate');

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

Route::group(
  array('before' => 'executive'),
  function () {
      Route::post('/r/activate/{cid}', 'AjaxController@activateUser');
      Route::post('/r/suspend/{cid}', 'AjaxController@suspendUser');
      Route::post('/r/terminate/{cid}', 'AjaxController@terminateUser');
      Route::post('/m/staff-welcome/{cid}', 'AjaxController@sendStaffWelcome');
  }
);

Route::group(
  array('before' => 'instructor'),
  function() {
      //TODO create routes
  });

Route::group(
  array('before' => 'mentor'),
  function () {
      Route::post('/e/review/{eid}', 'AjaxController@postReviewComment');
      Route::get('staff/training/{id}', 'TrainingController@showAdmin');
  });
