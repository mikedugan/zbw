<?php
//
Route::group(
  ['before' => 'auth|staff'], function () {
      Route::group(
        ['prefix' => 'staff'], function () {
            Route::get('live/{tsid}', 'TrainingController@testLiveSession');
            Route::post('live/{tsid}', 'TrainingController@postLiveSession');

            Route::get('/', ['as' => 'staff', 'uses' => 'AdminController@getAdminIndex']);
            Route::get('staffing', ['as' => 'staff/staffing', 'uses' => 'StaffingController@getIndex']);
            Route::get('exams/all', ['as' => 'staff/exams/all', 'uses' => 'ExamsController@getIndex']);
            Route::post('exams/review/{eid}', ['as' => 'exams/review/{eid}', 'uses' => 'ExamsController@postComment']);
            Route::get('training', ['as' => 'staff/training', 'uses' => 'TrainingController@getAdminIndex']);
            Route::get('training/new', ['as' => 'training.new', 'uses' => 'TrainingController@getNewSession']);
            Route::post('training/new', ['as' => 'training.new', 'uses' => 'TrainingController@postNewSession']);
            Route::get('training/all', ['as' => 'staff/training/all', 'uses' => 'TrainingController@getAll']);
            Route::get('training/availability', ['as' => 'staff.availability', 'uses' => 'TrainingController@getStaffStaffAvailability']);
            Route::post('training/availability', ['as' => 'staff.availability', 'uses' => 'TrainingController@postStaffAvailability']);
            Route::get('training/availability/delete/{id}', ['as' => 'staff.availability.delete', 'uses' => 'TrainingController@getDeleteAvailability']);

            Route::get('exams/review/{eid}', ['as' => 'exams/review/{eid}', 'uses' => 'ExamsController@getStaffReview']);
            Route::get('exams/questions', ['as' => 'staff/exams/questions', 'uses' => 'ExamsController@getQuestions']);
            Route::get('exams/questions/{id}', ['as' => 'staff/exams/questions/{id}', 'uses' => 'ExamsController@getEditQuestion']);
            Route::post('exams/questions/{id}', ['as' => 'staff/exams/questions/{id}', 'uses' => 'ExamsController@postEditQuestion']);
            Route::post('exams/questions/{id}/delete', ['as' => 'staff/exams/questions/{id}/delete', 'uses' => 'ExamsController@deleteQuestion']);
            Route::post('exams/questions', ['as' => 'exams/add-question', 'uses' => 'ExamsController@addQuestion']);
            Route::get('adopt/{cid}', ['as' => 'staff/adopt/{cid}', 'uses' => 'TrainingController@getAdopt']);
            Route::post('adopt/{cid}', ['as' => 'staff/adopt/{cid}', 'uses' => 'TrainingController@postAdopt']);
            Route::post('adopt/{cid}/drop', ['as' => 'staff/adopt/{cid}/drop', 'uses' => 'TrainingController@getDropAdopt']);
            Route::get('roster', ['as' => 'roster', 'uses' => 'RosterController@getAdminIndex']);
            Route::post('roster/groups/add', ['as' => 'staff/roster/add-group', 'uses' => 'RosterController@postGroup']);
            Route::post('roster/groups/update', ['as' => 'staff/roster/edit-group', 'uses' => 'RosterController@updateGroup']);
            Route::get('roster/results', ['roster/search', 'uses' => 'AdminController@getSearchResults']);
            Route::get('roster/vatusa_exams/{cid}', ['as' => 'staff/roster/vatusa_exams/{cid}', 'uses' => 'AjaxController@getVatusaExams']);
            Route::get('u/{id}', ['roster/user/{id}', 'uses' => 'UsersController@showUser']);
            Route::get('{id}/edit', ['as' => 'roster/user/{id}/edit', 'uses' => 'RosterController@getEditUser']);
            Route::post('{id}/edit', ['as' => 'staff/{id}/edit', 'uses' => 'RosterController@postEditUser']);
            Route::get('{id}/training', ['as' => 'roster/user/{id}/training', 'uses' => 'RosterController@getControllerDashboard']);
            Route::post('{id}/comment', ['as' => 'staff/{id}/comment', 'uses' => 'RosterController@postRosterComment']);
            Route::get('comments/{comment}/delete', ['as' => 'staff/comments/{comment}/delete', 'uses' => 'RosterController@getDeleteComment']);
            Route::get('comments/{comment}/edit', ['as' => 'staff/comments/{comment}/edit', 'uses' => 'RosterController@getEditComment']);
            Route::post('comments/{comment}/edit', ['as' => 'staff/comments/{comment}/edit', 'uses' => 'RosterController@postEditComment']);
            Route::get('roster/create-controller', ['as' => 'roster/add', 'uses' => 'RosterController@getAddController']);
            Route::post('roster/create-controller', ['as' => 'roster/add', 'uses' => 'RosterController@postAddController']);
            Route::get('pages', ['as' => 'staff/pages', 'uses' => 'PagesController@getIndex']);
            Route::get('pages/create', ['as' => 'staff/pages/create', 'uses' => 'PagesController@getCreate']);
            Route::post('pages/create', ['as' => 'staff/pages/create', 'uses' => 'PagesController@postCreate']);
            Route::post('pages/edit', ['as' => 'staff/pages/edit', 'uses' => 'PagesController@postEdit']);
            Route::get('forum', ['as' => 'staff/forum', 'uses' => 'AdminController@getForumIndex']);
            Route::get('ts', ['as' => 'staff/ts', 'uses' => 'AdminController@getTsIndex']);

            Route::get('poker', ['as' => 'poker', 'uses' => 'PokerController@getIndex']);
            Route::post('poker', ['as' => 'poker', 'uses' => 'PokerController@postIndex']);
            Route::get('poker/{id}', ['as' => 'poker/{id}', 'uses' => 'PokerController@getPilot']);

            Route::get('news', ['as' => 'staff/news', 'uses' => 'NewsController@getAdminIndex']);
            Route::get('news/add', ['as' => 'news/add', 'uses' => 'NewsController@getCreate']);
            Route::post('news/add', ['as' => 'news/add', 'uses' => 'NewsController@postCreate']);

            Route::get('log', ['as' => 'log', 'uses' => 'AdminController@getLog']);

            Route::get('news/{id}/edit', ['as' => 'news/{id}/edit', 'uses' => 'NewsController@getEdit']);
            Route::post('news/{id}/edit', ['as' => 'news/{id}/edit', 'uses' => 'NewsController@postEdit']);
            //this route is deprecated
            Route::post('/a/complete/{aid}', 'AjaxController@actionCompleted');

            Route::get('pages/create', ['as' => 'pages/create', 'uses' => 'PagesController@getCreate']);
            Route::get('pages/view', ['as' => 'pages/view', 'uses' => 'PagesController@getShow']);
            Route::get('pages/trash', ['as' => 'pages/trash', 'uses' => 'PagesController@getTrash']);

            Route::post('pages/menus/create', ['as' => 'menus/create', 'uses' => 'MenusController@postCreate']);
            Route::get('pages/menus', ['as' => 'menus', 'uses' => 'MenusController@getIndex']);
            Route::get('pages/menus{mid}/edit', ['as' => 'menus/{mid}/edit', 'uses' => 'MenusController@getUpdate']);
            Route::post('pages/menus/{mid}/update', ['as' => 'menus/{mid}/edit', 'uses' => 'MenusController@postUpdate']);
            Route::get('pages/menus/{mid}/delete', ['as' => 'menus/{mid}/delete', 'uses' => 'MenusController@postDelete']);
            Route::post('exams/review/{id}/complete', ['as' => 'exams/review/{id}/complete', 'uses' => 'AjaxController@postExamReviewed']);
            Route::post('exams/review/{id}/reopen', ['as' => 'exams/review/{id}/reopen', 'uses' => 'AjaxController@postReopenExam']);
            Route::post('visitor/accept/{id}', ['as' => 'staff/visitor/accept/{id}', 'uses' => 'AjaxController@postVisitorAccept']);
            Route::post('visitor/deny', ['as' => 'staff/visitor/deny', 'uses' => 'RosterController@postVisitorDeny']);
            Route::post('visitor/lor', ['as' => 'staff/visitor/lor', 'uses' => 'RosterController@postVisitorLor']);
            Route::post('visitor/comment', ['as' => 'staff/visitor/comment', 'uses' => 'RosterController@postVisitorComment']);
            Route::post('visitor/delete/{id}', ['as' => 'staff/visitor/delete/{id}', 'uses' => 'RosterController@postVisitorDelete']);

            Route::group(['before' => 'executive', 'prefix' => 'teamspeak'], function() {
                Route::get('/', ['as' => 'teamspeak.index', 'uses' => 'TeamspeakController@getIndex']);
                Route::post('kick/{cid}', ['as' => 'teamspeak.kick', 'uses' => 'TeamspeakController@postKick']);
                Route::post('message/{cid}', ['as' => 'teamspeak.message', 'uses' => 'TeamspeakController@postMessage']);
            });
        }
      );

  }
);

Route::group(['before' => 'facilities'], function() {
    Route::get('/staff/files', ['as' => 'staff.files', 'uses' => 'AdminController@getFacilityFiles']);
    Route::post('/staff/files', ['as' => 'staff.files.upload', 'uses' => 'AdminController@postUploadFiles']);
    Route::get('/staff/files/delete/{name}', ['as' => 'staff.files.delete', 'uses' => 'AdminController@getDeleteFile']);
});

Route::group(['before' => 'executive'], function () {
      Route::post('/staff/poker/wipe', 'PokerController@postWipe');
      Route::post('r/activate/{cid}', ['as' => 'controllers/{cid}/active', 'uses' => 'AjaxController@activateUser']);
      Route::post('r/suspend/{cid}', ['as' => 'controllers/{cid}/suspend', 'uses' => 'AjaxController@suspendUser']);
      Route::post('r/terminate/{cid}', ['as' => 'controllers/{cid}/terminate', 'uses' => 'AjaxController@terminateUser']);
      Route::post('r/promote/{cid}', ['as' => 'controllers/{cid}/promote', 'uses' => 'AjaxController@promoteUser']);
      Route::post('r/demote/{cid}', ['as' => 'controllers/{cid}/demote', 'uses' => 'AjaxController@demoteUser']);
      Route::post('/m/staff-welcome/{cid}', ['as' => 'controllers/{cid}/staff-welcome', 'uses' => 'AjaxController@sendStaffWelcome']);
      Route::get('/staff/super/mike/{cid}', ['as' => 'staff/super/mike/{cid}', 'uses' => 'AdminController@getOverride']);
      Route::get('/staff/admin', ['as' => 'staff.admin', 'uses' => 'AdminController@getAdmin']);
  }
);

Route::get('/staff/feedback', ['as' => 'staff/feedback', 'before' => 'feedback', 'uses' => 'FeedbackController@viewFeedback']);
Route::get('/staff/feedback/delete/{id}', ['as' => 'staff.feedback.delete', 'before' => 'feedback', 'uses' => 'FeedbackController@deleteFeedback']);

Route::group(['before' => 'instructor'], function () {
      //TODO create routes
  }
);

Route::group(['before' => 'mentor'], function () {
      Route::post('/e/review/{eid}', 'AjaxController@postReviewComment');
      Route::get('staff/training/{id}', 'TrainingController@showAdmin');
  }
);
Route::post('/staff/poker/{id}', ['as' => '/staff/poker/{id}', 'uses' => 'PokerController@postDiscard']);
Route::post('{id}/edit', ['as' => 'roster/user/{id}/edit', 'uses' => 'RosterController@postEditUser']);


